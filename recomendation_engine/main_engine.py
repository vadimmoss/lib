import numpy as np
import pandas as pd
from typing import Dict, Text
import sqlalchemy
import os
from datetime import datetime

os.environ['TF_CPP_MIN_LOG_LEVEL'] = '2'

import tensorflow as tf
import tensorflow_recommenders as tfrs
import time
from threading import Timer


def retrain():
    start_time = datetime.now()
    start_time = datetime.strptime(start_time.strftime("%H:%M:%S"), "%H:%M:%S")

    # Connecting to database
    print("Connecting to database...")
    engine = sqlalchemy.create_engine('mysql://root:root@localhost/lib_db')

    # Read data from SQL tables
    print("Reading data from SQL tables...")
    books = pd.read_sql_table('books', engine, columns=['id', 'title'])
    books_data_for_search = books
    sql_data_ratings = pd.read_sql_table('rates', engine, columns=['id_book', 'id_rater', 'rate'])
    sql_books_ratings = pd.merge(sql_data_ratings, books, left_on='id_book', right_on='id')

    # Reformat data in tables to str
    print("Making datasets...")
    books_ratings = sql_books_ratings.astype(str)

    # Making datasets
    books_ratings_dataset = tf.data.Dataset.from_tensor_slices(dict(books_ratings))
    books_dataset = tf.data.Dataset.from_tensor_slices(dict(books))

    # Зберігаємо тільки ідентифікатори користувачів і назви книг
    ratings = books_ratings_dataset.map(lambda x: {
        "title": x["title"],
        "user_id": x["id_rater"],
    })
    books = books_dataset.map(lambda x: x["title"])

    # Для подальшої оцінки моделі розділюю датасет на набір для навчання та набір для тестування
    print("Randomizing data...")
    tf.random.set_seed(42)
    shuffled = ratings.shuffle(79_701, reshuffle_each_iteration=False)
    train = shuffled.take(60_000)
    test = shuffled.skip(60_000).take(19_701)

    # Отримую унікальні ідентифікатори книг та користувачів
    print("Getting unique id's...")
    books_titles = books.batch(1_000)
    user_ids = ratings.batch(79_701).map(lambda x: x["user_id"])
    unique_book_titles = np.unique(np.concatenate(list(books_titles)))
    unique_user_ids = np.unique(np.concatenate(list(user_ids)))
    unique_user_ids = unique_user_ids.astype(str)

    # Далі виконується реалізація моделі та її налаштування

    embedding_dimension = 32

    # Модель користувача
    user_model = tf.keras.Sequential([
        tf.keras.layers.experimental.preprocessing.StringLookup(
            vocabulary=unique_user_ids, mask_token=None),
        tf.keras.layers.Embedding(len(unique_user_ids) + 1, embedding_dimension)
    ])

    # Модель книги
    book_model = tf.keras.Sequential([
        tf.keras.layers.experimental.preprocessing.StringLookup(
            vocabulary=unique_book_titles, mask_token=None),
        tf.keras.layers.Embedding(len(unique_book_titles) + 1, embedding_dimension)
    ])

    # Метрики
    metrics = tfrs.metrics.FactorizedTopK(
        candidates=books.batch(128).map(book_model)
    )

    # "Loss"
    task = tfrs.tasks.Retrieval(
        metrics=metrics
    )

    # Повна модель
    class GoodbookModel(tfrs.Model):

        def __init__(self, user_model, book_model):
            super().__init__()
            self.book_model: tf.keras.Model = book_model
            self.user_model: tf.keras.Model = user_model
            self.task: tf.keras.layers.Layer = task

        def compute_loss(self, features: Dict[Text, tf.Tensor], training=False) -> tf.Tensor:
            # We pick out the user features and pass them into the user model.
            user_embeddings = self.user_model(features["user_id"])
            # And pick out the book features and pass them into the book model,
            # getting embeddings back.
            positive_book_embeddings = self.book_model(features["title"])

            # The task computes the loss and the metrics.
            return self.task(user_embeddings, positive_book_embeddings)

    class NoBaseClassGoodbookModel(tf.keras.Model):

        def __init__(self, user_model, book_model):
            super().__init__()
            self.book_model: tf.keras.Model = book_model
            self.user_model: tf.keras.Model = user_model
            self.task: tf.keras.layers.Layer = task

        def train_step(self, features: Dict[Text, tf.Tensor]) -> tf.Tensor:
            # Set up a gradient tape to record gradients.
            with tf.GradientTape() as tape:
                # Loss computation.
                user_embeddings = self.user_model(features["user_id"])
                positive_book_embeddings = self.book_model(features["title"])
                loss = self.task(user_embeddings, positive_book_embeddings)

                # Handle regularization losses as well.
                regularization_loss = sum(self.losses)

                total_loss = loss + regularization_loss

            gradients = tape.gradient(total_loss, self.trainable_variables)
            self.optimizer.apply_gradients(zip(gradients, self.trainable_variables))

            metrics = {metric.name: metric.result() for metric in self.metrics}
            metrics["loss"] = loss
            metrics["regularization_loss"] = regularization_loss
            metrics["total_loss"] = total_loss

            return metrics

        def test_step(self, features: Dict[Text, tf.Tensor]) -> tf.Tensor:
            # Loss computation.
            user_embeddings = self.user_model(features["user_id"])
            positive_book_embeddings = self.book_model(features["title"])
            loss = self.task(user_embeddings, positive_book_embeddings)

            # Handle regularization losses as well.
            regularization_loss = sum(self.losses)

            total_loss = loss + regularization_loss

            metrics = {metric.name: metric.result() for metric in self.metrics}
            metrics["loss"] = loss
            metrics["regularization_loss"] = regularization_loss
            metrics["total_loss"] = total_loss

            return metrics

    # Створюється екземпляр моделі
    print("Model config...")
    model = GoodbookModel(user_model, book_model)
    model.compile(optimizer=tf.keras.optimizers.Adagrad(learning_rate=0.1))

    # Перемішую та кешую дані для навчання та оцінки
    cached_train = train.shuffle(100_000).batch(8192).cache()
    cached_test = test.batch(4096).cache()

    # # Для подальшого використання моделі її треба зберегти
    # checkpoint_path = "saved_models/cp.ckpt"
    # checkpoint_dir = os.path.dirname(checkpoint_path)
    # cp_callback = tf.keras.callbacks.ModelCheckpoint(filepath=checkpoint_path,
    #                                                  save_weights_only=True,
    #                                                  verbose=1
    #                                                  )
    # print("Training model...")
    # model.fit(cached_train, epochs=5, callbacks=[cp_callback], verbose=1)
    # model.evaluate(cached_test, return_dict=True)

    # Якщо модель уже збережена та існує для швидшого тестування можна просто завантажити ваги
    checkpoint_path = "saved_models/cp.ckpt"
    checkpoint_dir = os.path.dirname(checkpoint_path)
    model.load_weights(checkpoint_path)

    # Роблю прогнози
    index = tfrs.layers.factorized_top_k.BruteForce(model.user_model, k=50)
    index.index(books.batch(200).map(model.book_model), books)
    _, titles = index(tf.constant(["42"]))
    print(f"Recommendations for user 42: {titles[0, :10]}")

    # Датасет для подальшого зберігання результату прогнозів
    tfdf = pd.DataFrame(columns=['user_id', 'book'])

    from progress.bar import IncrementalBar

    print("Processing data ...")
    # Обробка та форматування прогнозів для подальшого збереження в базу даних
    rand_users = np.random.choice(unique_user_ids, 1000)
    progress = 0
    bar = IncrementalBar("\rCountdown", max=len(unique_user_ids))

    for row in unique_user_ids:
        bar.next()
        _, titles = index(tf.constant([row]))
        for rowt in titles.numpy()[:50]:
            booksString = ''
            for rowts in rowt:
                rowts = str(rowts).replace("\'", "")
                rowts = str(rowts).replace("\"", "")
                booksString += rowts[1:] + '; '
            tfdf = tfdf.append({'user_id': row, 'book': '\"' + booksString[:-2] + '\"'}, ignore_index=True)

    bar.finish()
    np.savetxt("saved_csv/reco.csv", tfdf, delimiter=";", fmt='%s')

    end_time = datetime.now()
    end_time = datetime.strptime(end_time.strftime("%H:%M:%S"), "%H:%M:%S")
    print("\rRunning time: ", end_time - start_time)

    # tfdf.to_sql('recommendations', engine, if_exists='replace', index=False)
    time.sleep(60)
    t = Timer(5.0, retrain)
    t.start()


t = Timer(5.0, retrain)
t.start()
