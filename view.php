<?php 
	require_once('db.php');
	
	// make sure user is logged in
	if((isset($_SESSION['status'])) != 'active'){
		header('Location: login.php?err=3&url=Admin');
		exit;
	}
	
	$query = mysql_query("SELECT * FROM my_info WHERE myPos = 'owner'");
	$row = mysql_fetch_array($query);
	$myEmail = $row['myEmail'];
	$mySite = $row['mySite'];
	$mySiteUrl = $row['mySiteUrl'];
	$myId = $row['id'];
	$opt1 = $row[8];
	$opt2 = $row[9];
	
	/* row settings:
		0 => id number
		1 => affie name
		2 => email
		3 => Site name
		4 => site url
		5 => button url
		6 => status			// 0 = pending, 1 = rejected, 2 = accepted, 3 = graveyard, 4 = opt1, 5 = opt2
		7 => not needed
	*/
	
	$filter = '<div style="clear:left;"></div><br><hr>';
	$filter .= 'Filter affiliates by their status: <a href="view.php?flt=0">Pending</a> | <a href="view.php?flt=1">Rejected</a> | <a href="view.php?flt=2">Accepted</a> | <a href="view.php?flt=3">Graveyard</a><br>';
	
	if(strlen($row[8]) > 0){
		$filter .= 'Filter affiliates by Option 1: <a href="view.php?flt=4">'.$opt1.'</a>.<br>';
	} else {
		$filter .= 'Option 1 has not been set.<br>';
	}
	
	if(strlen($row[9]) > 0){
		$filter .= 'Filter affiliates by Option 2: <a href="view.php?flt=5">'.$opt2.'</a>.<br>';
	} else {
		$filter .= 'Option 2 has not been set.<br>';
	}
	
	$filter .= '<hr>';
	
	function output_all_accepted(){
	
		$query = "SELECT * FROM affie_info";
		
		
		if(isset($_GET['flt'])){
			$flt = mysql_real_escape_string($_GET['flt']);
			switch($flt){
				case 0: $query = "SELECT * FROM affie_info WHERE status = 0"; $curStatus = 'Pending'; break;
				case 1: $query = "SELECT * FROM affie_info WHERE status = 1"; $curStatus = 'Rejected'; break;
				case 2: $query = "SELECT * FROM affie_info WHERE status = 2"; $curStatus = 'Accepted'; break;
				case 3: $query = "SELECT * FROM affie_info WHERE status = 3"; $curStatus = 'Graveyard'; break;
				case 4: $query = "SELECT * FROM affie_info WHERE opt1 = 1"; $curStatus = 'Option 1'; break;
				case 5: $query = "SELECT * FROM affie_info WHERE opt2 = 1"; $curStatus = 'Option 2'; break;
				default: $query = "SELECT * FROM affie_info"; $curStatus = 'Accepted'; break;
			}
		} else {
			$curStatus = 'Active';
		}
	
		$result = mysql_query($query);
		$resultSize = mysql_num_rows($result);
		
		if($resultSize > 0){
			$output .= 'There are '.$resultSize.' affiliates in the database with the status '.$curStatus.'<br><hr>';
			//$output .= '<form action="view.php" method="POST"><table width="100%" align="center"><tr>';
			$output .= '<div style="text-align:center;">';
			if($flt == 4){
				$opt = 'opt1';
			} else if($flt == 5){
				$opt = 'opt2';
			}
			$optCheckSQL = mysql_query("SELECT * FROM my_info");
			$optCheck = mysql_fetch_array($optCheckSQL);
			if( ($flt == 4 AND strlen($optCheck['opt1'])==0) OR ($flt == 5 AND strlen($optCheck['opt2'])==0) ){
				$output .= 'Error. The option you have selected has not been activated. Please try another filter.';
			} else {
				while($row = mysql_fetch_row($result)){
					$affieID = md5($row[0]);
					$output .= '<div style="float:left; padding:10px;"><a href="affiesInfo.php?id='.md5($row[0]).'">'.$row[1].'</a><br><a href="'.$row[4].'" target="_blank" alt=""><img src="'.$row[5].'"></a></div>';
				}
			}
			$output .= '</div>';
		} else {
			$output .= 'There are no affiliates with the status '.$curStatus.'.';
		}
			
			return $output;
	}
	
	
	
	echo $header.
			'<h1>View Affiliates</h1>'.
			
			$menu.
			
			//''.$processActionOutput.''.
			
			'Below are all the affiliates. You can filter them based on their status using the links below.<br><br>'.
			
			''.$errMsg.''.
			
			output_all_accepted().
			
			$filter.
			
			$footer;
	
?>