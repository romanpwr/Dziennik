﻿﻿<?php 
session_start();
include("connection.php");

if (isset($_GET['IdWpisu']))
{
    $IdWpisu=$_GET['IdWpisu'];
    $query="SELECT * FROM wpisy WHERE IdWpis=$IdWpisu";
	$dziennik = $_SESSION['dziennik'];
	
    $result=  mysql_query($query);	
	date_default_timezone_set("Europe/Warsaw");
    if (mysql_num_rows($result)==1){
        $wpis=  mysql_fetch_assoc($result);   
		//do komentarzy, R.P.
		$spr = mysql_fetch_assoc(mysql_query("SELECT * FROM katalog WHERE IdKatalog ='".$wpis['IdKatalog']."'"));
		$spr2 = mysql_query("SELECT Komentarze FROM Dzienniki WHERE IdDziennika='".$spr['IdDziennika']."'");
		$rowK = mysql_fetch_array($spr2,MYSQL_ASSOC);		
		//koniec, R.P.
        $tytul=$wpis['Tytul'];
        $tresc=$wpis['Tresc'];
		$query = mysql_query("SELECT * FROM zalaczniki WHERE idwpisu = '".$IdWpisu."'");
	
?>

<html>
<head>

<title>Strona glowna</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>

</head>
<body>
<div id="inside">
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
	<div id="buttonsBox">
		<form name="buttonForm" action="editInscription.php?idWpisu=<?php echo $IdWpisu; ?>" method="POST">
			<input type="submit" name="Edycja" value ="Edycja">
		</form>
		<form name="buttonForm2" action="" method="POST">
			<input type="submit" name="Usun" value ="Usun" disabled="disabled">
		</form>
	</div>
	<form name="buttonForm" action="reportForm.php?idWpisu=<?php echo $IdWpisu; ?>" method="POST">
			<input type="submit" name="zglos" value ="Zgłoś ten wpis">
		</form>
	
</div>
<?php
//echo 'komentowac: '.$rowK["Komentarze"].'';
if($rowK["Komentarze"] == "TAK"){
	include("addComment.php");
	comment($IdWpisu);
	include("showComments.php");
	show($IdWpisu);
}
?>

</body>

</html>

<?php
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Wybrano błędny wpis! </span><br>';
    }
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie wybrano wpisu! </span><br>';
}
?>