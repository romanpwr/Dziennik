<?php
session_start();
include ("connection.php");

if (isset($_SESSION['zalogowany'])){

if (isset($_POST['wyslij'])){
$nick = $_SESSION['login'];
$tresc = $_POST['zgloszenie_txt'];
$temat = $_POST['report'];
$komunikaty = '';
$data = date('Y-m-d');

$spr1 = strlen($tresc);
$spr2 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM zgloszenia WHERE NickUsera='".$nick."' AND Url = '".$_POST[Url]."' AND 
Temat='Bledny wpis' OR Temat='Bledny komentarz' LIMIT 1"));
$spr3 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM zgloszenia WHERE NickUsera='".$nick."' AND 
Temat='Bledny wpis' OR Temat='Dodawanie dziennika' OR Temat='Usuniecie konta' OR Temat='Usuniecie dziennika' OR Temat='Zgloszenie uzytkownika' LIMIT 1"));

if($spr1 < 3){
$komunikaty = "Zgloszenie musi miec min. 3 znaki. Uzupelnij formularz.<br>";
echo '<br><span style="color: red; font-weight: bold;">'.$komunikaty.'</span><br>';
	if($spr2 > 0){
	$komunikaty .= '<font color="red"><b>Zgloszenie o podanym temacie: '.$temat.' <br>ju¿ istnieje i czeka na decyzjê administratora. </b></font>';
	}
	else if($spr3 > 0){
	$komunikaty .= '<font color="red"><b>Zgloszenie o podanym temacie: '.$temat.' <br>ju¿ istnieje i czeka na decyzjê administratora. </b></font>';
	}
}

if ($komunikaty) {
echo '';
} else {
//jesli wszystko jest ok wysylamy zgloszenie 
$result = mysql_query("INSERT INTO `zgloszenia` (NickUsera, Temat, Tresc, Url, DataZgl, StatusZgl) VALUES('$nick','$temat','$tresc','null','$data','0')") or die("Nie mog³em dodac zgloszenia !".mysql_error());

echo '<br><span style="color: green; font-weight: bold;">Zgloszenie zostalo wyslane. </span><br>';
echo '<br><a href="index.php">Strona glowna</a>';
}
}

?>
<html>
<head>

<title>Dodawanie zgloszenia</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>

</head>
<body>


<div id="inside">

<h4>Zgloszenie</h4>
<p>Rodzaj zgloszenia</p>
<form action="reportForm.php" method="POST">
<select name="report">
<option value="Dodawanie dziennika">Dodawanie dziennika</option>
<option value="Bledny komentarz">Bledny komentarz</option>
<option value="Bledny wpis">Bledny wpis</option>
<option value="Usuniecie konta">Usuniecie konta</option>
<option value="Usuniecie dziennika">Usuniecie dziennika</option>
<option value="Zgloszenie uzytkownika">Zgloszenie uzytkownika</option>
<option value="Inne">Inne</option>
</select>

<p>Tresc zgloszenia</p>
<textarea style="color:grey; resize:none;" name="zgloszenie_txt" id="zgloszenie_txt" rows="10"  cols="30">
Prosze wpisac tu tresc zgloszenia
</textarea><br>
<input type="submit" name="wyslij" value="Wyslij">
</form>
</div>
</body>

</html>
<?php
}
else{
echo '<br>Nie by³eœ zalogowany albo zosta³eœ wylogowany.<br><a href="login.php">Zaloguj siê</a><br>';
}
?>