<?php
    session_start();
    
    // make a check to see if admin bool is set to 1
    if(!isset($_SESSION['user'])){
        header('location:login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles/admin.css">
    <link rel="stylesheet" href="styles/nav.css">
</head>
<body>
    
</body>
</html>