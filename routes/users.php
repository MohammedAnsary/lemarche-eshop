<?php
	//Example Route

	router('/login', function() {
		require_once('views/login.php');
		exit();
	});

	router('/register', function() {
		if(!isset($_SESSION['messages'])) {
			$_SESSION['messages'] = array('presence' => '', 'email' => '', 'exists' => '', 'confirm' => '', 'password' => '');
		};
		require_once('views/register.php');
		exit();
	});

	router('/registerUserAccount', function() {
		$register = parseJson(User::register($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['confirm'], $_FILES['image']));
		var_dump($register);
		exit();
	});

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
