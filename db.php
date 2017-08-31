<?php
	
	/*
		DB.php
		Contains database details & provides connection to database via Mysqli
	*/
	define("__DB_HOST",""); //Database HOST
	define("__DB_NAME",""); //Database Name
	define("__DB_USERNAME" , ""); //Database Username
	define("__DB_PASS" , ""); //Database Password
	define("__DB_TABLE" , "transactions"); //Name of table containing data on transactions
	
	$mysqli = $GLOBALS['mysqli'] = new mysqli(__DB_HOST , __DB_USERNAME , __DB_PASS , __DB_NAME);
	if ($mysqli->connect_errno) {
		die("Failed to connect to Database: " . $mysqli->connect_error);
	}

	/* db_query to perform a mysqli query [just so that call can be made from functions without using global $mysqli] */
	function db_query($q) {
		
		return $GLOBALS['mysqli']->query( $q );
		
	}
	
	/* escapestr to perform mysqli->real_escape_string so that string can be escaped for use in SQL statement */
	function escapestr($str) {
		return $GLOBALS['mysqli']->real_escape_string($str);
	}
	
	function db_error() {
		return $GLOBALS['mysqli']->error;
	}