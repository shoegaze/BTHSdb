<?php
$conn = new PDO("mysql:host=localhost;dbname=physics","root","");
$cmd = "SELECT * FROM items";

$result = $conn->prepare($cmd);
$result->execute();
$data = $result->fetchAll(PDO::FETCH_NUM);



echo "<table class='table'>";

echo "<tr>
<th>Name</th>
<th>Room</th>
<th>Container</th>
<th>Container Letter</th>
<th>Serial number</th>
<th>Description</th>
<th>ID</th>
<th>Update</th>
<th>Delete</th>
</tr>";

for ($i=0; $i < count($data); $i++) {
	echo "<tr>"; 
	for ($j=0; $j < count($data[$i]); $j++) { 
		echo "<td>";
		echo $data[$i][$j];
		echo "</td>";
	}
	$id = $i + 1;
	echo "<td><a href='update.php?id=$id' class='btn btn-primary'>Update</a></td>";
	echo "<td><a href='delete.php?id=$id' class='btn btn-danger'>Delete</a></td>";

	echo "</tr>";
}



echo "</table>";
?>

<html>
<head>
	<title>View data</title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>

</body>
</html>