<?php
session_start();
include ("connection.php");

/** W sesji przesyłane są:
zalogowany = true - może mieć dalsze zastosowanie, u mnie nie ma. Sesja po wylogowaniu zostaje zniszczona.
login - login/nick danego usera
dostep - dostęp do naszego serwisu, domyślnie na razie jest to 0, ale zostanie zmienione na 1 (user), 2(admin), 3(superadmin)

**/

if(isset($_SESSION['zalogowany'])) {
echo "From Session <br />";
$login = $_SESSION['login'];
$dziennik = $_SESSION['dziennik'];
echo $login." Zostałeś poprawnie zalogowany.<br /> Twój poziom dostępu to ".$_SESSION['dostep']." </br> Masz dziennik: ".$dziennik;
		   echo('<br /><a href="index.php">Kliknij tutaj, aby przejść dalej</a>');
}else{
if(isset($_POST['wyslij'])) {
$login = $_POST['login'];
$haslo = $_POST['password'];
$haslo = md5($haslo);
$query = mysql_query("SELECT * FROM uzytkownicy WHERE Nick = '".$login."' && Haslo = '".$haslo."' ");
  if(mysql_num_rows($query) > 0) {

	       $r = mysql_fetch_array($query);
           $_SESSION['zalogowany'] = true;
           $_SESSION['login'] = $login;
		   $_SESSION['dostep']= $r['Dostep'];
		   $spr1 = mysql_query("SELECT * FROM dzienniki WHERE IdDziennika ='".$login."'");
		   if (mysql_num_rows($spr1) > 0){
		   $_SESSION['dziennik'] = $login;
		   }
		   else {
		   $_SESSION['dziennik'] ='0';
		   }
		   echo $_SESSION['dziennik']."<br />";
           echo $login." <br />Zostałeś poprawnie zalogowany.<br /> Twój poziom dostępu to ".$_SESSION['dostep']." </br>";
		   echo('<a href="index.php">Kliknij tutaj, aby przejść dalej</a>');
		   

       } else { 

   echo "Błędny login lub hasło";
 }
 } 
 if(!isset($_SESSION['zalogowany'])) {
 
?>

<link href="Data/formLCSS.css" type="text/css" rel="stylesheet"/> 
<title>Multimedialny dziennik podróży - logowanie.</title>

<div id="container">
<form name="input" method="post" action="login.php"> <!--(do srodka) |action="html_form_action.asp" method="get"| po nacisnieciu submit - wysyla dane do html_form_action.asp --> 
    <fieldset>
    <label for="loginname">Login: </label>    <input type='text'  class='lData' id='loginname' name='login' required="required"><br>
    <label for="password">Hasło: </label>     <input type='password'  class='lData' id='password' name='password' required="required"><br>
    <a href="stonaPrzypomienia.html" style="float:right">Przypomnienie hasła</a><br>
    <a href="register.php" style="float:right">Rejestracja</a><br>
    <input type="submit" class="submit" name="wyslij" value="Zaloguj">
    </fieldset>
</form>
</div>

<?php
}
}
?>
