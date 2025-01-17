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

                <h1>Login</h1>

                <h4>Don't Have an Account? <a href="login.php">Register</a></h4>

            </div>

            <div class = "login">

                <form action="register.php" method="post">

                    <input type="text" name="username" placeholder="User Name" required>

                    <input type="text" name="password" placeholder="Password" required>

                </form>

                <button type="submit">Register</button>

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