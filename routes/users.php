<?php
	//Example Route
	router('/', function() {
		require_once('views/homepage.php');
		exit();
	});
	router('/user/test', function() {
		var_dump(User::register('Abdo', 'Mahmoud', 'asd5@gmail.com', 'password1', 'password1'));
		exit();
	});
?>
