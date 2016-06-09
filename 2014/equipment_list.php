<?php

	$needDB = true;
	include('inc/header.php');


	$queryStatement = "select name, id, description from items";
	$query = $conn->prepare($queryStatement);
	$query->execute();

?>
		<style type="text/css">
			.indent {
				margin-left:50px;
			}
		</style>
	</head>
	<body>
		<script>
			$("#search_field").on("keydown", function(e){
				if((e.keyCode || e.which) == 13)
				{
					var t = $(this);
					var input = t.val().toLowerCase();
					if(input.length == 0)
					{
						$(".item-container").each(function(){
							t.show();
						});
					}
					else
					{
						$(".item-container").each(function(){
							var t = $(this);
							t.hide();
							if(t.data("name").substring(0, input.length).toLowerCase() == input)
							{
								t.show();
							}
						});
					}
				}
			});
		</script>
		<?php
			include('inc/nav_bar.php');
		?>
		<div class="indent">
			<input type="text" id="search_field" />
		</div>
		<div class="indent">
		<?php
			$queryStatement = "select * from subject_area";
			$query3 = $conn->prepare($queryStatement);
			$query3->execute();

			$result = $query3->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row)
			{
				echo("<input checked='true' class='subject_area_input' type='checkbox' id='" . $row["name"] . "' />" . $row["name"]);
			}
			echo("</div>");
			function getName($a)
			{
				return $a["name"];
			}
			while($item = $query->fetch(PDO::FETCH_NUM)) {
				$queryStatement = "select name from subject_area where id in (select subject_area_id from subject_area_item_assignments where item_id = " . $item[1] . ")";
				$query2 = $conn->prepare($queryStatement);
				$query2->execute();
				$item["subjects"] = $query2->fetchAll();
				echo "<div class=\"indent item-container\" data-subjects='" . join(",", array_map("getName", $item["subjects"])) . "' data-name=" . $item[0] . ">";
				echo("<div class='item_details'>
					<a href=\"equipment.php?id=$item[1]\"><h4 class='item' data-id='" . $item[1] . "'>" . $item[0] . "</h3></a>
					<div class='description'> Description: " . $item[2] . "</div>");
				if(count($item["subjects"]) != 0)
				{
					echo("<div class='subjects'> Subject areas: " . join(", ", array_map("getName", $item["subjects"])));
				}
				echo("</div>");
				echo "</div></div>";
			}
		?>
		<script>
			function subjectsChecked(elem)
			{
				var subjects = $(elem).data("subjects").split(",");
				var elems = $(".subject_area_input:checked");
				for(var x = 0; x < elems.length; x++)
				{
					for(var i = 0; i < subjects.length; i++)
					{
						if(subjects[i] == $(elems[x]).attr("id"))
							return true;
					}
				}
				return false;
			}
			$(".subject_area_input").on("click", function(){
				$(".item-container").each(function(){
					$(this).hide();
					if(subjectsChecked(this))
					{
						$(this).show();
					}
				});
			});
		</script>
	</body>
</html>
