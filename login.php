<?php 

session_start();

include __DIR__ . '/model/login_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {

        die('Username or password is empty');
        
    }

    $user = login($username, $password);

    if ($user) {

        if (session_status() == PHP_SESSION_NONE) {

            session_start();

        }

        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit();
        
    } else {

        $error = 'Invalid username or password.';

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Quest</title>
    <link rel="stylesheet" href="styles/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="wrapper">

    <div class="logo">
        <img src="images/logo.png" alt="">
    </div>
    <div class="slide-show">
        <img src="images/login-wall-1.jpg" alt="">
        <img src="images/login-wall-2.png" alt="">
        <img src="images/pet-bg.jpg" alt="">
        <div class="indicators">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
        <div class="catch-p">
            <p>Find the motivation to get your work done.</p>
        </div>
    </div>

        

        <div class="login-wrapper">

        <div class="login-center">
            <div class="header">

                <h1>Welcome Back!</h1>

                <h4>Don't Have an Account? <a href="register.php">Register</a></h4>

            </div>

            <div class = "login">

                <form action="login.php" method="POST">

                    <input type="text" name="username" placeholder="User Name" required>

                    <div class="password-input">
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <svg id="togglePassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#8d8b97" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/></svg>
                    </div>

                    <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="25" viewBox="0 0 24 24"><path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="m14 16l4-4m0 0l-4-4m4 4H6"/></svg>
                    </button>

                </form>

                <?php if (isset($error)): ?>
                    <p class="log-err" style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>

            </div>

            <div class="back-to-home">
                <a href="index.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m4 10l-.707.707L2.586 10l.707-.707zm17 8a1 1 0 1 1-2 0zM8.293 15.707l-5-5l1.414-1.414l5 5zm-5-6.414l5-5l1.414 1.414l-5 5zM4 9h10v2H4zm17 7v2h-2v-2zm-7-7a7 7 0 0 1 7 7h-2a5 5 0 0 0-5-5z"/></svg></a>
            </div>
            </div>
        </div>
    
    </div>

    <script src="scripts/login.js"></script>
    
</body>
</html>