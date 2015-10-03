<?php
	require_once('./config/dbconfig.php');
	 class DB {
		function query($queryStr, $types, $params) {
			$parameters = array();
			$response = array();
			$parameters[] = &$types;
			$len = count($params);
			for ($i=0; $i < $len; $i++) {
				$parameters[] = &$params[$i];
			}
		 	$db = new mysqli($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpassword'], $GLOBALS['$dbschema']);
			if($db->connect_errno) {
				$db->close();
				return json_encode(array('err' => $db->connect_errno, 'errmsg' => $db->connect_error, 'data' => null));
			} else {
				if($stmt = $db->prepare($queryStr)) {
					call_user_func_array(array($stmt, 'bind_param'), $parameters);
					$stmt->execute();
					$res = $stmt->get_result();
					while($row = $res->fetch_array(MYSQLI_ASSOC)) {
  					array_push($response, $row);
					}
					$stmt->close();
					$db->close();
					$data = json_encode($response);
					return json_encode(array('err' => $db->connect_errno, 'errmsg' => $db->connect_error, 'data' => $data));
				}
			}
    }
	 }
?>
