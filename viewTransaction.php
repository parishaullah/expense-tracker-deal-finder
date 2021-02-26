<?php include('db_connect.php'); ?>

<?php 
if(isset($_POST['submit1']))
{   $category = $_POST['category'];
	
	$query = "select transaction.tid, tamount, tdescription, tdate from transaction
				join belongs_to on transaction.tid = belongs_to.tid
				join category on belongs_to.cid = category.cid where cname='$category';";
    
	$performQuery=mysqli_query($connection, $query);
} elseif (isset($_POST['submit2']))
{	$rawfrom = $_POST['from'];
	$rawto = $_POST['to'];
	
	$from = date('Y-m-d', strtotime($rawfrom));
	$to = date('Y-m-d', strtotime($rawto));
	
	$query = "select transaction.tid, tamount, tdescription, tdate from transaction
				join belongs_to on transaction.tid = belongs_to.tid
				join category on belongs_to.cid = category.cid where cast(tdate as date) between cast('$from' as date) and cast('$to' as date);";
	
	$performQuery=mysqli_query($connection, $query);
} elseif (isset($_POST['submit3']))
{	$query = "select transaction.tid, tamount, tdescription, tdate from transaction
				join belongs_to on transaction.tid = belongs_to.tid
				join category on belongs_to.cid = category.cid;";
	
	$performQuery=mysqli_query($connection, $query);
} 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
		
		<title> View Transactions </title>
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
				</ul>
			</ul> 
		</nav>
		<div class="container" style="margin-top:20px; margin-bottom:50px">
			<?php
				if (mysqli_num_rows($performQuery) > 0) {
			?>
			<h4>Transactions</h4>
			<div class="table-responsive-md">
				<table class="table table-striped table-bordered">
					<thead class="thead-light">
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Amount</th>
							<th scope="col">Description</th>
							<th scope="col">Date</th>
						</tr>
					</thead>
					<?php
						$i=0;
						while($row = mysqli_fetch_array($performQuery)) {
					?>
					<tbody>
						<tr>
							<th scope="row"><?php echo $row["tid"]; ?></th>
							<th scope="row"><?php echo $row["tamount"]; ?> BDT</th>
							<th scope="row"><?php echo $row["tdescription"]; ?></th>
							<th scope="row"><?php echo $row["tdate"]; ?></th>
						</tr>
						<?php
							$i++;
							}
						?>
					</tbody>
				</table>
			</div>
			 <?php
				}
				else{
					echo "No result found";
				}
			?>
		</div>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	</body>
</html>

<?php include('db_close.php'); ?>