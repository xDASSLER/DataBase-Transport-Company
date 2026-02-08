<?php
    if (empty($_COOKIE['login'])) 
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
   Добро пожаловать: <?=htmlspecialchars($_COOKIE['login']) ?>   


</body>
<footer>

</footer>
</html>