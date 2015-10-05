<?php
	class User {

		function register($firstname, $lastname, $email, $password, $confirm) {

			//Initiaize vars
			$messages = array();
			$proceed = 1;

			//Validate presence of required fields
			if(!isset($firstname)
			|| !isset($lastname)
			|| !isset($email)
			|| !isset($password)
			|| !isset($confirm)) {
				$proceed = 0;
				$messages['presence'] = 'Please complete required fields';
			}

			//Validate password matches confirmation
			if($password != $confirm) {
				$proceed = 0;
				$messages['confirm'] = 'Password does not match confirmation';
			}

			//Validate correctnes of email
			if(!isValidEmail($email)) {
				$proceed = 0;
				$messages['email'] = 'Please enter a valid email';
			}

			//Validate length of password
			if(!isValidPassword($password)) {
				$proceed = 0;
				$messages['password'] = 'Password too short (min 8 characters)';
			}

			//Check if user exists
			$checkEmail = json_decode(DB::query('SELECT id FROM user where email = ?', 's', [$email], 1), true);
			if($checkEmail['status'] = 'OK') {
				$data = json_decode($checkEmail['data'], true);
				var_dump($data);
				if(count($data) > 0) {
					$proceed = 0;
					$messages['exists'] = 'Email exists';
				}
			} else {
				json_encode(array('status' => 'ERR', 'msg' => 'Internal Error'));
			}

			//Reject if validation fails
			if($proceed == 0) {
				return json_encode(array('status' => 'NO', 'messages' => json_encode($messages)));
			}

			//Rehash Password
			$password = password_hash($password, PASSWORD_DEFAULT);

			//Register
			return DB::query('INSERT INTO user (firstname, laStname, email, `password`, flag) VALUES (?, ?, ?, ?, ?)', 'ssssi', [$firstname, $lastname, $email, $password, 1], 0);
		}

		function editProfile() {

		}

		function auth($email, $password) {

			//Initiaize vars
			$messages = array();

			//Check if user exists
			$checkUser = json_decode(DB::query('SELECT * FROM user where email = ? LIMIT 1', 's', [$email], 1), true);
			if($checkUser['status'] = 'OK') {
				$data = json_decode($checkUser['data'], true);
				if(count($data) == 0) {
					$messages['login'] = 'Wrong email or password';
					return json_encode(array('status' => 'NO', 'messages' => json_encode($messages)));
				} else {
					$user = $data[0];
					if(password_verify($password, $user['password'])) {
						$_SESSION['id'] = $user['id'];
						$_SESSION['firstname'] = $user['firstname'];
						$_SESSION['lastname'] = $user['lastname'];
						$messages['login'] = 'Login successful';
						return json_encode(array('status' => 'OK', 'messages' => json_encode($messages)));
					} else {
						$messages['login'] = 'Wrong email or password';
						return json_encode(array('status' => 'NO', 'messages' => json_encode($messages)));
					}
				}
			} else {
				json_encode(array('status' => 'ERR', 'msg' => 'Internal Error'));
			}

		}

	}
?>
