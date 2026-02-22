<?php 
session_start();
require_once('linkBD/dbconnect.php');


// Получение данных
$tableName = $_POST['table_name'] ?? '';
$recordId  = $_POST['record_id'] ?? null;

$recordId = (int)$recordId;

$stmt = $link->prepare("DELETE FROM `$tableName` WHERE Id = ?");

// Привязка параметра (i = integer)
$stmt->bind_param("i", $recordId);

if ($stmt->execute()) {
    
    $deleted = $stmt->affected_rows > 0;
    $stmt->close();
    $link->close();
    
    // Редирект с результатом
    if ($deleted) {
        header("Location: /profile.php");
    }

} else {
    $stmt->close();
    $link->close();
    header("Location: /profile.php");
    exit;
}
?>



