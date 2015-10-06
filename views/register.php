<?php
	$title = 'Register';
	require_once('header.php');
?>
		<form enctype="multipart/form-data" method="post" action="registerUserAccount">
			<div class="form-wrapper">
				<div class="error-element<?php if(!$_SESSION['messages']['presence']) { echo ' hidden'; } ?>">
					<div id="missing" class="form-error">
						<?php if($_SESSION['messages']['presence']) { echo $_SESSION['messages']['presence']; } ?>
					</div>
				</div>
				<div class="form-element">
					<input type="text" name="firstname" placeholder="First Name">
				</div>
				<div class="form-element">
					<input type="text" name="lastname" placeholder="Last Name">
				</div>
				<div class="form-element">
					<input type="email" name="email" placeholder="Email">
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
					<input type="password" name="password" placeholder="Password (min. 8 chars)">
				</div>
				<div class="error-element<?php if(!$_SESSION['messages']['password']) { echo ' hidden'; } ?>">
					<div class="form-error">
						<?php if($_SESSION['messages']['password']) { echo $_SESSION['messages']['password']; } ?>
					</div>
				</div>
				<div class="form-element">
					<input type="password" name="confirm" placeholder="Confirm Password">
				</div>
				<div class="error-element<?php if(!$_SESSION['messages']['confirm']) { echo ' hidden'; } ?>">
					<div class="form-error">
						<?php if($_SESSION['messages']['confirm']) { echo $_SESSION['messages']['confirm']; } ?>
					</div>
				</div>
				<div class="form-element">
					<input id="upload-image" type="file" size="32" name="image" value="">
					<div class="file-mask">
						Choose your avatar
						<span class="fa fa-camera"></span>
					</div>
					<p>Square images of size 250 X 250 or greater are preferred as images will be resized</p>
				</div>
				<div class="form-element">
					<input type="submit" name="form_submit" value="Rgister" class="form-submit">
				</div>
			</div>
		</form>

<?php
	require_once('footer.php');
?>
