<h4>Lépésszám felvétel</h4>
<hr>
<?php
    if(isset($_SESSION['uName']))
    {
        $now = date("Y-m-d");
        if(isset($_POST['add']))
        {
            $walk = escapeshellcmd($_POST['walk']);
            $uid = escapeshellcmd($_SESSION['uID']);
            $date = escapeshellcmd($_POST['date']);
            if(empty($walk) || empty($date)) message("Nem töltötted ki valamelyik mezőt!",1);
            else if($walk < 1) message("Hamis lépésszám!");
            else
            {
                message("Sikeres adatfelvétel!",0);
                dbquery("INSERT INTO adatok VALUES(null,'$uid','$date','$walk')",$connectionx);
            }
        }
        else
        {
            $_POST['date'] = '';
            $_POST['walk'] = 0;
        }
        echo 
        '<form method="POST" action="index.php?pg=addata">
        <label for="date">Dátum megadása:</label><br>
        <input type="date" name="date" max='.$now.' value="'.$_POST['date'].'"><br>
        <br>
        <label for="walk">Lépésszám hozzáadása:</label><br>
        <input type="number" name="walk" value="'.$_POST['walk'].'"><br>
        <br>
        <input type="submit" value="Hozzáadás" name="add">
        </form>';
        $uid = escapeshellcmd($_SESSION['uID']);
        $result = dbquery("SELECT * FROM adatok WHERE felhID = '$uid'",$connectionx);
        if(mysqli_num_rows($result))
        {
            echo '<br>';
            echo '<h4>Felvett adatok:</h4><hr>';
            echo '<table>';
            echo '
            <tr>
            <th>ID</th>
            <th>Dátum</th>
            <th>Lépésszám</th>';
            while($walks = mysqli_fetch_assoc($result))
            {
                echo '
                <tr>
                <td>'.$walks['ID'].'</td>
                <td>'.$walks['datum'].'</td>
                <td>'.$walks['lepesszam'].'</td>
                </tr>';
            }
            
            echo '</table>';
            echo '<br>';
            echo '<h4>Adat szerkesztés/törlés:</h4><hr>';
            if(isset($_POST['delete']))
            {
                $e_id = escapeshellcmd($_POST['e_id']);
                $e_date = escapeshellcmd($_POST['e_date']);
                $e_walk = escapeshellcmd($_POST['e_walk']);
                if(empty($e_id)) message("A törléshez megkell add az egyik felvitt adat ID-jét.",1);
                else
                {
                    $result = dbquery("SELECT felhID from adatok WHERE ID='$e_id'",$connectionx);
                    $gd = mysqli_fetch_assoc($result);
                    if(!mysqli_num_rows($result)) message("Ez az adat nem létezik.",1);
                    else
                    {
                        if($gd['felhID'] != $_SESSION['uID']) message("Ezt az adatot nem törölheted, nem a te rekordod!",1);
                        else
                        {
                            dbquery("DELETE FROM adatok WHERE ID='$e_id'",$connectionx);
                            message("Sikeresen törölted a(z) '.$e_id.' azonosítójú rekordot.",1);
                            header("location: index.php?pg=addata");
                            return 1;
                        }  
                    }
                }
            }
            if(isset($_POST['edit']))
            {
                $e_walk = escapeshellcmd($_POST['e_walk']);
                $e_id = escapeshellcmd($_POST['e_id']);
                $e_date = escapeshellcmd($_POST['e_date']);
                if(empty($e_walk) || empty($e_date) || empty($e_id)) message("Nem töltötted ki valamelyik mezőt!",1);
                else if($e_walk < 1) message("Hamis lépésszám!");
                else
                {
                    $result = dbquery("SELECT felhID from adatok WHERE ID='$e_id'",$connectionx);
                    $gd = mysqli_fetch_assoc($result);
                    if(!mysqli_num_rows($result)) message("Ez az adat nem létezik.",1);
                    else
                    {
                        if($gd['felhID'] != $_SESSION['uID']) message("Ezt az adatot nem szerkesztheted, nem a te rekordod!",1);
                        else
                        {
                            message("Sikeres adatfelvétel!",0);
                            dbquery("UPDATE adatok SET datum='$e_date', lepesszam='$e_walk' WHERE ID='$e_id'",$connectionx);
                            header("location: index.php?pg=addata");
                            return 1;
                        }
                    }
                }
            }
            if(!isset($_POST['e_id']))
            {
                echo
                '<form method="POST" action="index.php?pg=addata">
                <input id="idinput" type="number" name="e_id" placeholder="ID..">
                <input type="date" name="e_date" max='.$now.' placeholder="Dátum..">
                <input type="number" name="e_walk" placeholder="Lépésszám..">
                <input type="submit" value="Szerkesztés" name="edit">
                <input type="submit" value="Törlés" name="delete">
                </form>';
                $_POST['e_date'] = '';
                $_POST['e_walk'] = 0;
                $_POST['e_id'] = -1;
            }
            else
            {
                echo
                '<form method="POST" action="index.php?pg=addata">
                <input id="idinput" type="number" name="e_id" placeholder="ID megad.." value="'.$_POST['e_id'].'">
                <input type="date" name="e_date" placeholder="Dátum átír.." value="'.$_POST['e_date'].'">
                <input type="number" name="e_walk" placeholder="Lépésszám megv.." value="'.$_POST['e_walk'].'">
                <input type="submit" value="Szerkesztés" name="edit">
                <input type="submit" value="Törlés" name="delete">
                </form>';
            }
            
        }
        
    }
    else message("Ehhez az oldalhoz nincs hozzáférésed. Jelentkezz be!",0);
?>
