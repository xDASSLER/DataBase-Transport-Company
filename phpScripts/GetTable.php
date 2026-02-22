<?php 
session_start();
require_once('linkBD/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['selected_table'] != null) {
    $selectedTable = $_POST['selected_table'];
    
    // Запрос данных таблицы
    $query = "SELECT * FROM `$selectedTable`";
    $dataResult = mysqli_query($link, $query);
    
    if ($dataResult) 
        {
        // Получение названия столбцов
        $columns = [];
        $fieldInfo = mysqli_fetch_fields($dataResult);
        foreach ($fieldInfo as $field) {
            $columns[] = $field->name;
        }
        
        // Получение данных строк
        $tableData = mysqli_fetch_all($dataResult, MYSQLI_ASSOC);
        
        // Сохранение
        $_SESSION['selected_table'] = $selectedTable;
        $_SESSION['table_data'] = $tableData;
        $_SESSION['columns'] = $columns;
        
        header('Location: /profile.php');
        exit;
        } 
    else 
    {
    header('Location: /profile.php');
    exit;
}
}
?>

