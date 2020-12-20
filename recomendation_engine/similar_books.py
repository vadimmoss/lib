import pandas as pd
import numpy as np
import warnings
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.metrics.pairwise import cosine_similarity

warnings.filterwarnings('ignore')

books = pd.read_csv('data_csv/books.csv', delimiter=';')
tags = pd.read_csv('data_csv/tags.csv')
book_tags = pd.read_csv('data_csv/book_tags.csv')
ratings = pd.read_csv('data_csv/ratings.csv')

books['authors'] = books['authors'].apply(lambda x: [str.lower(i.replace(" ", "")) for i in x.split(', ')])


def get_genres(x):
    t = book_tags[book_tags.book_id == x]
    return [i.lower().replace(" ", "") for i in tags.tag_name.loc[t.tag_id].values]


books['genres'] = books.book_id.apply(get_genres)

books['soup'] = books.apply(lambda x: ' '.join([x['title']] + x['authors'] + x['genres']), axis=1)

print(books.soup.head())

count = CountVectorizer(analyzer='word', ngram_range=(1, 2), min_df=0, stop_words='english')
count_matrix = count.fit_transform(books['soup'])
cosine_sim = cosine_similarity(count_matrix, count_matrix)

indices = pd.Series(books.index, index=books['title'])
titles = books['title']ф


def get_recommendations(title, n=10):
    idx = indices[title]
    sim_scores = list(enumerate(cosine_sim[idx]))
    try:
        sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)
    except ValueError:
        return False
    sim_scores = sim_scores[1:31]
    book_indices = [i[0] for i in sim_scores]
    return list(titles.iloc[book_indices].values)[:n]


similar = pd.DataFrame(columns=['book_id', 'books'])
from progress.bar import IncrementalBar

bar = IncrementalBar("\rCountdown", max=len(titles))
for title in titles:
    bar.next()
    booksString = ''
    rec = get_recommendations(title)
    if (rec != False):
        for book in get_recommendations(title):
            book = str(book).replace("\'", "")
            book = str(book).replace("\"", "")
            book = str(book).replace(";", "")
            booksString += book + '; '
        similar = similar.append({'book_id': books['book_id'][books['title'] == title].to_string(index=False),
                                  'books': '\"' + booksString + '\"'}, ignore_index=True)

bar.finish()
np.savetxt("saved_csv/similar_books.csv", similar, delimiter="|", fmt='%s', encoding='utf8')
