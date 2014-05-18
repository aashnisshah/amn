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
	
	// make sure user is logged in
	if((isset($_SESSION['status'])) != 'active'){
		header('Location: login.php?err=3&url=Admin');
		exit;
	}
	
	$affieID = mysql_real_escape_string($_GET['id']);
	$edit = mysql_real_escape_string($_GET['edit']);
	
	if((isset($edit) && strlen($edit)>0) && isset($affieID) AND $_SESSION['status'] == 'active'){
		
		//print_r($_POST);
		
		$query = mysql_query("SELECT * FROM affie_info WHERE md5(id) = '$affieID'");
        $num = mysql_num_rows($query);
        $row = mysql_fetch_row($query);
		
		//strip the info, then edit the name
		$text = htmlspecialchars(mysql_real_escape_string($_POST['update']));
				
		switch($edit){
			case name: $query = mysql_query("UPDATE affie_info SET name='$text' WHERE md5(id)='$affieID'") or die (mysql_error()); break;
			case email: $query = mysql_query("UPDATE affie_info SET email='$text' WHERE md5(id)='$affieID'") or die (mysql_error()); break;
			case siteName: $query = mysql_query("UPDATE affie_info SET siteName='$text' WHERE md5(id)='$affieID'") or die (mysql_error()); break;
			case siteURL: $query = mysql_query("UPDATE affie_info SET siteUrl='$text' WHERE md5(id)='$affieID'") or die (mysql_error()); break;
			case buttonURL: $query = mysql_query("UPDATE affie_info SET siteButton='$text' WHERE md5(id)='$affieID'") or die (mysql_error()); break;
			case status:$name = $row[1];
						$email = $row[2];
						$siteName = $row[3];
						$statusBefore = $row[6];
						$statusAfter = $text;
						send_mail($name, $email, $siteName, $statusBefore, $statusAfter);
						$query = mysql_query("UPDATE affie_info SET status='$text' WHERE md5(id)='$affieID'") or die (mysql_error());
						break;
			case opt1: $query = mysql_query("UPDATE affie_info SET opt1='$text' WHERE md5(id)='$affieID'") or die (mysql_error()); break;
			case opt2: $query = mysql_query("UPDATE affie_info SET opt2='$text' WHERE md5(id)='$affieID'") or die (mysql_error()); break;
			default: break;
		}
		
	}
	
	function send_mail($name, $email, $siteName, $statusBefore, $statusAfter){
        $query = mysql_query("SELECT * FROM my_info WHERE myPos = 'owner'");
        $row = mysql_fetch_array($query);
        $myName = $row['myName'];
        $myEmail = $row['myEmail'];
        $mySite = $row['mySite'];
        $myAffiesUrl = $row['myAffiesUrl'];
        $id_md5 = md5($affieID);
        
        $statusBefore = get_affie_status($statusBefore);
        $statusAfter = get_affie_status($statusAfter);
                
    	// email to the affiliate
        $to = $email;
        $subject = "Affiliate Status Update";
        $message = 'Hello '.$name.'. This is an email from '.$myName.' at '.$mySite.' telling you that I have updated your affiliate status from '.$statusBefore.' to '.$statusAfter.'. If you don\'t think this change should have happened, then please send me an email telling me so.';
        $message .= '$name';
        $from = $myEmail;
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
        
    }
	
	$myId = $_SESSION['id'];
	
	if(isset($affieID) && strlen($edit==0)){
		// run the track check
		
		$query = mysql_query("SELECT * FROM affie_info WHERE md5(id) = '$affieID'");
        $num = mysql_num_rows($query);
						
		if($num > 0){
			$row = mysql_fetch_row($query);
			$affieOutput = 'The ID number used is linked to '.$row['1'].', who owns the site '.$row['3'].'.<br><br><hr>';	
			$affieOutput .= get_affie_table($row, $_GET['id']);
		} else {
			$affieOutput = 'The ID number used, <b>'.$affieID.'</b>, is not related to any affies on this site. Please try another tracking number, or <a href="/view.php" alt="">view the list of affiliates</a>.<br><br><hr><br>';
		}
	} else if($_GET['edit'] == 'true'){
		$affieOutput = 'edit';
	} else {
		$affieOutput = 'No ID number was passed to this page. Please go to the <a href="view.php">view affiliates</a> page and find an affiliate whose information you would like to view.';
	}
	
	function get_affie_table($affieInfo, $id){
			
	if(isset($_GET['updt'])){
		$err = $_GET['updt'];
		switch($err){
			case 0: $err = "";
				break;
			case 1: $err = "Error: Please make sure you submit your Current Password to make any changes.";
				break;
			case 2: $err = "Error: The Current Password submitted does not match the one stored in the database.";
				break;
			default: $err = "There was an error processing your form. Please try submit it again.";
				break;
		}
	}
		
		
		$output .= 	'<table width=100%><tr>'.
					'	<td colspan=3>Affiliate Information for '.$affieInfo[1].'<hr></td>'.
					'</tr><tr>'.
					'	<td width=45%>Name</td><td>'.$affieInfo[1].'</td><td width=15%><a href="javascript:void(0)" onclick="document.getElementById(\'LBname\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">edit</a></td>'.
					'</tr><tr>'.
					'	<td>Email</td><td>'.$affieInfo[2].'</td><td><a href="javascript:void(0)" onclick="document.getElementById(\'LBemail\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">edit</a></td>'.
					'</tr><tr>'.
					'	<td>Site Name</td><td>'.$affieInfo[3].'</td><td><a href="javascript:void(0)" onclick="document.getElementById(\'LBsiteName\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">edit</a></td>'.
					'</tr><tr>'.
					'	<td>Site URL</td><td>'.$affieInfo[4].'</td><td><a href="javascript:void(0)" onclick="document.getElementById(\'LBsiteURL\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">edit</a></td>'.
					'</tr><tr>'.
					'	<td>Site Button URL</td><td>'.$affieInfo[5].'</td><td><a href="javascript:void(0)" onclick="document.getElementById(\'LBbuttonURL\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">edit</a></td>'.
					'</tr><tr>'.
					'	<td>Status</td><td>'.get_affie_status($affieInfo[6]).'</td><td><a href="javascript:void(0)" onclick="document.getElementById(\'LBstatus\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">edit</a></td>'.
					'</tr><tr>'.
					'	<td>Opt1 Affiliate</td><td>'.get_opt_status('1', '8', $affieInfo[0], $affieInfo[8]).'</td><td><a href="javascript:void(0)" onclick="document.getElementById(\'LBopt1\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">edit</a></td>'.
					'</tr><tr>'.
					'	<td>Opt2 Affiliate</td><td>'.get_opt_status('2', '9', $affieInfo[0], $affieInfo[9]).'</td><td><a href="javascript:void(0)" onclick="document.getElementById(\'LBopt2\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'">edit</a></td>'.
					'</tr><tr>'.
					'	<td colspan=3><hr>Click <a href="view.php">here</a> to return to your list of affiliates.</td>'.
					'</tr></table>';
					
		return $output;
	}
	
	function get_affie_status($status){
		switch($status){
			case 0: $statusOutput = 'Pending'; break;
			case 1: $statusOutput = 'Rejected'; break;
			case 2: $statusOutput = 'Accepted'; break;
			case 3: $statusOutput = 'Graveyard'; break;
			default: $statusOutput = 'Unknown'; break;
		}
		return $statusOutput;
	}
	
	function get_opt_status($opt, $ref, $myId, $status){
		$query = mysql_query("SELECT * FROM my_info WHERE myPos = 'owner'");
        $myInfo = mysql_fetch_row($query);
        
		$affieID = $_GET['id'];
		
		if(strlen($myInfo[$ref]) > 0){
			switch($status){
				case 0: $statusOutput = 'Option set as <i>'.$myInfo[$ref].'</i>, affie is not included'; break;
				case 1: $statusOutput = 'Option set as <i>'.$myInfo[$ref].'</i>, affie is included'; break;
				case 2: $statusOutput = 'Option set as <i>'.$myInfo[$ref].'</i>.<br><form id="editInfo" action="affiesInfo.php?id='.$affieID.'&edit=opt1" method="POST"><input type=radio name="update" value="0"> Do not include affie<br><input type=radio name="update" value="1"> Include Affie<br><input type="submit" value="Update"></form> or '; break;
				case 3: $statusOutput = 'Option set as <i>'.$myInfo[$ref].'</i>.<br><form id="editInfo" action="affiesInfo.php?id='.$affieID.'&edit=opt2" method="POST"><input type=radio name="update" value="0"> Do not include affie<br><input type=radio name="update" value="1"> Include Affie<br><input type="submit" value="Update"></form> or '; break;
				default: $statusOutput = 'Unknown'; break;
			}
		} else {
			$statusOutput = '<i>Option '.$opt.' has not been activated.</i>';
		}
		
		return $statusOutput;
		
	}
	
	function set_opt_status($opt, $ref, $myId, $status){
	
		$query = mysql_query("SELECT * FROM my_info WHERE myPos = 'owner'");
		$myInfo = mysql_fetch_row($query);
		
		$affieID = $_GET['id'];
		
		if(strlen($myInfo[$ref]) > 0){
			switch($status){
				case 0: $statusOutput = 'Option 1 set as <i>'.$myInfo[$ref].'</i>.<br><form id="editInfo" action="affiesInfo.php?id='.$affieID.'&edit=opt1" method="POST"><input type=radio name="update" value="0"> Do not include affie<br><input type=radio name="update" value="1"> Include Affie<br><input type="submit" value="Update"></form> or '; break;
				case 1: $statusOutput = 'Option 2 set as <i>'.$myInfo[$ref].'</i>.<br><form id="editInfo" action="affiesInfo.php?id='.$affieID.'&edit=opt2" method="POST"><input type=radio name="update" value="0"> Do not include affie<br><input type=radio name="update" value="1"> Include Affie<br><input type="submit" value="Update"></form> or '; break;
				default: $statusOutput = 'Unknown'; break;
			}
		} else {
			$statusOutput = '<i>Option '.$opt.' has not been activated.<br></i>';
		}
		
		return $statusOutput;
	
	}
	
	$affieID = $_GET['id'];
	
	$lightboxDivs = '<div id="LBname" class="white_content">Edit Affiliates Name:<br><form id="editInfo" action="affiesInfo.php?id='.$affieID.'&edit=name" method="POST"><input type=text name="update"><br><input type="submit" value="Update"> or <a href="javascript:void(0)" onclick = "document.getElementById(\'LBname\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Cancel</a></form></div>';		
	$lightboxDivs .= '<div id="LBemail" class="white_content">Edit Affiliates Email:<br><form id="editInfo" action="affiesInfo.php?id='.$affieID.'&edit=email" method="POST"><input type=text name="update"><br><input type="submit" value="Update"> or <a href="javascript:void(0)" onclick = "document.getElementById(\'LBemail\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Cancel</a></form></div>';		
	$lightboxDivs .= '<div id="LBsiteName" class="white_content">Edit Affiliates Site Name:<br><form id="editInfo" action="affiesInfo.php?id='.$affieID.'&edit=siteName" method="POST"><input type=text name="update"><br><input type="submit" value="Update"> or <a href="javascript:void(0)" onclick = "document.getElementById(\'LBsiteName\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Cancel</a></form></div>';		
	$lightboxDivs .= '<div id="LBsiteURL" class="white_content">Edit Affiliates Site URL:<br><form id="editInfo" action="affiesInfo.php?id='.$affieID.'&edit=siteURL" method="POST"><input type=text name="update"><br><input type="submit" value="Update"> or <a href="javascript:void(0)" onclick = "document.getElementById(\'LBsiteURL\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Cancel</a></form></div>';		
	$lightboxDivs .= '<div id="LBbuttonURL" class="white_content">Edit Affiliates Button URL:<br><form id="editInfo" action="affiesInfo.php?id='.$affieID.'&edit=buttonURL" method="POST"><input type=text name="update"><br><input type="submit" value="Update"> or <a href="javascript:void(0)" onclick = "document.getElementById(\'LBbuttonURL\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Cancel</a></form></div>';		
	$lightboxDivs .= '<div id="LBstatus" class="white_content">Edit Affiliates Status:<br><form id="editInfo" action="affiesInfo.php?id='.$affieID.'&edit=status" method="POST"><input type=radio name="update" value="2"> Accepted<br><input type=radio name="update" value="1"> Rejected<br><input type=radio name="update" value="3"> Graveyard<br><input type="submit" value="Update"> or <a href="javascript:void(0)" onclick = "document.getElementById(\'LBstatus\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Cancel</a></form></div>';		
	$lightboxDivs .= '<div id="LBopt1" class="white_content">Edit Affiliates Option 1:<br>'.set_opt_status('1', '8', $affieID, '0').'<a href="javascript:void(0)" onclick = "document.getElementById(\'LBopt1\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Cancel</a></div>';		
	$lightboxDivs .= '<div id="LBopt2" class="white_content">Edit Affiliates Option 2:<br>'.set_opt_status('2', '9', $affieID, '1').'<a href="javascript:void(0)" onclick = "document.getElementById(\'LBopt2\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">Cancel</a></div>';		
	$lightboxDivs .= '<div id="fade" class="black_overlay"></div>';
    
    echo $header.
			'<h1>Affiliates Information</h1>'.
			
			$menu.
			
			''.$affieOutput.''.
			
			''.$lightboxDivs.''.
			
			$footer;
?>