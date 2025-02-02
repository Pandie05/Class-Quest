<?php
include __DIR__ . '/includes/gyatt.php';
include __DIR__ . '/includes/func.php';
include __DIR__ . '/model/db.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$assignmentId = $data['id'] ?? null;

if ($assignmentId) {
    try {
        $sql = "DELETE FROM assignments WHERE id = :id AND userID = :userID";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $assignmentId,
            ':userID' => $_SESSION['user_id']
        ]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid assignment ID']);
}