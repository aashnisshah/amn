<?php
	include ('db.php'); 
	
	if(isset($_GET['trk'])){
		// run the track check
		$trackNum = mysql_real_escape_string($_GET['trackNum']);
		
		$query = mysql_query("SELECT * FROM affie_info WHERE md5(id) = '$trackNum'");
        $num = mysql_num_rows($query);
        				
		if($num > 0){
			$row = mysql_fetch_row($query);
			switch($row['6']){
				case 0: $trackStatus = 'The tracking number '.$trackNum.' is linked to the site: <b>'.$row['3'].'</b>.<br>Its status is currently <b>pending</b>.<br><br><hr><br>';
					break;
				case 1: $trackStatus = 'The tracking number '.$trackNum.' is linked to the site: <b>'.$row['3'].'</b>.<br>Its status is currently <b>rejected</b>.<br><br><hr><br>';
					break;
				case 2: $trackStatus = 'The tracking number '.$trackNum.' is linked to the site: <b>'.$row['3'].'</b>.<br>Its status is currently <b>accepted</b>.<br><br><hr><br>';
					break;
				case 3: $trackStatus = 'The tracking number '.$trackNum.' is linked to the site: <b>'.$row['3'].'</b>.<br>Its currently in the <b>graveyard</b>.<br><br><hr><br>';
					break;
				default: $trackStatus = 'The tracking number '.$trackNum.' is linked to the site: <b>'.$row['3'].'</b>.<br>Its status <b>can not be determined</b> at this time.<br><br><hr><br>';
					break;
			}
			
		} else {
			$trackStatus = 'The tracking number you entered, <b>'.$trackNum.'</b>, is not related to any affies on our site. Please try another tracking number, or <a href="/registationForm.php" alt="">apply</a> to be affiliates.<br><br><hr><br>';
		}
	}
    
    echo $header.
			'<h1>Track your Application</h1>'.
						
			''.$trackStatus.''.
			
			'Please enter a tracking number in the form below and hit enter to track the status of your application.<br /><br />'.
			
			'<form action="track.php?trk=num" method="GET">'.
			'<table width=100%>'.
				'<tr><td colspan><span class="errMsg">'.$errMsg.'</span></td></tr>'.
				'<tr><td><input name="trk" type="hidden" value="num"></td></tr>'.
				'<tr><td><center>Tracking Number: <input name="trackNum" type="text" /><input type="submit" value="Track"></center></td></tr>'.
			'</table>'.
			'</form>'.
			
			$footer;
			
?>