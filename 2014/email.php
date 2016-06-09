<?php 
	/* Check if valid!!! */
	$pageName = "Email User";
	$needDB = true;
	include('inc/header.php');

	function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'){
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
  }
?>
</head>
<body>
	<?php 
		
		$queryStatement = "Select email from users where id='" . $_SESSION['userModifying'] . "';";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		$results = $query->fetch();
		
		$pwd = randString(25);

		$to      = $results['email'];
		$subject = 'Physics System';
		$message = 'Your password has been reset as requested. Change your password when you login. YOUR TEMPORARY PASSWORD IS ' . $pwd;
		$headers = 'From: PHYSICSEMAIL@bths.edu' . "\r\n" .
		    'Reply-To: NO-REPLY@example.com' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		if(mail($to, $subject, $message, $headers)){
			$queryStatement = "Update users set password='". md5($pwd) . "' where id='" . $_SESSION['userModifying'] . "';";
			$query = $conn->prepare($queryStatement);
			$query->execute();
			echo "Email was successfully sent";
		}else{
			echo "Email failure";
		}


	?>
	<?php include('inc/footer.php'); ?>