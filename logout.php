<?php
    function logout() {
        session_start();
        session_destroy();
        header('Location: dashboard.php');
        exit();
    }

    logout();