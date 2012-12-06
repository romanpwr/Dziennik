<?php
$width = 60; //wysokosc diva lini czasu podzielona przez 10 - 5
             //(5 - potrzebne miejsce na buttony)

function tripYear($year) { 
    $query = "SELECT * FROM katalog WHERE YEAR(DataRozpoczecia)=$year";
    $katalogi= mysql_query($query);
    return mysql_num_rows($katalogi);
} //oblicza ile wycieczek w danym roku odbyl uzytownik

function upYear($year) {
    if ($year!=date("Y")) {
        global $width;
        $pom=0;
        while ($pom<$width-2) {            
            $pom+=tripYear($year)+1;
            $year++;
        }
        $year-=2;
        if ($year>date("Y")) $year=date("Y");
    }
    return $year;
} //oblicza od którego roku ma wyswietlac linie przy naciscnieciu przycisku 'UP'

function writeTrip($year,$dziennik) {
    
    global $width;
    $ile = $width-2;
    echo '<div style="height: 12px;"></div>';
    $ile--;
    while ($ile>0) {
        echo '<div id="wycieczka"></div>';
        $ile--;
        
        $query="SELECT * FROM katalog WHERE IdDziennika='$dziennik' AND Year(DataRozpoczecia)=$year ORDER BY DataRozpoczecia DESC";        
        $katalog=mysql_query($query); 
    
        while ($row = mysql_fetch_array($katalog)) {
                echo '<div id="wycieczka"><a href="showReg.php?wycieczka='.$row['IdKatalog'].'">'.$row['Katalog'].'</a></div>';
                $ile--;
        }
        $year--;
    }
    echo '<div id="wycieczka"></div>';
    return $year;
}

function writeYears($year) {
    global $width;
    $ile = $width-2;
    echo '<div id="rok"></div>';
    $ile--;
    while ($ile>0) {
        echo '<div id="rok">'.($year+1).'</div>';
        $ile--;
        $i=tripYear($year);
        while ($i>0 && $ile>0) {
            echo '<div id="rok"></div>';
            $ile--;
            $i--;
        }
        if ($i==0) $year--;
    }
    echo '<div id="rok"></div>';
    return $year;
}

function drawLine($year) {
    global $width;
    $ile = $width-2;
    echo '<img src="Linia/gora.png">';
    $ile--;
    while ($ile>0) {
        echo '<div id="element"><img src="Linia/pop.png"></div>'; 
        $ile--;
        $i=tripYear($year);
        while ($i>0 && $ile>0) {
            echo '<div id="element"><img src="Linia/linia.png"></div>';
            $ile--;
            $i--;
        }
        $year--;
    }
    echo '<img src="Linia/dol.png">';
    return $year;
}

function drawTripLine($rok,$dziennik) {
    $rokUp=upYear($rok);
    echo '  <div id="timeline">
            <div id="btn">
                <form id="btn" action="showReg.php" method="get">
                    <input type="hidden" value="'.$rokUp.'" name="rok" />
                    <input id="btn" type="submit" name="Up" value="Up" />
                </form>
            </div>
            <div id="liniaCzasu">
            <div id="lata">';

    $rokDown=writeYears($rok);

    echo '  </div>
            <div id="linia">';

    drawLine($rok);

    echo '  </div>
            </div>
            <div id="wycieczki">';

    writeTrip($rok,$dziennik);
    
    echo '  </div>
            <div id="btn2">
                <form action="showReg.php" method="get">
                    <input type="hidden" value="'.($rokDown+1).'" name="rok" />
                    <input id="btn" type="submit" name="Down" value="Down" />
                </form>
            </div>
            </div>';
    return $rok;
}

//dla wpisów

function getInscriptions($trip) {
    $query="SELECT * FROM wpisy WHERE IdKatalog='$trip' ORDER BY DataWpisu DESC";
    return mysql_query($query);
}

function countRatio($insNr) {
    global $width;
    return ($width-2)/$insNr;
}

function drawInsLine($trip) {
    global $width;
    $insNr=mysql_num_rows(getInscriptions($trip));
    $dif=countRatio($insNr);
    $ile=0;
    echo '<img src="Linia/gora.png"><br>';
    $ile++;
    while ($insNr>0) {
        $i=1;
        while ($i<$dif/2) { 
            echo '<img src="Linia/linia.png"><br>';
            $ile++;
            $i++;
        }
        echo '<img src="Linia/pop.png"><br>'; 
        $ile++;
        $i++;
        while ($i<$dif) { 
            echo '<img src="Linia/linia.png"><br>';
            $ile++;
            $i++;
        }
        $insNr--;
    }
    while ($ile<$width-2) {
        echo '<img src="Linia/linia.png"><br>';
        $ile++;
    }
    echo '<img src="Linia/dol.png">';
}

function writeDates($trip) {
    $inscriptions = getInscriptions($trip);
    global $width;
    $insNr=mysql_num_rows(getInscriptions($trip));
    $dif=countRatio($insNr);
    $ile=0;
    echo '<div id="data"></div>';
    $ile++;
    while ($row=mysql_fetch_assoc($inscriptions)) {
        $i=1;
        while ($i<$dif/2) { 
            echo '<div id="data"></div>';
            $ile++;
            $i++;
        }
        echo '<div id="data">'.$row['DataWpisu'].'</div>'; 
        $ile++;
        $i++;
        while ($i<$dif) { 
            echo '<div id="data"></div>';
            $ile++;
            $i++;
        }
    }
    while ($ile<$width-2) {
        echo '<div id="data"></div>';
        $ile++;
    }
    echo '<div id="data"></div>';
}

function writeInscriptions($trip) {
    $inscriptions = getInscriptions($trip);
    global $width;
    $insNr=mysql_num_rows(getInscriptions($trip));
    $dif=countRatio($insNr);
    $ile=0;
    echo '<div id="data"></div>';
    $ile++;
    while ($row=mysql_fetch_assoc($inscriptions)) {
        $i=1;
        while ($i<$dif/2) { 
            echo '<div id="data"></div>';
            $ile++;
            $i++;
        }
        echo '<div id="data"><a href="showReg.php?wycieczka='.$row['IdKatalog'].'&IdWpisu='.$row['IdWpis'].'">'.$row['Tytul'].'</a></div>'; 
        $ile++;
        $i++;
        while ($i<$dif) { 
            echo '<div id="data"></div>';
            $ile++;
            $i++;
        }
    }
    while ($ile<$width-2) {
        echo '<div id="data"></div>';
        $ile++;
    }
    echo '<div id="data"></div>';
    return $row['IdKatalog'];
}

function drawInscriptionLine($trip) {
    $query="SELECT Katalog FROM katalog WHERE IdKatalog=$trip";
    $result=mysql_query($query);
    $wycieczka=mysql_fetch_assoc($result);
    echo '  <div id="timeline">';
    echo '  <div id="btn" style="text-align:center;">'.$wycieczka['Katalog'].'</div>';
    echo '  <div id="liniaCzasuWpisy">
            <div id="daty">';

    writeDates($trip);

    echo '  </div>
            <div id="linia">';

    drawInsLine($trip);

    echo '  </div>
            </div>
            <div id="wpisy">';

    writeInscriptions($trip);

    echo '  </div>';
    echo '  <div id="btn2">
                <form action="showReg.php" method="get">
                    <input id="btn" type="submit" name="Powrot" value="Powrot" />
                </form>
            </div>';
    echo '  </div>';
}

?>