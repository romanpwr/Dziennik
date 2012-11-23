<?php
include ("connection.php");
	
	$is_ajax = $_REQUEST['is_ajax'];
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
	   echo "success";
	   }
	}
	
?>