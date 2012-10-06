<?php
	include ('db.php'); 
    
    if(isset($_POST['affieReg'])){
        // the form was submitted - human check:
        if($_POST['check'] == 7){
            if($_POST['name'] != NULL AND $_POST['email']!=NULL AND $_POST['siteName'] AND $_POST['siteUrl']!=NULL AND $_POST['siteButton']!=NULL){
                // form check passes, continue on with the website
            } else {
                header('Location: registrationForm.php?err=2');
				exit;
            }
        } else {
            header('Location: registrationForm.php?err=1');
			exit;
        }
    } else {
        header('Location: registrationForm.php?err=0');
		exit;
    }
    
    
	$name = mysql_real_escape_string($_POST['name']);
	$email = mysql_real_escape_string($_POST['email']);
	$siteName = mysql_real_escape_string($_POST['siteName']);
	$siteUrl = mysql_real_escape_string($_POST['siteUrl']);
	$siteButton = mysql_real_escape_string($_POST['siteButton']);
	$error = mysql_real_escape_string(mysql_query("INSERT INTO affie_info (name, email, siteName, siteUrl, siteButton, status) VALUES('$name', '$email', '$siteName', '$siteUrl', '$siteButton', '0')") or die(mysql_error()));
	$affieID = mysql_real_escape_string(mysql_insert_id());
    
    
	function send_mail($name, $email, $siteName, $affieID){
        $query = mysql_query("SELECT * FROM my_info WHERE myPos = 'owner'");
        $row = mysql_fetch_array($query);
        $myName = $row['myName'];
        $myEmail = $row['myEmail'];
        $mySite = $row['mySite'];
        $myAffiesUrl = $row['myAffiesUrl'];
        $id_md5 = md5($affieID);
                
    	// email to the affiliate
        $to = $email;
        $subject = "Affiliate Application Request";
        $message = 'Hello '.$name.'. This is an email from '.$myName.' at '.$mySite.' confirming that I received your application for your site, '.$siteName.' to be affiliates with us. I shall review your application and respond to your email soon. In the meantime, please feel free to track your sites status by visiting '.$myAffiesUrl.'/track.php?trk=true&trackNum='.$id_md5;
        $from = $myEmail;
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
        
    	// email to the site owner
        $to = $myEmail;
        $subject = "New Affiliate Application Request";
        $message = 'Hello! You should feel special today! '.$name.' has applied to have her site, '.$siteName.', and yours be affiliates. Please go to the Affiliates Pending Page at: '.$myAffiesUrl.'pending.php to accept or reject this request.';
        $from = $myEmail;
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
    }


	echo $header.
		'<h1>Output from the Form</h1>'.
			
			$menu;
		
		
		if ($error != false){
			echo 'Congratulations '.$name.'! Your application for '.$sname.' was successfully submitted. You should hear from our site soon.';
			send_mail($name, $email, $siteName, $affieID);
		} else {
			echo 'Sorry, there was a problem processing your form. Please <a href="registrationForm.php" alt="">go back</a> and fill the form out again.';
		}
	
	//<?php print_r($myInfo); 
	
	echo $footer;
	
?>