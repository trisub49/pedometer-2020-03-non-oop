<!DOCTYPE HTML>
<?php
    session_start();
    include("data.php");
    include("functions.php");
    $connectionx = dbconnect($dbhost, $dbname, $dbuser, $dbpass);
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>Lépésszámláló</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        <link rel="stylesheet" href="css/lepesszamlalo.css">
    </head>
    <body>
        <div id="menu" class="container">
            <?php include("menu.php"); ?>
        </div>
        <div id="container" class="container">
        <div id="blabla" class="visible-md visible-lg col-lg-2 col-md-3">
            <?php include("blabla.php"); ?>
            </div>
            <?php include("loader.php"); ?>
        </div>
        <div id="footer" class="container">
            Lépésszámláló @ Farkas András - 2020
        </div>  
    </body>
</html>