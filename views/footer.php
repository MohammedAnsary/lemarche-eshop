
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/raphael-min.js"></script>
	<script src="assets/js/custom.js"></script>
	<?php if(isset($_SESSION['id'])) { ?>
		<script src="assets/js/custom.js"></script>
	<?php } else { ?>
		<script src="assets/js/controls.js"></script>
		<?php if($title == 'login') { ?>
			<script src="assets/js/login.js"></script>
		<?php } else if($title == 'register') { ?>
			<script src="assets/js/register.js"></script>
		<?php } ?>
	<?php } ?>
	</body>
</html>
