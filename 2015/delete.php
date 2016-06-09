<?php
	
	$id = $_GET['id'];
	$conn = new PDO("mysql:host=localhost;dbname=physics","root","");
	$cmd = "SELECT * FROM items WHERE ID=$id";
	$result = $conn->prepare($cmd);
	$result->execute();
	$data = $result->fetch(PDO::FETCH_NUM);

	echo "<h1> Do you want to delete this data? </h1>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<table class='table'>
			<tr>
				<th>Name</th>
				<th>Room</th>
				<th>Container</th>
				<th>Container Letter</th>
				<th>Serial Number</th>
				<th>Description</th>
			</tr>
			<tr>
				<td>".$data[0]."</td>
				<td>".$data[1]."</td>
				<td>".$data[2]."</td>
				<td>".$data[3]."</td>
				<td>".$data[4]."</td>
				<td>".$data[5]."</td>
			</tr>
		</table>";
	echo "<a href='deleteDB.php?del=true&id=$id' class='btn btn-danger'>Yes</a>
		<a href='deleteDB.php?del=false&id=$id' class='btn btn-success'>No</a>";
	
?>

<html>
	<head>
		<title>Delete data</title>
		<link rel="stylesheet" href="css/bootstrap.css">
		
	</head>
</html>