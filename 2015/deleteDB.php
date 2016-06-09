<?php
$conn = new PDO("mysql:host=localhost;dbname=physics","root","");
if($_GET['del']==="false")
	header("Location:view.php");
$id = $_GET['id'];
$cmd = "DELETE FROM items WHERE ID=$id";
$conn->exec($cmd);

header("Location:view.php");

?>