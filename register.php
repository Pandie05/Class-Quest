<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Quest</title>
</head>
<body>

    <div>

        <div id="slide"> <!-- Slideshow div-->

            <!-- Picture Slideshow Here -->

        </div>

        <div> <!-- This is the main content div -->

            <header>
                <h1>Create Account</h1>

                <h4>Already Have an Account? <a href="login.php">Log In</a></h4>

            </header>

            <main>

                <form action="register.php" method="post">

                    <input type="text" name="schoolname" placeholder="School Name" required>

                    <input type="text" name="email" placeholder="Email" required>

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

    </div>
</body>
</html>