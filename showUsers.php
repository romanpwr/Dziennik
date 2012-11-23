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
<script>
$(document).ready(function() {
$("#wpisz").click(function() {
	$(this).attr("value","");
	$(this).css("color","black");
	});	
	
	$('.wyslij').click(function(){
	var user = $('#wpisz').val();
	var rows = $('.user');
	if (user == "Podaj tu nick do szukania" || user == ""){
	alert("Podaj nick");
	}
	else{
	$('.usun').removeAttr('disabled');
	rows.filter("#"+user).show();
    rows.not("#"+user ).hide();
	}
	});
	$('.usun').click(function(){
	$('.usun').attr('disabled', 'disabled');
	var rows = $('.user');
	rows.show();
	});
	$('.addCaution').click(function(){
	window.location = "adminSendReport.php?user="+$(this).attr("nick");
	
	});
});
</script>
</head>
<body>
<div id="search_panel">
			<!--<form name="searchForm" action="profile.php" method="POST"><br>-->
			<input type="text" id="wpisz" size="25" name="wpisz" style="color:grey;" value="Podaj tu nick do szukania">
			<input type="submit" class="wyslij" id="wyslij" name="wyslij" value="Szukaj">
			<input type="submit" class="usun" id="usun" name="usun" value="Usun wyszukanie" disabled = "disabled">
			<!--</form>-->
		</div>	
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
		<th>Rola</th>
		</tr>
                    <?php
                       if (mysql_num_rows($result)>0) { 
                        $i=0;
                        while ($tab= mysql_fetch_assoc($result)) {                     
                        $nick = $tab['Nick'];
                        $imie = $tab['Imie'];
                        $nazwisko = $tab['Nazwisko'];
                        $dziennik = $tab['Nazwa'];  
						if ($tab['Dostep'] == 1){
						$rola = 'Administrator';
						}
						else{
						$rola = 'User';
						}
						if ($nick != 'admin'){
                        echo '<tr class="user" id="'.$nick.'">
				<td  class="select">
					<input type="radio" name="loginUser" value="'.$nick.'" required="required">
				</td>
				<td class="">
					<!-- Numeracja uzytkownika -->
					<input type="text" name="numberOfUser"  class="" disabled value="'.++$i.'">
				</td>
				<td class="login">
					<!-- Login uzytkownika -->
					<input type="text" name="loginUser1" class="" disabled value="'.$nick.'">
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
					<form>
					<input type="button" name="addCaution" class="addCaution" nick="'.$nick.'" value="Dodaj nagane">
					</form>
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
				<td class="">
					<!-- Rola uzytkownika w systemie-->
					<input type="text" name="role" class="" disabled value="'.$rola.'">
				</td>
                            </tr> ';
							}
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