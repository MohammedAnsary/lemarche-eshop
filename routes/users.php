<?php
	//Example Route

	router('/login', function() {
		require_once('views/login.php');
		if(isset($_SESSION['form'])){
			unset($_SESSION['form']);
		}
		if(isset($_SESSION['messages'])) {
			unset($_SESSION['messages']);
		}
		exit();
	});

	router('/register', function() {

		if(!isset($_SESSION['messages'])) {
			$_SESSION['messages'] = array('presence' => '', 'email' => '', 'exists' => '', 'confirm' => '', 'password' => '');
		};
		require_once('views/register.php');
		$_SESSION['messages'] = array('presence' => '', 'email' => '', 'exists' => '', 'confirm' => '', 'password' => '');
		unset($_SESSION['messages']);
		if(isset($_SESSION['form'])){
			unset($_SESSION['form']);
		}
		exit();
	});

	router('/registerUserAccount', function() {
		$register = parseJson(User::register($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['confirm'], $_FILES['image']));
		if($register['status'] == 'OK') {
			$_POST = array();
			unset($_FILES['image']);
			header('Location: login');
		} else if($register['status'] == 'NO') {
			header('Location: register');
		} else {
			header('Location: /lemarche/');
		}
		exit();
	});

	router('/loginUserAccount', function() {
		$login = parseJson(User::auth($_POST['email'], $_POST['password']));
		if($login['status'] == 'OK') {
			header('Location: /lemarche/');
		} else {
			header('Location: login');
		}
		exit();
	});

	router('/', function() {
		require_once('views/homepage.php');
		exit();
	});

	router('/user/logout', function() {
		session_unset();
		session_destroy();
		header('Location: /lemarche/');
		exit();
	});
?>
