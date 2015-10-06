<?php

	router('/products/view', function() {

		header('Content-Type: application/json');
		echo Product::viewProducts();

		exit();
	});
?>
