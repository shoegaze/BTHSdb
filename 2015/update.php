<?php
$id = $_GET['id'];

$conn = new PDO('mysql:host=localhost;dbname=physics','root','');

$cmd = "SELECT * FROM items WHERE id='$id'";
$result = $conn->prepare($cmd);
$result->execute();
$data = $result->fetch();


$name = $data['Name'];
$room = $data['Room'];
$storage = $data['Shelf_or_drawer'];
$container = $data['Container_letter'];
$srnumber = $data['Serial_number'];
$description = $data['Description'];


echo    "<form action='updateDB.php?id=$id' method = 'POST'>
			<div class = 'form-group'>		
				Item name: 
				<input type='text' name='name' value='$name' class = 'form-control'>
			</div>		
			<div class='form-group'>
				Room number:
				<input type='text' name='room' value='$room' class='form-control'>
			</div>
			Storage type:
			<select name='storage' value='$storage'>
				<option value='shelf'>Shelf</option>
				<option value='drawer'>Drawer</option>
			</select>
			<div class='form-group'>
				Container letter:
				<input type='text' name='container-letter' value='$container' class='form-control'>
			</div>
			<div class='form-group'>
				Serial Number:
				<input type='text' name='srnumber' value='$srnumber'>
			</div>
			<div class='form-group'>
				Description:
				<input type='text' name='description' value='$description'>
			</div>
			<button type='submit' class='btn btn-default'>Submit</button>
		</form>";

?>


<html>
	<head>
		<title>Update data</title>
		<link rel='stylesheet' href='css/bootstrap.css'>
	</head>
	<body>
	</body>
</html>