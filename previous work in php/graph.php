<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				
				var data = google.visualization.arrayToDataTable([
					['Category', 'Amount'],
					
					<?php
						$query = "select category.cname, sum(tamount) as total from transaction
									join belongs_to on transaction.tid = belongs_to.tid
									join category on belongs_to.cid = category.cid
									group by cname;";
    
						$performQuery=mysqli_query($connection, $query);
						
						while($row = mysqli_fetch_array($performQuery)){
							echo "['".$row['cname']."',".$row['total']."],";
						}
					?>
					
				],
				false);
				
				var options = {pieHole: 0.4,
                    'height':600,
				};

				var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			}
		</script>
		<title> Graph </title>
	</head>
	<body>
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
			<ul class="navbar-nav">
				<a class="navbar-brand" href="home.php">Home</a>
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="addTransactionH.php">Add Transactions</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="viewTransactionH.php">View Transactions</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="graph.php">Graph</a>
					</li>
				</ul>
			</ul> 
		</nav>
		<div class="container" style="margin-top:20px; margin-bottom:50px">
			<h4>Graph</h4>
			<form action="periodicGraph.php" method="post">
				<div>
					<p>
						<label for="from">From</label>
						<input type="date" name="from" id="from">
						<label for="to">to</label>		
						<input type="date" name="to" id="to"> 
						<button type="submit" class="btn btn-primary" name="submit"> Go </button>
					</p>				
				</div>
			</form>
			<div id="chart_div"></div>
		</div>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	</body>
</html>

<?php include('db_close.php'); ?>