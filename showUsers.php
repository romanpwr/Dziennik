<?php
    session_start();
    include("connection.php");
    if (isset($_SESSION['dostep']) && $_SESSION['dostep']==1) {
    $result=mysql_query("SELECT * FROM uzytkownicy AS u LEFT JOIN dzienniki AS d ON u.Nick=d.IdDziennika");
?>


<!DOCTYPE html>
<html>
<head>

<title>Strona glowna</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>

</head>
<body>
<div id="inside">
<p>Lista uzytkownikow</p>
<form name="UsersList" action="profile.php" method="POST"><br>
		<table border="1">
		<tr>
		<th>Zaznacz</th>
		<th>Lp</th>
		<th>Login</th>
		<th>Imie</th>
		<th>Nazwisko</th>
		<th>Przejrzyj dziennik</th>
		<th>Dodaj nagane</th>
		<th>Usun nagane</th>
		<th>Usun uzytkownika</th>
		<th>Wyslij wiadomosc</th>
		</tr>
                    <?php
                       if (mysql_num_rows($result)>0) { 
                        $i=0;
                        while ($tab= mysql_fetch_assoc($result)) {                     
                        $nick = $tab['Nick'];
                        $imie = $tab['Imie'];
                        $nazwisko = $tab['Nazwisko'];
                        $dziennik = $tab['Nazwa'];                        
                        echo '<tr>
				<td  class="select">
					<input type="radio" name="userSelected" required="required">
				</td>
				<td class="">
					<!-- Numeracja uzytkownika -->
					<input type="text" name="numberOfUser"  class="" disabled value="'.++$i.'">
				</td>
				<td class="">
					<!-- Login uzytkownika -->
					<input type="text" name="loginUser" class="" disabled value="'.$nick.'">
				</td>
				<td class="">
					<!-- Imie uzytkownika -->
					<input type="text" name="nameUser" class="" disabled value="'.$imie.'">
				</td>
				<td class="">
					<!-- Nazwisko uzytkownika -->
					<input type="text" name="surnameUser" class="" disabled value="'.$nazwisko.'">
				</td>
				<td class="">
					<a href="getInscription.php?Dziennik='.$nick.'">'.$dziennik.'</a>
				</td>
				<td class="">
					<!-- Dodaj nagane -->
					<!-- Przycisk zostanie zmieniony obrazkiem (+) -->
					<input type="button" name="addCaution" class="" value="Dodaj nagane">
				</td>
				<td class="">
					<!-- Usun nagane -->
					<!-- za przyciskiem bedzie ilosc nagan podana w nawiasie -->
					<!-- Przycisk zostanie zmieniony obrazkiem (-) -->
					<input type="button" name="delCaution" class="" value="Usun nagane">
				</td>
				<td class="">
					<!-- Usun uzytkownika -->
					<input type="button" name="delUser" class="" value="Usun Usera">
				</td>
				<td class="">
					<!-- Wyslij uzytkownikowi wiadomosc mailowa -->
					<a href="mailto: adres e-mail ">wyslij</a>
				</td>
                            </tr> ';
                        }
                      }
                    ?>
		</table>
		<input type="submit" name="wyslij" value="Zatwierdz">
	</form>
</div>
</body>

</html>

<?php
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Dostep maja tylko administratorzy! </span><br>';
    }
?>