<?php 
include ("connection.php");


if (isset($_POST['zamknij'])){
$id = $_POST['id'];
$update = mysql_query("UPDATE zgloszenia SET StatusZgl = 2 WHERE IdZgloszenia ='$id'");
}
?>
<html>
<head>

<title>Strona glowna</title>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function() {
  // wczytywanie listy zgloszen reports ('echo $reports') ze strony 'adminReport.php'
  $.ajax({
            type: 'get',                                   
            contentType: 'application/json; charset=utf-8', 
            url: 'load.php?a=zgloszenie',                        
            success: function(zgloszenie){                       
                     $('.report').append(zgloszenie); 
					 load_report();
                     }
  });
  /**function filter(){
  $('.reportFiltr').change(function(){
	$('.reportFiltr option:selected').each(function(){
		Filtr = $(this).attr('value');
		 $.ajax({
				 type: 'get',
				 contentType: 'application/json; charset=utf-8',
				 url: 'load.php?a=zgloszenie&f1='+Filtr,
				 dataType: 'json',
				 success: function(zgloszenie){
						  $('.report').append(zgloszenie);
						  load_report();
						  }
	});
	**/
  
  
  
  function load_report() {
  $('.report').change(function(){                      
      $('.report option:selected').each(function(){   
	   IdZgloszenia = $(this).attr('id');
        $.ajax({
                type: 'get',                         
                contentType: 'application/json; charset=utf-8',
                url: 'load.php?a=info&IdZgloszenia='+IdZgloszenia, 
                dataType: 'json',                               
                success: function(zgloszenie){  
                         $('.name').text(zgloszenie['0']);            
                         $('.info').text(zgloszenie['1']);     
                         }
        }); 
      });
  }).trigger('change'); 
}
/*
	$('.report').change(function(){
	  var str = "";
          $(".report option:selected").each(function () {
                str += $(this).text() + " ";
              });
          $("span").text(str);
	
	}).change();
*/
	$('.reportFiltr2').change(function(){
		zmien();
	}).change();
	$('.reportFiltr').change(function(){
		zmien();
	}).change();
	function zmien(){
	var target1 = $('#filtr1').val();
	var target = $('#filtr2').val();
	if ( target != "ALL" && target1 != "ALL"){
	    $('.report').children('option').hide();
		$('.report').children('option[zigi*="'+target1+'"]').show(); 
		$('.report').children('option[value!="'+target+'"]').hide(); 
	}
		else if (target != "ALL" && target1 == "ALL"){
		$('.report').children('option').hide();
		$('.report').children('option[value="'+target+'"]').show(); 
		}
		else if (target1!="ALL" && target == "ALL"){
		$('.report').children('option').hide();
		$('.report').children('option[zigi*="'+target1+'"]').show(); 
		}
		else{
		$('.report').children('option').show();
     	}
	}
	$('.zadaniaOpt').change(function(){
		var zad = $('#zadania').val();
		var x = $('.report option:selected').val();
		if (zad == "select"){
		$('.zglAction').attr('disabled', 'disabled');
		}
		else if (x!=null){
		$('.zglAction').removeAttr('disabled');
		}
		else{
		$('#zadania option[value="select"]').attr("selected","selected") ;
		alert ("Wybierz zgłoszenie");
		}
	}).change();
	$('.zglAction').click(function(){
	var zad = $('#zadania').val();
	if (zad == "open"){
	var val = $('.report option:selected').attr('zigi');
	var id = $('.report option:selected').attr('id');
	var url = $('.report option:selected').attr('url');
	if (val == "zgłoszenie użytkownika"){
	alert("Zostaniesz przekierowany na profil użytkownika");
	window.location = url+"&zgl="+id;
	}
	
	}
	});
});
</script>
</head>
<body>
 
<div id="container">
	<div id="filtry">
	    <select class="reportFiltr" id="filtr1" name="filtr1" style="width:200px">
		<option id="all" value="ALL">Wszystkie</option>
		<option id="new_diary" value="dodanie dziennika">Dodanie dziennika</option>
		<option id="błąd" value="błędny komentarz">Błędny komentarz</option>
		<option id="błąd2" value="błędny wpis">Błędny wpis</option>
		<option id="usun" value="usunięcie konta">Usunięcie konta</option>
		<option id="usun2" value="usunięcie dziennika">Usunięcie dzienika</option>
		<option id="zgl" value="zgłoszenie użytkownika">Zgłoszenie użytkownika</option>
		<option id="inne" value="inne">Inne</option>
	</select>
	<select class="reportFiltr2" name="filtr2" id="filtr2" style="width:200px">
		<option id="all" value="ALL">Wszystkie</option>
		<option id="new" value="NEW">Nowe</option>
		<option id="otwarte" value="OTWARTE">Otwarte</option>
		<option id="zamkniete" value="ZAMKNIETE">Zamknięte</option>
	</select>
	</div>
	<!--<form name="reportReact"> -->
    <div id="listaZgloszen">
    <select class="report" style="width:300px" size="20">
		
	</select>
    </div>
	
    <div id="right"> 
	<hr>
		<h1 class="name" name="titleReport" value=""></h1>
		<hr>
        <p class="info" name="description" value=""></p>
	</div>
	<div id="reakcja" style="float:rigth">
	
	<select class="zadaniaOpt" name="zadania" id="zadania" style="width:200px" name="option">
		<option value="select">Wybierz działanie</option>
		<option value="open">Odpowiedz</option>
		<option value="close">Zamknij</option>
		
	</select>
		<input type="submit" class="zglAction" id="zglAction" name="zglAction" value ="Wykonaj">
		
		<!--etc w zaleznosci od humoru
	 </form>-->
	</div>
	
</div>
<span></span>

</body>

</html>