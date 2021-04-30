<?php
	$category = $_POST['category'];
	$description = $_POST['description'];
	$amount = $_POST['amount'];
	
	$conn = new mysqli('localhost', 'root', '', 'expenses');
	if (mysqli_connect_error()){
		die('Connect Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
	} else {
		$sql = "insert into transactions(tdescription, tamount)
			values('$description', '$amount')";
		if ($conn->query($sql)){
			echo "New record is inserted sucessfully";
		} else {
			echo "Error: ". $sql ."". $conn->error;
		}
		$conn->close();
	}
?>