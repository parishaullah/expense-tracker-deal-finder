<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">

	<head>
	
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

		<title>Add transactions</title>
	
	</head>
	
	<body>
		
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
			<ul class="navbar-nav">
				<a class="navbar-brand" href="home.php">Home</a>
				<ul class="navbar-nav">
					<li class="nav-item active">
						<a class="nav-link" href="addTransactionH.php">Add Transactions</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="viewTransactionH.php">View Transactions</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="graph.php">Graph</a>
					</li>
				</ul>
			</ul> 
		</nav>
	
		<div class="container" style="margin-top:20px; margin-bottom:50px">
		
			<form action="addTransaction.php" method="post">

				<h4>Add Transactions</h4>
				<div>
					<li>
						<label>Choose a category:</label>
						<div>
							<input type="radio" name="category" id="bills" value = "Bills">
							<label for="bills">Bills</label>
						</div>
						
						<div>
							<input type="radio" name="category" id="electronics" value = "Electronics">
							<label for="electronics">Electronics</label>
						</div>
						
						<div>
							<input type="radio" name="category" id="house" value = "House">
							<label for="house">House</label>
						</div>

						<div>
							<input type="radio" name="category" id="transportation" value = "Transportation">
							<label for="transportation">Transportation</label>

						</div>

						<div>
							<input type="radio" name="category" id="food" value = "Food">
							<label for="food">Food</label>
						</div>

						<div>
							<input type="radio" name="category" id="utilities" value = "Utilities">
							<label for="utilities">Utilities</label>

						</div>

						<div>
							<input type="radio" name="category" id="medical" value = "Medical">
							<label for="medical">Medical & Healthcare</label>
						</div>     

						<div>
							<input type="radio" name="category" id="communications" value = "Communications">
							<label for="communications">Communications</label>
						</div>
						
						<div>
							<input type="radio" name="category" id="clothes" value = "Clothes">
							<label for="clothes">Clothes</label>
						</div>
						
						<div>
							<input type="radio" name="category" id="gifts" value = "Gifts">
							<label for="gifts">Gifts</label>
						</div>
						
						<div>
							<input type="radio" name="category" id="recreation" value="Recreation">
							<label for="recreation">Recreation & Entertainment</label>
						</div>
								
						<div>
							<input type="radio" name="category" id="misc" value="Miscellaneous">
							<label for="misc">Miscellaneous</label>

						</div>
					</li>
				</div>
				
				<li>
					<label for="amount">Amount:</label>
					<input type="number" name="amount" id="amount" required>    
				</li>

				<li>
					<label for="description">Description:</label>
					<input type="text" name="description" id="description" required>    
				</li>
				
				<button type="submit" class="btn btn-primary" name="addtransactionhsubmit"> Submit </button>
				<button type="reset" class="btn btn-secondary" name="addtransactionhreset"> Reset </button>

			</form>
			
		</div>
		
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
		
	</body>
	
</html>
<?php include('db_close.php'); ?>