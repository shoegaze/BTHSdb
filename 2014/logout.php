<?php
session_start();
	if(isset($_SESSION['user'])){
		unset($_SESSION['user']);
		unset($_SESSION['level']);
	}
	header("location: login.php");
	exit;
?>