<?php
session_start();
include ("connection.php");

if (isset ($_SESSION['zalogowany'])){
if (isset($_GET['id'])){
$id = $_GET['id'];
$nick = $_SESSION['login'];
$query = mysql_query("SELECT * FROM redaktorzy WHERE IdRed = '".$id."' AND NazwaDziennika = '".$nick."'");
$r = mysql_fetch_array($query);

if (!(isset($r['IdRed']))){
	echo 'Wybrany redaktor nie należy do Twojego dziennika. <br />';
	exit;
}
else{
$query2 = mysql_query("SELECT * FROM dzienniki WHERE IdDziennika ='".$r['NazwaDziennika']."'");
$d = mysql_fetch_array($query2);
}
if (isset($_POST['zmiana'])){
$komunikaty = '';
$query3 = mysql_query("SELECT * FROM uzytkownicy WHERE Nick = '".$nick."'");
$n = mysql_fetch_array($query3);
if (isset ($_POST['password'])){
$old = $_POST['password'];
$old = md5($old);
if ($old==$n['Haslo']){
$redaktor = 'NIE';
$autor = 'NIE';
if (isset($_POST['option1'])){
$redaktor = $_POST['option1'];
}
if (isset($_POST['option2'])){
$autor = $_POST['option2'];
}
$result = mysql_query("UPDATE redaktorzy  SET EdycjaAutora='".$autor."', EdycjaRedaktora ='".$redaktor."' WHERE IdRed = '".$id."'");
if (!$result){
    die('Invalid query: ' . mysql_error());
  }
  else {
  $komunikaty.="Uprawnienia zostały nadane <br />";
  }
}
}
else{
$komunikaty.= "Podane aktualne hasło, jest nieprawidłowe. <br />";
}
}
$query = mysql_query("SELECT * FROM redaktorzy WHERE IdRed = '".$id."' AND NazwaDziennika = '".$nick."'");
$r = mysql_fetch_array($query);


?>
<html>
<head>

<title>Strona glowna</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>

</head>
<body>
<div id="inside">
<p>Edycja uprawnień redaktora</p>
<?php if (isset($komunikaty) && (!isset($result) || $result == FALSE)) { echo '<font color="red"><b> '.$komunikaty.'</b></font>'; }
	  elseif (isset($komunikaty)){echo '<font color="blue"><b> '.$komunikaty.'</b></font>';}?>
	<form name="Access_Editor" method="POST" <?php echo 'action="editEditor.php?id='.$id.'"'; ?>><br>
		Nick redaktora: <br /><input type="text" id="NickR" class="" size="25" style="color:black;" disabled value="<?php if (isset($r['NickRed'])) {echo $r['NickRed']; }?>"><br>
		Nazwa dziennika: <br /><input type="text" id="NazwD" class="" size="25" style="color:black;" disabled value="<?php if (isset($d['Nazwa'])) {echo $d['Nazwa']; }?>"><br>
	
		<p>Uprawnienia</p>
		<input type="checkbox" name="option1" value="TAK" 
			<?php if (isset ($r['EdycjaRedaktora'])) {
				  if ($r['EdycjaRedaktora'] == 'TAK') 
					{ echo 'checked="checked"'; 
					}
				  } ?>
		> Mozliwosc edycji wpisow innych Redaktorow<br>
		<input type="checkbox" name="option2" value="TAK"<?php if (isset ($r['EdycjaAutora'])) {
				  if ($r['EdycjaAutora'] == 'TAK') 
					{ echo 'checked="checked"'; 
					}
				  } ?>
		>Mozliwosc edycji wspisow Autora <br>
		
		<p>Podaj haslo w ramach potwierdzenia </p>
		<input type="password" id="Psswd" name="password" class="wpisz" size="25" style="color:grey;" value="" required="required"><br>
		<p>Zatwierdz zmiany</p>
		<input type="submit" name="zmiana" value="Zatwierdz">
	</form>
</div>
<script>
	$(".wpisz").click(function() {
	$(this).attr("value","");
	$(this).css("color","black");
	});	
</script>
</body>
<?php
}
else{
echo'<br>Błąd. <br />Nie wybrano redaktora do zmiany uprawnień. <br />';



}
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany<br><a href="login.php">Zaloguj się</a><br>';
	echo 'Lub <a href="register.php">Zarejestruj się</a>';
	exit;


}
?>