<?php
session_start();
include __DIR__ . '/includes/func.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['password']) && isset($_SESSION['user']['ID'])) {
    $userID = $_SESSION['user']['ID'];
    $newPassword = $data['password'];

    if (!empty($newPassword) && strlen($newPassword) > 6) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        updatePassword($userID, $hashedPassword);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Password must be more than 6 characters']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>