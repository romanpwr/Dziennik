<?php
session_start();
include ("connection.php");

if (isset($_POST['edit'])){
if (isset($_POST['redaktor'])){
header('Location: editEditor.php?id='.$_POST['redaktor']);
}
}
if (isset($_POST['del'])){
if (isset($_POST['redaktor'])){
header('Location: delEditor.php?id='.$_POST['redaktor']);
}
}


?>



<?php
if (isset($_SESSION['zalogowany'])){
$nick = $_SESSION['login'];
$spr1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dzienniki WHERE IdDziennika='".$nick."' LIMIT 1"));
$komunikaty = '';
$searcherror = false;

if ($spr1[0] == 1){

if (isset($_POST['dodaj'])){
$nickred = $_POST['nickred'];
$spr2 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownicy WHERE nick='".$nickred."' LIMIT 1"));
$spr3 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM redaktorzy WHERE NickRed='".$nickred."' AND NazwaDziennika = '".$nick."' LIMIT 1"));

if ($spr2[0] <1){
 $komunikaty .= '<font color="red"><b>Użytkownik o podanym nicku: '.$nickred.' <br>nie istnieje, sprawdź pisownię i spróbuj jeszcze raz.</b></font><br />';
 $searcherror = true;
 }
if  ($spr3[0] >=1){
$komunikaty .= '<font color="red"><b>Użytkownik o podanym nicku: '.$nickred.' <br>istnieje już jako redaktor w Twoim dzienniku. </b></font>';
$searcherror = true;
}
if ($nick == $nickred){

$komunikaty .= '<font color="red"><b>Nie możesz dodać samego siebie.</b></font>';
$searcherror = true;
}
 else{
 if (!($searcherror)){
 $result = mysql_query("INSERT INTO redaktorzy (`NickRed`, `NazwaDziennika`, `EdycjaAutora`, `EdycjaRedaktora`) VALUES ('".$nickred."', '".$nick."', 'NIE', 'NIE')");
 if ($result){
 $komunikaty .= '<font color="blue"><b>Użytkownik: '.$nickred.' <br> został dodany poprawnie. </b></font><br />';
 }
 else {
 echo ' '.mysql_error();
 }
 }
}
}
$query = mysql_query("SELECT IdRed, NickRed FROM redaktorzy WHERE NazwaDziennika = '".$nick."'");

?>
<title>Dodawanie redaktorów do dziennika</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>

</head>
<body>
<div id="inside">
<fieldset>
<p>Dodawanie nowego redaktora:</p>
<?php echo $komunikaty; ?>
	<form name="searchEditorForm" method="POST" action="addEditor.php"><br>
		<input type="text" id="wpisz" size="25" style="color:grey;" name="nickred" required="required" value="<?php if (isset($_POST['nickred'])) {echo $_POST['nickred'];} else {?>Podaj tu nick do szukania<?php }?>">
		<input type="submit" name="dodaj" value="Dodaj">
	</form>
	</fieldset>
</div>
<br>
<div id="table">
<fieldset>
<p>Lista redaktorów przydzielonych do dziennika:</p>
	<table border="1">
	<tr>
		<th class="select">Zaznacz</th>
		<th>Lp</th>
		<th>Nick</th>
	</tr>
	<?php 
	$i = 0;
	echo ('<form method="POST" action="addEditor.php">');
	while ($row = mysql_fetch_array($query, MYSQL_BOTH)){
	$i ++;
	
		echo '<tr>
		<td  class="select">
			
				<input type="radio" name="redaktor" value="'.$row['IdRed'].'" required="required"><br>
			
		</td>
		<td class="indexed">
		<!-- liczba porzadkowa Redaktora -->
			<var><center>'.$i.'</center></var>
		</td>
		<td class="nickName">
		<!-- Nick pierwszego Redaktora -->
		<p><center>'.$row['NickRed'].'</center></p>
		</td>
		
	</tr>';
	}
echo'</table>
<!-- Usuniecie Redaktora -->
		    <input type="submit" name="edit" value="Edytuj"';
			if ($i ==0){
			echo ('disabled="disabled"');
			}
			echo'>
			<input type="submit" name="del" value="Usun"';
			if ($i ==0){
			echo ('disabled="disabled"');
			}			
			echo'>';
			?>
		</form>
		</fieldset>
</div>
<script>
	$("#wpisz").click(function() {
	$(this).attr("value","");
	$(this).css("color","black");
	});	
</script>
</body>
<?php
}
else{
echo 'Nie posiadasz swojego dziennika, możesz założyć go <a href="addDiary.php">TUTAJ</a><br />.';
}
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="login.php">Zaloguj się</a><br>';
}
?>