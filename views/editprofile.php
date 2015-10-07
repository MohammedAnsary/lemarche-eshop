<?php
	$title = 'Edit';
	require_once('header.php');
?>

		<form enctype="multipart/form-data" method="post" action="editUserAccount">
			<div class="form-wrapper">
				<div class="error-element<?php if(!$_SESSION['messages']['presence']) { echo ' hidden'; } ?>">
					<div id="missing" class="form-error">
						<?php if($_SESSION['messages']['presence']) { echo $_SESSION['messages']['presence']; } ?>
					</div>
				</div>
				<div class="form-image">
					<img id="preview" src="assets/images/users/<?php echo $_SESSION['avatar'];  ?>">
				</div>
				<div class="form-element">
					<input id="upload-image" type="file" size="32" name="image" value="" accept="image/*" onchange="loadFile(event)">
					<div class="file-mask">
						Change your avatar
						<span class="fa fa-camera"></span>
					</div>
					<p>Square images of size 250 X 250 or greater are preferred as images will be resized</p>
				</div>
				<div class="form-element">
					<input type="text" name="firstname" placeholder="New First Name" value="<?php echo $_SESSION['firstname'];  ?>">
				</div>
				<div class="form-element">
					<input type="text" name="lastname" placeholder="New Last Name" value="<?php echo $_SESSION['lastname'];  ?>">
				</div>
				<div class="form-element">
					<input type="email" name="email" placeholder="Email" value="<?php echo $_SESSION['email'];  ?>">
				</div>
				<div class="error-element<?php if(!$_SESSION['messages']['email']) { echo ' hidden'; } ?>">
					<div class="form-error">
						<?php if($_SESSION['messages']['email']) { echo $_SESSION['messages']['email']; } ?>
					</div>
				</div>
				<div class="error-element<?php if(!$_SESSION['messages']['exists']) { echo ' hidden'; } ?>">
					<div class="form-error">
						<?php if($_SESSION['messages']['exists']) { echo $_SESSION['messages']['exists']; } ?>
					</div>
				</div>
				<div class="form-element">
					<input type="password" name="oldpassword" placeholder="Enter Old Password">
				</div>
				<div class="error-element<?php if(!$_SESSION['messages']['wrong']) { echo ' hidden'; } ?>">
					<div class="form-error">
						<?php if($_SESSION['messages']['wrong']) { echo $_SESSION['messages']['wrong']; } ?>
					</div>
				</div>
				<div class="form-element">
					<input type="password" name="newpassword" placeholder="Enter New Password">
				</div>
				<div class="form-element">
					<input type="password" name="confirm" placeholder="Confirm New Password">
				</div>
				<div class="error-element<?php if(!$_SESSION['messages']['confirm']) { echo ' hidden'; } ?>">
					<div class="form-error">
						<?php if($_SESSION['messages']['confirm']) { echo $_SESSION['messages']['confirm']; } ?>
					</div>
				</div>
				<div class="form-element">
					<input type="submit" name="form_submit" value="Submit" class="form-submit">
				</div>
			</div>
		</form>


<?php
	require_once('footer.php');
?>
