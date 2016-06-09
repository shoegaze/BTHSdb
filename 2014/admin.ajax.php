<?php 
	session_start();

	include("./inc/dbconnect.php");

	function createUser($email,$level){
		global $conn;
		$DEFAULT_PASSWORD = md5('physics');
		$queryStatement = "Insert into users(email,level,password) VALUES('{$email}','{$level}','{$DEFAULT_PASSWORD}')";
		$query = $conn->prepare($queryStatement);
		$result = $query->execute();
		if($result == false){
			return $query->errorCode();
		}
		return $email . " was created as an " . $level;
	}

	function deleteUser($email){
		global $conn;
		$queryStatement = "Delete from users where email = '{$email}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return $email;
	}

	function deleteUserById($id){
		global $conn;
		if($_SESSION['userModifying'] != $id){
			return "That user cannot currently be deleted. Modify Users one at a time. Try again later.";
		}
		$queryStatement = "Delete from users where id = '{$id}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return $id;
	}

	function changeUserLevel($id,$level){
		global $conn;
		if($_SESSION['userModifying'] != $id){
			return "That user cannot currently be deleted. Modify Users one at a time. Try again later.";
		}
		$queryStatement = "Update users set level='{$level}' where id='{$id}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return "This user is now an {$level}";
	}

	function updatePassword($password){
		global $conn;
		$password = md5($password);
		$email = $_SESSION['user'];
		$queryStatement = "Update users set password='{$password}' where email='{$email}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return "Your password has been updated. If you forget it just contact administration.";
	}

	function createItem($name,$description,$serial){
		global $conn;
		$queryStatement = "Insert into items(name,description,serial_number) VALUES('{$name}','{$description}','{$serial}')";
		$query = $conn->prepare($queryStatement);
		$result = $query->execute();
		$queryStatement = "Select max(id) from items";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		$newItem = $query->fetch(PDO::FETCH_NUM);
		return $newItem[0];
	}

	function deleteItem($itemId){
		global $conn;
		$queryStatement = "Delete from items where id = '{$itemId}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		$queryStatement = "Delete from container_item_assignments where item_id ='{$itemId}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return $itemId;

	}

	function removeItem($itemId,$containerId){
		global $conn;
		$queryStatement = "Delete from container_item_assignments where item_id = '{$itemId}' AND container_id = '{$containerId}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return;
	}

	function insertItem($itemId,$containerId,$quantity){
		global $conn;

		//if Item already in container we just update quantity
		$queryStatement = "Select quantity from container_item_assignments where item_id = '{$itemId}' AND container_id = '{$containerId}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		//updates quantity
		if($query->rowCount() != 0){
			$quantityAlreadyExist = $query->fetch(PDO::FETCH_NUM);
			$quantity += $quantityAlreadyExist[0];
			$queryStatement = "Update container_item_assignments set quantity='{$quantity}' where item_id = '{$itemId}' AND container_id = '{$containerId}'";
			$query = $conn->prepare($queryStatement);
			$query->execute();
		}else{
			$queryStatement = "Insert into container_item_assignments(item_id,container_id,quantity) VALUES('{$itemId}','{$containerId}','{$quantity}')";
			$query = $conn->prepare($queryStatement);
			$result = $query->execute();
		}
		return json_encode(array("quantity" => $quantity, "id" => $itemId));
	}

	switch($_GET["function"])
	{
		case "createUser":
			echo createUser($_GET["email"],$_GET["level"]);
			return;
		case "deleteUser":
			echo deleteUser($_GET['email']);
			return;
		case 'updatePassword':
			echo updatePassword($_GET['password']);
			break;
		case 'createItem':
			echo createItem($_GET['name'],$_GET['description'],$_GET['serial']);
			break;
		case 'deleteItem':
			echo deleteItem($_GET['itemId']);
			break;
		case 'insertItem':
			echo insertItem($_GET['itemId'],$_GET['container'],$_GET['quantity']);
			break;
		case 'removeItem':
			echo removeItem($_GET['itemId'],$_GET['container']);
			break;
		case 'deleteUserById':
			echo deleteUserById($_GET['id']);
			break;
		case 'changeUserLevel':
			echo changeUserLevel($_GET['id'],$_GET['level']);
			break;
		default:
			return;								
	}
?>