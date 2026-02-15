<?php 
require_once('linkBD/dbconnect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['selected_table'] != null) {
    $selectedTable = $_POST['selected_table'];
    
    // Запрос данных таблицы
    $query = "SELECT * FROM `$selectedTable`";
    $dataResult = mysqli_query($link, $query);
    
    if ($dataResult) 
        {
        // Получаем названия столбцов
        $columns = [];
        $fieldInfo = mysqli_fetch_fields($dataResult);
        foreach ($fieldInfo as $field) {
            $columns[] = $field->name;
        }
        
        // Получаем данные строк
        $tableData = mysqli_fetch_all($dataResult, MYSQLI_ASSOC);
        
        // Сохраняем данные в сессии
        $_SESSION['selected_table'] = $selectedTable;
        $_SESSION['table_data'] = $tableData;
        $_SESSION['columns'] = $columns;
        
        header('Location: /profile.php');
        exit;
        } 
    else 
    {
    // Если форма не отправлена, возвращаем на профиль
    header('Location: /profile.php');
    exit;
}
}
?>

