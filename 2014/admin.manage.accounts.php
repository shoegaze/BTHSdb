<div id="userContainer">
	<div id="createUser" class="userControl panel panel-primary">
		<h3 class="panel-heading">Create Users</h3>
		<div class="panel-body"> 
			<div class="result"></div>
				<form class="form-horizontal">
					<fieldset>
						<div class="form-group">
							<label for="email-input" class="col-lg-1 control-label label-lg-b">Email</label>
							<div class="col-lg-8">
								<input class="form-control" id="email-input" type="email" placeholder="email" name="email" maxlength="256"/>     
							</div>
						</div>
						<div class="form-group">
							<label for="priv-input" class="col-lg-1 control-label label-lg-b">Level</label>							
							<div class="col-lg-3 col-md-5">
								<select class="form-control" id="priv-input">
									<?php

										require('inc/level_dropdown.php');

										$levelsAvaliable = getLevels($_SESSION['level']);

										foreach ($levelsAvaliable as $level) {
											echo "<option value='{$level}'>" . strtoupper($level) ."</option>";
										}
									?>
								</select>
							</div>
						</div>
					</fieldset>
				</form>
			<button class="btn-primary" onclick="createUser();">Create User</button>
		</div>
	</div>
	<div id="deleteUser" class="userControl panel panel-primary">
		<h3 class="panel-heading">Delete User</h3>
		<div class="result"></div>
		<?php

			$possibleUsersToModify = "select email,id from users where email != '" . $_SESSION['user'] . "' AND level != 'admin' AND level != 'superadmin'";
			if($_SESSION['level'] == "superadmin")
				$possibleUsersToModify = "select email,id from users where email != '" . $_SESSION['user'] . "'";
			
			$usersList = listOptions($possibleUsersToModify);

			?>
			<ul class="panel-body">
			<?php 	
			
				foreach ($usersList as $user) {
			?>
				<li data-user="<?php echo $user[1]; ?>" style="list-style-type:none;">
					<span href="./admin.modify.user.php?userId=<?php echo $user[1] ?>" title="<?php echo $user[0]; ?>" class="fancybox fancy.iframe" ><?php echo $user[0]; ?></span>
				</li>
			<?php

				}			
			?>
			</ul>
	</div>
</div>