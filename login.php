<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Quest</title>
</head>
<body>

    <div>

        <div id="slide">
            <!-- Picture Slideshow Here -->
        </div>

        <div>

        <header>

            <h1>Login</h1>

            <h4>Don't Have an Account? <a href="login.php">Register</a></h4>

        </header>

        <main>

            <form action="register.php" method="post">

                <input type="text" name="username" placeholder="User Name" required>

                <input type="text" name="password" placeholder="Password" required>

            </form>

            <button type="submit">Register</button>

        </main>

        <footer>

            <input type="checkbox" name="terms" required> I agree to the <a href="terms.php">Terms of Service</a>

            <a href="dashboard.php">back to website</a>
            
        </footer>
    
    </div>
    
</body>
</html>