<?php 
	require_once('db.php');
	
	if((isset($_SESSION['status'])) == 'active'){
		header('Location: admin.php');
		exit;
	} else {
		
	}
	
	if(isset($_GET['lgn'])){
		// log in information was sent, log the user in
		
		// both fields have been filled:
		$myName = mysql_real_escape_string($_POST['myName']);
		$myPass = sha1(md5(mysql_real_escape_string($_POST['myPass'])));
		
		$check = mysql_query("SELECT * FROM my_info WHERE myName = '$myName'") or die(mysql_error());
		$check2 = mysql_num_rows($check);
		if ($check2 == 0) { //Check if account exists
			$url = 'Location: login.php?err=2';
			header($url);
			exit;
		}
		$row = mysql_fetch_array($check);
		$db_password = $row['myPass'];
		if ($myPass != $db_password) { //Check if password is correct
			header('Location: login.php?err=1');
			exit;
		} else {
			// login informaiton is real!
			$_SESSION['status'] = 'active';
			$_SESSION['id'] = $row['id'];
			$_SESSION['myName'] = $myName;
			header('Location: admin.php?lgn=t');
			exit;
		}
	} else {
		// show the log in form with any necessary errors
		
		if(isset($_GET['err'])){
			$err = $_GET['err'];
			$errMsg = "";
			switch($err){
				case 0: $errMsg = "";
					break;
				case 1: $errMsg = "Your User Name and Password do not match any existing users";
					break;
				case 2: $errMsg = "Your account user name does not exist in our database";
					break;
				case 3: $errMsg = 'Sorry, you must be logged in to access the '.mysql_real_escape_string($_GET['url']).' page';
					break;
				default: if(isset($errMsg) === false) {
				            $errMsg = '';
				      }
				      break;
			}
		}
		
		
		echo $header.
			'<h1>Apply To Be Affiliates</h1>'.
			
			'<hr>Enter your login information to enter Affies Me Not<hr>'.
			
			'<form action="login.php?lgn=true" method="POST">'.
			'<table align="center">'.
				'<tr><td><span class="errMsg">'.$errMsg.'</span></td></tr>'.
				'<tr><td>User Name: <input name="myName" type="text" /></td></tr>'.
				'<tr><td>Password: <input name="myPass" type="password" /></td></tr>'.
				'<tr><td><input name="lgn" value="true" type="hidden" /></td></tr>'.
				'<tr><td><input type="submit" value="Login"></td></tr>'.
			'</table>'.
			'</form>'.
			
			$footer;

	}

?>