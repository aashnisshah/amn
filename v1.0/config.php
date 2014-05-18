<?php 

	require_once('layout.php');
	
	if(isset($_GET['mk'])){
		$host = $_POST['host'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$dbname = $_POST['dbname'];
		
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		
		
		$error = 'false';
		
		if($pass1==$pass2){
			$pass = sha1(md5($pass1));
		} else {
			$error = 'true';
			$errMsg .= 'The passwords entered do not match.<br>';
		}
		
		mysql_connect($host, $username, $password) or die(mysql_error());
		$connect = mysql_select_db($dbname) or die(mysql_error());
		if($connect != false){
			$error = 'false';
		} else {
			$error = 'true';
			$errMsg .= 'A connection to the database cannot be established. Please check your database information and try again.<br>';
		}
		
		if($error == 'false'){
			make_db_store_info();
			create_db_file($host, $username, $password, $dbname);
			header('Location: setup.php?success=true');
			exit;
		}
	}
	
	function make_db_store_info(){
		$pos = 'owner';
		$name = mysql_real_escape_string($_POST['name']);
		$email = mysql_real_escape_string($_POST['email']);
		$siteName = mysql_real_escape_string($_POST['siteName']);
		$siteUrl = mysql_real_escape_string($_POST['siteUrl']);
		$myAffiesUrl = mysql_real_escape_string($_POST['myAffiesUrl']);
		$pass1 = mysql_real_escape_string($_POST['pass1']);
		$pass2 = mysql_real_escape_string($_POST['pass2']);
		
		$pass = sha1(md5($pass1));
		
			
			mysql_query("CREATE TABLE affie_info(
				id INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY(id),
				name VARCHAR(30),
				email VARCHAR(30),
				siteName VARCHAR(50),
				siteUrl VARCHAR(100),
				siteButton VARCHAR(100),
				status VARCHAR(100),
				opt1 VARCHAR(100),
				opt2 VARCHAR(100)
				)") or die(mysql_error());
			
			mysql_query("CREATE TABLE my_info(
				id INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY(id),
				myPos VARCHAR(30),
				myName VARCHAR(30),
				myEmail VARCHAR(50),
				mySite VARCHAR(50),
				mySiteUrl VARCHAR(100),
				myAffiesUrl VARCHAR(100),
				myPass VARCHAR(100),
				opt1 VARCHAR(100),
				opt2 VARCHAR(100)
				)") or die(mysql_error());
			
			mysql_query("INSERT INTO my_info (
				myPos,
				myName,
				myEmail,
				mySite,
				mySiteUrl,
				myAffiesUrl,
				myPass
			) VALUES(
				'owner',
				'$name',
				'$email',
				'$siteName',
				'$siteUrl',
				'$myAffiesUrl',
				'$pass'
			) ") or die(mysql_error());
			
			send_mail($email, $name, $pass1);
	}
	
	function create_db_file($host, $username, $password, $dbname){
		$fileName = "db.php";
		$fh = fopen($fileName, 'w') or die("The file cannot be opened.");
		$stringData = '<?php
			session_start();
			mysql_connect("'.$host.'", "'.$username.'", "'.$password.'") or die(mysql_error());
			mysql_select_db("'.$dbname.'") or die(mysql_error());
			require_once("layout.php");
			?>';
		fwrite($fh, $stringData);
		fclose($fh);
	}
	
	function send_mail($email, $name, $password){
		// email to the affiliate
        $to = $email;
        $subject = "Congratulations! Affies Me Not Has Been Set Up";
        $message = 'Hello '.$name.'. This email is to tell you that Affies Me Not has been successfully set up on your site. Please keep the following information safe for future use. '.
        	'Username: '.$name.', Password: '.$password.'. If you have any problems, please visit http://www.aashni.me/script/amn for help.';
        $from = $email;
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
	}
	
	$errMsg = "";
	
	$myName = $_SESSION['myName'];
	
	
	echo $header.
			'<h1>Set Up Affies Me Not</h1>'.
			
			$menu.
			
			'Welcome to Affies Me Not, and thanks for using this script.'.$errMsg.'Please fill in the following information to set up your site.<br>'.
			'<hr><b>Database Info</b><br><form action="config.php?mk=new" method="POST">'.
			'<table align="center"><tr><td>DB Host:</td><td><input type="text" name="host"></td></tr>'.
			'<tr><td>DB Username:</td><td><input type="text" name="username"></td></tr>'.
			'<tr><td>DB Password:</td><td><input type="text" name="password"></td></tr>'.
			'<tr><td>DB Name:</td><td><input type="text" name="dbname"></td></tr></table>'.
			
			'<hr><b>Your Information:</b><br><table align="center">'.
			'<tr><td>Name:</td><td><input type="text" name="name"></td></tr>'.
			'<tr><td>Email:</td><td><input type="text" name="email"></td></tr>'.
			'<tr><td>Site Name:</td><td><input type="text" name="siteName"></td></tr>'.
			'<tr><td>Site URL:</td><td><input type="text" name="siteUrl"></td></tr>'.
			'<tr><td>URL to Affies Me Not:</td><td><input type="text" name="myAffiesUrl"></td></tr>'.
			'<tr><td>Password:</td><td><input type="text" name="pass1"></td></tr>'.
			'<tr><td>Password again:</td><td><input type="text" name="pass2"></td></tr></table>'.
			'<hr><input type="submit" name="Submit">'.
			
			
			$footer;
	
?>