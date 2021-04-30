<?php include('db_connect.php'); ?>

<?php 
if (isset($_POST['submit']))
{	$rawfrom = $_POST['from'];
	$rawto = $_POST['to'];
	
	$from = date('Y-m-d', strtotime($rawfrom));
	$to = date('Y-m-d', strtotime($rawto));
	
	$query = "select category.cname, sum(tamount) as total from transaction
				join belongs_to on transaction.tid = belongs_to.tid
				join category on belongs_to.cid = category.cid where cast(tdate as date) between cast('$from' as date) and cast('$to' as date)
				group by cname;";
	
	$performQuery=mysqli_query($connection, $query);
} 
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		
		<?php
			$rowNum = mysqli_num_rows($performQuery);
			if ($rowNum > 0) {
		?>
		
		<script type="text/javascript">
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				
				var data = google.visualization.arrayToDataTable([
					['Category', 'Amount'],
					
					<?php
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
		
		<?php
			}
		?>
		
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
			<h4>Transactions from <?php echo $from, " to ", $to;?></h4>
			<?php
				if ($rowNum == 0) {
					echo "No result found";
				}
			?>
			<div id="chart_div"></div>
		</div>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	</body>
</html>

<?php include('db_close.php'); ?>