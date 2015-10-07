
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/raphael-min.js"></script>
	<script src="assets/js/custom.js"></script>
	<?php if($title == 'Register' || $title == 'Login') { ?>
		<script src="assets/js/md5.min.js"></script>
	<?php } ?>
	<?php if(	$title == 'Le Marché') { ?>
		<script src="assets/js/home.js"></script>
	<?php } ?>
	<?php if(!isset($_SESSION['id'])) { ?>
		<script src="assets/js/<?php echo strtolower($title); ?>.js"></script>
	<?php } else { ?>
		<script src="assets/js/edit.js"></script>
	<?php } ?>
	<script src="assets/js/products.js"></script>
	</body>
</html>
