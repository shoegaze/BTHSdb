<?php
	include('inc/header.php');
	
	

?>
	</head>
	<body>
		<?php include('inc/nav_bar.php'); ?>

		<div>
			<?php
				echo "You've logged in " . $_SESSION['user'];
			 ?>
		</div>
	<?php include('inc/footer.php'); ?>