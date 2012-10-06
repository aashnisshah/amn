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
		
		$who = mysql_real_escape_string($_POST['who']);
		$selwho = mysql_real_escape_string($_POST['selwho']);
		$subject = mysql_real_escape_string($_POST['subject']);
		$message = mysql_real_escape_string($_POST['message']);
		
		$query = "SELECT * FROM affie_info";
		
		if($who != "all" && $who != "sel"){
			$successUpdate = "<b>There was an error. No receipient was chosen. Please try again.</b><br><br>";
		} else {
			if($who == "all"){
				$query = "SELECT * FROM affie_info";
			} else if($who == "sel"){
				switch($selwho){
				case 0: $query = "SELECT * FROM affie_info WHERE status='0'"; break;
				case 1: $query = "SELECT * FROM affie_info WHERE status='1'"; break;
				case 2: $query = "SELECT * FROM affie_info WHERE status='2'"; break;
				case 3: $query = "SELECT * FROM affie_info WHERE status='3'"; break;
				default: $query = "SELECT * FROM affie_info WHERE status!='0'"; break;
				}
			}
			
			$querySql = mysql_query($query);
			while($row = mysql_fetch_array($querySql)){
				//print_r($row);
				send_mail($row[2], $subject, $message);
			}
			
			$successUpdate = '<b>The email was successfully sent.</b><br><br>';
		}
		
	}
	
	function send_mail($email, $theSubject, $theMessage){
        $query = mysql_query("SELECT * FROM my_info WHERE myPos = 'owner'");
        $row = mysql_fetch_array($query);
        $myName = $row['myName'];
        $myEmail = $row['myEmail'];
        $mySite = $row['mySite'];
        $myAffiesUrl = $row['myAffiesUrl'];
        $id_md5 = md5($affieID);
                
    	// email to the affiliate
        $to = $email;
        $subject = $theSubject;
        $message = $theMessage;
        $from = $myEmail;
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
        
    }
    
    //getting email info
    $allEmails = getEmailInfo("all");
    $pendingEmails = getEmailInfo("0");
    $acceptedEmails = getEmailInfo("1");
    $graveyardEmails = getEmailInfo("2");
    $opt1Emails = getEmailInfo("3");
    $opt2Emails = getEmailInfo("4");
    
    function getEmailInfo($selwho){
    
    	$myQuery = "SELECT * FROM my_info where myPos='owner'";
    	$myQuerySql = mysql_query($myQuery);
    	$checkBlock = false;
    	$emailList = '';
    	$opt1Name = '';
    	$opt2Name = '';
    	if($myQuerySql){
    		$myRow = mysql_fetch_array($myQuerySql);
    		$opt1Name = $myRow['opt1'];
    		$opt2Name = $myRow['opt2'];
    	}
    
    	$query = "SELECT * FROM affie_info";
		
		if($selwho == "all"){
			$query = "SELECT * FROM affie_info";
		} else {
			switch($selwho){
			case 0: $query = "SELECT * FROM affie_info WHERE status='0'"; break;
			case 1: $query = "SELECT * FROM affie_info WHERE status='1'"; break;
			case 2: $query = "SELECT * FROM affie_info WHERE status='2'"; break;
			case 3: $query = "SELECT * FROM affie_info WHERE status='3'"; break;
			case 4: $query = "SELECT * FROM affie_info WHERE opt1='1'"; $checkBlock = 'opt1'; break;
			case 5: $query = "SELECT * FROM affie_info WHERE opt2='1'"; $checkBlock = 'opt2'; break;
			default: $query = "SELECT * FROM affie_info"; break;
			}
		}
		
		if($checkBlock == false){
			$querySql = mysql_query($query);
			while($row = mysql_fetch_array($querySql)){
				//print_r($row);
				$emailList .= $row[2].', ';
			}
		} else if($checkBlock != true){
			if($checkBlock == 'opt1'){
				if(strlen($opt1Name) > 0){
					$querySql = mysql_query($query);
					while($row = mysql_fetch_array($querySql)){
						//print_r($row);
						$emailList .= $row[2].', ';
					}
				} else {
					$emailList = '<b>Option 1 has not been set yet. Please choose another option.</b>';
				}
			} else if($checkBlock == 'opt2'){
				if(strlen($opt2Name) > 0){
					$querySql = mysql_query($query);
					while($row = mysql_fetch_array($querySql)){
						//print_r($row);
						$emailList .= $row[2].', ';
					}
				} else {
					$emailList = '<b>Option 2 has not been set yet. Please choose another option.</b>';
				}
			}
		}
		
		return $emailList;
		
    }

    
    function optQuery($optName){
    	if(strlen($optName) == 0){
    		$query = "";
    	} else {
    		$query = "SELECT * FROM affie_info WHERE opt1 = '1'";
    	}
    	
    	return $query;
    }
    
    function optBlock($optName){
    
    }
	
	// site div
	$siteDiv = '<hr>Which group of affiliates would you like this email to be sent to?';
	$siteDiv .= '<form action="contactAffies.php?act=1" method="POST"><input type=radio name="who" value="all"> All Affiliates <input type=radio name="who" value="sel"> Selected Affiliates<br>';
	$siteDiv .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>If you chose "Selected Affiliates", please choose a group(s) from below</i><br><input type=checkbox name="selwho" value="0"> Pending <input type=checkbox name="selwho" value="1"> Rejected <input type=checkbox name="selwho" value="2"> Accepted <input type=checkbox name="selwho" value="3"> Graveyard ';
	$siteDiv .= '<br><hr>Please write your email below then hit the Send Email button.<br><br>Email Subject: <input type="text" size="90" name="subject"><br><textarea name="message" rows="20" cols="80"></textarea><br><br><input type="submit" value="Send Email"><br>';
	
	// client div
	$clientDiv = '';
	
	$clientDiv .= '<hr><a href="javascript:void(0)" onclick="document.getElementById(\'all\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">All Affiliates</a><br>';
	$clientDiv .= '<a href="javascript:void(0)" onclick="document.getElementById(\'pending\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">Pending Affiliates</a><br>';
	$clientDiv .= '<a href="javascript:void(0)" onclick="document.getElementById(\'accepted\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">Accepted Affiliates</a><br>';
	$clientDiv .= '<a href="javascript:void(0)" onclick="document.getElementById(\'graveyard\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">Graveyard Affiliates</a><br>';
	$clientDiv .= '<a href="javascript:void(0)" onclick="document.getElementById(\'opt1\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">Opt1 Affies</a><br>';
	$clientDiv .= '<a href="javascript:void(0)" onclick="document.getElementById(\'opt2\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">Opt2 Affies</a><br>';
	
	
	
	//lightbox divs with email info
	$lightboxDivs = '<div id="all" class="white_content">Copy and paste the emails from the textarea below.<br><br><textarea cols=50 rows=20>'.$allEmails.'</textarea><br><br><a href="javascript:void(0)" onclick = "document.getElementById(\'all\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Close</a></form></div>';		
	$lightboxDivs .= '<div id="pending" class="white_content">Copy and paste the emails from the textarea below.<br><br><textarea cols=50 rows=20>'.$pendingEmails.'</textarea><br><br><a href="javascript:void(0)" onclick = "document.getElementById(\'pending\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Close</a></form></div>';		
	$lightboxDivs .= '<div id="accepted" class="white_content">Copy and paste the emails from the textarea below.<br><br><textarea cols=50 rows=20>'.$acceptedEmails.'</textarea><br><br><a href="javascript:void(0)" onclick = "document.getElementById(\'accepted\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Close</a></form></div>';		
	$lightboxDivs .= '<div id="graveyard" class="white_content">Copy and paste the emails from the textarea below.<br><br><textarea cols=50 rows=20>'.$graveyardEmails.'</textarea><br><br><a href="javascript:void(0)" onclick = "document.getElementById(\'graveyard\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Close</a></form></div>';		
	$lightboxDivs .= '<div id="opt1" class="white_content">Copy and paste the emails from the textarea below.<br><br><textarea cols=50 rows=20>'.$opt1Emails.'</textarea><br><br><a href="javascript:void(0)" onclick = "document.getElementById(\'opt1\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Close</a></form></div>';		
	$lightboxDivs .= '<div id="opt2" class="white_content">Copy and paste the emails from the textarea below.<br><br><textarea cols=50 rows=20>'.$opt2Emails.'</textarea><br><br><a href="javascript:void(0)" onclick = "document.getElementById(\'opt2\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Close</a></form></div>';		
	$lightboxDivs .= '<div id="fade" class="black_overlay"></div>';

	
	
	
    
    echo $header.
			'<h1>Contact Affiliates</h1>'.
			
			$menu.
			
			$successUpdate.'How would you like to contact your affiliates?<br><a href="#" onclick="showHide(\'site\', \'client\')">Through the site</a> or <a href="#" onclick="showHide(\'client\', \'site\')">Via a mail client</a>?<br>'.
			
			'<div id="site" style="display:none;">'.$siteDiv.'</div><div id="client" style="display:none;">'.$clientDiv.'</div>'.
			
			''.$lightboxDivs.''.
			
			$footer;
			
?>