<ul>
    <li><a href="index.php?pg=news">Hírek</a></li>
    <?php
        if(!isset($_SESSION['uName'])) 
        {
            echo '<li><a href="index.php?pg=register">Regisztráció</a></li>';
            echo '<li><a href="index.php?pg=login">Belépés</a></li>';
        }
        else
        {
            echo '<li><a href="index.php?pg=addata">Adatfelvétel</a></li>';
            echo '<li><a href="index.php?pg=setpass">Felhasználó</a></li>';
            echo '<li><a href="index.php?pg=login">Kilépés</a></li>';
        }
    ?>
</ul>