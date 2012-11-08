<?php
session_start();
include("connection.php");
 
if (isset($_SESSION['login'])) {
        $dziennik=$_SESSION['login'];
        $month=0;
        $year=0;            
        
        $query="SELECT YEAR(DataWpisu) FROM wpisy WHERE IdDziennika='$dziennik' GROUP BY YEAR(DataWpisu) ORDER BY YEAR(DataWpisu) DESC";        
        $lata=mysql_query($query);
        
        if(isset($_GET['Year'])) {
            $year=$_GET['Year']; 
            $toYear=$year;  
            $date=$year.'-01-01';
            $toDate=$toYear.'-12-31';
            $query="SELECT MONTH(DataWpisu) FROM wpisy WHERE IdDziennika='$dziennik' AND DataWpisu BETWEEN '$date' AND '$toDate' GROUP BY MONTH(DataWpisu) ORDER BY MONTH(DataWpisu) DESC";        
            $miesiace=mysql_query($query);      
        }        
        
        if(isset($_GET['Month'])) {
            $month=$_GET['Month']; 
            $toMonth=$month; 
            $date=$year.'-'.$month.'-01';
            $toDate=$toYear.'-'.$toMonth.'-31';
            $query="SELECT DataWpisu,IdWpis FROM wpisy WHERE IdDziennika='$dziennik' AND DataWpisu BETWEEN '$date' AND '$toDate' ORDER BY DataWpisu DESC";        
            $daty=mysql_query($query);          
        }        
               
        if (mysql_num_rows($lata)>0) {
            echo '<ul>';
            while ($tab= mysql_fetch_array($lata)) {                
                echo '<li><a href=getInscription.php?Year='.$tab[0].'>'.$tab[0].'</a></li>';
                if ($year==$tab[0]) {
                    echo '<ul>';
                    while ($tab1= mysql_fetch_array($miesiace)) {
                        echo '<li><a href=getInscription.php?Year='.$tab[0].'&Month='.$tab1[0].'>'.$tab1[0].'</a></li>';
                        if ($month==$tab1[0]) {
                            echo '<ul>';
                            while ($tab2= mysql_fetch_array($daty)) {                                
                                echo '<li><a href=showReg.php?IdWpisu='.$tab2[1].'>'.$tab2[0].'</a></li>';                                
                            }
                            echo '</ul>';

                        }                        
                    }
                    echo '</ul>';
                }                
            }
            echo '</ul>';
        } else {
            echo '<br><span style="color: blue; font-weight: bold;">Brak wpisów w podanym przedziale czasowym! </span><br>';
        }   
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie jesteś zalogowany lub zostałeś wylogowany! </span><br>';
} 
?>