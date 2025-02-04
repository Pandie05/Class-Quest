<?php
include __DIR__ . '/includes/gyatt.php';
include __DIR__ . '/includes/func.php';
include __DIR__ . '/model/db.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Check if form was submitted and pokemon value exists
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pokemon'])) {
    
    $userId = $_SESSION['user']['ID'];
    $newPokemon = $_POST['pokemon'];
    
    try {
        // Update the pokemon column in the pets table
        $sql = "UPDATE pets SET pokemon = ? WHERE userID = ?";
        $stmt = $db->prepare($sql);  // Changed from $pdo to $db
        $stmt->execute([$newPokemon, $userId]);
        
        // Redirect back to profile page on success
        header('Location: profile.php');
        exit();
        
    } catch (PDOException $e) {
        // Handle any database errors
        $error = "Error updating pet choice: " . $e->getMessage();
        // Redirect back with error
        header('Location: profile.php?error=' . urlencode($error));
        exit();
    }
    
} else {
    // If accessed directly without POST data, redirect to profile
    header('Location: profile.php');
    exit();
}
?>