<?
header('Content-type: image/jpeg');

/* wielko�� miniaturki */
define ('width',150);
define ('height',150);
define ('quality',80);

/* otwieranie orginalnego obrazu */
$orginal=imagecreatefromjpeg($_GET['foto']);

/* Pobranie wymiar�w zdj�cia */
list($org_w,$org_h)=getimagesize($_GET['foto']);

/* Tworzenie miniaturki */
$mini=imagecreatetruecolor(width,height);

/* kopiujemy zawartosc zdjecia na miniaturke */
imagecopyresampled($mini,$orginal, 0, 0, 0, 0 ,width,height,$org_w,$org_h);

/* Wy�wietlenie */
imagejpeg($mini,NULL,quality);
?>