<?php
    session_start();
     error_reporting(E_ALL);
     ini_set('display_errors', 1); //отладка
    require_once('phpScripts/SelectTable.php');
    require_once('phpScripts/linkBD/dbconnect.php');
    $is_role = '';
    
    //Получение данных с сессии
    $selectedTable = $_SESSION['selected_table'] ?? '';
    $tableData = $_SESSION['table_data'] ?? [];
    $columns = $_SESSION['columns'] ?? [];
    $error = $_SESSION['error'] ?? '';

    if (empty($_SESSION['login'])) //Проверка роли вхожденного пользователя
    {
        header('location: /index.php');
        die();
    }
    elseif(($_SESSION['login']) === 'Admin')
    {
        $is_role = 'Admin';
    }
    elseif (($_SESSION['login']) === 'Operator')
    {
        $is_role = 'Operator';
    }

if ($is_role === 'Admin')
{
    $selectedTable = 'транспорт';
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
        }
    
    $selectedTable2 = 'маршрут';
    $query2 = "SELECT * FROM `$selectedTable2`";
    $dataResult2 = mysqli_query($link, $query2);
    
        if ($dataResult2) 
        {
            // Получение названия столбцов
            $columns2 = [];
            $fieldInfo2 = mysqli_fetch_fields($dataResult2);
            foreach ($fieldInfo2 as $field2) {
                $columns2[] = $field2->name;
        }
        
        // Получение данных строк
        $tableData2 = mysqli_fetch_all($dataResult2, MYSQLI_ASSOC);
        }
}

    elseif ($is_role === 'Operator') 
    {
        $selectedTable = 'рейс';
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

        // Справочник
        $lookup = [];
        
        // Справочник маршрутов
        $res = mysqli_query($link, "SELECT Id, Наименование FROM `маршрут`");
        while($r = mysqli_fetch_assoc($res)) {
            $lookup['Маршрут'][$r['Id']] = $r['Наименование'];
        }
        
        // Справочник транспорта
        $res = mysqli_query($link, "SELECT Id, Наименование FROM `транспорт`");
        while($r = mysqli_fetch_assoc($res)) {
            $lookup['Транспорт'][$r['Id']] = $r['Наименование'];
        }
        
        // Справочник статусов
        $res = mysqli_query($link, "SELECT Id, Статус FROM `status`");
        while($r = mysqli_fetch_assoc($res)) {
            $lookup['Статус'][$r['Id']] = $r['Статус'];
        }
        
        // Замена ID на названия
        foreach ($tableData as &$row) {
            if (isset($lookup['Маршрут'][$row['Маршрут']])) {
                $row['Маршрут'] = $lookup['Маршрут'][$row['Маршрут']];
            }
            if (isset($lookup['Транспорт'][$row['Транспорт']])) {
                $row['Транспорт'] = $lookup['Транспорт'][$row['Транспорт']];
            }
            if (isset($lookup['Статус'][$row['Статус']])) {
                $row['Статус'] = $lookup['Статус'][$row['Статус']];
            }
        }
        unset($row);

            $_SESSION['selected_table'] = $selectedTable;
            $_SESSION['table_data'] = $tableData;
            $_SESSION['columns'] = $columns;
        }
    }
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

<?php if ($is_role === 'Admin'): ?>
<fieldset>
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

        <?php if ($selectedTable === 'транспорт'): // Форма для добавления строк?>
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

        <?php if (!empty($selectedTable2) && !empty($tableData2) && !empty($columns2)): //Отображение данных таблицы?>
        <div class = 'info'>
        Информация по выбранной таблице:
            <span>|</span>
        <strong>Название:</strong> <?php echo htmlspecialchars($selectedTable2); ?> 
            <span>|</span>
        <strong>Записей:</strong> <?php echo count($tableData2); ?> 
            <span>|</span>
        <strong>Столбцов:</strong> <?php echo count($columns2); ?>
        </div>
        
        <div class = 'table'>
        <table>
            <thead>
                <tr>
                    <?php foreach ($columns2 as $column2): ?>
                        <th><?php echo htmlspecialchars($column2); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tableData2 as $row2): ?>
                    <tr>
                        <?php foreach ($columns2 as $column2): ?>
                            <td><?php echo htmlspecialchars($row2[$column2]); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <?php endif; ?>
                
<?php if ($selectedTable2 === 'маршрут'): // Форма для добавления строк?>
            <div class="addForm">
                <div class="FormTitle">Добавить новую строку в таблицу <?php echo htmlspecialchars($selectedTable2); ?>
                </div>
                <form class = "simpleForm" method="POST" action="/phpScripts/AddRecord.php">
                     <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($selectedTable2); ?>">
                    <?php foreach ($columns2 as $column2): ?>
                            <input class = "inputTable" type="text" name="<?php echo htmlspecialchars($column2); ?>" 
                            placeholder="<?php echo htmlspecialchars($column2); ?>" required>
                    <?php endforeach; ?>
                    <button type="submit">Добавить запись</button>
                </form>
            </div>
        <?php endif; ?>



<?php elseif($is_role === 'Operator'): ?>
    <fieldset>

<?php if (!empty($selectedTable) && !empty($tableData) && !empty($columns)): //Отображение данных таблицы?>
        <div class = 'info'>
        Информация по таблице:
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
                         <td>
                            <a href="phpScripts/edit.php?id=<?php echo $row['Id']; ?>">Редактировать</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>

   
<div class="addForm">
    <div class="FormTitle">Добавить новый рейс</div>
    <form class="simpleForm" method="POST" action="/phpScripts/AddRecordOperator.php">
        <input type="hidden" name="table_name" value="рейс">

        <!-- Поле ID -->
        <div class="form-group">
            <input class="inputTable" type="number" id="id" name="Id" required placeholder="Введите Id"
            >
        </div>
        
        <!-- Маршрут -->
        <div class="form-group">
            <select class="inputTable" id="Marshrut" name="Маршрут" required>
                <option value="">Выберите маршрут</option>
                <?php
                $result_Marshruts = $link->query("SELECT * FROM `маршрут`");
                while($row = $result_Marshruts->fetch_array()) {
                    echo '<option value="' . htmlspecialchars($row['Id']) . '">' 
                         . htmlspecialchars($row['Наименование'] ?? $row['Id']) 
                         . '</option>';
                }
                ?>
            </select>
        </div>
        
        <!-- Транспорт  -->
        <div class="form-group">
            <select class="inputTable" id="Car" name="Транспорт" required>
                <option value="">Выберите транспорт</option>
                <?php
                $result_Car = $link->query("SELECT * FROM `транспорт`");
                while($row = $result_Car->fetch_array()) {
                    echo '<option value="' . htmlspecialchars($row['Id']) . '">' 
                         . htmlspecialchars($row['Наименование'] ?? $row['Id']) 
                         . '</option>';
                }
                ?>
            </select>
        </div>
        
        <!-- Дата отправления -->
        <div class="form-group">
            <label class = "Label_input" for="departure_date">Дата отправления:</label>
            <input 
                class="inputTable" 
                type="datetime-local" 
                id="departure_date" 
                name="Дата_Отправления" 
                min="<?= date('Y-m-d\T00:00') ?>"
            >
        </div>
        
        <!-- Дата прибытия -->
        <div class="form-group">
            <label class = "Label_input" for="arrival_date">Дата прибытия:</label>
            <input 
                class="inputTable" 
                type="datetime-local" 
                id="arrival_date" 
                name="Дата_Прибытия" 
                min="<?= date('Y-m-d\T00:00') ?>"
            >
        </div>
        
        <!-- Статус -->
        <div class="form-group">
            <select class="inputTable" id="status" name="Статус" required>
                <option value="">Выберите статус</option>
                <?php
                $result_Status = $link->query("SELECT * FROM `status`");
                while($row = $result_Status->fetch_array()) {
                    echo '<option value="' . htmlspecialchars($row['Id']) . '">' 
                         . htmlspecialchars($row['Статус'] ?? $row['Id']) 
                         . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="submit">Добавить рейс</button>
    </form>
</div>



    </fieldset>
    <?php endif; ?>
<?php endif; ?>


<footer>

</footer>
</body>
</html>