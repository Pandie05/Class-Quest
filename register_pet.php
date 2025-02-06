<?php 

include __DIR__ . '/includes/gyatt.php';
include __DIR__ . '/model/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $petname = $_POST['petname'];
    $pokemon = $_POST['pokemon'];
    $userID = $_POST['userID'];

    // Insert pet information into the pets table
    $sql = "INSERT INTO pets (userID, petname, pokemon) VALUES (:userID, :petname, :pokemon)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':petname', $petname, PDO::PARAM_STR);
    $stmt->bindParam(':pokemon', $pokemon, PDO::PARAM_STR);
    $stmt->execute();

    header('Location: login.php');
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
                <input class="petname-input" type="text" name="petname" placeholder="Pet Name" required>

                <div class="pet-selection">
                    <label>
                        <input type="radio" name="pokemon" value="absol" required>
                        <img src="images/absol-mega.gif" alt="Absol">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="blaziken" required>
                        <img src="images/charizard.gif" alt="Blaziken">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="venasaur" required>
                        <img src="images/venasaur.gif" alt="Venasaur">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="thundurus" required>
                        <img src="images/thundurus.gif" alt="Thundurus">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="pangoro" required>
                        <img src="images/pangoro.gif" alt="Pangoro">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="snorlax" required>
                        <img src="images/snorlax.gif" alt="Snorlax">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="scizor" required>
                        <img src="images/scizor.gif" alt="Scizor">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="celebi" required>
                        <img src="images/celebi.gif" alt="Celebi">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="umbreon" required>
                        <img src="images/umbreon.gif" alt="Umbreon">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="rayquaza" required>
                        <img src="images/rayquaza-mega.gif" alt="Rayquaza">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="obstagoon" required>
                        <img src="images/obstagoon.gif" alt="Obstagoon">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="tyrantrum" required>
                        <img src="images/tyrantrum.gif" alt="Tyrantrum">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="swampert" required>
                        <img src="images/swampert.gif" alt="Swampert">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="spinda" required>
                        <img src="images/spinda.gif" alt="Spinda">
                    </label>
                    <label>
                        <input type="radio" name="pokemon" value="gardevoir" <?php echo ($currentPokemon == 'gardevoir') ? 'checked' : ''; ?> required>
                        <img src="images/gardevoir.gif" alt="Gardevoir">
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
