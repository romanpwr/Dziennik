<?php
session_start();
include("connection.php");

/** Potrzebuje z sesji:
 login - nick danego usera(redaktora), który dodaje wpis
 dziennik - idDziennika, do którego wpis jest dodawany
Czyli przed wywo³aniem skryptu trzeba dodaæ do sesji 'dziennik'!
  
 * Po przeanalizowaniu bazy uzna³em, ¿e gdy wpis dodaje autor pole NickRed zostaje puste.
 (Ewentualnie mo¿na przerobiæ zeby zawsze dodawac nick osoby dodaj¹cej wpis.)
 
 **/

if (isset($_SESSION['dziennik'])) {
if(isset($_POST['submit'])) {
    $login = $_SESSION['login'];
    $dziennik = $_SESSION['dziennik'];
    $tytul = $_POST['title'];
    $wpis = $_POST['inscription'];
    $data = date("Y-m-d");
    
    if ($login == $dziennik) {
        $query=mysql_query("INSERT INTO wpisy (IdDziennika,Tytul,Tekst,DataWpisu) VALUES('$dziennik','$tytul','$wpis','$data')");
    } else {
        $query=mysql_query("INSERT INTO wpisy (IdDziennika,NickRed,Tytul,Tekst,DataWpisu) VALUES('$dziennik','$login','$tytul','$wpis','$data')");
    }
    if ($query) {
        echo '<br><span style="color: green; font-weight: bold;">Wpis zosta³ dodany! </span><br>';
    } else {
        echo '<br><span style="color: red; font-weight: bold;">B³¹d po³¹czenia z baz¹ danych! </span><br>';
    }
}

?>

<link href="" type="text/css" rel="stylesheet"/>      
<title>Multimedialny dziennik podrÃ³Å¼y - dodawanie zdarzenia.</title>        
<table>        
    <th>         
    <td>            
        <form name="addInscription" method="POST" action="addInscription.php">                
        <p><label for="title">TytuÅ‚ zdarzenia: </label></p>                
        <p> <input type="text" name="title" size="30" autofocus required="required"/>                    
            <button> Uprawnienia </button>                 
        </p>                
        <p><label for="inscription">Wpis: </label></p>                
        <p><textarea name="inscription" rows="20" cols="60" required="required"/></textarea></p>                
        <p class="center">                    
           <input type="reset" value="WyczyÅ›Ä‡ pola"/>                    
           <input type="submit" class="submit" name="submit" value="Zapisz"/>                
        </p>            
        </form>         
    </td>           
    </th>        
    <th>                    
        <table>               
        <tr><td><label>ZaÅ‚Ä…cz zdjÄ™cie: </label></td></tr>            
        <tr><td><button>PrzeglÄ…daj</button></td></tr>            
        <tr><td><textarea>Tu bÄ™dzie kontener multimediÃ³w. </textarea></td></tr>
        <tr><td><label>ZaÅ‚Ä…cz video: </label></td></tr>    
        <tr><td><button>PrzeglÄ…daj</button></td></tr>    
        <tr><td><textarea>Tu bÄ™dzie kontener multimediÃ³w. </textarea> </td></tr>    
        <tr><td><label>ZaÅ‚Ä…cz plik audio: </label></td></tr>    
        <tr><td><button>PrzeglÄ…daj</button></td></tr>    
        <tr><td><textarea>Tu bÄ™dzie kontener multimediÃ³w. </textarea> </td></tr>                
        </table>
    </th>
</table>

<?php
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie zosta³ wybrany dziennik, do którego wpis ma byæ dodany!</span><br>' ;
}
?>