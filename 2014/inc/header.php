<?php
	/**
	 *	Includes all the code Needed for the Headers for Pages!
	 *
	 */

	session_start();

	//prevents infinte loop on login page
	if(!isset($loginPage)){
		$loginPage = false;
	}	

	if(!isset($_SESSION['user']) && $loginPage == false){
		header("Location:login.php");
		exit;
	}

	if(isset($needDB) && $needDB == true)
		include_once('./inc/dbconnect.php');

	if(!isset($pageName))
		$pageName = basename($_SERVER['PHP_SELF']); 

 ?>
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $pageName; ?></title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href="css/bootstrap.super.css" rel="stylesheet">
	<style type="text/css">
	.label-lg-b{
		font-size: 14px;
		font-weight: 700;
	}
	</style>

	 <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/bootstrap.min.js"></script>