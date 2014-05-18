<?php
	include ('db.php'); 
	
	/*
	0 - ID Number
	1 - Affies Name
	2 - Affies email
	3 - Affies Site Name
	4 - Affies Site URL
	5 - Affies Button URL
	6 - Status
		0 - pending, 1 - rejected, 2 - accepted, 4 - deleted, 5 - graveyard
	7 - nothing
	8 - opt1 affie
	9 - opt2 affie
	*/
	
	$successUpdate = '';
	
	// make sure user is logged in
	if((isset($_SESSION['status'])) != 'active'){
		header('Location: login.php?err=3&url=Admin');
		exit;
	}
	
	if(isset($_GET['act']) &&  $_GET['act']==1){
		//process form
		//print_r($_POST);
		
		//echo 'something awesome is happening';
		
		$codeOutput = '<?php ';
		$SQLquery = '';
		$SQLerror = false;
		
		$who = htmlspecialchars(mysql_real_escape_string($_POST['who']));
		$order = htmlspecialchars(mysql_real_escape_string($_POST['order']));
		$how = htmlspecialchars(mysql_real_escape_string($_POST['how']));
		$howButton = htmlspecialchars(mysql_real_escape_string($_POST['howButton']));
		$howWord = htmlspecialchars(mysql_real_escape_string($_POST['howWord']));
		$num = htmlspecialchars(mysql_real_escape_string($_POST['num']));
		
		if(isset($who)){
			$codeOutput .= ' $who = '.$who.';';
		} else {
			$SQLerror = true;
		}
		
		if(isset($order)){
			$codeOutput .= ' $order = '.$order.';';
		} else {
			$SQLerror = true;
		}
		
		if(isset($how)){
			$codeOutput .= ' $how = '.$how.';';
		
			if($how == 'ownWord'){
				if(isset($howWord)){
					$codeOutput .= ' $ownWord = '.$howWord.';';
				} else {
					$SQLerror = true;
				}
			}
			
			if($_how == 'ownButton'){
				if(isset($howButton)){
					$codeOutput .= ' $ownButton = '.$howButton.';';
				} else {
					$SQLerror = true;
				}
			}
			
		} else {
			$SQLerror = true;
		}
		
		if(isset($num)){
			$codeOutput .= ' $num = '.$num.';';
		} else {
			$SQLerror = true;
		}
		
		if($SQLerror == false){
			$AMNurl = realpath(dirname(__FILE__));
			$codeOutput .= ' include(\''.$AMNurl.'/generatecodes.php\'); ?>';
			$textarea = '<hr><b>Copy the codes below and paste them wherever you want your affiliates displayed</b><br><br><textarea cols="80" rows="2">'.$codeOutput.'</textarea>';
		} else {
			$codeOutput = '';
			$textarea = '<hr><b>There was an error in your display option settings. Please try again.</b>';
		}
		
	}
	
	
	
    
    echo $header.
			'<h1>Get Affiliate Display Codes</h1>'.
			
			$menu.
			
			'Here you will be able to setup how you would like to display your affiliates on your site. Fill out the form, then hit submit and it will provide you with the necessary codes.<hr>'.
			'<form action="gdc.php?act=1" method="POST"><b>Who would you like to display?</b><br><br><table width="100%" align="center"><tr><td><input type="radio" name="who" value="all"> All Affiliates</td><td width="50%"><input type="radio" name="who" value="0"> Pending Affiliates Affiliates</td><td><input type="radio" name="who" value="2"> Accepted Affiliates</td></tr><tr><td><input type="radio" name="who" value="3"> Graveyard Affiliates</td><td><input type="radio" name="who" value="opt1"> Affiliates in Option 1</td><td><input type="radio" name="who" value="opt2"> Affiliates in Option 2</td></tr>'.
			'<tr><td colspan=3>&nbsp;</td></tr><tr><td colspan=3><b>How would you like to order them?</b></td></tr><tr><td colspan=3>&nbsp;</td></tr><tr><td colspan=3><input type="radio" name="order" value="rand"> Randomly &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="order" value="subm"> Order of Submission</td></tr>'.
			'<tr><td colspan=3>&nbsp;</td></tr><tr><td colspan=3><b>How would you like to display them?</b></td></tr><tr><td colspan=3>&nbsp;</td></tr><tr><td><input type="radio" name="how" value="site"> Use the Site Name</td><td><input type="radio" name="how" value="own"> Use the Owners Name</td><td><input type="radio" name="how" value="siteButton"> Use the Site Button URL</td></tr><tr><td colspan=50%><input type="radio" name="how" value="ownButton"> Use your own button: <input type="text" name="howButton">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="how" value="ownWord"> Use your own letter/word: <input type="text" name="howWord"></td></tr>'.
			'<tr><td colspan=3>&nbsp;</td></tr><tr><td colspan=3><b>How many affiliates would you like to display?</b><br>Enter 0 if you would like to display all affiliates.<br><input type="text" name="num"></td></tr>'.
			'<tr><td colspan=3><input type="submit" value="Get Codes"></td></tr>'.
			'</table></form>'.
			
			''.$textarea.''.
			
			$footer;
			
			
?>