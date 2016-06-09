<?php
try{

	$conn = new PDO('mysql:host=localhost;dbname=whate','root','');
}catch(Exception $e){
	echo "DB Error";
	die;
}	 

?>