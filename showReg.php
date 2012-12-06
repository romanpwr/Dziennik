<?php 
session_start();
include("connection.php");

if (isset($_GET['dziennik'])) {
    $_SESSION['dziennik']=$_GET['dziennik'];
}

if (isset($_GET['IdWpisu']))
{
    $IdWpisu=$_GET['IdWpisu'];
    $query="SELECT * FROM wpisy WHERE IdWpis=$IdWpisu";
    $dziennik = $_SESSION['dziennik'];
	
    $result= mysql_query($query);	
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
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Wybrano błędny wpis! </span><br>';
    }
} else if (isset($_GET['wycieczka'])) {
    $query="SELECT Katalog,Opis FROM katalog WHERE IdKatalog=".$_GET['wycieczka'];
    $result=  mysql_query($query);
    $wycieczka=mysql_fetch_assoc($result);
    $tytul=$wycieczka['Katalog'];
    $tresc=$wycieczka['Opis'];
} else {
    $tytul="";
    $tresc="Wybierz wycieczke z osi czasu!";
}
if (isset($_SESSION['dziennik'])) {
?>

<html>
<head>

<title>Strona glowna</title>
<?php
if (isset($_GET['IdWpisu'])) echo 
    '<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css" media="all">';
else echo 
    '<link rel="stylesheet" type="text/css" href="Data/cssShowReg.css" media="all">';
?>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="simplegallery/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="simplegallery/js/simplegallery.js"></script>

</head>

<body>
<div id="inside">
    <div id="inscription">
	<!-- Tytul wpisu -->
	<div id="title" name="titleName"><h3><?php echo $tytul;?></h3></div>
	<!-- tekst wpisu -->
	<div id="entry" name="entryText"> 
            <?php echo $tresc;?>
        </div>
	<!-- Multimedia -->
        <div id="simplegallery">
        <script>sg_load("", "Galeria multimediów", "100", "80",<?php echo $IdWpisu; ?>);</script>
        </div>
    </div>    
    <div id="timeline">
    <?php
    include ("timelineFun.php");
           
    $nr=0;
    if (isset($_GET['wycieczka'])) {
        $query="SELECT * FROM wpisy WHERE IdKatalog=".$_GET['wycieczka'];
        $wpisy=mysql_query($query);
        $nr=mysql_num_rows($wpisy);
    }
    if ($nr>0) {
        drawInscriptionLine($_GET['wycieczka']);
    } else {            
        if (isset($_GET['rok'])) $rok=$_GET['rok'];
        else $rok=date("Y");
        drawTripLine($rok,$_SESSION['dziennik']);
    } 
    ?>
    </div>
    <div id="buttonsBox">
            <!--Wyswietla sie, gdy przeglada uzytkownik(zalogowany). No i gdy widnieje wpis! -->
            <?php 
            if (isset($_SESSION['zalogowany'])) {
            if (isset($_GET['IdWpisu'])) { // trzeba sprawdzac czy uzytkownik ma prawa do przyciskow
            echo '
                    <div>
                    <form id="button" name="buttonForm" action="editInscription.php" method="GET">
                            <input type="hidden" value="'.$IdWpisu.'" name="idWpisu" />
                            <input type="submit" name="Edycja" value ="Edycja">
                    </form>
                    </div>
                    <div>
                    <form id="button" name="buttonForm2" action="" method="POST">
                            <input type="submit" name="Usun" value ="Usun" disabled="disabled">
                    </form>
                    </div>
                    <div>
                    <form id="button" name="buttonForm" action="reportForm.php?idWpisu='.$IdWpisu.' ?>" method="POST">
                            <input type="submit" name="zglos" value ="Zgłoś ten wpis">
                    </form>
                    </div>
                '; 
            } else if (isset($_GET['wycieczka'])) {
            echo '
                    <div>
                    <form id="button" name="buttonForm" action="editTrip.php" method="GET">
                            <input type="hidden" value="'.$_GET['wycieczka'].'" name="IdTrip" />
                            <input type="submit" name="Edycja" value ="Edycja">
                    </form>
                ';
            }            
            }
            ?>
    </div> 
</div>
<div id="komentarze">
<?php
if (isset($_GET['IdWpisu']) && $rowK["Komentarze"] == "TAK") {
    if (isset($_SESSION['zalogowany'])) {
        include("addComment.php");
        comment($IdWpisu);
        } 
    include("showComments.php");
    show($IdWpisu);
}
?>
</div>
</body>
</html>
<?php
}
?>