
<?php
session_start();
include ("connection.php");
?>

<?php
if ($_SESSION['zalogowany']){
$nick = $_SESSION['login'];
$query = mysql_query("SELECT * FROM uzytkownicy WHERE Nick = '".$nick."'");
$r = mysql_fetch_array($query);
$imie = $r['Imie'];
$nazwisko = $r['Nazwisko'];
$email = $r['Email'];
$omnie = $r['OMnie'];
$dataUr = $r['DataUr'];
$dataRej = $r['DataRej'];
?>

<link href="formECSS.css" type="text/css" rel="stylesheet"/>
<title>Multimedialny dziennik podróży - edycja danych.</title>
</head>
<body>
<div id="container">
<fieldset>
<legend>Profil użytkownika</legend><br>
<label for="firstname">Imie:</label>     <input type='text' value="<?php echo $imie;?>"  class='pData' id='firstname' name='firstname' disabled = "disabled"><br>
	<label for="surname">Nazwisko:</label>   <input type='text' value="<?php echo $nazwisko;?>" class='pData' id='surname' name='surname' disabled="disabled"><br>
	<label for="email">E-mail:</label>       <input type='email' value="<?php echo $email;?>" class='pData' id='email' name='email' disabled="disabled"><br><br>
	<label for="omnie">O mnie:</label>       <input type='text'  value="<?php echo $omnie;?>" class='pData' id='omnie' name='omnie' disabled = "disabled"><br><br>
	<label for="dataUr">Data urodzenia:</label>     <input type='text' value="<?php echo $dataUr;?>" class='pData'  id='dataur'  disabled = "disabled"><br><b>
	<label for="dataRej">Data rejestracji:</label>  <input type='text' value="<?php echo $dataRej;?>" class='pData'  disabled = "disabled"><br><b>
</fieldset>
	</div>
</body>
<?php }
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany<br><a href="login.php">Zaloguj się</a><br>';
}
?>
