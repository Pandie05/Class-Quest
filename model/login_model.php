<?php
    include __DIR__ . '/db.php';

    function login($username, $password) {
        global $db;
        
        $sql = "SELECT ID, username, password, email FROM users WHERE username = :username";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && $user['password'] === $password) {
            // Return the user data instead of true
            return $user;
        }
        
        return false;
    }