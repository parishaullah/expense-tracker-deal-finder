<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">

	<head>
	
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

		<title>Expense Tracker</title>
	
	</head>
	
	<body>
		
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
			<ul class="navbar-nav">
				<a class="navbar-brand active" href="home.php">Home</a>
				<ul class="navbar-nav">
					<li class="nav-item">
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
	
		<div class="container" style="margin: 0; position: absolute; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%)">
			<h1 style="font-size:10vw">Expense Tracker</h1>
		</div>
		
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
		
	</body>
	
</html>
<?php include('db_close.php'); ?>