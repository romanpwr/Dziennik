<?php session_start();
include("connection.php");

$nick = $_SESSION['login'];
    if (empty($nick)) {
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany<br><a href="login.php">Zaloguj się</a><br>';
echo 'Lub <a href="register.php">Zarejestruj się</a>';
exit;
}
// tresc dla zalogowanego uzytkownika
echo 'Witaj '.$nick.' zostałeś/aś pomyślnie zalogowany/a <br/>';
echo '<a href="edit.php">Edytuj swój profil</a><br />';
echo '<a href="addDiary.php">Dodaj nowy dziennik</a><br />';
echo '<a href="addEditor.php">"Dodaj nowego redaktora</a><br />';
echo '<br><a href="wyloguj.php">Wyloguj mnie</a>';
?>