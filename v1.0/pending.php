<?php 
	require_once('db.php');
	
	// make sure user is logged in
	if((isset($_SESSION['status'])) != 'active'){
		header('Location: login.php?err=3&url=Admin');
		exit;
	}
	
	$errMsg = "";
	
	$myName = $_SESSION['myName'];
	
	// declaring myInfo
	$query = mysql_query("SELECT * FROM my_info WHERE myName = '$myName'");
	$row = mysql_fetch_array($query);
	$myEmail = $row['myEmail'];
	$mySite = $row['mySite'];
	$mySiteUrl = $row['mySiteUrl'];
	$myId = $row['id'];
	
	if(isset($_GET['updt'])){
		//print_r($_POST);
		
		$numRows = sizeOf($_POST);
		//$numFields = $numRows / 2;
		$i = 0;
		
		$acceptList = "";
		$rejectList = "";
		$laterList = "";
		
		$query = "SELECT * FROM affie_info WHERE status='0'";
		$result = mysql_query($query);
		
		while($row = mysql_fetch_row($result)){
		
		//$row format:
		// 0 => id number
		// 1 => name
		// 2 => email
		// 3 => Site Name
		// 4 => Site URL
		// 5 => Site Button URL
		// 6 => status
					
			$action = 'action'.$i;
			$reason = 'reason'.$i;
			if($_POST[$action] == 'Accept'){
				// accept
				// update mysql database, send email, concat string
				
				$updateAffieStatus = mysql_query("UPDATE affie_info SET status='2' WHERE id='$row[0]'") or die(mysql_error()); 
				
				send_mail_accept($row[1], $row[2], $row[3], $_POST[$reason]);
				
				if(strlen($acceptList) <= 0 ){
					$acceptList .= $row[3];
				} else {
					$acceptList .= ', '.$row[3];
				}
				
			} else if($_POST[$action] == 'Reject'){
				// reject
				
				$updateAffieStatus = mysql_query("UPDATE affie_info SET status='1' WHERE id='$row[0]'") or die(mysql_error()); 
				
				send_mail_reject($row[1], $row[2], $row[3], $_POST[$reason]);
				
				if(strlen($rejectList) <= 0 ){
					$rejectList .= $row[3];
				} else {
					$rejectList .= ', '.$row[3];
				}
				
			} else if($_POST[$action] == 'Later'){
				// decide later - don't do anything
				
				if(strlen($laterList) <= 0 ){
					$laterList .= $row[3];
				} else {
					$laterList .= ', '.$row[3];
				}
				
			} else {
				header('Location: pending.php?err=1');
				exit;
			}
			
			$i += 1;
		}
	}
		
		if(strlen($acceptList) <= 0 ){
			$acceptList = 'None';
		}
		
		if(strlen($rejectList) <= 0 ){
			$rejectList = 'None';
		}
		
		if(strlen($laterList) <= 0 ){
			$laterList = 'None';
		}
		
		$processActionOutput = 'Congratulations! Your form was successfully submitted. Here\'s a little recap just for you: <br />'.
			'Accepted:     <i>'.$acceptList.'</i><br />'.
			'Rejected:     <i>'.$rejectList.'</i><br />'.
			'Left Alone:   <i>'.$laterList.'</i><br /><br /><hr><br />';
		
	
	
	if(isset($_GET['err'])){
		$err = $_GET['err'];
		$output = "";
		switch($err){
			case 0: $errMsg = "";
				break;
			case 1: $errMsg = "There was a strange error when you submitted the form. Please try submitting the form again.";
				break;
			case 2: $errMsg = "Your account user name does not exist in our database";
				break;
			default: $errMsg = "There was an error processing your form. Please try submit it again.";
				break;
		}
	}
	
	function output_pending_apps(){
		
		$output = '';
		
		$query = "SELECT * FROM affie_info WHERE status='0'";
		$result = mysql_query($query);
		$resultSize = mysql_num_rows($result);

		if($resultSize > 0){
			$i = 0;
			$output = '<form action="pending.php?updt=true" method="POST">';
			$output .= '<table width="100%" align="center"><tr><td colspan=3><hr></td></tr><tr><td>Applicant Info</td><td>Your Decision</td><td>Personal Message</td></tr>'.
					'<tr><td colspan=3><hr></td></tr>';
			while ($row = mysql_fetch_row($result)){
				$output .= '<tr><td>Applicant Name: '.$row[1].'<br />Email: '.$row[2].'<br />Site Name: <a href="'.$row[4].'" target="_blank" alt="Click to visit '.$row[3].'">'.$row[3].'</a><br />Site Button: <img src="'.$row[5].'" alt=""></td>';
				$output .= '<td>Decision<br /><input type="radio" name="action'.$i.'" value="Accept"> Accept <br>'.
							'<input type="radio" name="action'.$i.'" value="Reject"> Reject <br>'.
							'<input type="radio" name="action'.$i.'" value="Later" checked> Decide Later<br></td>';
				$output .= '<td>Reason:<br /><textarea name="reason'.$i.'" rows=7 cols=35></textarea></td></tr>';
				$output .= '<tr><td colspan=3><hr></td></tr>';
				$i = $i + 1;
			}
			$output .= '</table>';
			$output .= '<input type="submit" value="Update Information"></form>';
		} else {
			$output = '<b>There are currently 0 pending applications.</b>';
		}
			
			return $output;
	}
	
	function send_mail_accept($name, $email, $siteName, $reason){
        $query = mysql_query("SELECT * FROM my_info WHERE myPos = 'owner'");
        $row = mysql_fetch_array($query);
        $myName = $row['myName'];
        $myEmail = $row['myEmail'];
        $mySite = $row['mySite'];
                
    	// email to the affiliate
        $to = $email;
        $subject = "RE: Affiliate Request at ".$mySite;
        $message = 'Hello! This is a letter from '.$myName.' at '.$mySite.' to tell you that I have reviewed your application, and have accepted you as an affiliate! You should now be on my sites Affiliate Page. ';
        if(strlen($reason)>0){
        	$message .= ' '.$reason.' ';
        }
        $message .=  'If you have any questions, feel free to email me at '.$myEmail.', and make sure to stop by my site and see what new things I have to offer!';
        $from = $myEmail;
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
    }
    
    function send_mail_reject($name, $email, $siteName, $reason){
        $query = mysql_query("SELECT * FROM my_info WHERE myPos = 'owner'");
        $row = mysql_fetch_array($query);
        $myName = $row['myName'];
        $myEmail = $row['myEmail'];
        $mySite = $row['mySite'];
                
    	// email to the affiliate
        $to = $email;
        $subject = "RE: Affiliate Request at ".$mySite;
        $message = 'Hello! This is a letter from '.$myName.' at '.$mySite.' to tell you that I have reviewed your application. I\'m sorry to tell you that after much consideration, I have had to reject your affiliation request. ';
        if(strlen($reason)>0){
        	$message .= ' '.$reason.' ';
        }
        $message .=  'If you have any questions, feel free to email me at '.$myEmail.', and make sure to stop by my site and see what new things I have to offer!';
        $from = $myEmail;
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
    }
	
	
	echo $header.
			'<h1>Pending Applications</h1>'.
			
			$menu.
			
			''.$processActionOutput.''.
			
			'Below are all the pending applications. You can approve or reject applications here. When you approve or reject an application, a form will be sent to the applicant telling them your decision. You are welcome to include a personal message or reason.<br /><br />'.
			
			''.$errMsg.''.
			
			output_pending_apps().
			
			$footer;
	
?>