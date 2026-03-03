<?php 
require_once('linkBD/dbconnect.php');

// Получение данных для редактирования
$id = $_GET['id'] ?? null;
$editData = null;
$statuses = [];

if ($id) {
    // Подготовка запроса (mysqli)
    $stmt = $link->prepare("SELECT * FROM рейс WHERE Id = ?");
    $stmt->bind_param("i", $id);  // "i" = integer
    $stmt->execute();
    $result = $stmt->get_result();
    $editData = $result->fetch_assoc();
    $stmt->close();
}

// Получение статусов из другой таблицы
$result = $link->query("SELECT * FROM `status`");
while ($row = $result->fetch_array()) 
{
    $statuses[] = $row;
}

// Получение списка маршрутов из другой таблицы
$result_Marshruts = $link->query("SELECT * FROM `маршрут`");
while($row = $result_Marshruts->fetch_array())
{
    $Marshruts[] = $row;
}

// Получение списка транспорта из другой таблицы
$result_Car = $link->query("SELECT * FROM `транспорт`");
while($row = $result_Car->fetch_array())
{
    $Cars[] = $row; 
} 

// Обработка сохранения
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
    $Marshrut = $_POST['Marshrut'];
    $Car = $_POST['Car'];
    $departure = $_POST['departure_date'];
    $arrival = $_POST['arrival_date'];
    $status = $_POST['status'];

    $departure = !empty($_POST['departure_date']) ? $_POST['departure_date'] : null;
    $arrival = !empty($_POST['arrival_date']) ? $_POST['arrival_date'] : null;
    
    $stmt = $link->prepare("UPDATE рейс SET Маршрут = ?, Транспорт = ?, Дата_Отправления = ?, Дата_Прибытия = ?, Статус = ? WHERE Id = ?");
    $stmt->bind_param("sssssi", $Marshrut,$Car, $departure, $arrival, $status, $id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: /Profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>profile</title>
    <link rel="stylesheet" href="/css/font3.css">
</head>
<body>

<div class="form-container">
    <h2>Редактирование рейса №<?= htmlspecialchars($editData['Id']) ?></h2>
     
    <form method="POST">

        <div class="form-group">
            <label for="Marshrut">Маршрут:</label>
            <select id="Marshrut" name="Marshrut" required>
                <?php foreach ($Marshruts as $Marshrut): ?>
                    <option value="<?= $Marshrut['Id'] ?>" 
                        <?= $editData['Маршрут'] == $Marshrut['Id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($Marshrut['Наименование'] ?? $Marshrut['Id']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Car">Транспорт:</label>
            <select id="Car" name="Car" required>
                <?php foreach ($Cars as $Car): ?>
                    <option value="<?= $Car['Id'] ?>" 
                        <?= $editData['Транспорт'] == $Car['Id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($Car['Наименование'] ?? $Car['Id']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="departure_date">Дата отправления:</label>
            <input 
                type="datetime-local" 
                id="departure_date" 
                name="departure_date" 
                value="<?= !empty($editData['Дата_Отправления']) ? date('Y-m-d\TH:i', strtotime($editData['Дата_Отправления'])) : '' ?>"
            >
        </div>

        <div class="form-group">
            <label for="arrival_date">Дата прибытия:</label>
            <input 
                type="datetime-local" 
                id="arrival_date" 
                name="arrival_date" 
                value="<?= !empty($editData['Дата_Прибытия']) ? date('Y-m-d\TH:i', strtotime($editData['Дата_Прибытия'])) : '' ?>"
            >
        </div>
        
        <div class="form-group">
            <label for="status">Статус:</label>
            <select id="status" name="status" required>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?= $status['Id'] ?>" 
                        <?= $editData['Статус'] == $status['Id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($status['Статус'] ?? $status['Id']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="ButtonText">
            <button type="submit" class="btn-save">Сохранить</button>
            <a href="/Profile.php"><button type="button" class="btn-cancel">Отмена</button></a>
        </div>
    </form>
</div>

</body>
</html>