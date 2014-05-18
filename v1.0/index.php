<?php 
	if (!file_exists(db.php)) {
		header('Location: config.php');
		exit;
	}
	
	require_once('db.php');
	
	if((isset($_SESSION['status'])) == 'active'){
		header('Location: admin.php');
		exit;
	} else {
		header('Location: login.php');
		exit;
	}
		
		echo $header.
			'<h1>Affies Me Not</h1>'.
			
			'Please <a href="login.php">login</a> to continue.'.
			
			$footer;

?>