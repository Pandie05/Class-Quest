<?php
session_start();
include __DIR__ . '/includes/func.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['password']) && isset($_SESSION['user']['ID'])) {
    $userID = $_SESSION['user']['ID'];
    $newPassword = $data['password']; // Reminder: Hash the password before storing it in the database

    if (!empty($newPassword)) {
        updatePassword($userID, $newPassword);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Password cannot be empty']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>