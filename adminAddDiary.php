<?php
session_start();
include ("connection.php");
function curPageURL() {
 $pageURL = $_SERVER["REQUEST_URI"];
 return $pageURL;
}


if (isset($_SESSION['dostep']) && $_SESSION['dostep']==1) {
if (isset($_GET['id']) && isset($_GET['zgl'])) {
$dziennik = $_GET['id'];
$id = $_GET['zgl'];
$page = curPageURL();
$zgloszenie = mysql_fetch_array(mysql_query("SELECT * FROM zgloszenia WHERE IdZgloszenia ='$id'"));
if (isset($zgloszenie['Url']) && $zgloszenie['Url']."&zgl=$id" == $page){
$update = mysql_query("UPDATE zgloszenia SET StatusZgl = 1 WHERE IdZgloszenia ='$id'");
$row= mysql_fetch_array(mysql_query("SELECT * FROM dzienniki WHERE IdDziennika = '$dziennik'"));

?>
<html>
<head>

<title>Strona glowna</title>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<!-- JQuery -->
<script>
$(document).ready(function(){
	$('#request input:text').attr("disabled", true).css("color","black") ;
	$('.back').hide();
	$('.button').click(function(){
	var form_data = {
			dziennik: $("#NickU").val(),
			zgl: $("#id").val(),
			opt: $(this).attr('id'),
			diary: 1
		};
	$.ajax({
			type: "POST",
			url: "delete.php",
			data: form_data,
		}).done(function( response ) {
		if(response == "﻿success"){
		$('#container').hide();
		if($(this).attr('id') == "accept"){
		$("#message").html("<p class='success'><font color='blue'>Dziennik został poprawnie zaakceptowany.</font></p>");
		}
		else{
		$("#message").html("<p class='success'><font color='blue'>Dziennik został poprawnie odrzucony.</font></p>");
		}
		$('.back').show();
		}
		else alert(response);
		});
	
	});
});
</script>
</head>
<body>

<div id="message">

</div>
<div id="container">
    <div id="request">
		
				Nick użytkownika: <input type="text" id="NickU" name="nickUzytkownika" class="" size="25" value="<?php echo $row['IdDziennika']?>"><br>
				Nazwa dziennika: <input type="text" id="DiaryName" name="nazwaDziennika" class="" size="25" value="<?php echo $row['Nazwa']?>"><br>
				Data zgłoszenia: <input type="text" id="DateR" name="dataZgloszenia" class="" size="25" value="<?php echo $zgloszenie['DataZgl']?>"><br>
				<!-- dodaj dziennik -->
				<input class="button" id="accept" type="submit" value="Akceptuj"><input class="button" type="submit" id="denited" value="Odrzuć">
		
	</div>
</div>
<form class="back" action="adminReportPage.php" method="POST">
<input type="hidden" id="id" name="id" value="<?php echo $zgloszenie['IdZgloszenia']; ?>">
<input class="close" id="zamknij" type="submit" name="zamknij" value="Zamknij zgłoszenie">
</form>
</body>

</html>
<?php
}
else{ '<br><span style="color: red; font-weight: bold;">Nieprawidłowe zgłoszenie.</span><br>';
}
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie został wybrany dziennik.</span><br>';
}
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Dostep maja tylko administratorzy! </span><br>';
    }
?>