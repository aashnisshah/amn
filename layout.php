<?php 
	$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.
			'<html xmlns="http://www.w3.org/1999/xhtml">'.
			'<head>'.
			'<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'.
			'<title>Affies Me Not | Affiliate Management Script</title>'.
			'<link rel="stylesheet" href="style.css" type="text/css" />'.
			'<link rel="stylesheet" href="lightbox.css" type="text/css" />'.
			'<link rel="icon" type="image/png" href="images/favicon.ico">'.
			
			'<script language="javascript">'.
			'	function showHide(show, hide){'.
			'		var divShow = document.getElementById(show);'.
			'		var divHide = document.getElementById(hide);'.
			'		if(divShow.style.display == "none"){'.
			'			divShow.style.display = "block";'.
			'			divHide.style.display = "none";'.
			'		} else {'.
			'			divShow.style.display = "none";'.
			'			divHide.style.display = "block";'.
			'		}'.
			'	}'.
			'</script>'.
			
			
			'</head>'.
			
			'<body>'.
			'<div id="main">';
			
	$menu = '<hr>'.
			'<a href="admin.php">Home Page</a>    |    '.
			'<a href="settings.php">Settings</a>    |    '.
			'<a href="pending.php">Pending</a>    |    '.
			'<a href="view.php">List Affies</a>    |    '.
			'<a href="contactAffies.php">Contact Affies</a>    |    '.
			'<a href="gdc.php">Get Display Codes</a>    |    '.
			'<a href="about.php">About AMN</a>    |    '.
			'<a href="logout.php">Log Out</a>'.
			'<hr>';
			
			
	$footer = '<hr>The <a href="http://www.aashni.me/scripts/amn" target="_blank">Affies Me Not</a> script is designed by <a href="http://www.aashni.me">Aashni</a>.<hr>'.
			'</div>'.
			
			'</body></html>';
			
	$version = '1.0.0';
?>