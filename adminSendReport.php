<?php
include ("connection.php");
session_start();
if (isset($_SESSION['dostep']) && $_SESSION['dostep']==1){

if (isset($_POST['tresc']) && isset($_POST['nickU'])){
$user = $_POST['nickU'];
$tresc = $_POST['tresc'];
date_default_timezone_set("Europe/Warsaw"); 
$data = date("Y-m-d");

$query = mysql_query("INSERT INTO ostrzezenia (NickUser, Data, Powod) VALUES ('$user', '$data', '$tresc')");
if ($query){
echo "Użytkownik ".$user." dostał naganę";
exit;
}
else{
echo "Coś się spierdoliło";
exit;
}
}
if (isset($_GET['user'])){
$user = $_GET['user'];

?>
<html>
<head>

<title>Dodanie ostrzeżenia</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>

</head>
<body>
<div id="inside">
	<form name="UserProfileForm" method="POST" action="adminSendReport.php?user=<?php echo $user; ?>">
		<!-- Dane o uzytkowniku 
		<div id="lUser" name="loginU">-->
		Zgłoszenie dotyczy użytkownika o nicku: <b><?php echo $user; ?></b><br>
			<input type="hidden" id="nickU" name="nickU" class="nickU" size="25" value="<?php echo $user; ?>" required="required">
		<!--<div>
		 tresc wiadomosci -->
		<p>Powód ostrzeżenia</p>
		<textarea style="color:grey; resize:none;" name="tresc" rows="7"  cols="40"  required="required"></textarea><br>
		<input type="submit" value="Wyslij">
	</form>
</div>
</body>

</html>
<?php 
}
else{
echo "Nie został wybray użytkownik któremu chcemy nadać naganę";
}
}
else {
    echo '<br><span style="color: red; font-weight: bold;">Dostep maja tylko administratorzy! </span><br>';
}
?>