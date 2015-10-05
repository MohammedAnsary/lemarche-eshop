<?php
	//Example Route
	router('/', function() {
		require_once('views/homepage.php');
		exit();
	});
	router('/user/test', function() {
		var_dump($_SESSION);
		exit();
	});
?>
