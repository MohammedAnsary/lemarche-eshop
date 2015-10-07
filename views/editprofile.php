
<?php
	$title = 'Le Marché';
	require_once('header.php');
?>

<html>
			<form enctype="multipart/form-data" method="post" action="editUserAccount">
				<div class="form-wrapper">
					<div class="form-image">
					<img id="preview" src="assets/images/users/default.png">
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
					<input type="text" name="firstname" placeholder="New first Name" value="<?php if(isset($_SESSION['form'])) { echo $_SESSION['form']['fname']; } ?>">
				</div>
				<div class="form-element">
					<input type="text" name="lastname" placeholder="New last Name" value="<?php if(isset($_SESSION['form'])) { echo $_SESSION['form']['lname']; } ?>">
				</div>
				
				<div class="error-element<?php if(!$_SESSION['messages']['exists']) { echo ' hidden'; } ?>">
					<div class="form-error">
						<?php if($_SESSION['messages']['exists']) { echo $_SESSION['messages']['exists']; } ?>
					</div>
				</div>
				<div class="form-element">
					<input type="password" name="password" placeholder="Enter your password">
				</div>
				<div class="error-element<?php if(!$_SESSION['messages']['presence']) { echo ' hidden'; } ?>">
					<div id="missing" class="form-error">
						<?php if($_SESSION['messages']['presence']) { echo $_SESSION['messages']['presence']; } ?>
					</div>
				</div>
				<div class="form-element">
					<input type="submit" name="form_submit" value="Submit" class="form-submit">
				</div>
			</div>
</div>
</form>

 </html>
<?php
	require_once('footer.php');
?>
