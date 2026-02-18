<?php 
require_once('linkBD/dbconnect.php');
session_start();

//Получение имени таблицы
$tableName = $_POST['table_name'] ?? '';

//Получение колонок таблицы
$colsResult = $link->query("SHOW COLUMNS FROM `$tableName`");
$validColumns = [];
while ($row = $colsResult->fetch_assoc()) {
    $validColumns[] = $row['Field'];
}
$colsResult->free(); //Очистка

// получение строк таблицы
$columns = [];
$values = [];
$params = [];
$types = '';

foreach ($validColumns as $col) {
    // Пропускаем автоинкремент и системные поля
    if (in_array(strtolower($col), ['id', 'created_at', 'updated_at'])) continue;
    
    if (isset($_POST[$col]) && $_POST[$col] !== '') {
        $columns[] = "`$col`";
        $values[] = '?';
        $params[] = $_POST[$col];
        $types .= 's'; 
    }
}

// Вставка данных
if (!empty($columns) && !empty($params)) {
    $colsStr = implode(', ', $columns);
    $valsStr = implode(', ', $values);
    
    $stmt = $link->prepare("INSERT INTO `$tableName` ($colsStr) VALUES ($valsStr)");
    if ($stmt) {
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();
    } else {
        error_log('Prepare Error: ' . $link->error);
        $_SESSION['error'] = 'Ошибка при добавлении записи';
    }
}

// 🔥 САМОЕ ВАЖНОЕ: Проверка execute() 🔥
$executed = $stmt->execute();

if (!$executed) {
    error_log('EXECUTE ERROR: ' . $stmt->error);
    $_SESSION['error'] = 'Не удалось добавить запись: ' . $stmt->error;
    $stmt->close();
    $_SESSION['selected_table'] = $tableName;
    header('Location: /profile.php');
    exit;
}

// Возврат на профиль
$_SESSION['selected_table'] = $tableName;
header('Location: /profile.php');
exit;

?>