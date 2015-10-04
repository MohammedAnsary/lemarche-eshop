<?php
	require_once('./config/dbconfig.php');
	 class DB {
		function query($queryStr, $types, $params, $retrieve) {
			$db = new mysqli($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpassword'], $GLOBALS['$dbschema']);
			$parameters = array();
			$response = array();
			$parameters[] = &$types;
			$len = count($params);
			for ($i=0; $i < $len; $i++) {
				$parameters[] = &$params[$i];
			}
			if($db->connect_errno) {
				$db->close();
				return json_encode(array('status' => 'ERR', 'msg' => 'Internal Error Code 1'));
			} else {
				if($stmt = $db->prepare($queryStr)) {
					call_user_func_array(array($stmt, 'bind_param'), $parameters);
					if(!$stmt->execute()) {
						$stmt->close();
						$db->close();
						return json_encode(array('status' => 'ERR', 'msg' => 'Internal Error Code 2'));
					}
					if($retrieve) {
						$res = $stmt->get_result();
						while($row = $res->fetch_array(MYSQLI_ASSOC)) {
							array_push($response, $row);
						}
					}
					$stmt->close();
					$db->close();
					return json_encode(array('status' => 'OK', 'data' => json_encode($response)));
				} else {
					return json_encode(array('status' => 'ERR', 'msg' => 'Internal Error Code 3'));
				}
			}
    }
	 }
?>
