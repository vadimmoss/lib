# Online library with recommendation engine using a neural network 
## Web app architecture  

  In the project I used the Active Record design pattern. 
  
  The Active Record scheme is an approach to accessing data in a database. A database table or view is wrapped in classes. Thus, the object instance is bound to a single row in the table. 
  
  After creating the object, a new row will be added to the table for saving. Any downloaded object receives its information from the database. When the object is updated, the corresponding row in the table will also be updated. The wrapper class implements access methods or properties for each column in the table or view.
  

## Recommentaition engine  
  A common and effective pattern for this sort of task is the so-called two-tower model: a neural network with two sub-models that learn representations for queries and candidates separately. 
  
  The score of a given query-candidate pair is simply the dot product of the outputs of these two towers.  
  
  This model architecture is quite flexible. The inputs can be anything: user ids, search queries, or timestamps on the query side; books titles, descriptions.
  
  ![Architecture](https://1.bp.blogspot.com/-ww8cKT3nIb8/X2pdWAWWNmI/AAAAAAAADl8/pkeFRxizkXYbDGbOcaAnZkorjEuqtrabgCLcBGAsYHQ/s0/TF%2BRecommenders%2B06.gif")
  
  ![Arcjhitecture](https://raw.githubusercontent.com/vadimmoss/lib/main/recomendation_engine/%D0%9D%D0%BE%D0%B2%D1%8B%D0%B9%20%D1%82%D0%BE%D1%87%D0%B5%D1%87%D0%BD%D1%8B%D0%B9%20%D1%80%D0%B8%D1%81%D1%83%D0%BD%D0%BE%D0%BA.bmp")

## Dataset  
  This ![dataset](ttps://www.kaggle.com/zygmunt/goodbooks-10k) contains ratings for ten thousand popular books. As to the source, let's say that these ratings were found on the internet. Generally, there are 100 reviews for each book, although some have less - fewer - ratings. Ratings go from one to five.
  
  Both book IDs and user IDs are contiguous. For books, they are 1-10000, for users, 1-53424. All users have made at least two ratings. Median number of ratings per user is 8.
  
  There are also books marked to read by the users, book metadata (author, year, etc.) and tags. 
  
  toread.csv provides IDs of the books marked "to read" by each user, as userid,book_id pairs.

books.csv has metadata for each book (goodreads IDs, authors, title, average rating, etc.).
  
  The metadata have been extracted from goodreads XML files, available in the third version of this dataset as booksxml.tar.gz. The archive contains 10000 XML files. One of them is available as samplebook.xml. To make the download smaller, these files are absent from the current version. 
  
