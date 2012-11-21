<?php

function show($variable){
$komentarze = mysql_query("SELECT * FROM komentarze WHERE IdWpisu=".$variable."");

echo '<head><link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css"></head>';

echo 'Komentarze</br>';
echo '<hr size="1" align="left" width="340px" color="#DDDDDD">';
while ($row = mysql_fetch_array($komentarze, MYSQL_BOTH)){
$var = strlen($row['Tresc'])/40;
//echo ''.$var;
echo'<textarea style="color:black; border:0; resize:none;"  name="komentarz" id="komentarz" rows="'.ceil($var).'"  cols="40" readonly="readonly">';
echo ''.$row['IdUser'].': '.$row['Tresc'];
echo '</textarea></br>';
echo '<a style="color:blue;text-align:right;font-family:Times New Roman,serif;font-size:11" href="reportForm.php">Zgłoś</a>  ';
$user = $_SESSION['login'];
if($user==$row['IdUser']){
echo '<a href="editComment.php?IdKom='.$row['IdKom'].'">Edytuj</a><br />';}
echo '<hr size="1" align="left" width="340px" color="#DDDDDD">';

}
}
?>