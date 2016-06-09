<?php
	$pageName = "Equipment Page";
	$needDB = true;

	include('inc/header.php');

	$query = $conn->prepare("select * from rooms");
	$query->execute();
	$rooms = $query->fetchAll();
	for($i = 0; $i < count($rooms); $i++)
	{
		$query = $conn->prepare("select * from sections where room_id = " . $rooms[$i]["id"]);
		$query->execute();
		$rooms[$i]["sections"] = $query->fetchAll();
		for($x = 0; $x < count($rooms[$i]["sections"]); $x++)
		{
			$query = $conn->prepare("select * from containers where section_id = " . $rooms[$i]["sections"][$x]["id"]);
			$query->execute();
			$rooms[$i]["sections"][$x]["containers"] = $query->fetchAll();
			for($y = 0; $y < count($rooms[$i]["sections"][$x]["containers"]); $y++)
			{
				$query = $conn->prepare("select * from items where id in (select item_id from container_item_assignments where container_id = " . $rooms[$i]["sections"][$x]["containers"][$y]["id"] . ")");
				$query->execute();
				$rooms[$i]["sections"][$x]["containers"][$y]["items"] = $query->fetchAll();
			}
		}
	}
?>
	<style>
		.room-sections{
			display:none;
		}
		.sections-containers{
			display:none;
		}
		.container-items{
			display:none;
		}
	</style>
	<script>
		$(document).ready(function(){
			$(".room-name").on("click", function(){
				$(this).siblings(".room-sections").toggle();
			});
		});
		$(document).ready(function(){
			$(".section-name").on("click", function(){
				$(this).siblings(".section-containers").toggle();
			});
		});
		$(document).ready(function(){
			$(".container-name").on("click", function(){
				$(this).siblings(".container-items").toggle();
			});
		});
	</script>
	</head>
	<body>
		<div class="container">
			<div class="col-mid-4">
				
			</div>
			<div class="col-mid-4">
				<div class="rooms">
					<?php
						foreach($rooms as $room)
						{
							echo("<div class=\"room\">");
								echo("<div class=\"room-name\">". $room['name'] . "</div>");
								echo("<div class=\"room-sections\">");
									foreach($room["sections"] as $section)
									{
										echo("<div class=\"section\">");
											echo("<div class=\"section-name\">" . $section['name'] . "</div>");
											echo("<div class=\"section-containers\">");
												foreach($section["containers"] as $container)
												{
													echo("<div class=\"container-name\">" . $container['type'] . " " . $container['label'] . "</div>");
													echo("<div class=\"container-items\">");
														foreach($container["items"] as $item)
														{
															echo("<div class=\"item-name\">" . $item["name"] . "</div>");
														}
													echo("</div>");
												}
											echo("</div>");
										echo("</div>");
									}
								echo("</div>");
							echo("</div>");
						}
					?>
				</div>
			</div>
			<div class="col-mid-4">
				
			</div>
		</div>
	</body>
</html>
