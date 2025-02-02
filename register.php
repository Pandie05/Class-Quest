<?php 

include __DIR__ . '/includes/gyatt.php';
include __DIR__ . '/model/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if email or username already exists
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR username = :username");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $error = 'Email or username already exists.';
    } else {
        // Insert into users
        $sql = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        header('Location: profile.php');
        exit();
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

    <img src="images/bg.png" alt="" class="background-image">
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

                <h1>Create An Account</h1>

                <h4>Already Have an Account? <a href="login.php">Login</a></h4>

            </div>

            <div class = "login">

                <form action="register.php" method="POST">

                    <input type="text" name="email" placeholder="Email" required>

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

                <div class="terms">
                    <input type="checkbox" class="ui-checkbox"> I agree to the <a href="#" id="terms-link">Terms of Service</a>
                </div>

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