<?php 
	
	$target_path = "uploads/";

	$target_path = $target_path . basename( $_FILES['csv']['name']); 

	$path = $_FILES['csv']['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	echo $ext;

	if($ext != "csv")
		die;


	if(move_uploaded_file($_FILES['csv']['tmp_name'], $target_path)) {
	    echo "The file ".  basename( $_FILES['csv']['name']). " has been uploaded";
	} else{
	    echo "There was an error uploading the file, please try again!";
	}

?>
