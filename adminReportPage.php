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

});
</script>
</head>
<body>
 
<div id="container">
	<div id="filtry">
	    <select class="reportFiltr" style="width:200px">
		<option>Sortowanie1</option>
		<option>Sortowanie2</option>
		<option>Sortowanie3</option>
		<option>Sortowanie4</option>
	</select>
	</div>
	<form name="reportReact" action="" method="POST">
    <div id="listaZgloszen">
    <select class="report" style="width:200px" size="20">
		<option></option>
	</select>
    </div>
	
    <div id="right"> 
	<hr>
		<h1 class="name" name="titleReport" value=""></h1>
		<hr>
        <p class="info" name="description" value=""></p>
	</div>
	<div id="reakcja" style="float:rigth">
	
	<select class="option" style="width:200px" name="option">
		<option>Sortowanie1</option>
		<option>Sortowanie2</option>
		<option>Sortowanie3</option>
		<option>Sortowanie4</option>
	</select>
		<input type="submit" name="zglAction" value ="Wykonaj">
		
		<!-- etc w zaleznosci od humoru -->
	</form>
	</div>
	
</div>


</body>

</html>