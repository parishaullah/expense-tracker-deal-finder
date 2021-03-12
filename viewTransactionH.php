<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">

	<head>
	
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

		<title>View transactions</title>
	
	</head>
	
	<body>
	
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
			<ul class="navbar-nav">
				<a class="navbar-brand" href="home.php">Home</a>
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="addTransactionH.php">Add Transactions</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="viewTransactionH.php">View Transactions</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="graph.php">Graph</a>
					</li>
				</ul>
			</ul> 
		</nav>
	
		<div class="container" style="margin-top:20px; margin-bottom:50px">
		
			<form action="viewTransaction.php" method="post">
				
				<h4>View Transactions</h4>
				
				<div>
					<li>
						<label for="category">Choose a category:</label>
						<p>
							<select name="category" id="category">
								<option value="Beauty">Beauty</option>
								<option value="Bills">Bills</option>
								<option value="Electronics">Electronics</option>
								<option value="Communications">Communications</option>
								<option value="Food">Food</option>
							</select>
							<button type="submit" class="btn btn-primary" name="submit1"> Go </button>
						</p>
					</li>
				</div>
				
				<div>
					<li>
						<label for="dates">Select dates:</label>
						<p>
							<label for="from">From</label>
							<input type="date" name="from" id="from">
							<label for="to">to</label>		
							<input type="date" name="to" id="to"> 
							<button type="submit" class="btn btn-primary" name="submit2"> Go </button>
						</p>
					</li>
				</div>
				
				<div>
					<li>
						<button type="submit" class="btn btn-primary" name="submit3">View all</button>
					</li>
				</div>

			</form>
			
		</div>
		
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
		
	</body>
	
</html>
<?php include('db_close.php'); ?>