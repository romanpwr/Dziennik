<?php 
session_start();
include("connection.php");

if (isset($_GET['IdWpisu']))
{
    $IdWpisu=$_GET['IdWpisu'];
    $query="SELECT * FROM wpisy WHERE IdWpis=$IdWpisu";
    $result=  mysql_query($query);
    if (mysql_num_rows($result)==1){
        $wpis=  mysql_fetch_assoc($result);    
        $tytul=$wpis['Tytul'];
        $tresc=$wpis['Tresc'];
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
	<ul name="photoList">
		<li>
			<a href="URL#???"><img src="sciezka do zdjecia" name="foto"></a>
		</li>
	</ul>
	</div>
	<div id="buttonsBox">
		<form name="buttonForm" action="" method="POST">
			<input type="submit" name="Edycja" value ="Edycja">
			<input type="submit" name="Usun" value ="Usun">
		</form>
	</div>
	
</div>
</body>

</html>

<?php
    } else {
        echo '<br><span style="color: red; font-weight: bold;">B³¹d aplikacji! </span><br>';
    }
} else {
    echo '<br><span style="color: red; font-weight: bold;">B³¹d aplikacji! </span><br>';
}
?>