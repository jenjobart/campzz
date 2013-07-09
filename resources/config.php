<?php

	$config['DB_HOST'] = 'localhost';
	$config['DB_USER'] = 'root';
	$config['DB_PASS'] = '';
	$config['DB_NAME'] = 'lamp_final_project';
	
	foreach ($config as $k => $v ) {
		define (strtoupper($k), $v);
	}
	
?>