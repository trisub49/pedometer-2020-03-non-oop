<h4>Regisztráció</h4>
<hr>

<?php
    if(!isset($_SESSION['uName']))
    {
        if(isset($_POST['reg']))
        {
            $user = escapeshellcmd($_POST['user']);
            $email = escapeshellcmd($_POST['email']);
            $pass1 = escapeshellcmd($_POST['pass1']);
            $pass2 = escapeshellcmd($_POST['pass2']);
            if (empty($user) || empty($email) || empty($pass1) || empty($pass2)) message("Hiba! Nem töltötted ki az űrlapot teljesen!",1);
            else
            {
                if ($pass1 != $pass2) message("Hiba! A megadott jelszavak nem egyeznek!",1);
                else
                {
                    $result = dbquery("SELECT ID FROM felhasznalok WHERE email='$email'", $connectionx);
                    if (mysqli_num_rows($result) != 0) message("Ez az e-mail már szerepel az adatbázisban!",1);
                    else
                    {
                        $pass1 = SHA1($pass1);
                        dbquery("INSERT INTO felhasznalok VALUES(null, '$user', '$email', '$pass1')", $connectionx);
                        $result = dbquery("SELECT * FROM felhasznalok WHERE nev='$user'", $connectionx);
                        $data = mysqli_fetch_assoc($result);
                        $_SESSION['uID'] = $data['ID'];
                        $_SESSION['uName'] = $user;
                        $_SESSION['uMail'] = $email;
                        message("Sikeres regisztráció, autómatikusan bejelentkeztél.",0);
                        header("location: index.php?pg=news");
                        return 1;
                    }
                }
            }
        }
        else
        {
            $_POST['user'] = '';
            $_POST['email'] = '';
            $_POST['pass1'] = '';
            $_POST['pass2'] = '';
        }
        echo'
        <form method="POST" action="index.php?pg=register">
        <label for="user">Felhasználónév:</label><br>
        <input type="text" name="user" value="'.$_POST['user'].'"><br>
        <br>
        <label for="email">E-mail cím:</label><br>
        <input type="email" name="email" value="'.$_POST['email'].'"><br>
        <br>
        <label for="pass1">Jelszó:</label><br>
        <input type="password" name="pass1" value="'.$_POST['pass1'].'"><br>
        <br>
        <label for="pass2">Jelszó megerősítése:</label><br>
        <input type="password" name="pass2" value="'.$_POST['pass2'].'"><br>
        <br>
        <input type="submit" value="Regisztráció" name="reg">
        </form>';
    }
    else message("Jelenleg be vagy jelentkezve. Új felhasználó regisztrálásához jelentkezz ki!");
?>
