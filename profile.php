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
    <link rel="stylesheet" href="styles/noscroll.css">

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
        <a class="logout-btn" href="includes/logout.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 20 20"><path fill="currentColor" fill-rule="evenodd" d="M3 3a1 1 0 0 0-1 1v12a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1m10.293 9.293a1 1 0 0 0 1.414 1.414l3-3a1 1 0 0 0 0-1.414l-3-3a1 1 0 1 0-1.414 1.414L14.586 9H7a1 1 0 1 0 0 2h7.586z" clip-rule="evenodd"/></svg>
        </a>
    </div>
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
                
                <div class="password-change-section">
                    <div class="password-input">
                        <label for="password">Password:</label>
                        <div style="position: relative;">
                            <input type="password" name="password" id="password" placeholder="Password" value="<?php echo $_SESSION['user']['password']; ?>" readonly style="padding-right: 30px;">
                            <svg id="togglePassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/>
                            </svg>
                        </div>
                    </div>

                    <div class="password-input">
                        <label for="new-password">New Password:</label>
                        <div style="position: relative;">
                            <input type="password" name="new-password" id="new-password" placeholder="New Password" style="padding-right: 30px;">
                            <svg id="toggleNewPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/>
                            </svg>
                        </div>
                    </div>

                    <div class="password-input">
                        <label for="confirm-password">Confirm Password:</label>
                        <div style="position: relative;">
                            <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" style="padding-right: 30px;">
                            <svg id="toggleConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/>
                            </svg>
                        </div>
                    </div>

                    <button id="change-password-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-dasharray="24" stroke-dashoffset="24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l6 6l10 -10"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.4s" values="24;0"/></path></svg></button>
                </div>


                <script src="scripts/login.js"></script>
                <script src="scripts/profile.js"></script>
            </div>
            

            <?php 
            $currentPokemon = getPetPokemon($_SESSION['user']['ID']);
            $petData = getPetData($_SESSION['user']['ID']);
            $availablePets = getAvailablePets($petData['lvl']);
            ?>

            <div class="pet-picker">
                <form class="pet-pick" action="change_pet.php" method="POST">
                    <h6>Change your pet:</h6>
                    <p class="current-level">Current Level: <?php echo $petData['lvl']; ?></p>

                    <div class='pet-save'>
                        <div class="pet-name-section">
                            <label for="petname">Pet Name:</label>
                            <input type="text" name="petname" value="<?php echo htmlspecialchars(getPetName($_SESSION['user']['ID'])); ?>" placeholder="Name your pet">
                        </div>
                        <button class="save-btn" type="submit">
                            Save Changes
                        </button>   
                    </div>

                    <div class="pet-selection">
                        <!-- Evolution Order -->
                        <label <?php echo !in_array('shinx', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="shinx" <?php echo ($currentPokemon == 'shinx') ? 'checked' : ''; ?> required>
                            <img src="images/shinx.gif" alt="shinx">
                            <span class="level-req">lvl 1</span>
                        </label>
                        
                        <label <?php echo !in_array('luxio', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="luxio" <?php echo ($currentPokemon == 'luxio') ? 'checked' : ''; ?> <?php echo !in_array('luxio', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/luxio.gif" alt="luxio">
                            <span class="level-req">lvl 5</span>
                        </label>
                        
                        <label <?php echo !in_array('luxray', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="luxray" <?php echo ($currentPokemon == 'luxray') ? 'checked' : ''; ?> <?php echo !in_array('luxray', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/luxray.gif" alt="luxray">
                            <span class="level-req">lvl 10</span>
                        </label>
                        
                        <label <?php echo !in_array('ralts', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="ralts" <?php echo ($currentPokemon == 'ralts') ? 'checked' : ''; ?> required>
                            <img src="images/ralts.gif" alt="ralts">
                            <span class="level-req">lvl 1</span>
                        </label>
                        
                        <label <?php echo !in_array('kirlia', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="kirlia" <?php echo ($currentPokemon == 'kirlia') ? 'checked' : ''; ?> <?php echo !in_array('kirlia', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/kirlia.gif" alt="kirlia">
                            <span class="level-req">lvl 5</span>
                        </label>
                        
                        <label <?php echo !in_array('gardevoir', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="gardevoir" <?php echo ($currentPokemon == 'gardevoir') ? 'checked' : ''; ?> <?php echo !in_array('gardevoir', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/gardevoir.gif" alt="gardevoir">
                            <span class="level-req">lvl 10</span>
                        </label>
                        
                        <label <?php echo !in_array('megaGardevoir', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="megaGardevoir" <?php echo ($currentPokemon == 'megaGardevoir') ? 'checked' : ''; ?> <?php echo !in_array('megaGardevoir', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/megaGardevoir.gif" alt="megaGardevoir">
                            <span class="level-req">lvl 15</span>
                        </label>
                        
                        <label <?php echo !in_array('zorua', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="zorua" <?php echo ($currentPokemon == 'zorua') ? 'checked' : ''; ?> required>
                            <img src="images/zorua.gif" alt="zorua">
                            <span class="level-req">lvl 1</span>
                        </label>
                        
                        <label <?php echo !in_array('zoroark', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="zoroark" <?php echo ($currentPokemon == 'zoroark') ? 'checked' : ''; ?> <?php echo !in_array('zoroark', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/zoroark.gif" alt="zoroark">
                            <span class="level-req">lvl 8</span>
                        </label>

                        <label <?php echo !in_array('toxel', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="toxel" <?php echo ($currentPokemon == 'toxel') ? 'checked' : ''; ?> required>
                            <img src="images/toxel.gif" alt="toxel">
                            <span class="level-req">lvl 1</span>
                        </label>

                        <label <?php echo !in_array('toxtricity', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="toxtricity" <?php echo ($currentPokemon == 'toxtricity') ? 'checked' : ''; ?> <?php echo !in_array('toxtricity', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/toxtricity.gif" alt="toxtricity">
                            <span class="level-req">lvl 8</span>
                        </label>

                        <label <?php echo !in_array('toxtricityGigantamax', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="toxtricityGigantamax" <?php echo ($currentPokemon == 'toxtricityGigantamax') ? 'checked' : ''; ?> <?php echo !in_array('toxtricityGigantamax', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/toxtricity-gigantamax.gif" alt="toxtricityGigantamax">
                            <span class="level-req">lvl 25</span>
                        </label>

                        <label <?php echo !in_array('charcadet', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="charcadet" <?php echo ($currentPokemon == 'charcadet') ? 'checked' : ''; ?> required>
                            <img src="images/charcadet.gif" alt="charcadet">
                            <span class="level-req">lvl 1</span>
                        </label>
                        <label <?php echo !in_array('armorouge', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="armorouge" <?php echo ($currentPokemon == 'armorouge') ? 'checked' : ''; ?> <?php echo !in_array('armorouge', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/armorouge.gif" alt="armorouge">
                            <span class="level-req">lvl 8</span>
                        </label>
                        <label <?php echo !in_array('ceruledge', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="ceruledge" <?php echo ($currentPokemon == 'ceruledge') ? 'checked' : ''; ?> <?php echo !in_array('ceruledge', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/ceruledge.gif" alt="ceruledge">
                            <span class="level-req">lvl 8</span>
                        </label>

                    </div>

                    
                </form>
            </div>     

        
        </div>

    </div>

</div>

<footer>
    <p>...</p>
</footer>

</body>
</html>