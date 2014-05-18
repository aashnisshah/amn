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
		0 - pending, 1 - rejected, 2 - accepted, 3 - deleted, 4 - graveyard
	7 - nothing
	8 - opt1 affie
	9 - opt2 affie
	*/	
	
	$SQLquery = '';
	$SQLerror = false;
	
	if(isset($who)){
		if($who == 'all'){
			$SQLquery = 'SELECT * FROM affie_info WHERE status!="100"';
		} else {
			if($who == '0'){
				$SQLquery = 'SELECT * FROM affie_info WHERE status="0"';
			} else if($who == '2'){
				$SQLquery = 'SELECT * FROM affie_info WHERE status="2"';
			} else if($who == '3'){
				$SQLquery = 'SELECT * FROM affie_info WHERE status="3"';
			} else if($who == 'opt1'){
				if(mysql_query("SELECT * FROM my_info WHERE opt1=1")){
					$SQLquery = 'SELECT * FROM affie_info WHERE status="2" AND opt1="1"';
				} else {
					$SQLquery = '';
					$SQLerror = true;
				}
			} else if($who == 'opt2'){
				if(mysql_query("SELECT * FROM my_info WHERE opt2=1")){
					$SQLquery = 'SELECT * FROM affie_info WHERE status="2" AND opt2="2"';
				} else {
					$SQLquery = '';
					$SQLerror = true;
				}
			}
		}
	} else {
		$SQLerror = true;
	}
	
	if(isset($order)){
		if($order=='rand'){
			$SQLquery .= ' ORDER BY RAND()';
		} else if($order == 'subm'){
			$SQLquery .= '';
		} else {
			$SQLerror = true;
		}
	} else {
		$SQLerror = true;
	}
	
	if(isset($num)){
		if($num == 0){
			$SQLquery .= '';
		} else if($num == 1){
			$SQLquery .= ' LIMIT 1';
		} else if($num > 1){
			$val = $num - 1;
			$SQLquery .= ' LIMIT '.$val.'';
		} else {
			$SQLerror = true;
		}
	} else {
	
	}
	
	if(isset($how)){
		$output = '<ul class="affieListUL">';
		// site name:
		if($how=='site'){
			$querySQL = mysql_query($SQLquery);
			while($row = mysql_fetch_array($querySQL)){
				$output .= '<li class="affieListLI"><a href="'.$row['siteUrl'].'" target="_blank">'.$row['siteName'].'</a></li>';
			}
			$output .= '<li class="affieListLI"><a href="http://www.aashni.me/scripts/amn" target="_blank">Affies Me Not</a></li>';
		}
		
		if($how=='own'){
			$querySQL = mysql_query($SQLquery);
			while($row = mysql_fetch_array($querySQL)){
				$output .= '<li class="affieListLI"><a href="'.$row['siteUrl'].'" target="_blank">'.$row['name'].'</a></li>';
			}
			$output .= '<li class="affieListLI"><a href="http://www.aashni.me/scripts/amn" target="_blank">Affies Me Not</a></li>';
		}
		
		if($how=='siteButton'){
			$querySQL = mysql_query($SQLquery);
			while($row = mysql_fetch_array($querySQL)){
				$output .= '<li class="affieListLI"><a href="'.$row['siteUrl'].'" target="_blank"><img src="'.$row['siteButton'].'"></a></li>';
			}
			$output .= '<li class="affieListLI"><a href="http://www.aashni.me/scripts/amn" target="_blank"><img src="http://www.aashni.me/scripts/amn/images/linkback8831.png"></a></li>';
		}
		
		if($how=='ownButton'){
			$querySQL = mysql_query($SQLquery);
			while($row = mysql_fetch_array($querySQL)){
				$output .= '<li class="affieListLI"><a href="'.$row['siteUrl'].'" target="_blank"><img src="'.$ownButton.'"></a></li>';
			}
			$output .= '<li class="affieListLI"><a href="http://www.aashni.me/scripts/amn" target="_blank"><img src="'.$ownButton.'"></a></li>';
		}
		
		if($how=='ownWord'){
			$querySQL = mysql_query($SQLquery);
			while($row = mysql_fetch_array($querySQL)){
				$output .= '<li class="affieListLI"><a href="'.$row['siteUrl'].'" target="_blank">'.$ownWord.'</a></li>';
			}
			$output .= '<li class="affieListLI"><a href="http://www.aashni.me/scripts/amn" target="_blank">'.$ownWord.'</a></li>';
		}
		$output .= '</ul>';
	} else {
		$SQLerror = true;
	}
	
	if($SQLerror == false){
		echo $output;
	} else {
		echo 'There was an error displaying your codes. Please try again.';
	}

				
?>