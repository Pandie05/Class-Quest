<?php
    include __DIR__ . '/includes/gyatt.php';
    include __DIR__ . '/includes/func.php';
    include __DIR__ . '/model/db.php';

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }

    $theme = getUserPetTheme($_SESSION['user']['ID']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Quest</title>

    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/themes.css">

</head>
<body class="theme-<?php echo $theme; ?>">

<nav>
        
        <a href="index.php" class="logo">
            <img src="images/logo.png" alt="">
        </a>

        <div class="icon-links" style="margin-top: 100px; gap: 30px;">
            
            <a class="dash-btn" href="dashboard.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12.204c0-2.289 0-3.433.52-4.381c.518-.949 1.467-1.537 3.364-2.715l2-1.241C9.889 2.622 10.892 2 12 2s2.11.622 4.116 1.867l2 1.241c1.897 1.178 2.846 1.766 3.365 2.715S22 9.915 22 12.203v1.522c0 3.9 0 5.851-1.172 7.063S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.212S2 17.626 2 13.725z"/><path stroke-linecap="round" d="M9 16c.85.63 1.885 1 3 1s2.15-.37 3-1"/></g></svg>
            </a>
            <a class="home-btn" href="calendar.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path stroke="currentColor" stroke-width="1.5" d="M2 12c0-3.771 0-5.657 1.172-6.828S6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172S22 8.229 22 12v2c0 3.771 0 5.657-1.172 6.828S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172S2 17.771 2 14z"/><path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M7 4V2.5M17 4V2.5M2.5 9h19"/><path fill="currentColor" d="M18 17a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-5 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-5 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0"/></g></svg>
            </a>
            <a href="profile.php" class="pet-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linejoin="round" d="M4 18a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z"/><circle cx="12" cy="7" r="3"/></g></svg>
            </a>
            <a class="logout-btn" href="logout.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 20 20"><path fill="currentColor" fill-rule="evenodd" d="M3 3a1 1 0 0 0-1 1v12a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1m10.293 9.293a1 1 0 0 0 1.414 1.414l3-3a1 1 0 0 0 0-1.414l-3-3a1 1 0 1 0-1.414 1.414L14.586 9H7a1 1 0 1 0 0 2h7.586z" clip-rule="evenodd"/></svg>
            </a>
        <div>

    </nav>

    <div class="dashboard-wrapper">

        <div class="left-panel-2">

            <div class="breds">
                    
                <h1> 
                    <?php
                        $date = date('l, F j, Y');
                        $dateParts = explode(', ', $date);
                        $dayOfWeek = $dateParts[0];
                        $formattedDate = '<span>' . $dateParts[1] . ', ' . $dateParts[2] . '</span>';
                        echo $dayOfWeek . ', ' . $formattedDate;
                    ?>
                </h1>

            </div>

            <div>

                <div class="profile-info">
                    <h2>Hi!, <?php echo $_SESSION['user']['username']; ?></h2>
                    <p>Email: <?php echo $_SESSION['user']['email']; ?></p>
                    
                    <div class="password-input">
                        <label for="password">Password:</label>
                        <div style="position: relative;">
                            <input type="password" name="password" id="password" placeholder="Password" value="<?php echo $_SESSION['user']['password']; ?>" readonly style="padding-right: 30px;">
                            <svg id="togglePassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/>
                            </svg>
                        </div>
                    </div>

                    <script src="scripts/login.js"></script>
                </div>

                <div class="pet-picker">

                <?php $currentPokemon = getPetPokemon($_SESSION['user']['ID']); ?>

                    <form class="pet-pick" action="change_pet.php" method="POST">
                        <h6>Change your pet:</h6>

                        <div class="pet-name-section">
                            <label for="petname">Pet Name:</label>
                            <input type="text" name="petname" value="<?php echo htmlspecialchars(getPetName($_SESSION['user']['ID'])); ?>" placeholder="Name your pet">                        
                        </div>

                        <div class="pet-selection">
                            <label>
                                <input type="radio" name="pokemon" value="absol" <?php echo ($currentPokemon == 'absol') ? 'checked' : ''; ?> required>
                                <img src="images/absol-mega.gif" alt="Absol">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="blaziken" <?php echo ($currentPokemon == 'blaziken') ? 'checked' : ''; ?> required>
                                <img src="images/charizard.gif" alt="Blaziken">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="venasaur" <?php echo ($currentPokemon == 'venasaur') ? 'checked' : ''; ?> required>
                                <img src="images/venasaur.gif" alt="Venasaur">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="thundurus" <?php echo ($currentPokemon == 'thundurus') ? 'checked' : ''; ?> required>
                                <img src="images/thundurus.gif" alt="Thundurus">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="pangoro" <?php echo ($currentPokemon == 'pangoro') ? 'checked' : ''; ?> required>
                                <img src="images/pangoro.gif" alt="Pangoro">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="snorlax" <?php echo ($currentPokemon == 'snorlax') ? 'checked' : ''; ?> required>
                                <img src="images/snorlax.gif" alt="Snorlax">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="scizor" <?php echo ($currentPokemon == 'scizor') ? 'checked' : ''; ?> required>
                                <img src="images/scizor.gif" alt="Scizor">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="celebi" <?php echo ($currentPokemon == 'celebi') ? 'checked' : ''; ?> required>
                                <img src="images/celebi.gif" alt="Celebi">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="umbreon" <?php echo ($currentPokemon == 'umbreon') ? 'checked' : ''; ?> required>
                                <img src="images/umbreon.gif" alt="Umbreon">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="rayquaza" <?php echo ($currentPokemon == 'rayquaza') ? 'checked' : ''; ?> required>
                                <img src="images/rayquaza-mega.gif" alt="Rayquaza">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="obstagoon" <?php echo ($currentPokemon == 'obstagoon') ? 'checked' : ''; ?> required>
                                <img src="images/obstagoon.gif" alt="Obstagoon">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="tyrantrum" <?php echo ($currentPokemon == 'tyrantrum') ? 'checked' : ''; ?> required>
                                <img src="images/tyrantrum.gif" alt="Tyrantrum">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="tinkaton" <?php echo ($currentPokemon == 'tinkaton') ? 'checked' : ''; ?> required>
                                <img src="images/Tinkaton.gif" alt="Tinkaton">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="swampert" <?php echo ($currentPokemon == 'swampert') ? 'checked' : ''; ?> required>
                                <img src="images/swampert.gif" alt="Swampert">
                            </label>
                            <label>
                                <input type="radio" name="pokemon" value="spinda" <?php echo ($currentPokemon == 'spinda') ? 'checked' : ''; ?> required>
                                <img src="images/spinda.gif" alt="Spinda">
                            </label>
                        </div>

                        <button class="save-btn" type="submit">
                            Save Changes
                        </button>
                    </form>

                    <?php if (isset($error)): ?>
                        <p class="log-err" style="color: red;"><?php echo $error; ?></p>
                    <?php endif; ?>
                </div>        

            
            </div>

        </div>

    <div>

    
</body>
</html>