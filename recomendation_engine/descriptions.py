import pandas as pd
import numpy as np
import seaborn as sns
import matplotlib.pyplot as plt
import datetime

import warnings
warnings.filterwarnings('ignore')

# key: 4xI2XpEwp7fNVB61UugjzQ
# secret: wbv9NdZbNyu3bCeTCaiSFxek4Iw3aytRDG7i8724s



# books = pd.read_csv('data_csv/books.csv')
# ratings = pd.read_csv('data_csv/books_ratings.csv')
# book_tags = pd.read_csv('data_csv/book_tags.csv')
# tags = pd.read_csv('data_csv/tags.csv')

from goodreads import client
api_key = '4xI2XpEwp7fNVB61UugjzQ'
api_secret = 'wbv9NdZbNyu3bCeTCaiSFxek4Iw3aytRDG7i8724s'
gc = client.GoodreadsClient(api_key, api_secret)


# print(gc.book(52357).description)




import sqlalchemy


# Connecting to database
engine = sqlalchemy.create_engine('mysql://root:root@localhost/test_library_database')
# Read data from SQL table
books = pd.read_sql_table('books', engine, columns=['book_id', 'title'])


descs = pd.DataFrame(columns=['book_id', 'description'])
books_ids = books['book_id'].unique()
books_ids2 = np.array([])
i = 0
used_ids = range(22543497)
from progress.bar import IncrementalBar
bar = IncrementalBar("\rCountdown", max=len(used_ids))
for id_used in used_ids:
    bar.next()
    if id_used in books_ids:
        books_ids2 = np.append(books_ids2, id_used)

new_list = list(set(books_ids) - set(books_ids2))



save_time = 0
for id in np.sort(np.array(new_list)):
    print(id)
    description = gc.book(id).description
    description = str(description).replace("|", "")
    print(i,'. ',id, '-', description)
    descs = descs.append({'book_id': id, 'description': description.encode('utf8')}, ignore_index=True)
    i = i + 1
    save_time = save_time + 1
    if(save_time == 10):
        np.savetxt("saved_csv/descriptions.csv", descs, delimiter="|", fmt='%s')
        save_time = 0

np.savetxt("saved_csv/descriptions.csv", descs, delimiter="|", fmt='%s')