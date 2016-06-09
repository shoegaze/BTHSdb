<?php 
	session_start();

	include("./inc/dbconnect.php");


	function itemDetails($itemId){
		global $conn;
		$queryStatement = "Select description from items where id='{$itemId}'";
		//$queryStatement = "select i.name,i.description,assign.quantity,c.type,c.label,s.name 'Section_name',r.name 'Room_Name',r.number from items i join container_item_assignments assign join containers c join sections s join rooms r on i.id =assign.item_id AND c.id=assign.container_id AND c.section_id=s.id AND s.room_id = r.id where i.id ={$itemId}";
		$query = $conn->prepare($queryStatement);
		$query->execute();

		//json array
		$data = array();
		$results = $query->fetch(PDO::FETCH_ASSOC);
		$data[] = $results['description'];
		$containers = findContainer($itemId);
		//Finds the sections of all the containers
		for ($i=0; $i < count($containers) ; $i++) { 
			$containers[$i]['section'] = findSection($containers[$i]['container_id']);
		}
		
		//Finds the rooms of the sections
		for ($i=0; $i < count($containers) ; $i++) { 
			$containers[$i]['room'] = findRoom($containers[$i]['section']['section_id']);
		}
		$data[] = $containers;

		return json_encode($data);
	}

	function findContainer($itemId){
		global $conn;
		$queryStatement = "Select container_id,quantity from container_item_assignments where item_id='{$itemId}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		$containers = array();
		while($row = $query->fetch(PDO::FETCH_ASSOC)){
			$containers[] = $row; 
		}
		return $containers;
	}

	function findSection($containerId){
		global $conn;
		$queryStatement = "Select section_id,label 'container_label',type 'container_type' from containers where id='{$containerId}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	}
	

	function findRoom($sectionId){
		global $conn;
		$queryStatement = "Select r.name,s.name 'section_name',number 'room_number' from sections s join rooms r on s.room_id = r.id where s.id='{$sectionId}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	function subjectAreas(){

	}

	function itemDescription($itemId){
		global $conn;
		$queryStatement = "Select description from items where id='{$itemId}'";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		$description = $query->fetch(PDO::FETCH_NUM);
		return $description[0];
	}
	
	function loadSections($roomId)
	{
		global $conn;
		$queryStatement = "select * from sections where room_id = " . $roomId;
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return json_encode($query->fetchAll());
	}
	
	function loadEquipment($containerId)
	{
		global $conn;
		$queryStatement = "select i.id, i.name, i.description, i.serial_number, a.quantity from items i, container_item_assignments a where i.id = a.item_id AND a.container_id = " . $containerId;
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return json_encode($query->fetchAll());
	}
	
	function loadContainers($sectionId)
	{
		global $conn;
		$queryStatement = "select * from containers where section_id = " . $sectionId . " order by type";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		return json_encode($query->fetchAll());
	}
	
	switch($_GET["function"])
	{
		case "itemDetails":	
			echo itemDetails($_GET['itemId']);
			return;
		case "itemDescription":
			echo itemDescription($_GET['itemId']);
			return;	
		case "loadSections":
			echo loadSections($_GET["roomId"]);
			return;
		case "loadContainers":
			echo loadContainers($_GET["sectionId"]);
			return;
		case "loadEquipment":
			echo loadEquipment($_GET["containerId"]);
			return;
		default:
			return;								
	}
?>