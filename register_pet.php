<?php 

include __DIR__ . '/includes/gyatt.php';
include __DIR__ . '/model/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $petname = $_POST['petname'];
    $pettype = $_POST['pettype'];
    $userID = $_POST['userID'];

    // Insert pet information into the pets table
    $sql = "INSERT INTO pets (userID, petname, pokemon) VALUES (:userID, :petname, :pokemon)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':petname', $petname, PDO::PARAM_STR);
    $stmt->bindParam(':pokemon', $pettype, PDO::PARAM_STR);
    $stmt->execute();

    header('Location: dashboard.php');
    exit();
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

                <h1>Add Your Pet</h1>

            </div>

            <div class = "login">

                <form action="register_pet.php" method="POST">

                    <input type="hidden" name="userID" value="<?php echo htmlspecialchars($_GET['userID']); ?>" required>

                    <input type="text" name="petname" placeholder="Pet Name" required>

                    <div class="pet-selection">
                        <button type="submit" name="pettype" value="absol">
                            <img src="images/absol-mega.gif" alt="Absol">
                        </button>
                        <button type="submit" name="pettype" value="blaziken">
                            <img src="images/charizard.gif" alt="Blaziken">
                        </button>
                        <button type="submit" name="pettype" value="venasaur">
                            <img src="images/venasaur.gif" alt="Venasaur">
                        </button>
                        <button type="submit" name="pettype" value="thundurus">
                            <img src="images/thundurus.gif" alt="Thundurus">
                        </button>
                        <button type="submit" name="pettype" value="pangoru">
                            <img src="images/pangoru.gif" alt="Pangoru">
                        </button>
                        <button type="submit" name="pettype" value="snorlax">
                            <img src="images/snorlax.gif" alt="Snorlax">
                        </button>
                        <button type="submit" name="pettype" value="scizor">
                            <img src="images/scizor.gif" alt="Scizor">
                        </button>
                        <button type="submit" name="pettype" value="celebi">
                            <img src="images/celebi.gif" alt="Celebi">
                        </button>
                        <button type="submit" name="pettype" value="umbreon">
                            <img src="images/umbreon.gif" alt="Umbreon">
                        </button>
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
    
</body>
</html>