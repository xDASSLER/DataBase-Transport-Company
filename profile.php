<?php
    require_once('phpScripts/SelectTable.php');
    session_start();
    if (empty($_SESSION['login'])) 
    {
        header('location: /index.php');
        die();
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
    <fieldset>
        <legend class = "StaticText"> Выберите таблицу базы данных из выпадающего списка. </legend>
        <!-- Форма для отправки данных -->
    <form method="post" action="phpScripts/SelectTable.php">
        <!-- Подпись к выпадающему списку -->
        <label for="tableSelect">Таблица:</label>
        
        <!-- Выпадающий список для выбора таблицы -->
        <select id="tableSelect" name="selected_table" required>
            <!-- Пустой вариант по умолчанию -->
            <option value="">-- Выберите таблицу --</option>
            
            <!-- PHP-цикл для генерации опций из массива таблиц -->
            <?php foreach ($tables as $table): ?>
                <!-- Каждая опция списка -->
                <option value="<?php echo htmlspecialchars($table); ?>">
                    <!-- Текст опции (название таблицы) -->
                    <?php echo htmlspecialchars($table); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <!-- Кнопка отправки формы -->
        <button type="submit">Выбрать</button>

    </form>
    </fieldset>

<footer>

</footer>
</body>
</html>