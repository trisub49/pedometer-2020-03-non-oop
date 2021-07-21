<?php
    // adatbázis kapcsolódás
    function dbconnect($dbhost, $dbname, $dbuser, $dbpass)
    {
        if (!($link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)))
        {
            die("Hiba a kiszolgálóhoz történő csatlakozáskor! Hibakód: ".mysqli_connect_errno());
        }
        else
        {
            mysqli_query($link, "SET NAMES utf8");
          //  mysqli_set_charset($link, "utf8");
            return $link;
        }
    }

    // adatbázis lekérdezés
    function dbquery($sql, $connection)
    {
        $result = mysqli_query($connection, $sql);
        if ($result) return $result;
    }
    function message($str,$err)
    {
        if($err == 0) echo '<span class="msg"><b>Szerver: </b>'.$str.'</span><br><br>';
        else echo '<span class="emsg"><b>Hiba: </b>'.$str.'</span><br><br>';
    }
?>