<?php
include __DIR__ . '/includes/gyatt.php';
include __DIR__ . '/includes/func.php';
include __DIR__ . '/model/db.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user']['ID'];

// Handle pet type change
if (isset($_POST['pokemon'])) {
    try {
        $sql = "UPDATE pets SET pokemon = ? WHERE userID = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['pokemon'], $userId]);
    } catch (PDOException $e) {
        $error = "Error updating pet: " . $e->getMessage();
        header('Location: dashboard.php?error=' . urlencode($error));
        exit();
    }
}

// Handle pet name change
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user']['ID'];
    
    if (isset($_POST['pokemon'])) {
        $sql = "UPDATE pets SET pokemon = ?, petname = ? WHERE userID = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['pokemon'], $_POST['petname'], $userId]);
    }

    header('Location: dashboard.php');
    exit();
}

header('Location: dashboard.php');
exit();
?>