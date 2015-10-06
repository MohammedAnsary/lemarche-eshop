<?php
	$title = 'Le Marché';
	require_once('header.php');
?>

		<div class="form-wrapper">
			<div class="form-element">
				<div class="form-error">
					Wrong email or password
				</div>
			</div>
			<div class="form-element">
				<input type="email" placeholder="Email">
				<span class="fa fa-envelope"></span>
			</div>
			<div class="form-element">
				<input type="password" placeholder="Password">
				<span class="fa fa-lock"></span>
			</div>
			<div class="form-element">
				<a class="form-submit" href="#">
					Login
				</a>
			</div>
		</div>

<?php
	require_once('footer.php');
?>
