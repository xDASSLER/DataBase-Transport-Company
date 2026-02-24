<?php 
//Функция для подключения к БД
$database = 'transport company';
$link = mysqli_connect('localhost','root','',$database); 
$link->set_charset("utf8mb4");

//Проверка подключения erno - номер ошибки, error - текст об ошибке
if(mysqli_connect_errno() != 0)
    {
        echo 'Ошибка к подключении к БД ('.mysqli_connect_errno().'): '.mysqli_connect_error();
        exit();
    }

?>