<?php
	class User {

		function register($firstname, $lastname, $email, $password, $confirm, $image) {

			//Initiaize vars
			$_SESSION['messages'] = array('presence' => '', 'email' => '', 'exists' => '', 'confirm' => '', 'password' => '');
			$proceed = 1;
			$_SESSION['form'] = array('fname' => $firstname, 'lname' => $lastname, 'email' => $email);
			//Validate presence of required fields
			if(!strlen($firstname) > 0
			|| !strlen($lastname) > 0
			|| !strlen($email) > 0
			|| !strlen($password) > 0
			|| !strlen($confirm) > 0) {
				$proceed = 0;
				$_SESSION['messages']['presence'] = 'Please complete required fields';
			}

			//Not useful since front end md5 generates passwords longer than 8 chars
			//Validate length of password
			// if(!isValidPassword($password)) {
			// 	$proceed = 0;
			// 	$_SESSION['messages']['password'] = 'Password too short (min 8 characters)';
			// }

			//Validate password matches confirmation
			if($password != $confirm) {
				$proceed = 0;
				$_SESSION['messages']['confirm'] = 'Password does not match confirmation';
			}

			//Validate correctnes of email
			if(!isValidEmail($email)) {
				$proceed = 0;
				$_SESSION['messages']['email'] = 'Please enter a valid email';
			}

			//Check if user exists
			$checkEmail = json_decode(DB::query('SELECT id FROM user where email = ?', 's', [$email], 1), true);
			if($checkEmail['status'] == 'OK') {
				$data = json_decode($checkEmail['data'], true);
				if(count($data) > 0) {
					$proceed = 0;
					$_SESSION['messages']['exists'] = 'Email exists';
				}
			} else {
				json_encode(array('status' => 'ERR', 'msg' => 'Internal Error'));
			}

			//Reject if validation fails
			if($proceed == 0) {
				return json_encode(array('status' => 'NO'));
			}

			//All is good unset messages and temp data
			unset($_SESSION['messages']);
			unset($_SESSION['form']);

			//Let's resize and save the avatar
			if(isset($image)) {
				$filename = uniqid();
				$handle = new upload($image);
				if ($handle->uploaded) {
				  $handle->file_new_name_body   = $filename;
				  $handle->image_resize         = true;
				  $handle->image_x              = 256;
					$handle->image_ratio_y        = false;
				  $handle->image_y              = 256;
					$handle->dir_auto_chmod       = true;
					$handle->dir_chmod           = 0777;
					$handle->process('assets/images/users/');
				  if (!$handle->processed) {
				    $filename ='default.png';
				    $handle->clean();
				  }
				}
			} else {
				$filename ='default.png';
			}
			// Rehash Password
			$password = password_hash($password, PASSWORD_DEFAULT);

			//Register
		 	$completeRegestration = parseJson(DB::query('INSERT INTO user (firstname, laStname, email, `password`, avatar, flag) VALUES (?, ?, ?, ?, ?, ?)', 'sssssi', [$firstname, $lastname, $email, $password, $filename, 1], 0));
			if($completeRegestration['status'] == 'OK') {
				return json_encode(array('status' => 'OK'));
			} else {
				return json_encode(array('status' => 'ERR'));
			}

		}

		function editProfile() {

		}

		function auth($email, $password) {

			//Initiaize vars
			$_SESSION['messages'] = array('login' => '');
			$_SESSION['form'] = array('email' => $email);

			//Check if user exists
			$checkUser = json_decode(DB::query('SELECT * FROM user where email = ? LIMIT 1', 's', [$email], 1), true);
			if($checkUser['status'] == 'OK') {
				$data = json_decode($checkUser['data'], true);
				if(count($data) == 0) {
					$_SESSION['messages']['login'] = 'Wrong email or password';
					return json_encode(array('status' => 'NO'));
				} else {
					$user = $data[0];
					if(password_verify($password, $user['password'])) {
						$_SESSION['id'] = $user['id'];
						$_SESSION['firstname'] = $user['firstname'];
						$_SESSION['lastname'] = $user['lastname'];

						//All is good unset messages and temp email
						unset($_SESSION['messages']);
						unset($_SESSION['form']);

						return json_encode(array('status' => 'OK'));
					} else {
						$_SESSION['messages']['login'] = 'Wrong email or password';
						return json_encode(array('status' => 'NO'));
					}
				}
			} else {
				json_encode(array('status' => 'ERR'));
			}
		}

	}

?>
