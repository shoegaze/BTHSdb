<?php
	session_start();
	include('./inc/dbconnect.php');
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	$query = "select email,level from users where email='{$email}' AND password = '{$password}'";
	$userQuery = $conn->prepare($query);
	$userQuery->execute();
	if($userQuery->rowCount() == 0){
		setcookie('loginError','Wrong username or Password',time() + 2);
		header("location: login.php");
		exit;
	}
	
	$data = $userQuery->fetch(PDO::FETCH_ASSOC);
	//$_SESSION['user'] = $email;
	$_SESSION['user'] = $data['email'];
	$_SESSION['level'] = $data['level'];
	header("location: index1.php");
	exit;
?>