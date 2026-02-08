<?php
    require_once('linkBD\dbconnect.php');
    session_start();
    if (empty($_SESSION['login'])) 
    {
        header('location: /index.php');
        die();
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>profile</title>
    <link rel="stylesheet" href="font2.css">
</head>
<header> 
    
</header>
<body>
<div>
    Добро пожаловать: <?=htmlspecialchars($_SESSION['login']) ?> <br>
    <a href="phpScripts/logout.php">Выйти</a>



</div>

</body>
<footer>

</footer>
</html>