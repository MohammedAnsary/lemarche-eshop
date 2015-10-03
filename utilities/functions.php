<?php
	//function credited to http://blogs.shephertz.com/2014/05/21/how-to-implement-url-routing-in-php/
	function getCurrentUri() {
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
		if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
		$uri = '/' . trim($uri, '/');
		return $uri;
	}

	function parseJSON($json) {
		$parsed = json_decode($json, true);
		return $parsed;
	}

	function route($route, $callback) {
		if($route == $GLOBALS['current_route']) {
			call_user_func($callback);
		}
	}

	function isValidEmail($email) {
		return !filter_var($email, FILTER_VALIDATE_EMAIL) === false;
	}

	function isValidPassword($password) {
		return strlen($password) >= 8;
	}
?>
