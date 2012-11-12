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
if (isset($_GET['idWpisu']) && (isset($_SESSION['dziennik']))){
$idWpisu = $_GET['idWpisu'];
$dziennik = $_SESSION['dziennik'];
$nick = $_SESSION['login'];
$query = mysql_query("SELECT * FROM wpisy WHERE IdWpis='$idWpisu' AND IdDziennika='$dziennik'");
$spr1 = mysql_query ("SELECT * FROM redaktorzy WHERE NazwaDziennika='$dziennik' AND NickRed = '$nick'");

if (mysql_num_rows($query)==1) { 
    $result = mysql_fetch_array($query);
	if (mysql_num_rows($spr1) == 1 || $result['IdDziennika'] == $nick){
	$red = mysql_fetch_array($spr1);
	if ($red['EdycjaAutora']=='TAK' && $result['IdDziennika'] == $result['NickRed'] || $red['EdycjaRedaktora'] =='TAK' && $result['NickRed'] != $result['IdDziennika'] || $result['IdDziennika'] == $nick){
    $tytul = $result['Tytul'];
    $wpis = $result['Tresc'];
 

if(isset($_POST['submit'])) {    
    
    $tytul = $_POST['title'];
    $wpis = $_POST['inscription'];
        
    $query=mysql_query("UPDATE wpisy SET Tytul='$tytul',Tresc='$wpis' WHERE IdWpis='$idWpisu'");
    
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
	$query2=mysql_query("DELETE FROM zalaczniki WHERE idwpisu ='$idWpisu'");
    if ($query) {
        echo '<br><span style="color: green; font-weight: bold;">Wpis został usunięty! </span><br>';
        // Dobrze by było żeby nie zostawiać na stronie. Najlepiej info i powrót na index.
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>'.mysql_error();
    }
	if ($query2){
	echo '<br><span style="color: green; font-weight: bold;">Załączniki wpisu zostały usunięte! </span><br>';
        // Dobrze by było żeby nie zostawiać na stronie. Najlepiej info i powrót na index.
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>'.mysql_error();
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
        <tr><td><form name="addInscription" method="POST" action="addPhoto.php"><input type="hidden" name="idWpisu" value="<?php echo $idWpisu; ?>" /> <input type="submit" class="submit" name="wpis" value="Przejdź do galerii zdjęć"></form></td></tr>            
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

<?php
} else {
$tytul = "";
$wpis = "";
echo '<br><span style="color: red; font-weight: bold;">Nie masz uprawnień do edycji tego wpisu.</span><br>' ;
} 
}
else {
$tytul = "";
$wpis = "";
echo '<br><span style="color: red; font-weight: bold;">Nie masz uprawnień do edycji tego wpisu.</span><br>' ;
} 


}else {
    $tytul = "";
    $wpis = "";
    echo '<br><span style="color: red; font-weight: bold;">Brak wpisu w bazie lub nie należy on do wybranego dziennika.</span><br>' ;
}   
}
else{
 echo '<br><span style="color: red; font-weight: bold;">Nie został wpis, który ma być edytowany!</span><br>' ;
}
