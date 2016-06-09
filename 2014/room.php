<?php
	
	$needDB = true;
	include('inc/header.php');

	$queryStatement = "select name, id, number from rooms";
	$query = $conn->prepare($queryStatement);
	$query->execute();

?>
		<style type="text/css">
			.section{
				margin-left:10px;
			}
			.container2{
				margin-left:20px;
			}
			.item{
				margin-left:30px;
			}
		</style>
		<script type="text/javascript">
			$(document).ready(function(){
				function loadEquipment()
				{
					var t = $(this);
					if(!t.data("loaded"))
					{
						$.get("ajax.php?function=loadEquipment&containerId=" + t.data("id"), function(data){
							t.data("loaded", true);
							data = JSON.parse(data);
							var itemsContainer = t.siblings(".items_container");
							var newHtml = "";
							for(var i=0; i < data.length; i++)
							{
								newHtml += "<div class='item_container'><div class='item' data-id='" + data[i].id + "'>" + data[i].name + "</div></div>";
							}
							itemsContainer.html(newHtml);
						});
					}
				}
			
				function loadContainers()
				{
					var t = $(this);
					if(!t.data("loaded"))
					{
						$.get("ajax.php?function=loadContainers&sectionId=" + t.data("id"), function(data){
							t.data("loaded", true);
							data = JSON.parse(data);
							var containersContainer = t.siblings(".containers_container");
							var newHtml = "";
							for(var i=0; i < data.length; i++)
							{
								newHtml += "<div class='container_container'><div class='container2' data-id='" + data[i].id + "'>" + data[i].type + " " + data[i].label +"</div><div class='items_container'></div></div>";
							}
							containersContainer.html(newHtml);
							containersContainer.children(".container_container").each(function(){
								$(this).children(".container").on("click", loadEquipment);
							});
						});
					}
					else
					{
						t.siblings(".containers_container").toggle();
					}
				}

				function loadSections()
				{
					var t = $(this);
					if(!t.data("loaded"))
					{
						$.get("ajax.php?function=loadSections&roomId=" + t.data("id"), function(data){
							t.data("loaded", true);
							data = JSON.parse(data);
							var sectionsContainer = t.siblings(".sections_container");
							var newHtml = "";
							for(var i=0; i < data.length; i++)
							{
								newHtml += "<div class='section_container'><div class='section' data-id='" + data[i].id + "'>Section " + data[i].name +"</div><div class='containers_container'></div></div>";
							}
							sectionsContainer.html(newHtml);
							sectionsContainer.children(".section_container").each(function(){
								$(this).children(".section").on("click", loadContainers);
							});
						});
					}
					else
					{
						t.sibilings(".containers_container").toggle();
					}
				}
				$(".room").on("click", loadSections);
			});
		</script>
	</head>
	<body>
		<?php 
			while($room = $query->fetch(PDO::FETCH_NUM)) {
				echo "<div class='room' data-id='" . $room[1] . "'>" . $room[2] . ", " . $room[0] . "</div>";
				echo "<div class='sections_container'></div>";
			}
		?>
	</body>
</html>
