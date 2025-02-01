<?php
include __DIR__ . '/includes/gyatt.php';
include __DIR__ . '/includes/func.php';
include __DIR__ . '/model/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $done = $data['done'];

    $sql = "UPDATE assignments SET done = :done WHERE id = :id AND userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':done', $done, PDO::PARAM_BOOL);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $_SESSION['user_id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->errorInfo()]);
    }
}
?>