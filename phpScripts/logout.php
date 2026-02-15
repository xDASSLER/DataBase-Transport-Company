<?php
    require_once('linkBD\dbconnect.php');
    session_start();
    
    //Очистка переменных сессии
    $_SESSION = array();
    
    // Удаление куки
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    // Удаление сессии
    session_destroy();
    
    header('Location: /index.php');
    exit();
?>