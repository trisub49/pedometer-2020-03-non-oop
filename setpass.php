

<?php
    if(isset($_SESSION['uName']))
    {
        echo '
        <h4>Név vagy email frissítés</h4>
        <hr>';
        if(isset($_POST['frst']))
        {
            $user = escapeshellcmd($_POST['myname']);
            $email = escapeshellcmd($_POST['myemail']);
            if (empty($user) && empty($email)) message("Legalább az egyik mezőt kikell töltsd!",1);
            else
            {
                $myid = escapeshellcmd($_SESSION['uID']);
                if(!empty($email))
                {
                    $result = dbquery("SELECT ID FROM felhasznalok WHERE email='$email'", $connectionx);
                    $dataz = mysqli_fetch_assoc($result);
                    if (mysqli_num_rows($result) != 0)
                    {
                        if($dataz['ID'] != $_SESSION['uID']) message("Ez az e-mail már szerepel az adatbázisban és nem a sajátod!",1);
                        else message("Már jelenleg is ez az e-mail címed!",0);
                    }
                    else
                    {
                        dbquery("UPDATE felhasznalok SET email='$email' WHERE ID='$myid'", $connectionx);
                        $_SESSION['uMail'] = $email;
                        message("Sikeresen frissítetted az e-mail címed erre: <b>".$email."</b>",0);
                    }
                }
                if(!empty($user))
                {
                    if($user == $_SESSION['uName']) message("Már jelenleg is ez a felhasználóneved!");
                    else
                    {
                        dbquery("UPDATE felhasznalok SET nev='$user' WHERE ID='$myid", $connectionx);
                        $_SESSION['uName'] = $user;
                        message("Sikeresen frissítetted a felhasználóneved erre: <b>".$user."</b>",0);
                    }
                }
            }
        }
        echo '
        <form method="POST" action="index.php?pg=setpass">
        <label for="myname">Felhasználónév:</label><br>
        <input type="text" name="myname" value="'.$_SESSION['uName'].'"><br><br>
        <label for="myemail">E-mail cím:</label><br>
        <input type="email" name="myemail" value="'.$_SESSION['uMail'].'"><br>
        <br>
        <input type="submit" value="Megváltoztat" name="frst">
        </form>
        <br>
        <h4>Jelszó megváltoztatása</h4>
        <hr>';
        if(isset($_POST['sps']))
        {
            $oldpass = escapeshellcmd($_POST['oldpass']);
            $pass1 = escapeshellcmd($_POST['pass1']);
            $pass2 = escapeshellcmd($_POST['pass2']);
            $uname = escapeshellcmd($_SESSION['uName']);
            $result = dbquery("SELECT jelszo FROM felhasznalok WHERE nev='$uname'",$connectionx);
            $datas = mysqli_fetch_assoc($result);
            if(empty($oldpass) || empty($pass1) || empty($pass2)) message("Nem töltötted ki valamelyik mezőt!",1);
            else if(SHA1($oldpass) != $datas['jelszo']) message("A megadott jelenlegi jelszó hibás!",1);
            else if($pass1 != $pass2) message("A megadott új jelszavak nem egyeznek!",1);
            else
            {
                $pass1 = SHA1($pass1);
                dbquery("UPDATE felhasznalok SET jelszo='$pass1' WHERE nev='$uname'",$connectionx);
                message("Sikeresen jelszót változtattál.",0);
                $_POST['oldpass'] = '';
                $_POST['pass1'] = '';
                $_POST['pass2'] = '';
            }
        }
        else
        {
            $_POST['oldpass'] = '';
            $_POST['pass1'] = '';
            $_POST['pass2'] = '';
        }
        echo '
        <form method="POST" action="index.php?pg=setpass">
            <label for="oldpass">Jelenlegi jelszó:</label><br>
            <input type="password" name="oldpass" value="'.$_POST['oldpass'].'"><br>
            <br>
            <label for="pass1">Új jelszó:</label><br>
            <input type="password" name="pass1" value="'.$_POST['pass1'].'"><br>
            <br>
            <label for="pass2">Új jelszó megerősítése:</label><br>
            <input type="password" name="pass2" value="'.$_POST['pass2'].'"><br>
            <br>
            <input type="submit" value="Megváltoztat" name="sps">
        </form>';
    }
    else message("Ez az oldal nem elérhető számodra. Jelentkezz be!",1);
?>