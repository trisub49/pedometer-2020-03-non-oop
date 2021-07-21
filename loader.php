<?php
    $page = @$_GET['pg'];
    if (!empty($page) && $page != "news") 
    {
        echo '<div class="content col-xs-12 col-sm-12 col-md-8 col-lg-9">';
        include($page.'.php');
        echo '</div>';
    }
    else include('news.php');
?>