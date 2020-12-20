# Online library with recommendation engine using a neural network <h1>
# Web app architecture </h2>
<p>
  In the project I used the Active Record design pattern. The Active Record scheme is an approach to accessing data in a database. A database table or view is wrapped in classes. Thus, the object instance is bound to a single row in the table. After creating the object, a new row will be added to the table for saving. Any downloaded object receives its information from the database. When the object is updated, the corresponding row in the table will also be updated. The wrapper class implements access methods or properties for each column in the table or view.
</p>
<h2>Recommentaition engine</h2>
<p>
  A common and effective pattern for this sort of task is the so-called two-tower model: a neural network with two sub-models that learn representations for queries and candidates separately. The score of a given query-candidate pair is simply the dot product of the outputs of these two towers.  
	This model architecture is quite flexible. The inputs can be anything: user ids, search queries, or timestamps on the query side; books titles, descriptions. </br>
	
  <img src="https://1.bp.blogspot.com/-ww8cKT3nIb8/X2pdWAWWNmI/AAAAAAAADl8/pkeFRxizkXYbDGbOcaAnZkorjEuqtrabgCLcBGAsYHQ/s0/TF%2BRecommenders%2B06.gif"</img>
</p>
