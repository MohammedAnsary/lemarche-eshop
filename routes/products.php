<?php

	router('/products/view', function() {

		header('Content-Type: application/json');
		echo Product::viewProducts();

		exit();
	});

	router('/products/add', function() {
		$pid = $_GET['pid'];
		//header('Content-Type: application/json');
		echo Product::addToCart($_SESSION['id'], $pid);
		exit();
	});

	router('/products/remove', function() {
		$pid = $_GET['pid'];
		//header('Content-Type: application/json');
		echo Product::removeFromCart($_SESSION['id'], $pid);
		exit();
	});

	router('/products/cart', function() {
		header('Content-Type: application/json');
		echo Product::viewCart($_SESSION['id']);
		exit();
	});

?>
