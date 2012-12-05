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
	//if(count($_FILES['plik']['name']) >1){
  foreach ($_FILES['plik']['name'] as $file) {
$extension = end(explode(".", $_FILES["plik"]["name"][$i]));
$numer = $zal + $i +1; 
$plik_tmp = $_FILES['plik']['tmp_name'][$i]; 
$filename = stripslashes($_FILES['plik']['name'][$i]); 
//$ext =  getExtension($filename);
//$ext = strtolower($ext);
$plik_nazwa = $idwpisu.'_z_'.$numer.'.'.$extension;
$plik_rozmiar = $_FILES['plik']['size'][$i]; 
$r = $_POST['rodzaj'];
$max = false;

if (isset($_POST['yt_link'])){
$vt = $_POST['yt_link'];

if (strpos($vt, "youtube.com") !== false){
echo "Jednak to był link z YT <br />";
if (strpos($vt, "v=") !== false){
$vt_link = substr(substr($vt, strpos($vt, "v=")),2);
if (strpos($vt_link,"#") !== false){
$vt_link = substr($vt_link,0, strpos($vt_link,"#"));
}
}
elseif (strpos($vt, "embed/") !== false){
$vt_link = substr(substr($vt, strpos($vt, "embed/")),6);
if (strpos($vt_link, '" frameborder') !== false){
$vt_link = substr($vt_link, 0, strpos($vt_link, '" frameborder'));
}
elseif (strpos($vt_link, "?feature") !== false){
$vt_link = substr($vt_link, 0, strpos($vt_link, "?feature"));
}
}
$vt_link = 'http://www.youtube.com/v/'.$vt_link;
//http://www.youtube.com/watch?v=QC5DJom3PAs
//http://www.youtube.com/embed/UV3rv_gO0Qc?feature=player_detailpage
//<iframe width="854" height="510" src="http://www.youtube.com/embed/Ylk74Nys5oA" frameborder="0" allowfullscreen></iframe>
}


}

if ($r == "foto" &&(($_FILES["plik"]["type"][$i] == "image/gif")
|| ($_FILES["plik"]["type"][$i] == "image/jpeg")
|| ($_FILES["plik"]["type"][$i] == "image/png")
|| ($_FILES["plik"]["type"][$i] == "image/pjpeg"))
&& in_array($extension, $allowedExts))
  {
	if (($_FILES["plik"]["size"][$i] < 20971521)){
  $rodzaj = 'Z'; //zdjęcie
  }
  else{
  $max = true;
  $komunikaty.="Dla pliku ".$_FILES["plik"]["name"][$i]." przekroczono maksymalny rozmiar 20MB<br />";
  }
  }
elseif ($r == "song" &&(($_FILES["plik"]["type"][$i] == "audio/mpeg")
|| ($_FILES["plik"]["type"][$i] == "audio/ogg")
|| ($_FILES["plik"]["type"][$i] == "audio/wav")
//|| ($_FILES["plik"]["type"][$i] == "image/pjpeg")
)
&& in_array($extension, $allowedExts))
  {
	if (($_FILES["plik"]["size"][$i] < 20971521)){
  $rodzaj = 'A'; //pliki dźwiękowe
  }
  else{
  $max = true;
  $komunikaty.="Dla pliku ".$_FILES["plik"]["name"][$i]." przekroczono maksymalny rozmiar 20MB<br />";
  }
  }
elseif ($r == "film" 
&&(($_FILES["plik"]["type"][$i] == "video/webm")
|| ($_FILES["plik"]["type"][$i] == "video/mp4")
|| ($_FILES["plik"]["type"][$i] == "video/ogg")
|| ($_FILES["plik"]["type"][$i] == "video/x-flv")
|| ($_FILES["plik"]["type"][$i] == "video/x-ms-wmv")
|| ($_FILES["plik"]["type"][$i] == "video/mpeg")
|| (isset ($vt_link)))
&& in_array($extension, $allowedExts))
  {
	if ($_FILES["plik"]["size"][$i] < 20971521){
  $rodzaj = 'W'; //wideo
  }
  else{
  $max = true;
  $komunikaty.="Dla pliku ".$_FILES["plik"]["name"][$i]." przekroczono maksymalny rozmiar 20MB<br />
				<i>Zapraszamy do korzystania z portalu YouTube w celu przesłania większego pliku wideo</i><br />";
  }
  }
if (isset ($vt_link)){
$rodzaj = 'W';
$addbd = mysql_query("INSERT INTO zalaczniki (idwpisu, nickRed, dataDodania, url, rodzaj) VALUES ('$idwpisu', '$nick', '$data','$vt_link','".$rodzaj."')");
	if ($addbd){
    $komunikaty.="<br />Link: <strong>$vt_link</strong> został poprawnie dodany!<br />";
	}
	else{
	echo mysql_error();
	}

}
elseif (isset($rodzaj)){
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
	$addbd = mysql_query("INSERT INTO zalaczniki (idwpisu, nickRed, dataDodania, url, rodzaj) VALUES ('$idwpisu', '$nick', '$data','$url','".$rodzaj."')");
	if ($addbd){
	move_uploaded_file($plik_tmp, $url); 
    $komunikaty.="<br />Plik: <strong>$plik_nazwa</strong> o rozmiarze 
    <strong>$plik_rozmiar bajtów</strong> został przesłany na serwer!<br />";
	}
	else{
	echo mysql_error();
	}
} 
    
  }
  }
  else{
  if ($max == false){
  $komunikaty.= "Nieprawidłowy format pliku: " .$_FILES["plik"]["name"][$i]."<br />";
  }
  }
  $i++;
  }
 //}
 
if (isset($komunikaty)){
  echo "Komunikaty dotyczące przesyłanych plików :<br />";
  echo $komunikaty;
  
  }
}
}



?>
<head>

<title>Dodawanie multimediów</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function() {
$('.multimedia').children('div').hide();
$('#videoopt').hide();
$('#yt').hide();
$('.obj').change(function(){
		var target = $('input[name=obj]:checked').val();
		$('#kom').hide();
		$('.multimedia').children('div').hide();
		$('.multimedia').children('div [value="'+target+'"]').show();
		if (target == 'video'){
		$('#videoopt').show();
		}
		else{
		$('#videoopt').hide();
		}
	});
$('.objlink').change(function(){
	var  target = $('input[name=objlink]:checked').val();
	//alert(target);
	if (target == 'yt'){
	$('#dysk').hide();
	$('#yt').show();
	$('.vfile').removeAttr('required');
	$('#yt_link').attr("required","required"); 
	}
	else{
	$('#yt').hide();
	$('#dysk').show();
	$('#yt_link').removeAttr('required');
	$('.vfile').attr("required","required"); 
	}


});

});
</script>
</head>
<body>
<p>Wybierz obiekt do dodania:</p>
<p id="kom"><font color="red"><b>Wybierz jedną z opcji poniżej</b></font></p>
<input type="radio" class="obj"name="obj" id="fotoobj" value="foto"> Zdjęcia
<input type="radio" class="obj"name="obj" id="videoobj" value="video"> Filmy
<input type="radio" class="obj"name="obj" id="songobj"value="song"> Pliki dźwiękowe
<div id="videoopt">
<b>
	<input type="radio" class="objlink" name="objlink" id="dysklink" value="dysk" checked> Z dysku
	<input type="radio" class="objlink" name="objlink" id="ytlink" value="yt"> Z YouTube<br />
	</b>
	
</div>
<div class="multimedia" id ="multimedia">
<div id="foto" value="foto">
<hr width="400" align="left">
<form method="post" action="uploadImg.php">
<input type="hidden" name="idWpisu" value="<?php echo $idwpisu; ?>" />
<input type="submit" name="wyslij" value ="Obejrzyj zdjęcia">
</form>
<p><b>Zaladuj zdjecia</b></p>
	<form method="post" enctype="multipart/form-data" action="addPhoto.php">
  <fieldset>
    <legend>Przeslij pliki</legend>
    <label>Dodaj pliki:
     <p><strong>Upload Files:</strong> <input type="file" accept="image/jpeg, image/gif, image/png" name="plik[]" id="filesToUpload" required="required"multiple="" onChange="makeFileList();" /></p>
	 </label><br><input type="hidden" name="idWpisu" value="<?php echo $idwpisu; ?>" />
	 <input type="hidden" name="rodzaj" value="foto" />
    <input type="submit" name="wyslij" value ="Wyslij zapytanie">
  </fieldset>
  </form>
  <!-- w tym miejscu zrobi sie system miniatur przeslanych obrazkow -->
</div>
<div id="video" value="video">
<hr width="400" align="left">
<!--<form method="post" action="uploadImg.php">
<input type="hidden" name="idWpisu" value="<?php //echo $idwpisu; ?>" />
<input type="submit" name="wyslij" value ="Obejrzyj zdjęcia">
</form>
-->
<p><b>Zaladuj Film</b></p>
	<form method="post" enctype="multipart/form-data" action="addPhoto.php">
  <fieldset>
    <legend>Przeslij pliki</legend>
    <label>Dodaj pliki:<br />
	
	<div id="dysk">
	Obsługiwane typy plików:<br />
	WEBM, MP4, OGG (video), FLV, WMV, MPEG<br />
     <p><strong>Upload Files:</strong> <input class="vfile" type="file" accept="video/webm, video/mp4, video/ogg, video/x-flv, video/x-ms-wmv, video/mpeg" name="plik[]" id="filesToUpload" onChange="makeFileList();" required="required"/></p>
	 </div>
	 <div id="yt">
	 <p>Podaj link z serwisu YT<br /></p>
	 <input type="text" id="yt_link" name="yt_link" size="40" value="">
	 </div>
	 </label><br><input type="hidden" name="idWpisu" value="<?php echo $idwpisu; ?>" />
	 <input type="hidden" name="rodzaj" value="film" />
    <input type="submit" name="wyslij" value ="Wyslij zapytanie">
  </fieldset>
  </form>
  </div>
<div id="song" value="song">
<hr width="400" align="left">
<!--<form method="post" action="uploadImg.php">
<input type="hidden" name="idWpisu" value="<?php //echo $idwpisu; ?>" />
<input type="submit" name="wyslij" value ="Obejrzyj zdjęcia">
</form>-->
<p><b>Zaladuj Plik dźwiękowy</b></p>
	<form method="post" enctype="multipart/form-data" action="addPhoto.php">
  <fieldset>
    <legend>Przeslij pliki</legend>
    <label>Dodaj pliki:<br />
	Obsługiwane typy plików:<br />
	MP3, OGG (audio), WAV<br />
     <p><strong>Upload Files:</strong> <input type="file" accept="audio/mpeg, audio/ogg, audio/wav" name="plik[]" id="filesToUpload" required="required" onChange="makeFileList();" /></p>
	 </label><br><input type="hidden" name="idWpisu" value="<?php echo $idwpisu; ?>" />
	 <input type="hidden" name="rodzaj" value="song" />
    <input type="submit" name="wyslij" value ="Wyslij zapytanie">
  </fieldset>
  </form>
  <!-- w tym miejscu zrobi sie system miniatur przeslanych obrazkow -->
  
  </div>
  </div>
<div><p>Wybrane pliki</p>
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

<script>


	$(".wpisz").click(function() {
	$(this).attr("value","");
	$(this).css("color","black");
	});	
</script>
</body>
</div>
<?php
}
else{
   echo '<br><span style="color: red; font-weight: bold;">Nie został wpis, do którego mają być przesyłane nowe zdjęcia!</span><br>' ;
}
?>