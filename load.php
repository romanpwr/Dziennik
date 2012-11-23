<?php
include("connection.php");
if(isset($_GET['a']) && $_GET['a'] == 'zgloszenie'){

	$query = mysql_query("SELECT * FROM zgloszenia ORDER BY `IdZgloszenia` ASC");
	
	while ($row = mysql_fetch_array($query, MYSQL_BOTH)){
	    switch($row['StatusZgl']){
			case 0:
				$stan = "NEW";
				break;
			case 1:
				$stan = "OTWARTE";
				break;
			case 2:
				$stan = "ZAMKNIETE";
				break;
		}
		$zgloszenie.= '<option id="'.$row['IdZgloszenia'].'" zigi="'.$row['Temat'].'" url="'.$row['Url'].'" name="IdZgl" value="'.$stan.'">['.$stan.'] '.$row['Temat'].'</option>';
	}
echo $zgloszenie;
}

if(isset($_GET['a']) && $_GET['a'] == 'info')       { 
    if(intval($_GET['IdZgloszenia'])) {
		$query = mysql_query("SELECT * FROM zgloszenia WHERE IdZgloszenia='".$_GET['IdZgloszenia']."'");
		$row = mysql_fetch_array($query);
		$zgloszenie = array('0' => $row['IdZgloszenia'], '1' => $row['Tresc']);
	
	echo json_encode($zgloszenie);
	}
}
?>