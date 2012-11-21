<?php
include("connection.php");
if(isset($_GET['a']) && $_GET['a'] == 'zgloszenie'){
	if (isset($_GET['f1'])){
	$filtr = $_GET['f1'];
	}
	if (isset($_GET['f2'])){
	$filtr2 = $_GET['f2'];
	switch ($filtr2){
		case "OTWARTE":
			$spr = 1;
			break;
		case "NEW":
			$spr = 0;
			break;
		case "ZAMKNIETE":
			$spr = 2;
			break;
		case "ALL";
			break;
	}
	}
	if (isset($spr) && isset($filtr)){
	$query = mysql_query("SELECT * FROM zgloszenia WHERE Temat ='".$filtr."' AND StatusZgl ='".$spr."' ORDER BY `IdZgloszenia` ASC");
	}
	elseif (isset ($filtr)){
	$query = mysql_query("SELECT * FROM zgloszenia WHERE Temat ='".$filtr."' ORDER BY `IdZgloszenia` ASC");
	}
	elseif (isset ($spr)){
	$query = mysql_query("SELECT * FROM zgloszenia WHERE StatusZgl ='".$spr."' ORDER BY `IdZgloszenia` ASC");
	}
	else{
	$query = mysql_query("SELECT * FROM zgloszenia ORDER BY `IdZgloszenia` ASC");
	}
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
		$zgloszenie.= '<option id="'.$row['IdZgloszenia'].'" zigi="'.$row['Temat'].'"name="IdZgl" value="'.$stan.'">['.$stan.'] '.$row['Temat'].'</option>';
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