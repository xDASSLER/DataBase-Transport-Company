<?php
    require_once('linkBD\dbconnect.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="font.css">
</head>
<header> 
    <p class = "UpperText">Введите логин и пароль для входа в WEB приложение</p>
</header>
<body>
        <div class = register> Окно для ввода
            <form class = register action="main" id = "add-form">
                <fieldset>
                    <legend>Данные</legend>
                        <p><label>Логин </label><input type="login" placeholder="Введите логин"></p>
                        <p><label>Пароль </label><input type="password" placeholder="Введите пароль"></p>
                </fieldset>

                <div class = "submit">
                    <button type = "submit" id = "submit">Отправить</button>
                </div>
                
            </form>
        </div>


</body>
<footer>

</footer>
</html>