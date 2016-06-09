<?php
	// name room storage container-letter srnumber description 
	$conn = new PDO("mysql:host=localhost;dbname=physics","root","");
	$name = $_POST["name"];
	$room = $_POST["room"];
	$storage = $_POST["storage"];
	$container = $_POST["container-letter"];
	$srnumber = $_POST["srnumber"];
	$description = $_POST["description"];

	$cmd = "INSERT INTO `items`(`Name`, `Room`, `Shelf_or_drawer`, `Container_letter`, `Serial_number`, `Description`) VALUES ('$name','$room','$storage','$container','$srnumber','$description')";
	$conn->exec($cmd);

	header("location:insert.html");
?>