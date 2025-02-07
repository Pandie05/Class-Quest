<?php
session_start();
include __DIR__ . '/includes/func.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['password']) && isset($_SESSION['user']['ID'])) {
    $userID = $_SESSION['user']['ID'];
    $newPassword = $data['password']; // Reminder: Hash the password before storing it in the database

    updatePassword($userID, $newPassword);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>