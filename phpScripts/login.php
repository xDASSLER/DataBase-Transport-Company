<?php
    require_once('linkBD\dbconnect.php');
    session_start(); //Создание сессии

    //Пользователь уже авторизован
    if (!empty($_SESSION['login'])) 
    {
        header('Location: /profile.php'); 
        die();
    }

    $error = '';
    if(!empty($_POST['login']) && !empty($_POST['password'])) 
        {
            $login = $_POST['login'];
            $password = $_POST['password'];

            //Формируем запрос к БД
            $result = mysqli_query($link, "SELECT * FROM `login_password` WHERE `Login` = '$login'");
            $user = mysqli_fetch_assoc($result);

            if ($login === $user['Login'] && $password === $user['Password']) //Если пароль и логин верный
                {
                    $_SESSION['login'] = $login;
                    header('Location: /profile.php'); //Переход на другую страницу
                    die();                       
                }
            else 
                {
                    $error = 'Неверный пользователь или пароль!';
                }
            
        }

    // $error = '';
    // if (!empty($_POST['login']) && !empty($_POST['password'])) {
    //     $login = $_POST['login'];
    //     $password = $_POST['password'];
    //     if ($login == 'admin' && $password == '12345') 
    //     {
    //         $_SESSION['login'] = "$login"; //Присвоение переменной значения логина
    //         header('Location: /profile.php'); //Переход на другую страницу
    //         die();
    //     }
    //     else 
    //     {
    //         $error = 'Неверный пользователь или пароль!';
    //     }
    // }
?>
