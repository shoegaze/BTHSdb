<?php 

$levels = array(
	0 => "teacher",
	1 => "admin",
	2 => "superadmin"
);

function getLevels($currentUsersLevels){
	global $levels;

	$levelsOfUser = -1;
	switch ($currentUsersLevels) {
		case 'teacher':
			$levelsOfUser = 0;
			break;
		case 'admin':
			$levelsOfUser = 1;
			break;
		case 'superadmin':
			$levelsOfUser = 1;
			break;
		default:
			break;
	}
	$levelsAvaliable = array();

	while($levelsOfUser > -1){
		$levelsAvaliable[] = $levels[$levelsOfUser];
		$levelsOfUser--; 
	}

	return $levelsAvaliable;
}


?>