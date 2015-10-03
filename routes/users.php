<?php
	//Example Route
	route('/user/register', function() {
		var_dump(User::register('Mohammed', 'Ansary', 'm@gmail.com', 'mohalaa123', 'mohalaa123'));
		exit();
	});
?>
