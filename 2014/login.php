<?php
	$loginPage = true;
	$pageName = "login";
	require('./inc/header.php');

?>

	</head>
	<body>
		<form id="loginForm" method="POST" action="attemptlogin.php">
				<h3> Login </h3>
				<label>Email:<input type="email" name="email"></label>
				<label>Password:<input type="password" name="password"></label>
				<div><?php 
					if(isset($_COOKIE['loginError'])){
					echo $_COOKIE['loginError'];
				} ?></div>
				<input type="submit" value='Login'>
		</form>
	<?php include('inc/footer.php'); ?>