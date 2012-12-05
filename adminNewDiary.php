<?php
session_start();
include ("connection.php");
function curPageURL() {
 $pageURL = $_SERVER["REQUEST_URI"];
 return $pageURL;
}


if (isset($_SESSION['dostep']) && $_SESSION['dostep']==1) {
if (isset($_GET['id']) && isset($_GET['zgl'])) {
$dziennik = $_GET['id'];
$page = curPageURL();
$zgloszenie = mysql_fetch_array(mysql_query("SELECT * FROM zgloszenia WHERE IdZgloszenia ='$id'"));
if (isset($zgloszenie['Url']) && $zgloszenie['Url']."&zgl=$id" == $page){
$update = mysql_query("UPDATE zgloszenia SET StatusZgl = 1 WHERE IdZgloszenia ='$id'");
$query = mysql_query("SELECT * FROM dzienniki WHERE IdDziennika = '$dziennik");

?>
<html>
<head>

<title>Strona glowna</title>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<!-- JQuery -->
<script>
$(document).ready(function(){
	$('form input:text').attr("disabled", true).css("color","black") ;
	$('.back').hide();
});
</script>
</head>
<body>
 
<div id="container">
    <div id="request">
		<form name="newDiaryForm">
				<input type="text" id="NickU" name="nickUzytkownika" class="" size="25" value="Tutaj powinien byc nick Uzytkownika"><br>
				<input type="text" id="DiaryName" name="nazwaDziennika" class="" size="25" value="Tutaj powininna byc nazwa Dziennika"><br>
				<input type="text" id="DateR" name="dataZgloszenia" class="" size="25" value="Tutaj powinna byc data zgloszenia"><br>
				<!-- dodaj dziennik -->
				<input class="button" id="accept" type="submit" value="Akceptuj"><input class="button" type="submit" id="denited" value="Odrzuć">
		</form>
	</div>
</div>
<form class="back" action="adminReportPage.php" method="POST">
<input type="hidden" name="id" value="<?php echo $zgloszenie['IdZgloszenia']; ?>">
<input class="close" id="zamknij" type="submit" name="zamknij">
</form>
</body>

</html>
<?php
}
else{ '<br><span style="color: red; font-weight: bold;">Nieprawidłowe zgłoszenie.</span><br>';
}
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie został wybrany dziennik.</span><br>';
}
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Dostep maja tylko administratorzy! </span><br>';
    }
?>