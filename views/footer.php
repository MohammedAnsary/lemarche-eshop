
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/raphael-min.js"></script>
	<?php if(isset($_SESSION['id'])) { ?>
		<script src="assets/js/custom.js"></script>
	<?php } else if($title != 'Le Marché') { ?>
		<script src="assets/js/<?php echo $title; ?>.js"></script>
	<?php } ?>
	</body>
</html>
