<?php
	class User {

		function register($firstname, $lastname, $email, $password, $confirm, $image) {

			//Initiaize vars
			$_SESSION['messages'] = array('presence' => '', 'email' => '', 'exists' => '', 'confirm' => '', 'password' => '');
			$proceed = 1;

			//Validate presence of required fields
			if(!isset($firstname)
			|| !isset($lastname)
			|| !isset($email)
			|| !isset($password)
			|| !isset($confirm)) {
				$proceed = 0;
				$_SESSION['messages']['presence'] = 'Please complete required fields';
			}

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

			//Validate length of password
			if(!isValidPassword($password)) {
				$proceed = 0;
				$_SESSION['messages']['password'] = 'Password too short (min 8 characters)';
			}

			//Check if user exists
			$checkEmail = json_decode(DB::query('SELECT id FROM user where email = ?', 's', [$email], 1), true);
			if($checkEmail['status'] = 'OK') {
				$data = json_decode($checkEmail['data'], true);
				var_dump($data);
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

			//All is good unset messages
			unset($_SESSION['messages']);

			//Let's upload the avatar(if available)
			var_dump(isset($image));
			if(isset($image)) {
				$filename = uniqid();
				echo $filename;
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
					var_dump($handle);
				  if (!$handle->processed) {
				    $filename ='default.png';
				    $handle->clean();
				  }
				}
			} else {
				 var_dump( 'error : ' . $handle->error);
				$filename ='default.png';
			}
			echo $filename;
		return null;
		//Rehash Password
		// 	$password = password_hash($password, PASSWORD_DEFAULT);
		//
		// 	//Register
		// 	return DB::query('INSERT INTO user (firstname, laStname, email, `password`, avatar, flag) VALUES (?, ?, ?, ?, ?, ?)', 'sssssi', [$firstname, $lastname, $email, $password, $filename, 1], 0);
		}

		function editProfile() {

		}

		function auth($email, $password) {

			//Initiaize vars
			$_SESSION['messages'] = array('login' => '');

			//Check if user exists
			$checkUser = json_decode(DB::query('SELECT * FROM user where email = ? LIMIT 1', 's', [$email], 1), true);
			if($checkUser['status'] = 'OK') {
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

						//All is good unset messages
						unset($_SESSION['messages']);

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
