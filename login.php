<?php 

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
            <div class="header">

                <h1>Welcome Back!</h1>

                <h4>Don't Have an Account? <a href="register.php">Register</a></h4>

            </div>

            <div class = "login">

                <form action="login.php" method="POST">

                    <input type="text" name="username" placeholder="User Name" required>

                    <input type="password" name="password" placeholder="Password" required>

                    <button type="submit">Login</button>

                </form>

                <?php if (isset($error)): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>

            </div>

            <div class="terms-back">

                <input type="checkbox" name="terms" required> I agree to the <a href="terms.php">Terms of Service</a>

                <a href="dashboard.php">back to website</a>
                
            </div>
        </div>
    
    </div>

    <script src="scripts/login.js"></script>
    
</body>
</html>