<?php
include ("connection.php");

$sql = "SHOW TABLES FROM $mysql_db";
$result = mysql_query($sql);

if (!$result) {
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
$wynik = false;

// DODAWANIE TABELI ZAŁĄCZNIKI
while ($row = mysql_fetch_row($result)) {
    if ($row[0] == "zalaczniki"){
	$wynik = true;
	}
}
if ($wynik == true){
echo "Twoja baza danych jest aktualna";
}
else{
$query =mysql_query("CREATE  TABLE `$mysql_db`.`zalaczniki` (
  `idzal` BIGINT NOT NULL AUTO_INCREMENT ,
  `idwpisu` BIGINT NOT NULL ,
  `nickRed` VARCHAR(20) NOT NULL ,
  `komentarz` VARCHAR(255) NULL ,
  `dataDodania` DATE NOT NULL ,
  `url` VARCHAR(100) NOT NULL ,
  `rodzaj` VARCHAR(1) NOT NULL CHECK(Rodzaj IN ('Z','F','D')),
  PRIMARY KEY (`idzal`))");
  if ($query){
  echo "Twoja baza danych została uaktualniona o tabelę załączniki <br />";
  }
  else{
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }
}
// KONIEC DODAWANIA TABELI ZAŁĄCZNIKI
?>