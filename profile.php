<?php
    session_start();
    require_once('phpScripts/SelectTable.php');
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
                        <option value="" disabled selected>Выберите таблицу</option>
            <?php foreach ($tables as $table): //Перебор элементов массива и запись во временную переменную ?> 
                <option value="<?php echo htmlspecialchars($table); ?>">
                    <?php echo htmlspecialchars($table); ?>
                </option>
            <?php endforeach; ?>
                    </select>
                <button type="submit">Выбрать</button>
                    </div>
            </form>


<?php if (!empty($selectedTable) && !empty($tableData) && !empty($columns)): //Отображение данных таблицы?>
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

                
<?php if ($selectedTable === 'транспорт' || $selectedTable === 'маршрут'): // Форма для добавления строк?>
            <div class="addForm">
                <div class="FormTitle">Добавить новую строку в таблицу <?php echo htmlspecialchars($selectedTable); ?>
                </div>
                <form class = "simpleForm" method="POST" action="/phpScripts/AddRecord.php">
                     <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($selectedTable); ?>">
                    <?php foreach ($columns as $column): ?>
                            <input class = "inputTable" type="text" name="<?php echo htmlspecialchars($column); ?>" 
                            placeholder="<?php echo htmlspecialchars($column); ?>" required>
                    <?php endforeach; ?>
                    <button type="submit">Добавить запись</button>
                </form>
            </div>
        <?php endif; ?>
    <?php endif; ?>

<?php if ($selectedTable === 'груз'): //Форма для удаления строк ?>
    <div class="addForm">
        <div class="FormTitle">Удалить запись из таблицы: <?php echo htmlspecialchars($selectedTable); ?></div>
        <form method="POST" action="/phpScripts/DeleteRecord.php" class="simpleForm">
            <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($selectedTable); ?>">
            <select name="record_id" class="simpleInput" required>
                <option value="" disabled selected>Выберите запись для удаления</option>
                <?php foreach ($tableData as $row): ?>
                    <?php
                        $id = isset($row['Id']) ? (int)$row['Id'] : null;
                    ?>
                    <?php if ($id !== null): ?>
                        <option value="<?php echo $id; ?>">
                            <?php echo $id; ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            
            <button type="submit">Удалить</button>
        </form>
    </div>
<?php endif; ?>


    </fieldset>

<footer>

</footer>
</body>
</html>