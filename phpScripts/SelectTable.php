<?php 
require_once('linkBD/dbconnect.php');
session_start();
//Формируем запрос к БД 
$result = mysqli_query($link, "SELECT table_name FROM information_schema.tables WHERE table_schema = '$database' AND table_name != 'Login_Password'");

$tables = []; //Создаем массив для хранения названий таблиц

if ($result) //Если результат запроса успешен с помощью цикла перебираем названия и записываем массив
    {
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
}

