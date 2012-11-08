<?
header('Content-type: image/jpeg');

/* wielkoœæ miniaturki */
define ('width',150);
define ('height',150);
define ('quality',80);

/* otwieranie orginalnego obrazu */
$orginal=imagecreatefromjpeg($_GET['foto']);

/* Pobranie wymiarów zdjêcia */
list($org_w,$org_h)=getimagesize($_GET['foto']);

/* Tworzenie miniaturki */
$mini=imagecreatetruecolor(width,height);

/* kopiujemy zawartosc zdjecia na miniaturke */
imagecopyresampled($mini,$orginal, 0, 0, 0, 0 ,width,height,$org_w,$org_h);

/* Wyœwietlenie */
imagejpeg($mini,NULL,quality);
?>