<h4>Adatok módosítása/törlése</h4>
<hr>
<?php
    if(isset($_SESSION['uName']))
    {
        $uid = escapeshellcmd($_SESSION['uID']);
        $result = dbquery("SELECT * FROM adatok WHERE felhID = '$uid'",$connectionx);
        if(mysqli_num_rows($result))
        {
            if(isset($_POST['delete_']))
            while($walks = mysqli_fetch_assoc($result))
            {
                echo '
                <form id="'.$walks['ID'].'" method="POST" action="index.php?pg=editdata">
                <label for="date">ID: '.$walks['ID'].'</label>
                <input type="date" value="'.$walks['datum'].'">
                <input type="number" value="'.$walks['lepesszam'].'">
                <input type="submit" value="Szerkesztés" name="edit'.$walks['ID'].'">
                <input type="submit" value="Törlés" name="delete_'.$walks['ID'].'"><br>
                </form>';
            }
        }
        else message("Nincsen több felvitt lépésadat!");
    }
    else message("Nincs hozzáférésed ehhez az oldalhoz. Jelentkezz be!",1);
?>