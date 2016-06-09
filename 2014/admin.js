function loadDescending(nameOfCurrentLevel,func,id,nameOfDescendingSelect){
			$("[name='" + nameOfDescendingSelect +"']").empty();
			if(nameOfDescendingSelect == "currentContainer"){
				$("#" + nameOfDescendingSelect).empty();
			}
			var t = $("#locations").find("[name='" + nameOfCurrentLevel +"']");
			var url = "ajax.php?function=" + func + "&" + id + "=" + encodeURIComponent(t.find(":selected").val());
			$.get(url).done(function(data){
					var infomation = JSON.parse(data);
				switch(id){
					case 'roomId':
						for (var i = 0; i < infomation.length; i++) {
							$("[name='" + nameOfDescendingSelect +"']").append("<option value='" + infomation[i]['id'] + "'>" + infomation[i]['name'] +"</option>");
						};
						break;
					case 'sectionId':
						for (var i = 0; i < infomation.length; i++) {
							$("[name='" + nameOfDescendingSelect +"']").append("<option value='" + infomation[i]['id'] + "'>" + infomation[i]['label'] +"</option>");
						};
						break;
					case 'containerId':
						for (var i = 0; i < infomation.length; i++) {
							$("#" + nameOfDescendingSelect).append("<span class='movable' data-id='" + infomation[i]['id']  + "'>" + infomation[i]['name'] + "  X" + infomation[i]['quantity'] +"</span>");
						};
						$(".movable").draggable({
							containment: '#itemManage'
						});
						break;
					default:
						break;
				}	
			});
		}

		function createUser(){
			var email = $('#createUser').find("[name='email']")[0];
			var level = $('#createUser').find("[name='level']")[0];
			
			var url = "admin.ajax.php?function=createUser&email=" + encodeURIComponent(email.value) + "&level=" + encodeURIComponent(level.value);
					$.get(url).done(function(data){
						($('#createUser').find('.result')[0]).innerHTML = data;
						//There is an error code(usually 23000 meaning users added already)
						if(!isNaN(parseInt(data))){
							($('#createUser').find('.result')[0]).innerHTML = "The user already exists!";
						}
					}).fail(function(data){
						($('#createUser').find('.result')[0]).innerHTML = "There was an MAJOR ERROR!";
					});
		}

		/**
			Deletes a user by their ID.
		 */
		function deleteUser(userElement){
			var accountToBeDeleted = $(userElement).attr('data-user');

			var url = "admin.ajax.php?function=deleteUserById&id=" + encodeURIComponent(accountToBeDeleted);
			$.get(url).done(function(data){
				if(isNaN(data)){
					alert(data);
				}else{
				parent.$("[data-user='" + data + "']").remove();
					console.log("data");
				}
				parent.$.fancybox.close();
			}).fail(function(data){
				($('#deleteUser').find('.result')[0]).innerHTML = "There was an MAJOR ERROR!";
			});
		}

		function updatePassword(){
			var passwords = $("[type='password']");
			if(passwords[0].value != passwords[1].value){
				$("#modifyMyAccount").find('.result')[0].innerHTML = "The Passwords Don't Match!";
				return;
			}
			var url = "admin.ajax.php?function=updatePassword&password=" + encodeURIComponent(passwords[0].value);
			$.get(url).done(function(data){
				($('#modifyMyAccount').find('.result')[0]).innerHTML = data;
			}).fail(function(data){
				($('#deleteUser').find('.result')[0]).innerHTML = "There was an MAJOR ERROR!";
			});

		}

		function createItem(){
			var itemName = $("#items").find("[name='nameOfItem']")[0].value;
			var description = $("#items").find("[name='description']")[0].value;
			var serial = $("#items").find("[name='serial']")[0].value;
			if(itemName == ""){
				return;
			}
			var url = "admin.ajax.php?function=createItem&name=" + encodeURIComponent(itemName) + "&description=" + encodeURIComponent(description) + "&serial=" + encodeURIComponent(serial);
			$.get(url).done(function(data){
				alert("You made a " + itemName);
				$("[name='itemsList']").append("<option data-id='" + data + "' value='" + itemName + "'>" + itemName +"</option>"); 
			});
		}

		function deleteItem(itemId){
			var itemId = $("[name='itemsList']").find(":selected").attr("data-id");
			var url = "admin.ajax.php?function=deleteItem&itemId=" + encodeURIComponent(itemId);
			$.get(url).done(function(data){
				alert("It has been deleted");
				$("[name='itemsList']")[0].remove($("[name='itemsList']").find("[data-id='" + data + "']")); 
			});
		}