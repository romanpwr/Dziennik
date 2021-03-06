﻿<?php
session_start();
include("connection.php");

/** Potrzebuje z sesji:
 login - nick danego usera(redaktora), który dodaje wpis
 dziennik - idDziennika, do którego wpis jest dodawany
Czyli przed wywołaniem skryptu trzeba dodał do sesji 'dziennik'!
  
 * Po przeanalizowaniu bazy uznałem, że gdy wpis dodaje autor pole NickRed zostaje puste.
 (Ewentualnie można przerobić zeby zawsze dodawac nick osoby dodającej wpis.)
 
 **/

if (isset($_SESSION['dziennik']) && strlen($_SESSION['dziennik'])>1) {
    $login = $_SESSION['login'];
    $dziennik = $_SESSION['dziennik'];

// Sprawdzanie czy dziennik został zaakceptowany przez admina
$error = false;
if ($_SESSION['dziennik'] == $login){
$zgl = mysql_query("SELECT * FROM zgloszenia WHERE NickUsera ='$login' AND Temat='dodanie dziennika' AND Url='/adminAddDiary.php?id=$login'");
while ($row = mysql_fetch_array($zgl)){
if ($row['StatusZgl'] <> 2){
$error = true;
}
}
}
if (!$error){
if(isset($_POST['submit'])) {    
    $tytul = $_POST['title'];
    $wpis = $_POST['inscription'];
	date_default_timezone_set("Europe/Warsaw");
    $data = date("Y-m-d");    
    $podroz = $_POST['trip'];
    $katalog = mysql_query("SELECT * FROM katalog WHERE Katalog='$podroz' AND IdDziennika='$dziennik'");
    if (mysql_num_rows($katalog)==1) {
        $idKatalog = mysql_fetch_assoc($katalog);
        $idKatalogu=$idKatalog['IdKatalog'];
        $spr1 = mysql_query("SELECT * FROM wpisy WHERE IdKatalog='$idKatalogu' AND DataWpisu ='$data'");
        if (mysql_num_rows($spr1) ==0){
            $query=mysql_query("INSERT INTO wpisy (IdKatalog,NickRed,Tytul,Tresc,DataWpisu) VALUES('$idKatalogu','$login','$tytul','$wpis','$data')");
            if ($query) {
                echo '<br><span style="color: green; font-weight: bold;">Wpis został dodany! </span><br>';
            } else {
                echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>'.mysql_error();
            }
        } else {
            echo '<br><span style="color: red; font-weight: bold;">W bazie danych istnieje już wpis w tym dzienniku z taką datą. Możesz TUTAJ przejść do niego. </span><br>';
        } 
    }
}

?>

<?php
}
else { echo'<br><span style="color: red; font-weight: bold;">Twój dziennik nie został jeszcze zaakceptowany przed admina.</span><br>' ;
}
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie został wybrany dziennik, do którego wpis ma być dodany lub nie posiadasz dziennika!</span><br>' ;
}
?>