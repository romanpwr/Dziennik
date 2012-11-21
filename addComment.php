<?php
function comment($parametr){
$komunikaty = "";
if (isset($_SESSION['zalogowany'])){

if (isset($_POST['wyslij'])){
$nick = $_SESSION['login'];
$komentarz = $_POST['komentarz'];
$wpis = $parametr;
	date_default_timezone_set("Europe/Warsaw");

$result = mysql_query("INSERT INTO komentarze (IdWpisu, IdUser, Tresc, Widoczny, Ostrz, DataOstrz) VALUES('$wpis','$nick','$komentarz','',null,null)") or die("Nie mogłem dodac komentarza !".mysql_error());
$komunikaty .= "ok";

}
?>



<div id="inside">
<form action="showReg.php?IdWpisu=<?php if(isset($komunikaty))echo $parametr;?>" method="POST">
<p>Dodaj komentarz</p>
<textarea style="color:grey; resize:none;" name="komentarz" id="komentarz" rows="7"  cols="40" placeholder="Miejsce na Twoj komentarz" required="required">
</textarea><br>
<input type="submit" name="wyslij" value="Wyslij">
<?php if ($komunikaty =="ok")  { echo '<br><span style="color: green; font-weight: bold;">Komentarz został dodany. </span><br>';} ?>
</form>
</div>
</body>

</html>
<?php
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="login.php">Zaloguj się</a><br>';
}
}
?>
