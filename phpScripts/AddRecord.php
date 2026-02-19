<?php 
require_once('linkBD/dbconnect.php');
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('log_errors', 1);

// ini_set('error_log', __DIR__ . '/add_record_error.log');

$error = '';
$success = '';
// Получение имени таблицы
$tableName = $_POST['table_name'] ?? '';

// Получение столбцов таблицы
$validColumns = []; 
$columnTypes = [];

//Запрос
$colsResult = $link->query("SHOW COLUMNS FROM `$tableName`");

while ($row = $colsResult->fetch_assoc()) {
    $colName = $row['Field'];
    $colType = strtolower($row['Type']);
    
    $validColumns[] = $colName;
    
    if (strpos($colType, 'int') !== false) {
        $columnTypes[$colName] = 'i';
    } elseif (preg_match('/float|double|decimal/', $colType)) {
        $columnTypes[$colName] = 'd';
    } else {
        $columnTypes[$colName] = 's';
    }
}
$colsResult->free();

// Формирование параметров запроса
$columns = [];
$values = [];
$params = [];
$types = '';

foreach ($validColumns as $col) {

    // проверка совпадения ключа 
    if (isset($_POST[$col]) && $_POST[$col] !== '') {
        $columns[] = "`$col`";
        $values[] = '?';
        $params[] = $_POST[$col];
        $types .= $columnTypes[$col] ?? 's';
    }
}


// Вставка данных
$colsStr = implode(', ', $columns); //Соединение строка массива в одну строку
$valsStr = implode(', ', $values);

$stmt = $link->prepare("INSERT INTO `$tableName` ($colsStr) VALUES ($valsStr)");
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    $success = 'Запись добавлена';
} 
else 
{
    $error = 'Ошибка добавления записи!';
}
$stmt->close();

$_SESSION['selected_table'] = $tableName;
header('Location: /profile.php');
exit;
?>