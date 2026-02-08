<?php
    session_start(); //Создание сессии

    if (!empty($_SESSION['login'])) 
    {
        header('Location: /profile.php'); 
        die();
    }

    $error = '';
    if (!empty($_POST['login']) && !empty($_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        if ($login == 'admin' && $password == '12345') 
        {
            $_SESSION['login'] = "$login"; //Присвоение переменной значения логина
            header('Location: /profile.php'); //Переход на другую страницу
            die();
        }
        else 
        {
            $error = 'Неверный пользователь или пароль!';
        }
    }
?>
