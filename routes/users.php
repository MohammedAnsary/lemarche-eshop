<?php
	//Example Route
	router('/user/test', function() {
		var_dump($_SESSION);
		exit();
	});
?>
