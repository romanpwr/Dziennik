<?php session_start();
include ("connection.php");
if (isset($_SESSION['dostep']) && $_SESSION['dostep']==1) {
function curPageURL() {
 $pageURL = $_SERVER["REQUEST_URI"];
 return $pageURL;
}
if (isset($_GET['IdWpisu']) && isset($_GET['zgl'])) {
$IdWpisu = $_GET['IdWpisu'];
$id = $_GET['zgl'];
$page = curPageURL();
$zgloszenie = mysql_fetch_array(mysql_query("SELECT * FROM zgloszenia WHERE IdZgloszenia ='$id'"));
if (isset($zgloszenie['Url']) && $zgloszenie['Url']."&zgl=$id" == $page){
$update = mysql_query("UPDATE zgloszenia SET StatusZgl = 1 WHERE IdZgloszenia ='$id'");
$row= mysql_fetch_array(mysql_query("SELECT * FROM Wpisy WHERE IdWpis = '$IdWpisu'"));
$nick=$row['NickRed'];
		$spr = mysql_fetch_assoc(mysql_query("SELECT * FROM katalog WHERE IdKatalog ='".$row['IdKatalog']."'"));
		$spr2 = mysql_query("SELECT Komentarze FROM Dzienniki WHERE IdDziennika='".$spr['IdDziennika']."'");
		$rowK = mysql_fetch_array($spr2,MYSQL_ASSOC);		
		//koniec, R.P.
        $tytul=$row['Tytul'];
        $tresc=$row['Tresc'];
		$query = mysql_query("SELECT * FROM zalaczniki WHERE idwpisu = '".$IdWpisu."'");
	
?>

<html>
<head>

<title>Strona glowna</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function() {
	$("#deleteForm").hide();
	$('.deleteBT').click(function(){
		var form_data = {
			username: $("#adminlogin").val(),
			password: $("#password").val(),
			is_ajax: 1
		};
		$.ajax({
			type: "POST",
			url: "pass.php",
			data: form_data,
		}).done(function( response ) {
		//alert(response);
                if(response == "﻿success"){
					var del_data = {
					idwpis: $("#idwpis").val(),
					zgl: $("#id").val(),
					is_wpis: 1
					};
					//$('input:checkbox').serializeArray()
					$.ajax({
					type: "POST",
					url: "delete.php",
					data: del_data,
					}).done(function (msg){
					if (msg == "﻿success"){
					$("#deleteForm2").slideUp('slow');
					$("#container").slideUp('slow');
					$("#zgloszenie").slideUp('slow');
					$("#deleteForm").slideUp('slow', function() {
						$("#message").html("<p class='success'><font color='blue'>Wpis poprawnie usunięty</font></p>");
					});
					$('.usunUser').attr('disabled', 'disabled');
					}
					else{
					alert(msg);
					//$("#message").html("<p class='error'><font color='red'>Wystąpił błąd</font></p>");
					}
					});
					}
				else
					$("#message").html("<p class='error'><font color='red'>Podano nieprawidłowe hasło.</font></p>");	
		});
		
		return false;
	});
	$('.usunUser').click(function(){
	$("#deleteForm").show();
	window.location = "#deleteForm";
	});
	
	$('.nagana').click(function(){
	window.location = "adminSendReport.php?user="+$("#nick").val();
	
	});
	
	});
	</script>

</head>
<body>
<div id="container">
	<!-- Tytul wpisu -->
	<div id="title" name="titleName"><h3><?php echo $tytul;?></h3></div>
	<!-- tekst wpisu -->
	<div id="entry" name="entryText"> 
            <?php echo $tresc;?>
        </div>
	<!-- Multimedia -->
	<div id="mediaList" name="mediaList"> 
	<?php
	$i = 0;
	while ($row = mysql_fetch_array($query, MYSQL_BOTH)){
	if ($i ==0){
	
	echo '
	<ul name="photoList">';
	}
		echo'<li>
			
				<img src="
				'//miniaturka.php?foto='
				.$row["url"].'" height="150" width="150">
				<br>
			
		</li>';
		
		$i++;
		}
	if ($i != 0){
	echo '</ul>';
	}
	?>
<?php
//echo 'komentowac: '.$rowK["Komentarze"].'';
if($rowK["Komentarze"] == "TAK"){
	include("showComments.php");
	show($IdWpisu);
}
?>
</div></div>
<input type="hidden" name="nick" id="nick" value="<?php echo $nick;?>">

	Wybierz działanie<br>
	<input type="submit" class="nagana" id="nagana" name="nagana" value ="Dodaj naganę">
	<input type="submit" class="usunUser" id="usunUser" name="usunUser" value ="Usuń wpis">
	<form action="adminReportPage.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $zgloszenie['IdZgloszenia']; ?>">
	<input type="submit" class="zamknij" id="zamknij" name="zamknij" value ="Zamknij zgłoszenie">
	</form>
	<div id="message"></div>
	<div id="delete">
	<fieldset id="deleteForm">
	<form id="deleteForm2" action="" method="POST">
	<input type="hidden" name="idwpis" id="idwpis" value="<?php echo $IdWpisu;?>">
	<input type="hidden" id="id" name="id" value="<?php echo $zgloszenie['IdZgloszenia']; ?>">
	<input type="hidden" id="adminlogin" name="adminlogin" value="<?php echo $_SESSION['login']; ?>">
	<b>Podaj swoje hasło</b><br>	<input type="password" id="password" name="password" value="" required="required"><br>
	<input type="submit" class="deleteBT" id="deleteBT" name="deleteBT" value="Potwierdź usunęcie">
</body>

</html>

<?php
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Wybrano błędny wpis! </span><br>';
    }
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nieprawidłowe zgłoszenie.</span><br>';
}
}
?>