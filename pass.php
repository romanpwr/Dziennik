<?php
include ("connection.php");
	
	$is_ajax = $_REQUEST['is_ajax'];
	if(isset($is_ajax) && $is_ajax)
	{
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$password = md5($password);
		$query = mysql_query("SELECT * FROM uzytkownicy WHERE Nick='$username'");
		$row = mysql_fetch_array($query);
		
		if($password == $row['Haslo'])
		{
			echo "success";	
		}
	}
	
?>