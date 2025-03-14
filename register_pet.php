<?php 

include __DIR__ . '/includes/gyatt.php';
include __DIR__ . '/model/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $petname = $_POST['petname'];
    $pokemon = $_POST['pokemon'];
    $userID = $_POST['userID'];

    // Check if the user already has a pet
    $sql = "SELECT * FROM pets WHERE userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $existingPet = $stmt->fetch();

    if ($existingPet) {
        // Update the existing pet record
        $sql = "UPDATE pets SET petname = :petname, pokemon = :pokemon WHERE userID = :userID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':petname', $petname, PDO::PARAM_STR);
        $stmt->bindParam(':pokemon', $pokemon, PDO::PARAM_STR);
        $stmt->execute();
    } else {
        // Insert a new pet record
        $sql = "INSERT INTO pets (userID, petname, pokemon) VALUES (:userID, :petname, :pokemon)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':petname', $petname, PDO::PARAM_STR);
        $stmt->bindParam(':pokemon', $pokemon, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Log the user in
    $_SESSION['user'] = ['ID' => $userID];

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
    <link rel="stylesheet" href="styles/pet-reg.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="pet-wrapper">
        <div class="header">
            <h1>Pick Your Pet</h1>
        </div>

        <div class="pet-picker">
            <form class="pet-pick" action="register_pet.php" method="POST">
                <input type="hidden" name="userID" value="<?php echo htmlspecialchars($_GET['userID']); ?>" required>
                <input class="petname-input" type="text" name="petname" placeholder="Pet Name" maxlength="15" required>

                <div class="pet-selection">
                    <label>
                        <input type="radio" name="pokemon" value="shinx" required>
                        <img src="images/shinx.gif" alt="Shinx">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="zorua" required>
                        <img src="images/zorua.gif" alt="Zorua">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="ralts" required>
                        <img src="images/ralts.gif" alt="Ralts">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="toxel" required>
                        <img src="images/toxel.gif" alt="Toxel">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="charcadet" required>
                        <img src="images/charcadet.gif" alt="Charcadet">
                    </label>
                    
                </div>

                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="25" viewBox="0 0 24 24">
                        <path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="m14 16l4-4m0 0l-4-4m4 4H6"/>
                    </svg>
                </button>
            </form>

            <?php if (isset($error)): ?>
                <p class="log-err" style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
        </div>

        <div class="back-to-home">
            <a href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m4 10l-.707.707L2.586 10l.707-.707zm17 8a1 1 0 1 1-2 0zM8.293 15.707l-5-5l1.414-1.414l5 5zm-5-6.414l5-5l1.414 1.414l-5 5zM4 9h10v2H4zm17 7v2h-2v-2zm-7-7a7 7 0 0 1 7 7h-2a5 5 0 0 0-5-5z"/>
                </svg>
            </a>
        </div>        
    </div>

</body>
</html>
