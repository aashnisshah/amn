<?php
	require_once('db.php');
	
	if(isset($_SESSION)){
		$_SESSION['status'] = 'offline';
		session_destroy();
		$output = "You have been successfully logged out<br />";
	} else {
		$output = "You were not previously logged in.<br />";
	}
	
	echo $header.
			'<h1>Log Out</h1>'.
			
			''.$output.''.
			
			'To continue, return to the <a href="login.php">login page</a>.'.
			
			$footer;
?>