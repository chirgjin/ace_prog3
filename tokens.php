<?php
	//tokens.php
	//Used to generate & verify tokens (In order to prevent botting/spamming)
	
	@session_start();
	
	//token_gen uses uniqid() to generate a token & returns it [it isn't safe but implementing crypt will consume more time & random_int is not supported is php < 7.0]
	function token_gen() {
		if(!isset($_SESSION['tokens']))
			$_SESSION['tokens'] = array();
		
		$token = md5( uniqid() );
		
		$_SESSION['tokens'][ $token ] = 1;
		
		return $token;
	}
	
	function token_verify($token) {
		
		if(!isset($_SESSION['tokens']) || !isset( $_SESSION['tokens'][$token] ) )
			return 0;
		
		unset( $_SESSION['tokens'][$token] ); //remove it from array so that it cant be used again
		return 1;
	}
	