<?php
    require_once('linkBD\dbconnect.php');
    require_once('phpScripts\login.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="css/font1.css">
</head>
<body>
<header> 
    <p class = "UpperText">Введите логин и пароль для входа в WEB приложение</p>
</header>
  
<form method="POST" action="index.php">
    <fieldset>
        <div class = "ErrorLog">
            <?=$error?>
        </div> 

        <div class = "CenterText">
            Логин:
            <input type="login" id = "login" name = "login" placeholder="Введите логин">
        </div>
        
        <div class = "CenterText">
            Пароль:
            <input type="password" id = "password" name = "password" placeholder="Введите пароль">
        </div>

        <div class = "ButtonText">
            <button type="submit">Войти</button>
        </div>

    </fieldset>
</form>
<footer>

</footer>
</body>
</html>