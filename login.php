<?php
    if(!isset($_SESSION['uName']))
    {
        echo '<h4>Bejelentkezés</h4> <hr>';
        if(isset($_POST['log']))
        {
            $email = escapeshellcmd($_POST['email']);
            $pass = escapeshellcmd($_POST['pass']);
            if (empty($email) || empty($pass)) message("Nem adtál meg minden adatot!",1);
            else
            {
                $result = dbquery("SELECT * FROM felhasznalok WHERE email='$email'",$connectionx);
                if (mysqli_num_rows($result) == 0) message("Nincs ilyen e-mail címmel regisztrált felhasználó!",1);
                else
                {
                    $tUser = mysqli_fetch_assoc($result);
                    if ($tUser['jelszo'] != SHA1($pass)) message("Hibás jelszó!",1);
                    else
                    {
                        $_SESSION['uID'] = $tUser['ID'];
                        $_SESSION['uName'] = $tUser['nev'];
                        $_SESSION['uMail'] = $tUser['email'];
                        message("Sikeresen bejelentkeztél!",0);
                        header("location: index.php?pg=news");
                        return 1;
                    }
                }
            }
        }
        else
        {
            $_POST['email'] = '';
            $_POST['pass'] = '';
        }
        echo '
        <form method="POST" action="index.php?pg=login">
        <label for="email">Felhasználónév:</label><br>
        <input type="text" name="email" value="'.$_POST['email'].'"><br>
        <br>
        <label for="pass">Jelszó:</label><br>
        <input type="password" name="pass" value="'.$_POST['pass'].'"><br>
        <br>
        <input type="submit" value="Bejelentkezés" name="log">
        </form>';
    }
    else
    {
        echo '
        <h4>Kijelentkezés</h4>
        <hr>
        ';
        message("Sikeresen kijelentkeztél!",0);
        unset($_SESSION['uID']);
        unset($_SESSION['uName']);
        unset($_SESSION['uMail']);
        header("location: index.php?pg=login");
    }
?>

