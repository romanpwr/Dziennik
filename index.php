<?php session_start();
include("connection.php");
$nick="";
if (isset($_SESSION['login'])) {
	$nick = $_SESSION['login'];
}
if (empty($nick)) {
	echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany<br><a href="login.php">Zaloguj się</a><br>';
	echo 'Lub <a href="register.php">Zarejestruj się</a>';
	exit;
}

// tresc dla zalogowanego uzytkownika
echo 'Witaj '.$nick.' zostałeś/aś pomyślnie zalogowany/a <br/>';
echo '<a href="edit.php">Edytuj swój profil</a><br />';
echo '<a href="addDiary.php">Dodaj nowy dziennik</a><br />';
echo '<a href="addEditor.php">Dodaj nowego redaktora</a><br />';
$dziennik = mysql_query("SELECT * FROM dzienniki WHERE IdDziennika='$nick'");
if (isset($_SESSION['dziennik']) && strlen($_SESSION['dziennik'])>1){
echo '<a href="addInscription.php">Dodaj wpis do dziennika</a><br />';
$dziennik = $_SESSION['dziennik'];

$wpis = mysql_query("SELECT * FROM wpisy WHERE IdDziennika = '".$dziennik."'");

while ($row = mysql_fetch_array($wpis, MYSQL_BOTH)){
echo '<a href="editInscription.php?idWpisu='.$row['IdWpis'].'">Edytuj wpis numer '.$row['IdWpis'].'</a> z dnia '.$row['DataWpisu'].'<br />';
}
}
echo '<br><a href="wyloguj.php">Wyloguj mnie</a>';
?>