<?php session_start();
include ("connection.php");



if (isset($_POST['idWpisu']) && (isset($_SESSION['dziennik']))){

$idwpisu = $_POST['idWpisu'];
$dziennik = $_SESSION['dziennik'];
$nick = $_SESSION['login'];
date_default_timezone_set("Europe/Warsaw");
$data = date("Y-m-d");


if (isset($_POST['wyslij'])){

$zal = mysql_num_rows(mysql_query("SELECT * FROM zalaczniki WHERE idwpisu = '$idwpisu'"));
$allowedExts = array("jpg", "jpeg", "gif", "png");
$komunikaty = '';

if(count($_FILES['plik']['name'])) {
$i = 0;
  foreach ($_FILES['plik']['name'] as $file) {
$extension = end(explode(".", $_FILES["plik"]["name"][$i]));
$numer = $zal + $i +1; 
$plik_tmp = $_FILES['plik']['tmp_name'][$i]; 
$filename = stripslashes($_FILES['plik']['name'][$i]); 
//$ext =  getExtension($filename);
//$ext = strtolower($ext);
$plik_nazwa = $idwpisu.'_z_'.$numer.'.'.$extension;
$plik_rozmiar = $_FILES['plik']['size'][$i]; 

if ((($_FILES["plik"]["type"][$i] == "image/gif")
|| ($_FILES["plik"]["type"][$i] == "image/jpeg")
|| ($_FILES["plik"]["type"][$i] == "image/png")
|| ($_FILES["plik"]["type"][$i] == "image/pjpeg"))
//&& ($_FILES["file"]["size"] < 20000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["plik"]["error"][$i] > 0)
    {
    $komunikaty.= "Error: " . $_FILES["plik"]["error"][$i] . " dla pliku ".$_FILES["plik"]["name"][$i]."<br />";
    }
  else
    {
    /*
	echo "Upload: " . $_FILES["plik"]["name"][$i] . "<br />";
    echo "Type: " . $_FILES["plik"]["type"][$i] . "<br />";
    echo "Size: " . ($_FILES["plik"]["size"][$i] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["plik"]["tmp_name"][$i];
    */
	
if(is_uploaded_file($plik_tmp)) { 
	$url = "upload/".$plik_nazwa;
	$addbd = mysql_query("INSERT INTO zalaczniki (idwpisu, nickRed, dataDodania, url, rodzaj) VALUES ('$idwpisu', '$nick', '$data','$url','Z')");
	if ($addbd){
	move_uploaded_file($plik_tmp, $url); 
    echo "<br />Plik: <strong>$plik_nazwa</strong> o rozmiarze 
    <strong>$plik_rozmiar bajtów</strong> został przesłany na serwer!<br />";
	}
	else{
	echo mysql_error();
	}
} 
    
  }
  }
  else{
  $komunikaty.= "Nieprawidłowy format pliku: " .$_FILES["plik"]["name"][$i]."<br />";
  }
  $i++;
  }
if (isset($komunikaty)){
  
  echo $komunikaty;
  
  }
}
}



?>
<head>

<title>Dodawanie zdjęć</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>

</head>
<body>
<div id="inside">
<p>Zaladuj zdjecia</p>
	<form method="post" enctype="multipart/form-data" action="addPhoto.php">
  <fieldset>
    <legend>Przeslij pliki</legend>
    <label>Dodaj pliki:
     <p><strong>Upload Files:</strong> <input type="file" accept="image/jpeg, image/gif, image/png" name="plik[]" id="filesToUpload" required="required"multiple="" onChange="makeFileList();" /></p>
	 </label><br><input type="hidden" name="idWpisu" value="<?php echo $idwpisu; ?>" />
    <input type="submit" name="wyslij" value ="Wyslij zapytanie">
  </fieldset>
  <!-- w tym miejscu zrobi sie system miniatur przeslanych obrazkow -->
  <div><p>Wybrane obrazki</p>
  <ul id="fileList"><li>No Files Selected</li></ul>
	
	<script type="text/javascript">
		function makeFileList() {
			var input = document.getElementById("filesToUpload");
			var ul = document.getElementById("fileList");
			while (ul.hasChildNodes()) {
				ul.removeChild(ul.firstChild);
			}
			for (var i = 0; i < input.files.length; i++) {
				var li = document.createElement("li");
				li.innerHTML = input.files[i].name;
				ul.appendChild(li);
			}
			if(!ul.hasChildNodes()) {
				var li = document.createElement("li");
				li.innerHTML = 'No Files Selected';
				ul.appendChild(li);
			}
		}
	</script>
  
  </div>
</div>

<script>


	$(".wpisz").click(function() {
	$(this).attr("value","");
	$(this).css("color","black");
	});	
</script>
</body>
<?php
}
else{
   echo '<br><span style="color: red; font-weight: bold;">Nie został wpis, do którego mają być przesyłane nowe zdjęcia!</span><br>' ;
}
?>