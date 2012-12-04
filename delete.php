<?php
include ("connection.php");
	
	if (isset ($_REQUEST['is_ajax'])){
	$is_ajax = $_REQUEST['is_ajax'];
	}
	if (isset ($_REQUEST['diary'])){
	$diary = $_REQUEST['diary'];
	}
	if (isset ($_REQUEST['is_kom'])){
	$is_kom = $_REQUEST['is_kom'];
	}
	if (isset ($_REQUEST['is_wpis'])){
	$is_wpis = $_REQUEST['is_wpis'];
	}
	if(isset($is_ajax) && $is_ajax)
	{
	   $opt = $_REQUEST['opt'];
	   $user = $_REQUEST['user'];
	   $komentarz = "";
	   $result = true;
	   for ($i =0; $i< sizeof($_REQUEST['opt']); $i++){
	   if ($result){
	   switch ($_REQUEST['opt'][$i]){
			case "dziennik":
			 $query = mysql_query("DELETE FROM dzienniki WHERE IdDziennika = '$user'");
			 if (!$query){
			 $result = false;
			 }
			 $query = mysql_query("DELETE d FROM wpisy d INNER JOIN katalog k 
								   ON d.IdKatalog = k.IdKatalog 
								   WHERE k.IdDziennika = d.NickRed AND d.NickRed = '$user'");
			 if (!$query){
			 $result = false;
			 }
			 break;
			case "wpisy":
			 $query = mysql_query("DELETE d FROM wpisy d INNER JOIN katalog k 
								   ON d.IdKatalog = k.IdKatalog 
								   WHERE k.IdDziennika <> d.NickRed AND d.NickRed = '$user'");
			 if (!$query){
			 $result = false;
			 }
			 break;
	   
	   }
	   }
	   else{
	   break;
	   }
	   }
	   if ($result){
	   $query = mysql_query("DELETE FROM ostrzezenia WHERE NickUser='$user'");
	   if (!$query){
			 $result = false;
		}
		}
		if ($result){
	   $query = mysql_query("DELETE FROM uzytkownicy WHERE Nick='$user'");
	   if (!$query){
			 $result = false;
		}
		}
	   if ($result){
	   echo "success";
	   }
	}
	elseif(isset($diary) && $diary)
	{
		$dziennik = $_REQUEST['dziennik'];
		$zgl = $_REQUEST['zgl'];
		$result = false;
		$opt = $_REQUEST['opt'];
		
		if ($opt == 'accept'){
		$update = mysql_query("UPDATE zgloszenia SET StatusZgl = 2 WHERE IdZgloszenia ='$zgl'");
		if ($update){
		$result = true;
		}
		}
		elseif ($opt =='denited'){
		$del = mysql_query("DELETE FROM dzienniki WHERE IdDziennika ='$dziennik'");
		$update = mysql_query("UPDATE zgloszenia SET StatusZgl = 2 WHERE IdZgloszenia ='$zgl'");
		if ($del){
		$result = true;
		}
		}
		if ($result){
		echo "success";
		}
	
	}
	elseif(isset($is_kom) && $is_kom)
	{
		$komentarz = $_REQUEST['idkom'];
		$zgl = $_REQUEST['zgl'];
		$result = false;
		
	
		$del = mysql_query("DELETE FROM komentarze WHERE IdKom ='$komentarz'");
		$update = mysql_query("UPDATE zgloszenia SET StatusZgl = 2 WHERE IdZgloszenia ='$zgl'");
		if ($del){
		$result = true;
		}
		if ($result){
		echo "success";
		}
	
	}
	elseif(isset($is_wpis) && $is_wpis)
	{
		$wpis = $_REQUEST['idwpis'];
		echo $wpis;
		$zgl = $_REQUEST['zgl'];
		$res = false;
		$dupa = false;
		$del = mysql_query("DELETE FROM wpisy WHERE IdWpis ='$wpis'");
		$i =0;
		
		while($row = mysql_fetch_array(mysql_query("SELECT * FROM zalaczniki WHERE idwpisu='$wpis'"))){
		$result = mysql_query("DELETE FROM zalaczniki WHERE idwpisu='$wpis' AND url = '".$row['url']."'");
		$result2 = unlink($row['url']);
		if (!$result || !$result2){
		$dupa = true;
		}
		$i++;
		}
		//$del2 = mysql_query("DELETE FROM zalaczniki WHERE idwpisu ='$wpis'");
		$update = mysql_query("UPDATE zgloszenia SET StatusZgl = 2 WHERE IdZgloszenia ='$zgl'");
		if ($del && !$dupa){
		$res = true;
		}
		if ($res){
		echo "success";
		}
	
	}
	
?>