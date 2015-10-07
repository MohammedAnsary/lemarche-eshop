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


			//Default filename
			$filename ='default.png';

			//Let's resize and save the avatar
			if($image != null) {
				$handle = new upload($image);
				if ($handle->uploaded) {
				  $handle->file_new_name_body   = uniqid();
				  $handle->image_resize         = true;
				  $handle->image_x              = 256;
					$handle->image_ratio_y        = false;
				  $handle->image_y              = 256;
					$handle->dir_auto_chmod       = true;
					$handle->dir_chmod            = 0777;
					$handle->process('assets/images/users/');
					$filename = $handle->file_dst_name_body.".".$handle->file_dst_name_ext;
				  if (!$handle->processed) {
				    $filename ='default.png';
				  } else {
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

		function editProfile($user_id, $firstname, $lastname, $email, $oldpassword, $newpassword, $confirm, $image) {
			//Initiaize vars
			$_SESSION['messages'] = array('presence' => '', 'email' => '', 'exists' => '','wrong' => '', 'confirm' => '', 'password' => '');
			$proceed = 1;
			//Validate presence of required fields
			if(!strlen($firstname) > 0
			|| !strlen($lastname) > 0
			|| !strlen($email) > 0) {
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
			if(strlen($newpassword) > 0 && $newpassword != $confirm) {
				$proceed = 0;
				$_SESSION['messages']['confirm'] = 'Password does not match confirmation';
			}

			//Validate correctnes of email
			if(!isValidEmail($email)) {
				$proceed = 0;
				$_SESSION['messages']['email'] = 'Please enter a valid email';
			}

			//Check if user exists
			if($email != $_SESSION['email']){
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
			}

			//Check if passwrod is right
			// $checkPass = json_decode(DB::query('SELECT * FROM user where id = ? LIMIT 1', 'i', [$user_id], 1), true);
			// if($checkPass['status'] == 'OK') {
			// 	var_dump($checkPass);
			// 	$data = json_decode($checkPass['data'], true);
			// 	echo $data[0]['password'];
			// 	if(!password_verify($oldpassword, $data[0]['password'])) {
			// 		$proceed = 0;
			// 		$_SESSION['messages']['wrong'] = 'Wrong Password';
			// 	}
			// } else {
			// 	json_encode(array('status' => 'ERR'));
			// }

			//Reject if validation fails
			if($proceed == 0) {
				return json_encode(array('status' => 'NO'));
			}

			//All is good unset messages and temp data
			unset($_SESSION['messages']);

			//Let's resize and save the avatar
			$filename = $_SESSION['image'];
			if($image != null) {
				$handle = new upload($image);
				if ($handle->uploaded) {
					$handle->file_new_name_body   = uniqid();
					$handle->image_resize         = true;
					$handle->image_x              = 256;
					$handle->image_ratio_y        = false;
					$handle->image_y              = 256;
					$handle->dir_auto_chmod       = true;
					$handle->dir_chmod            = 0777;
					$handle->process('assets/images/users/');
					$filename = $handle->file_dst_name_body.".".$handle->file_dst_name_ext;
					if (!$handle->processed) {
						$filename = $_SESSION['image'];
					} else {
						$handle->clean();
					}
				}
			} else {
				$filename = $_SESSION['image'];
			}

			// Rehash Password
			if(strlen($newpassword) > 0) {
				$newpassword = password_hash($password, PASSWORD_DEFAULT);
				$completeEdit = parseJson(DB::query('UPDATE  user set firstname = ?, lastname = ?, email = ?, `password` = ?, avatar = ? WHERE id = ?', 'sssssi', [$firstname, $lastname, $email, $newpassword, $filename, $user_id], 0));
				if($completeEdit['status'] == 'OK') {
					return json_encode(array('status' => 'OK'));
					$_SESSION['firstname'] = $firstname;
					$_SESSION['lastname'] = $lastname;
					$_SESSION['avatar'] = $filename;
					$_SESSION['email'] = $email;
				} else {
					return json_encode(array('status' => 'ERR'));
				}
			} else {
				$completeEdit = parseJson(DB::query('UPDATE  user set firstname = ?, lastname = ?, email = ?, avatar = ? WHERE id = ?', 'ssssi', [$firstname, $lastname, $email, $filename, $user_id], 0));
				if($completeEdit['status'] == 'OK') {
					$_SESSION['firstname'] = $firstname;
					$_SESSION['lastname'] = $lastname;
					$_SESSION['avatar'] = $filename;
					$_SESSION['email'] = $email;
					return json_encode(array('status' => 'OK'));
				} else {
					return json_encode(array('status' => 'ERR'));
				}
			}
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
						$_SESSION['avatar'] = $user['avatar'];
						$_SESSION['email'] = $user['email'];

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
