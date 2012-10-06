<?php
	include ('db.php'); 
    
    if(isset($_GET['err'])){
    	$err = $_GET['err'];
        $errMsg = "";
        switch($err){
        	case 0: $errMsg = "";
            	break;
            case 1: $errMsg = "You did not pass the Security Check";
            	break;
            case 2: $errMsg = "You did not fill out all the fields in the form. Please do this correctly.";
            	break;
            default: $errMsg = "There was an error processing your form. Please try submit it again.";
            	break;
        }
    }

echo $header.
			'<h1>Apply To Be Affiliates</h1>'.
			
			'Please fill out the following form to apply for affiliation.<br /><br />'.
			
			'<form action="process.php" method="POST">'.
			'<table width=40% align=center>'.
			'	<tr><td><span class="errorMsg"><?php if(isset($errMsg)) { echo $errMsg; } ?></span></td></tr>'.
			'	<tr><td>Your name:</td><td><input name="name" type="text" /></td></tr>'.
			'	<tr><td>Your email:</td><td><input name="email" type="text" /></td></tr>'.
			'	<tr><td>Your site\'s Name:</td><td><input name="siteName" type="text" /></td></tr>'.
			'	<tr><td>Your site\'s URL:</td><td><input name="siteUrl" type="text" /></td></tr>'.
			'	<tr><td>Your site\'s Button:</td><td><input name="siteButton" type="text" /></td></tr>'.
			'	<tr><td>Sum of 3 and 4:</td><td><input name="check" type="text" /></td></tr>'.
			'	<tr><td colspan=2><input name="affieReg" value="true" type="hidden" /></td></tr>'.
			'	<tr><td colspan=2><input type="submit" value="Send"></td></tr>'.
			'</table>'.
			'</form>'.
			
			$footer;

?>