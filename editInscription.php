<?php
session_start();
include("connection.php");

/** Potrzebuje z sesji:
 login - nick danego usera(redaktora), który edytuje wpis
 * Z GET'a pobiera:
 IdWpisu - id wpisu, który będziemy edytować
  
 * Trzeba przemyśleć, czy będziemy chcieli gdzieś zapamitywać datę i autora korekty.
 * Trzeba by jeszcze dorobić jakiś Messege box do deleta. 
 * Po delejcie powrót do indexa by się przydać
 
 **/

$idWpisu = $_GET['idWpisu'];

$query = mysql_query("SELECT * FROM wpisy WHERE IdWpis='$idWpisu'");

if (mysql_num_rows($query)==1) { 
    $result = mysql_fetch_array($query);
    $tytul = $result['Tytul'];
    $wpis = $result['Tekst'];
} else {
    $tytul = "";
    $wpis = "";
    echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych!</span><br>' ;
}    

if(isset($_POST['submit'])) {    
    
    $tytul = $_POST['title'];
    $wpis = $_POST['inscription'];
        
    $query=mysql_query("UPDATE wpisy SET Tytul='$tytul',Tekst='$wpis' WHERE IdWpis='$idWpisu'");
    
    if ($query) {
        echo '<br><span style="color: green; font-weight: bold;">Wpis został zmieniony! </span><br>';
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>';
    }
    
} else if(isset($_POST['reset'])) {
    $tytul = "";
    $wpis = "";
} else if(isset($_POST['delete'])) {
    //Przed skasowaniem dialogbox Yes/No by się przydać.
    $query= mysql_query("DELETE FROM wpisy WHERE IdWpis='$idWpisu'");
    if ($query) {
        echo '<br><span style="color: green; font-weight: bold;">Wpis został usunięty! </span><br>';
        // Dobrze by było żeby nie zostawiać na stronie. Najlepiej info i powrót na index.
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>';
    }
}

?>

<link href="" type="text/css" rel="stylesheet"/>      
<title>Multimedialny dziennik podróży - dodawanie zdarzenia.</title>        
<table>        
    <th>         
    <td>            
        <form name="editInscription" method="POST" action="editInscription.php?idWpisu=<?php echo $idWpisu?>">             
        <p><label for="title">Tytuł zdarzenia: </label></p>                
        <p> <input type="text" name="title" value="<?php echo $tytul;?>" size="30" autofocus required/>                    
            <button> Uprawnienia </button>                 
        </p>                
        <p><label for="inscription">Wpis: </label></p>                
        <p><textarea name="inscription" rows="20" cols="60" required/><?php echo $wpis;?></textarea></p>                
        <p class="center">                    
           <input type="submit" name="reset" value="Wyczyść pola"/>                    
           <input type="submit" name="submit" value="Zapisz"/>
           <input type="submit" name="delete" value="Usuń"/>
        </p>            
        </form>     
    </td>           
    </th>        
    <th>                    
        <table>               
        <tr><td><label>Załącz zdjęcie: </label></td></tr>            
        <tr><td><button>Przeglądaj</button></td></tr>            
        <tr><td><textarea>Tu będzie kontener multimediów. </textarea></td></tr>
        <tr><td><label>Załącz video: </label></td></tr>    
        <tr><td><button>Przeglądaj</button></td></tr>    
        <tr><td><textarea>Tu będzie kontener multimediów. </textarea> </td></tr>    
        <tr><td><label>Załącz plik audio: </label></td></tr>    
        <tr><td><button>Przeglądaj</button></td></tr>    
        <tr><td><textarea>Tu będzie kontener multimediów. </textarea> </td></tr>                
        </table>
    </th>
</table>

