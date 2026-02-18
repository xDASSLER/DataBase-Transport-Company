<?php
    require_once('phpScripts/SelectTable.php');
    session_start();
    if (empty($_SESSION['login'])) 
    {
        header('location: /index.php');
        die();
    }
    //Получение данных с сессии
    $selectedTable = $_SESSION['selected_table'] ?? '';
    $tableData = $_SESSION['table_data'] ?? [];
    $columns = $_SESSION['columns'] ?? [];
    $error = $_SESSION['error'] ?? '';

    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>profile</title>
    <link rel="stylesheet" href="css/font2.css">
</head>
<body>
<header> 
    <span class = "Word_Space">Добро пожаловать: <img src="img/ProfilePhoto.png" width="20" height="20">      
    <?=htmlspecialchars($_SESSION['login']) ?></span> 
    <a href="phpScripts/logout.php">Выйти</a>
</header>

    <fieldset>
         <legend class = "StaticText"> Выберите таблицу базы данных из выпадающего списка. </legend>
            <form method="POST" action="/phpScripts/GetTable.php">
                <div class = "Select-Group">
                    <select id="tableSelect" name="selected_table">
                        <option value="">Выберите таблицу</option>
            <?php foreach ($tables as $table): //Перебор элементов массива и запись во временную переменную ?> 
                <option value="<?php echo htmlspecialchars($table); ?>">
                    <?php echo htmlspecialchars($table); ?>
                </option>
            <?php endforeach; ?>
                    </select>
                <button type="submit">Выбрать</button>
                    </div>
            </form>

    <!-- Отображение данных таблицы -->
    <?php if (!empty($selectedTable) && !empty($tableData) && !empty($columns)): ?>
        <div class = 'info'>
        Информация по выбранной таблице:
            <span>|</span>
        <strong>Название:</strong> <?php echo htmlspecialchars($selectedTable); ?> 
            <span>|</span>
        <strong>Записей:</strong> <?php echo count($tableData); ?> 
            <span>|</span>
        <strong>Столбцов:</strong> <?php echo count($columns); ?>
        </div>
        
        <div class = 'table'>
        <table>
            <thead>
                <tr>
                    <?php foreach ($columns as $column): ?>
                        <th><?php echo htmlspecialchars($column); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tableData as $row): ?>
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <td><?php echo htmlspecialchars($row[$column]); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>

                
        <?php if ($selectedTable === 'транспорт' || $selectedTable === 'маршрут'): // Форма для таблицы транспорт?>
            <div class="addForm">
                <div class="FormTitle">Добавить новую строку в таблицу "Транспорт"</div>
                <form method="POST" action="/phpScripts/AddRecord.php">
                    <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($selectedTable); ?>">
                    <?php foreach ($columns as $column): ?>
                            <input 
                                type="text" 
                                name="<?php echo htmlspecialchars($column); ?>" 
                                placeholder="<?php echo htmlspecialchars($column); ?>"
                            >
                    <?php endforeach; ?>
                    <button type="submit">Добавить запись</button>
                </form>
            </div>
        <?php endif; ?>

    <?php endif; ?>


    </fieldset>

<footer>

</footer>
</body>
</html>