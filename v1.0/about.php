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
	
	// perform a check to see if the script has been updated
	$versionLatest = get_data('http://www.aashni.me/scripts/amn/version.php');
	
	if($versionLatest == $version){
		$update = '<hr><h2>Version Info</h2><hr>You are using version '.$version.' of Affies Me Not. This is the latest version.';
	} else {
		$update = '<hr><h2>Version Info</h2><hr>You are using version '.$version.' of Affies Me Not. This is not the latest version. Please <a href="http://www.aashni.me/scripts/amn/updates.php" target="_blank">update</a> your script as soon as possible.';
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
			'<h1>About Affies Me Not</h1>'.
			
			$menu.
			
			'Affies Me Not is an Affiliates management script that makes it easier for you to keep track of your affiliates.<br><br>'.
			'<hr><h2>Using Affies Me Not</h2><hr><b>Home Page:</b> Here you have the links to all the options listed in the menu.<br><br>'.
			'<b>Settings:</b> This is an extremely important page. Here you will control your name, your site Name and URL, as well as your site\'s button. It\'s important that these are kept accurate since they are used when sending emails to your affiliates. You can also change your password here, or activate Option 1 and Option 2 Affie Groups by entering a name for them. You must remember to enter your current password at the bottom of the form, or none of your changes will be processed.<br><br>'.
			'<b>Pending Applications:</b> Here you can review all the pending applications on your site, and respond to the requests. You can accept or reject the affiliates and include a personal message in the email that will be sent to them. You can also choose to respond to the request at a later time.<br><br>'.
			'<b>List Affies:</b> On this page you will see a list of all your affiliates. You can filter these affies depending on who has been accepted, rejected, is pending or in the graveyard. If Option 1 or Option 2 are active, you can also filter affies based on those groups. By clicking on the site\'s name, you will be able to view all information about that affiliate, as well as update or edit any information about the affiliate.<br><br>'.
			'<b>Contact Affies:</b> This option allows you to contact your affiliates. You have two options, you can either use the form built in on the site, or you can generate a list of all the affiliates email addresses and email them from your email account instead. Either way, you can filter who you\'d like to send the email to as well.<br><br>'.
			'<b>Get Display Codes:</b> Here you can choose how you would like to display your affiliates on your website. You can choose who will be shown (all, pending, graveyard etc.), as well as how you\'d like them to be displayed and how many as well. Once you submit the form, you\'ll be given a piece of code. Copy this code and paste it wherever you would like your affiliates to be displayed. The beauty of this code snippet is that you only need to copy it once, and the script will automatically update itself to show all newly accepted affies.<br><br>'.
			'<b>Log Out:</b> This will log you out of AMN.<br>'.
			'<hr><h2>Affiliate Registration</h2><hr>You will need to link your affiliates to the registration form, which can be found at <a href="registrationForm.php" target="_blank">registrationForm.php</a>. You will be notified of any new requests, and will then be able to accept/reject them through the pending applications page.'.
			'<hr><h2>Customizing The Affiliates List</h2><hr>The Get Display Code will generate an HTML list on your site which you can stlye using CSS. The class name for the Unorganized List (UL) is affieListUL, and the class name for the List Element (LI) is affieListLI.'.
			
			'<hr><h2>AMN History</h2><hr>The AMN project started in June 2012 by <a href="http://www.aashni.me" target="_blank">Aashni</a>.<br>'.
			$update.''.
			'<hr><h2>Suggestions and Support</h2><hr>If you have any problems, suggestions, comments etc. with the script, please share them in our <a href="http://www.aashni.me/scripts/forum" target="_blank">support forum</a>.'.
						
		$footer;
	
?>































