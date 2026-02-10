<?php
    require_once('linkBD\dbconnect.php');
    session_start();
    unset($_SESSION['login']);
    header('location: /index.php');
    
    mysqli_close($link);
    die();
?>