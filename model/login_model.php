<?php
include __DIR__ . '/db.php';

function login($username, $password) {
    global $db;

    $sql = "SELECT * FROM /* DATABASE NAME HERE */ WHERE username = :username";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
    #header('Location: ---LOCATION HERE--- ');
    exit();
}

?>