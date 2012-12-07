﻿<?php
session_start();
include("connection.php");

/** Potrzebuje z sesji:
 login - nick danego usera(redaktora), który dodaje wpis
 dziennik - idDziennika, do którego wpis jest dodawany
Czyli przed wywołaniem skryptu trzeba dodał do sesji 'dziennik'!
  
 * Po przeanalizowaniu bazy uznałem, że gdy wpis dodaje autor pole NickRed zostaje puste.
 (Ewentualnie można przerobić zeby zawsze dodawac nick osoby dodającej wpis.)
 
 **/
if (isset ($_SESSION['zalogowany'])){
if (isset($_SESSION['dziennik']) && strlen($_SESSION['dziennik'])>1) {
    $login = $_SESSION['login'];
    $dziennik = $_SESSION['dziennik'];

$zgl = mysql_query("SELECT * FROM zgloszenia WHERE NickUsera ='$login' AND Temat='dodanie dziennika' AND Url='/adminAddDiary.php?id=$login'");

$error = false;
while ($row = mysql_fetch_array($zgl)){
if ($row['StatusZgl'] <> 2){
$error = true;
}
}
if (!$error){

?>
<html>
<head>
<title>Multimedialny dziennik podróży - dodawanie zdarzenia.</title>        
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	$(".titleEr").hide();
	$(".wpisEr").hide();
	$('.dodajWpis').click(function(){
	if ($("#title").val() ==""){
	$('.titleEr').show();
	}
	else{
	$('.titleEr').hide();
	}
	if ($("#inscription").val() == ""){
	$('.wpisEr').show();
	}
	else{
	$('.wpisEr').hide();
	}
	if ($("#title").val() !="" && $("#inscription").val() != ""){
	var form_data = {
			title: $("#title").val(),
			inscription: $("#inscription").val(),
			trip: $("#trip").val(),
			submit: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "addInscription2.php",
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		});
	
	}
	});
	$('.addTrip').click(function(){
	$('.insideDiv').load('addTrip.php');
	});
	
});
</script>
</head>
<body>
<?php include ("ckeditor.php"); ?>
<div id="message"></div>
<table>        
    <th>         
    <td>            
        <p><label for="title">Podróż: </label> 
          <?php
            $podroze = mysql_query("SELECT * FROM Katalog WHERE IdDziennika='$dziennik'");
            if (mysql_num_rows($podroze)>0) {
                echo "<select id='trip' name='trip'>";
                while ($podroz=mysql_fetch_assoc($podroze)) echo '<option>'.$podroz['Katalog'].'</option>';
                echo "</select>";
            }
          ?>
            <button type="button" class="addtrip">Dodaj podróż</button></a>
        </p>
        <p><label for="title">Tytuł zdarzenia: </label>   
			<div class="titleER"><font color="red">Podaj tytuł</font></div>
            <input type="text" id="title" name="title" size="30" autofocus required="required"/>                                  
        </p>                
        <p><label for="inscription">Wpis: </label></p>     
			<div class="wpisER"><font color="red">Wpisz treść</font></div>	
        <p><textarea class="ckeditor" id="inscription"name="inscription" rows="20" cols="60"/></textarea></p>                
        <p class="center">                    
           <input type="reset" class="clear" value="Wyczyść pola"/>                    
           <input type="submit" class="dodajWpis" name="submit" value="Zapisz"/>                
        </p>                    
    </td>           
    </th>        
    <th>                    
        <table>               
        <tr><td><label>Załącz zdjęcie: </label></td></tr>            
        <tr><td></td></tr>            
        <tr><td><label>Tu będzie kontener multimediów. </label></td></tr>
        <tr><td><label>Załącz video: </label></td></tr>    
        <tr><td><button>Przeglądaj</button></td></tr>    
        <tr><td><label>Tu będzie kontener multimediów. </label> </td></tr>    
        <tr><td><label>Załącz plik audio: </label></td></tr>    
        <tr><td><button>Przeglądaj</button></td></tr>    
        <tr><td><label>Tu będzie kontener multimediów. </label> </td></tr>                
        </table>
    </th>
</table>
</body>
</html>
<?php
}
else { echo'<br><span style="color: red; font-weight: bold;">Twój dziennik nie został jeszcze zaakceptowany przed admina.</span><br>' ;
}
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie został wybrany dziennik, do którego wpis ma być dodany lub nie posiadasz dziennika!</span><br>' ;
}
}else {
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="index.html">Zaloguj się</a><br>';

}
?>