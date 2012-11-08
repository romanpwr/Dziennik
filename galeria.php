<?php
define('ESTATS_COUNT', 1);
define('ESTATS_TITLE', $_GET['link']);
@include('/homez.548/kameliao/www/estats/stats.php');
?>

<?
/**setcookie('test', '1');
if ($_COOKIE ['test']){
if(isset($_COOKIE['wys']) AND isset($_COOKIE['szer'])) {
$width = $_COOKIE['szer'];
$height = $_COOKIE['wys'];
}
else {
?>
 <script language="javascript">
 <!--
 writeCookie();
 function writeCookie() {
  var enddate = new Date();
  enddate.setDate(enddate.getDate()+7);
  var the_cookie = "wys="+ screen.height + ";expires="+enddate.toGMTString();
  var the_cookie2 = "szer="+ screen.width + ";expires="+enddate.toGMTString();
  document.cookie = the_cookie;
  document.cookie = the_cookie2;
  //location = 'galeria.php';
  //window.location.replace("<? echo $_SERVER['PHP_SELF']; ?>");
 // window.location.reload(true);
 }
 //-->
 </script>
<?
}
} */

if (isset($_GET['link'])){
$link = $_GET['link'];
$folder = "foto/".$link."/*.*";
$onpage = 50;

$l=0;
foreach (glob($folder) as $fotki) $album[$l++]=$fotki; 
$razem=count($album); 

echo('<html><head><style>img.special {border: 3px black solid;} </style><script src="js/jquery-1.7.2.min.js"></script><script src="js/lightbox.js"></script><link href="css/lightbox.css" rel="stylesheet" /></head>');
echo('<body bgcolor="#FFEBCD">');


if ($link == "bukiety"){
	echo('<br /><br /><b><font size=4 color="red">Bukiet ślubny jest kształtowany według oczekiwań pod względem kolorystyki oraz formy ułożenia kwiatów-spełniając najśmielszą wyobrażnie.</font></b><br /><br />');
	}
if ($link == "koscioly"){
echo('<h1 id="slub">Dekoracja ślubna kościoła</h1>');
}

if ($link == "sale"){
$stron=floor($razem/$onpage); $stron+=$razem % $onpage ? 1:0;
$strona=$_GET['page']; if (!isset($strona)) $strona=1;
$start=($strona-1) * $onpage;
$stop=($strona==$stron) ? $razem % $onpage: $onpage; $stop+=$start;

echo"<b>Zdjęcia od $start do $stop z $razem</b>";
if ($stron>1){ /* jeśli jest więcej niż jedna strona to wyświetla liste */
echo '<div align="right">';
echo "Wybierz stronę: "; for($z=1;$z<=$stron;$z++) {

/* Bieżącą strone pogrubimy a pozostale beda linkami z odpowiednim adresem */
if ($strona==$z){echo "<b> $z </b>";} else {echo " <a href=\"galeria.php?link=$link&page=$z\">$z</a> ";}
}
echo "</div>";
}
for ($x=$start;$x<$stop;$x++){
echo "<a href=\"".$album[$x]."\" rel=\"lightbox[a]\" title=\"\"><img src=\"miniaturka.php?foto="."{$album[$x]}\" class=\"special\"></a>"; 
}
if ($stron>1){ /* jeśli jest więcej niż jedna strona to wyświetla liste */
echo "<br>";
echo '<div align="center">';
echo "Wybierz stronę: "; for($z=1;$z<=$stron;$z++) {

/* Bieżącą strone pogrubimy a pozostale beda linkami z odpowiednim adresem */
if ($strona==$z){echo "<b> $z </b>";} else {echo " <a href=\"galeria.php?link=$link&page=$z\">$z</a> ";}
}
}
echo "</div>";
}

else{
for ($x=0;$x<$razem;$x++){

//echo($album[$x]);
//echo("<br />");
echo "<a href=\"".$album[$x]."\" rel=\"lightbox[a]\" title=\"\"><img src=\"miniaturka.php?foto="."{$album[$x]}\" class=\"special\"></a>"; 
}

/* miniaturka */
}
if ($link == "koscioly"){
echo('<h1 id="wielkanoc">Dekoracja wielkanocna kościoła</h1>');
$folder = "foto/".$link."/wielkanoc"."/*.*";

//$wszystkich="5";



$l=0;
foreach (glob($folder) as $fotki2) $album2[$l++]=$fotki2; 
$razem2=count($album2); 
for ($x=0;$x<$razem2;$x++){

//echo($album[$x]);
//echo("<br />");
echo "<a href=\"".$album2[$x]."\" rel=\"lightbox[a]\" title=\"\"><img src=\"miniaturka.php?foto="."{$album2[$x]}\" class=\"special\"></a>"; 


/* miniaturka */
}
}

/**if ($stron>1){ /* jeśli jest więcej niż jedna strona to wyświetla liste 
echo "<br>";
echo "strony: "; for($x=1;$x<=$stron;$x++) {

/* Bieżącą strone pogrubimy a pozostale beda linkami z odpowiednim adresem 
if ($strona==$x){echo "<b> $x </b>";} else {echo "<a href=\"galeria.php?strona=$x\"> $x </a>";}
}
}*/
}
else {
echo('<body bgcolor="#FFEBCD">');
echo "Wystąpił błąd <br /> Jeśli będzie się on powtarzał, prosimy o kontakt z administracją.";
}

echo("<br><br><noscript>
<div>");
echo('
<img src="/estats/antipixel.php?count=0" alt="eStats" title="eStats" />
</div>
</noscript>
<script type="text/javascript">
var eCount = 0;');
echo("var ePath = '/estats/';
var eTitle = '';
var eAddress = '';
var eAntipixel = '';
</script>");
echo('<script type="text/javascript" src="/estats/stats.js"></script>');

?>