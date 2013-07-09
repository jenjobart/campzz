<?php

	include_once('config.php');

	$link = @mysqli_connect($config['DB_HOST'], $config['DB_USER'], 
		$config['DB_PASS'], $config['DB_NAME']);

	/* check connection */
	if (!$link) {
		die('Connect failed: ' . mysqli_connect_errno());
	}

?>