<?php 
	require_once('layout.php');
	// make sure user is logged in
	
	if($_GET['success']=='true'){
	
	
		echo $header.
			'<h1>Congratulations!</h1>'.
			
			'Affies Me Not has successfully been set up on your site.<br>'.
			'You will receive an email shortly with your login information. Keep this for your records.<br>'.
			'Please <a href="login.php">log in</a> to start using Affies Me Not.'.
			
			
			$footer;
			
			
		$myFile = "config.php";
		$fh = fopen($myFile, 'w') or die("The file cannot be accessed.");
		fclose($fh);
		unlink($myFile);
		
		$myFile2 = "setup.php";
		$fh2 = fopen($myFile2, 'w') or die("The file cannot be accessed.");
		fclose($fh2);
		unlink($myFile2);
		
	} else {
		header('config.php');
		exit;
	}
	
	
	
	echo $header.
			'<h1>Congratulations!</h1>'.
			
			'Affies Me Not has successfully been set up on your site.<br>'.
			'You will receive an email shortly with your login information. Keep this for your records.<br>'.
			'Please <a href="login.php">log in</a> to start using Affies Me Not.'.
			
			
			$footer;
	
?>