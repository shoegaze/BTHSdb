<?php
	//fuck optimization, I do what I want
	$needDB = true;
	include('inc/header.php');


	$queryStatement = "select * from items where id = " . $_GET["id"] . ";";
	$query = $conn->prepare($queryStatement);
	$query->execute();

	$item = $query->fetch(PDO::FETCH_ASSOC);

	$queryStatement = "select * from containers where id in (select container_id from container_item_assignments where item_id = " . $_GET["id"] . ");";
	$query = $conn->prepare($queryStatement);
	$query->execute();

	$containers = $query->fetchAll(PDO::FETCH_ASSOC);

	function get_section($a)
	{
		return $a["section_id"];
	}
	$queryStatement = "select * from sections where id in (" . join(",", array_map("get_section", $containers)) . ");";
	$query = $conn->prepare($queryStatement);
	$query->execute();

	$sections = $query->fetchAll(PDO::FETCH_ASSOC);

	function get_room($a)
	{
		return $a["room_id"];
	}
	$queryStatement = "select * from rooms where id in (" . join(",", array_map("get_room", $sections)) . ");";
	$query = $conn->prepare($queryStatement);
	$query->execute();

	$rooms = $query->fetchAll(PDO::FETCH_ASSOC);

	function getName($a)
	{
		return $a["name"];
	}

	$queryStatement = "select name from subject_area where id in (select subject_area_id from subject_area_item_assignments where item_id = " . $item[1] . ")";
	$query = $conn->prepare($queryStatement);
	$query->execute();

	$item["subjects"] = $query->fetchAll(PDO::FETCH_ASSOC);
?>
		<style type="text/css">
			.indent {
				margin-left:50px;
			}
			.description {
				margin-left:20px;
			}
		</style>
	</head>
	<body>
		<?php
			include('inc/nav_bar.php');
		?>
		<div class="indent">
			<div class="item">
				<h3>
					<?php echo($item['name']); ?>
				</h3>
				<div class='description'>
					<?php echo($item['description']); ?>
				</div>
				<?php echo("<div class='subjects'> Subject areas: " . join(", ", array_map("getName", $item["subjects"]))); ?>
				<h4>
					In room(s): 
				</h4>
				<div class='rooms'>
					<?php 
						foreach($rooms as $room)
						{
							echo("<div class='room'>");
							echo($room["name"] . ", ");
							$room_sections = [];
							for($i = 0; $i<count($sections); $i++)
							{
								$section = $sections[$i];
								$section_containers = [];
								if($section["room_id"] == $room["id"])
								{
									foreach($containers as $container)
									{
										if($container["section_id"] == $section["id"])
										{
											array_push($section_containers, $container["type"] . " " . $container["label"]);
										}
									}
									if(count($section_containers) > 1)
									{
										array_push($room_sections, $section["name"] . ", containers " . join(", ", $section_containers));
									}
									else
									{
										array_push($room_sections, $section["name"] . ", container " . $section_containers[0]);
									}
								}
							}
							if(count($room_sections) > 1)
							{
								echo("sections " . join(", ", $room_sections));
							}
							else
							{
								echo("section " . $room_sections[0]);
							}
							echo("</div>");
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>
