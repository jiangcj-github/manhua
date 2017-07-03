<?php
    session_start();
    unset($_SESSION["nick"]);
    header( "Location:/user/signin.php" );
    exit();