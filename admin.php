<?php 
	require_once('db.php');
	
	// make sure user is logged in
	if((isset($_SESSION['status'])) != 'active'){
		header('Location: login.php');
		exit;
	}
	
	$errMsg = "";
	$update = '';
	
	$myName = $_SESSION['myName'];
	
	if($_GET['lgn'] == 't'){
		// perform a check to see if the script has been updated
		
		$versionLatest = get_data('http://www.aashni.me/scripts/amn/version.php');
		
		if($versionLatest == $version){
			$update = '<hr>You are using version '.$version.' of Affies Me Not. This is the latest version.';
		} else {
			$update = '<hr>You are using version '.$version.' of Affies Me Not. This is not the latest version. Please <a href="http://www.aashni.me/scripts/amn/updates.php" target="_blank">update</a> your script as soon as possible.';
		}
	}
	
	function get_data($url) {
	  $ch = curl_init();
	  $timeout = 5;
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}
	
	echo $header.
			'<h1>Admin Home Page</h1>'.
			
			$menu.
			
			'Welcome to the Admin Home Page, '.$myName.'. Here you will find all the links to the different administrative options you have.<hr>'.
			
			'<ul>'.
				'<li><a href="settings.php" alt="">Settings Page</a> - Change your Account Information</li>'.
				'<li><a href="pending.php" alt="">Pending Applications Page</a> - Check for any Pending Applications here</li>'.
				'<li><a href="view.php" alt="">View Affies Page</a> - View a list of all your affiliates</li>'.
				'<li><a href="contactAffies.php" alt="">Contact Affiliates</a> - Different options to contact your affiliates</li>'.
				'<li><a href="gdc.php" alt="">Get Display Codes</a> - Configure and get codes to display your affies on your site</li>'.
				'<li><a href="about.php" alt="">About AMN</a> - Information about AMN, and how to use it</li>'.
				'<li><a href="logout.php" alt="">Log Out Page</a> - Log out of your Administrative Account</li>'.
			'</ul>'.
			
			$update.
			
		$footer;
	
?>