<?php
    $result = dbquery("SELECT * FROM adatok INNER JOIN felhasznalok ON felhasznalok.ID = adatok.felhID ORDER BY datum DESC",$connectionx);
    if(mysqli_num_rows($result))
    {
        while($news = mysqli_fetch_assoc($result))
        {
            echo '<div class="content col-xs-12 col-sm-12 col-md-8 col-lg-9">';
            echo '<h4>Dátum: '.$news['datum'].'</h4><hr>';
            echo '<b>'.$news['nev'].'</b> hozzáadott <b>'.$news['lepesszam'].'</b> lépést.';
            echo '</div>';
        }
    }
    else 
    {
        echo '<div class="content col-xs-12 col-sm-12 col-md-8 col-lg-9">';
        echo '<h4>Hoppácska!</h4><hr>';
        message("Üres az adatbázis!",0);
        echo '</div>';
    }
?>