<?php
    require_once('linkBD\dbconnect.php');

    $error = '';
    if (!empty($_POST['login']) && !empty($_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        if ($login == 'admin' && $password == '12345') 
        {
            setcookie('login', $login, time()+3600, "/"); //Создание куки
            header('Location: /profile.php'); //Переход на другую страницу
            die();
        }
        else 
        {
            $error = 'Неверный пользователь или пароль!';
        }
    }
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
        <?=$error?> 
        <div class = CenterText>
            <label class="login">Логин:</label> <input type="login" id = "login" name = "login" placeholder="Введите логин">
        </div>
        
        <div class = CenterText>
            <label class = "password">Пароль: </label> <input type="password" id = "password" name = "password" placeholder="Введите пароль">
        </div>

        <div>
            <button type="submit">Войти</button>
        </div>

    </fieldset>
</form>
<footer>

</footer>
</body>
</html>