<?php
/**$to      = 'sneven@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: pis.bartek@gmail.com' . "\r\n" .
    'Reply-To: pis.bartek@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
	
ini_set ( "SMTP", "smtp-server.example.com" );

date_default_timezone_set('America/New_York');
mail($to, $subject, $message, $headers);
**/

if(mail('jan_testowy@serwer.pl', 'Witaj', 'Oto test funkcji mail'))
   {
      echo 'Wiadomoœæ zosta³a wys³ana';
   }
?>