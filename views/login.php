<?php
	$title = 'Login';
	require_once('header.php');
?>

		<form enctype="multipart/form-data" method="post" action="loginUserAccount">
			<div class="form-wrapper">
				<div class="form-element">
					<div class="form-error<?php if(!isset($_SESSION['messages'])) { echo ' hidden'; } ?>">
						<?php if(isset($_SESSION['messages'])) { echo $_SESSION['messages']['login']; } ?>
					</div>
				</div>
				<div class="form-element">
					<input type="email" name="email" placeholder="Email" value="<?php if(isset($_SESSION['form'])) { echo $_SESSION['form']['email']; } ?>">
					<span class="fa fa-envelope"></span>
				</div>
				<div class="form-element">
					<input type="password" name="password" placeholder="Password">
					<span class="fa fa-lock"></span>
				</div>
				<div class="form-element">
					<input type="submit" name="form_submit" value="Login" class="form-submit">
				</div>
			</div>
		</form>

<?php
	require_once('footer.php');
?>
