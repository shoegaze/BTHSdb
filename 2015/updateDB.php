<?php
$conn = new PDO("mysql:host=localhost;dbname=physics","root","");
$id = $_GET['id'];
$name = $_POST['name'];
$room = $_POST['room'];
$storage = $_POST['storage'];
$container = $_POST['container-letter'];
$srnumber = $_POST['srnumber'];
$description = $_POST['description'];

$cmd = "UPDATE items SET Name='$name', Room='$room', Shelf_or_drawer='$storage',Container_letter='$container',Serial_number='$srnumber',Description='$description' WHERE ID = $id";


$conn->exec($cmd);
header("Location:view.php");
?>

