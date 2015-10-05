<?php
	//Example Route
	router('/', function() {
		require_once('views/homepage.php');
		exit();
	});

	router('/user/test', function() {
		var_dump(User::register('Abdo', 'Mahmoud', 'asd6@gmail.com', 'password1', 'password1'));
		exit();
	});

	router('/user/logout', function() {
		session_unset();
		session_destroy();
		exit();
	});
?>
