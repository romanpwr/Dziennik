<?php
if(count($_FILES['plik']['name'])) {
$i = 0;
  foreach ($_FILES['plik']['name'] as $file) {
    
$plik_tmp = $_FILES['plik']['tmp_name'][$i]; 
$plik_nazwa = $_FILES['plik']['name'][$i]; 
$plik_rozmiar = $_FILES['plik']['size'][$i]; 

if(is_uploaded_file($plik_tmp)) { 
	$url = "upload/".$plik_nazwa;
     move_uploaded_file($plik_tmp, $url); 
    echo "Plik: <strong>$plik_nazwa</strong> o rozmiarze 
    <strong>$plik_rozmiar bajtów</strong> został przesłany na serwer!<br />"; 
} 
    $i++;
  }
}
?>