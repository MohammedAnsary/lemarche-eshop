<?php
	class User {

		function register($firstname, $lastname, $email, $password, $confirm) {

			//Validate presence of required fields
			if(!isset($firstname)
			|| !isset($lastname)
			|| !isset($email)
			|| !isset($password)
			|| !isset($confirm)
			|| ($password != $confirm)) {
				return json_encode(array('status' => 'NO', 'msg' => 'Please complete missing fields'));
			}

			//Validate correctnes of email
			if(!isValidEmail($email)) {
				return json_encode(array('status' => 'NO', 'msg' => 'Please enter a valid email'));
			}

			//Validate length of password
			if(!isValidPassword($password)) {
				return json_encode(array('status' => 'NO', 'msg' => 'Password too short (min 8 characters)'));
			}

			//Check if user exists
			$users = DB::query('SELECT id FROM user where eamail = ?', 's', [$email], 1);

			//Rehash Password
			$password = password_hash($password, PASSWORD_DEFAULT);

			return DB::query('INSERT INTO user (firstname, lastname, email, `password`, flag) VALUES (?, ?, ?, ?, ?)', 'ssssi', [$firstname, $lastname, $email, $password, 1], 0);
		}

		function editProfile() {

		}

		function login() {

		}
	}
?>
