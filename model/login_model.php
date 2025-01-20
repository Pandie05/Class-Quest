<?php
    include __DIR__ . '/db.php';

    function login($username, $password) {
        global $db;

        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['password'] === $password) {
            session_start();
            $_SESSION['user'] = $user;
            return $user;
        }

        return false;
    }

    function logout() {
        session_start();
        header('Location: dashboard.php');
        session_destroy();
        header('Location: dashboard.php');
        exit();
    }

?>