<?php include('db_connect.php'); ?>

<?php 
if(isset($_POST['addtransactionhsubmit']))
{   $category = $_POST['category'];
	$description = $_POST['description'];
	$amount = $_POST['amount'];

	$query = "insert into transaction(tdescription, tamount)
			values('$description', $amount)";        
        
    $performQuery=mysqli_query($connection, $query);

	if(!$performQuery)
		//echo 'Query unsuccessful';
		echo ("Error description: " . mysqli_error($connection));

	$tid=mysqli_insert_id($connection);
	
	$query = "select cid from category where cname = '$category'";
	
	$performQuery=mysqli_query($connection, $query);
    
	if(!$performQuery)
		echo ("Error description: " . mysqli_error($connection));
		
	$row = mysqli_fetch_assoc($performQuery);
	$cid=$row["cid"];
	
	$query = "insert into belongs_to(cid, tid)
				values($cid, $tid)";
	
	$performQuery=mysqli_query($connection, $query);
    
	if(!$performQuery)
		echo ("Error description: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
		
		<title> Add Transactions </title>
	</head>
	<body>
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
			<ul class="navbar-nav">
				<a class="navbar-brand" href="home.php">Home</a>
				<ul class="navbar-nav">
					<li class="nav-item" active>
						<a class="nav-link" href="addTransactionH.php">Add Transactions</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="viewTransactionH.php">View Transactions</a>
					</li>
				</ul>
			</ul> 
		</nav>
		<div class="container" style="margin-top:20px; margin-bottom:50px">
			
			<h4>Transaction added</h4>
			
		</div>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	</body>
</html>

<?php include('db_close.php'); ?>