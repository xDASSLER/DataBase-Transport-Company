<?php
require_once('linkBD/dbconnect.php');
session_start();

// Получение данных из формы
$id = intval($_POST['Id'] ?? 0);  
$marshrut = intval($_POST['Маршрут'] ?? 0);
$transport = intval($_POST['Транспорт'] ?? 0);
$status = intval($_POST['Статус'] ?? 0);
$departure = $_POST['Дата_Отправления'] ?? null;
$arrival = $_POST['Дата_Прибытия'] ?? null;

// Конвертация дат
if ($departure) 
    { 
    $departure = str_replace('T', ' ', $departure); 
    if (strlen($departure)===16) $departure .= ':00'; 
    }
else 
    {
    $departure = NULL;  
    }
if ($arrival) 
    { 
    $arrival = str_replace('T', ' ', $arrival); 
    if (strlen($arrival)===16)   $arrival   .= ':00'; 
    }
else 
    {
    $arrival = NULL; 
    }

$sql = "INSERT INTO `рейс` (`Id`, `Маршрут`, `Транспорт`, `Дата_Отправления`, `Дата_Прибытия`, `Статус`) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $link->prepare($sql);
if (!$stmt) {
    $_SESSION['db_error'] = 'Ошибка БД: ' . $link->error;
    header('Location: /Profile.php'); exit;
}

$stmt->bind_param("iiissi", $id, $marshrut, $transport, $departure, $arrival, $status);

if ($stmt->execute()) {
    $_SESSION['db_success'] = 'Рейс';
} else {
    $_SESSION['db_error'] = '' . $stmt->error;
}

$stmt->close();
$link->close();

$_SESSION['selected_table'] = 'рейс';
header('Location: /Profile.php');
exit;
?>