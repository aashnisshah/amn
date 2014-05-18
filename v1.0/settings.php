<?php 
	require_once('db.php');
	
	// make sure user is logged in
	if((isset($_SESSION['status'])) != 'active'){
		header('Location: login.php?err=3&url=settings');
		exit;
	}
	
	$errMsg = "";
	
	// declaring myInfo
	$query = mysql_query("SELECT * FROM my_info WHERE myPos = 'owner'");
	$row = mysql_fetch_array($query);
	$myName = $row['myName'];
	$myEmail = $row['myEmail'];
	$mySite = $row['mySite'];
	$mySiteUrl = $row['mySiteUrl'];
	$myAffiesUrl = $row['myAffiesUrl'];
	$myId = $_SESSION['id'];
	$opt1 = $row['opt1'];
	$opt2 = $row['opt2'];
	
	//print_r($_POST);
	
	$updt = mysql_real_escape_string($_GET['updt']);
	
	if(isset($updt)){
		switch($updt){
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
	
	if(isset($_GET['process'])){
		// update the information, then show a message, then update the form
		
		if(strlen(mysql_real_escape_string($_POST['myPass'])) == 0){
			header('Location: settings.php?updt=1');
			exit;
		}

		//check to make sure the password was correctly entered
		$myPass = sha1(md5(mysql_real_escape_string($_POST['myPass'])));
		$myName = $_SESSION['myName'];

		
		$check = mysql_query("SELECT * FROM my_info WHERE id = '$myId'") or die(mysql_error());
		$check2 = mysql_num_rows($check);
		if ($check2 == 0) { //Check if account exists
			header("Location: settings.php?updt=2");
			exit;
		}
		$row = mysql_fetch_array($check);
		$db_password = $row['myPass'];
		
		if ($myPass != $db_password) { //Check if password is correct
			header('Location: settings.php?updt=2');
			exit;
		} else {
			$output = '';
			
			// correct password used - now to check and update informaiton
			
			// name
			if(strlen(mysql_real_escape_string($_POST['myName'])) > '0'){
				$myName = mysql_real_escape_string($_POST['myName']);
				$output .= update_user_info('name', 'myName', $myName, $myId);
			}
			
			// email
			if(strlen(mysql_real_escape_string($_POST['myEmail'])) > '0'){
				$myEmail = mysql_real_escape_string($_POST['myEmail']);
				$output .= update_user_info('email', 'myEmail', $myEmail, $myId);
			}
			
			// site name
			if(strlen(mysql_real_escape_string($_POST['mySite'])) > '0'){
				$mySite = mysql_real_escape_string($_POST['mySite']);
				$output .= update_user_info('site name', 'mySite', $mySite, $myId);
			}
			
			// site url
			if(strlen(mysql_real_escape_string($_POST['mySiteUrl'])) > '0'){
				$mySiteUrl = mysql_real_escape_string($_POST['mySiteUrl']);
				$output .= update_user_info('site URL', 'mySiteUrl', $mySiteUrl, $myId);
			}
			
			// AMN url
			if(strlen(mysql_real_escape_string($_POST['myAffiesUrl'])) > '0'){
				$myAffiesUrl = mysql_real_escape_string($_POST['myAffiesUrl']);
				$output .= update_user_info('Affies Me Not URL', 'myAffiesUrl', $myAffiesUrl, $myId);
			}
			
			//password
			if(strlen(mysql_real_escape_string($_POST['myPassNew1'])) > '0'){
				if(strlen(mysql_real_escape_string($_POST['myPassNew2'])) > '0'){
					if(mysql_real_escape_string($_POST['myPassNew1']) == mysql_real_escape_string($_POST['myPassNew2'])){
						$myPassNew = mysql_real_escape_string($_POST['myPassNew1']);
						$myPassNew = sha1(md5($myPassNew));
						$output .= update_user_info('Password', 'myPass', $myPassNew, $myId);
					} else {
						$output .= '<br>Error: There was a problem updating your password since the two passwords entered do not match. Please try again.';
					}
				} else {
					$output .= '<br>Error: There was a problem updating your password since the password confirmation field was left empty. Please fill this and try again.';
				}
			}
			
			//affie info: option 1
			if(mysql_real_escape_string($_POST['opt1'] == 'update')){
				if(strlen(mysql_real_escape_string($_POST['opt1Name'])) > 0){
					$opt1Name = mysql_real_escape_string($_POST['opt1Name']);
					$output .= update_user_info('Affie Opt1', 'opt1', $opt1Name, $myId);
				} else {
					$output .= '<br>Error: Affie Option 1 was selected, but no new name was entered. As such, Affie Option 1 has not been activated.';
				}
			} else if(mysql_real_escape_string($_POST['opt1']) == 'deactivate'){
				$output .= update_user_info('Affie Opt1', 'opt1', '', $myId);
			}
			
			//affie info: option 2
			if(mysql_real_escape_string($_POST['opt2']) == 'update'){
				if(strlen(mysql_real_escape_string($_POST['opt2Name'])) > 0){
					$opt2Name = mysql_real_escape_string($_POST['opt2Name']);
					$output .= update_user_info('Affie Option 2', 'opt2', $opt2Name, $myId);
				} else {
					$output .= '<br>Error: Affie Option 2 was selected, but no new name was entered. As such, Affie Option 2 has not been activated.';
				}
			} else if(mysql_real_escape_string($_POST['opt2']) == 'deactivate'){
				$output .= update_user_info('Affie Opt2', 'opt2', '', $myId);
			}
			
			//update_affie_info();
			//update_password();
			
			
		}
	}
	
	
		
		function update_user_info($type, $myType, $info, $myId){
			$info = htmlspecialchars($info);
			$query = mysql_query("UPDATE my_info SET $myType='$info' WHERE id='$myId'") or die(mysql_error());
			
			if($info == '' && ($myType == 'opt1' OR $myType == 'opt2')){
				return '<br>The '.$type.' was successfully deactivated.';
			} else if($myType == 'myPass'){
				return '<br>Your password has successfully been updated';
			} else {
				return '<br>The '.$type.' was successfully updated to '.$info;
			}
		}
		
		
	// declaring myInfo
	$query = mysql_query("SELECT * FROM my_info WHERE myPos = 'owner'");
	$row = mysql_fetch_array($query);
	$myName = $row['myName'];
	$myEmail = $row['myEmail'];
	$mySite = $row['mySite'];
	$mySiteUrl = $row['mySiteUrl'];
	$myAffiesUrl = $row['myAffiesUrl'];
	$myOpt1 = $row['opt1'];
	$myOpt2 = $row['opt2'];
	
	if(strlen($myOpt1) > 0){
		$myOpt1Msg .= '<td>Option 1 has been activated: <b>'.$myOpt1.'</b></td>';
		$myOpt1Msg .= '<td><input type=radio name="opt1" value="update"> Update Name ';
		$myOpt1Msg .= '<input type=radio name="opt1" value="deactivate"> Deactivate</td>';
		$myOpt1Msg .= '<td><input type=text name="opt1Name"></td>';
	} else {
		$myOpt1Msg .= '<td>Option 1 has not been activated.</td>';
		$myOpt1Msg .= '<td><input type=radio name="opt1" value="update"> Activate ';
		$myOpt1Msg .= '<input type=radio name="opt1" value="deactivate"> Keep Deactivated</td>';
		$myOpt1Msg .= '<td><input type=text name="opt1Name"></td>';
	}
	
	if(strlen($myOpt2) > 0){
		$myOpt2Msg .= '<td>Option 2 has been activated: <b>'.$myOpt2.'</b></td>';
		$myOpt2Msg .= '<td><input type=radio name="opt2" value="update"> Update Name ';
		$myOpt2Msg .= '<input type=radio name="opt2" value="deactivate"> Deactivate</td>';
		$myOpt2Msg .= '<td><input type=text name="opt2Name"></td>';
	} else {
		$myOpt2Msg .= '<td>Option 2 has not been activated.</td>';
		$myOpt2Msg .= '<td><input type=radio name="opt2" value="update"> Activate ';
		$myOpt2Msg .= '<input type=radio name="opt2" value="deactivate"> Keep Deactivated</td>';
		$myOpt2Msg .= '<td><input type=text name="opt2Name"></td>';
	}
	
	if(strlen($output) > 0){
		$output = '<hr>Update Results<hr><center>'.$output.'<br></center>';
	}
	
	if(strlen($err) > 0){
		$err = '<hr>There was an error!<hr><center>'.$err.'<br></center>';
	}
	
	echo $header.
		'<h1>Change Your Account Settings</h1>'.
			
			$menu.
		
		'Fill out the fields on the right to edit your account settings. You must provide your current password to log in, otherwise your settings will not be updated.<br /><br />'.
		
		'<form action="settings.php?process=true" method="POST">'.
		'<table width=100%><tr>'.
		'	<td colspan=3>'.$output.'</td>'.
		'</tr><tr>'.
		'	<td colspan=3>'.$err.'</td>'.
		'</tr><tr>'.
		'	<td colspan=3><hr>General Account and Site Information<hr></td>'.
		'</tr><tr>'.
		'	<td>Name</td>'.
		'	<td>'.$myName.'</td>'.
		'	<td><input name="myName" type=text" /></td>'.
		'</tr><tr>'.
		'	<td>Email</td>'.
		'	<td>'.$myEmail.'</td>'.
		'	<td><input name="myEmail" type=text" /></td>'.
		'</tr><tr>'.
		'	<td>Site Name</td>'.
		'	<td>'.$mySite.'</td>'.
		'	<td><input name="mySite" type=text" /></td>'.
		'</tr><tr>'.
		'	<td>Site URL</td>'.
		'	<td>'.$mySiteUrl.'</td>'.
		'	<td><input name="mySiteUrl" type=text" /></td>'.
		'</tr><tr>'.
		'	<td>URL to AffiesMeNot</td>'.
		'	<td>'.$myAffiesUrl.'</td>'.
		'	<td><input name="myAffiesUrl" type=text" /></td>'.
		'</tr><tr>'.
		'	<td colspan=3><hr>Optional Affiliate Grouping Fields<hr></td>'.
		'</tr><tr>'.
		''.$myOpt1Msg.''.
		'</tr><tr>'.
		''.$myOpt2Msg.''.
		'</tr><tr>'.
		'	<td colspan=3><hr>Change Your Password<hr></td>'.
		'</tr><tr>'.
		'	<td colspan=2>New Password</td>'.
		'	<td><input name="myPassNew1" type="password" /></td>'.
		'</tr><tr>'.
		'	<td colspan=2>Confirm Password</td>'.
		'	<td><input name="myPassNew2" type="password" /></td>'.
		'</tr><tr>'.
		'	<td colspan=3><hr>Update<hr></td>'.
		'</tr><tr>'.
		'	<td colspan=2>Current Password</td>'.
		'	<td><input name="myPass" type="password" /></td>'.
		'</tr><tr>'.
		'	<td colspan=3><input type="submit" value="Send"></td>'.
		'</tr><tr>'.
		'</tr></table>'.
		'</form>'.
		
		$footer;
?>