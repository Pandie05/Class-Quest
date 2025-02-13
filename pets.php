<?php
    include __DIR__ . '/includes/gyatt.php';
    include __DIR__ . '/includes/func.php';
    include __DIR__ . '/model/db.php';

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
    
    $userId = $_SESSION['user']['ID'];
    $petName = getPetName($userId);
    $petData = getPetData($userId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $title = $_POST['title'];
        $classname = $_POST['classname'];
        $duedate = $_POST['duedate'];
        $assigntype = $_POST['assigntype'];
        $xp = xp($duedate, $assigntype);

        if ($id) {

            updateAssignment($id, $title, $classname, $duedate, $assigntype, $xp);

        } else {

            addAssignment($title, $classname, $duedate, $assigntype, $xp);

        }
    }

    $theme = getUserPetTheme($_SESSION['user']['ID']);
    /* themes: absol, blaziken, venasaur, thundurus, pangoru, snorlax, scizor, 
    celebi, umbreon */

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Quest</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/themes.css">
    <link rel="stylesheet" href="styles/nav.css">
    <link rel="stylesheet" href="styles/pets.css">
    <link rel="stylesheet" href="styles/profile.css">
    <script src="scripts/nav.js" defer></script>

</head>
<body class="theme-<?php echo $theme; ?>">

    <nav>
        <a href="index.php" class="logo">
            <img src="images/logo.png" alt="">
        </a>

        <div class="hamburger">
            <span class="bark"></span>
            <span class="bark"></span>
            <span class="bark"></span>
        </div>

        <div class="icon-links">
            <a href="dashboard.php" class="dash-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12.204c0-2.289 0-3.433.52-4.381c.518-.949 1.467-1.537 3.364-2.715l2-1.241C9.889 2.622 10.892 2 12 2s2.11.622 4.116 1.867l2 1.241c1.897 1.178 2.846 1.766 3.365 2.715S22 9.915 22 12.203v1.522c0 3.9 0 5.851-1.172 7.063S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.212S2 17.626 2 13.725z"/><path stroke-linecap="round" d="M9 16c.85.63 1.885 1 3 1s2.15-.37 3-1"/></g></svg>
            </a>
            <a class="home-btn" href="calendar.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path stroke="currentColor" stroke-width="1.5" d="M2 12c0-3.771 0-5.657 1.172-6.828S6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172S22 8.229 22 12v2c0 3.771 0 5.657-1.172 6.828S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172S2 17.771 2 14z"/><path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M7 4V2.5M17 4V2.5M2.5 9h19"/><path fill="currentColor" d="M18 17a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-5 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-5 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0"/></g></svg>
            </a>
            <a class="home-btn" href="pets.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><defs><path id="hugeiconsPokeball0" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2s10 4.477 10 10"/></defs><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><use href="#hugeiconsPokeball0"/><use href="#hugeiconsPokeball0"/><path d="M15 13a3 3 0 1 1-6 0a3 3 0 0 1 6 0M2 11c2.596 1.004 4.853 1.668 6.998 1.993M22 11.003c-2.593 1.01-4.848 1.675-6.998 1.997"/></g></svg>
            </a>
            <a href="profile.php" class="pet-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linejoin="round" d="M4 18a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z"/><circle cx="12" cy="7" r="3"/></g></svg>
            </a>
            <a class="logout-btn" href="includes/logout.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 20 20"><path fill="currentColor" fill-rule="evenodd" d="M3 3a1 1 0 0 0-1 1v12a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1m10.293 9.293a1 1 0 0 0 1.414 1.414l3-3a1 1 0 0 0 0-1.414l-3-3a1 1 0 1 0-1.414 1.414L14.586 9H7a1 1 0 1 0 0 2h7.586z" clip-rule="evenodd"/></svg>
            </a>
            <a class="home-btn" href="admin.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 14v2a6 6 0 0 0-6 6H4a8 8 0 0 1 8-8m0-1c-3.315 0-6-2.685-6-6s2.685-6 6-6s6 2.685 6 6s-2.685 6-6 6m0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4s-4 1.79-4 4s1.79 4 4 4m9 6h1v5h-8v-5h1v-1a3 3 0 1 1 6 0zm-2 0v-1a1 1 0 1 0-2 0v1z"/></svg>
            </a>
        </div>
    </nav>

        <?php 
            $currentPokemon = getPetPokemon($_SESSION['user']['ID']);
            $petData = getPetData($_SESSION['user']['ID']);
            $petsInfo = getAvailablePets($petData['lvl']);
            $availablePets = $petsInfo['available'];
            $requirements = $petsInfo['requirements'];
        ?>

        <div class="pet-page">

        <div class="pet-picker">
                <form class="pet-pick" action="change_pet.php" method="POST">
                    <h6>Change your pet:</h6>
                    <p class="current-level">Current Level: <?php echo $petData['lvl']; ?></p>

                    <div class='pet-save'>
                        <div class="pet-name-section">
                            <label for="petname">Pet Name:</label>
                            <input type="text" name="petname" value="<?php echo htmlspecialchars(getPetName($_SESSION['user']['ID'])); ?>" placeholder="Name your pet" maxlength="15">
                        </div>
                        <button class="save-btn" type="submit">
                            Save Changes
                        </button>   
                    </div>

                    <div class="pet-selection">
                        <!-- Evolution Order -->
                        <label <?php echo !in_array('petilil', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="petilil" <?php echo ($currentPokemon == 'petilil') ? 'checked' : ''; ?> required>
                            <img src="images/petilil.gif" alt="petilil">
                            <span class="level-req">lvl 1</span>
                        </label>

                        <label <?php echo !in_array('lilligant', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="lilligant" <?php echo ($currentPokemon == 'petilil') ? 'checked' : ''; ?> required>
                            <img src="images/lilligant.gif" alt="lilligant">
                            <span class="level-req">lvl 5</span>
                        </label>

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

                        <label <?php echo !in_array('cinderaceGMAX', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="cinderaceGMAX" <?php echo ($currentPokemon == 'cinderaceGMAX') ? 'checked' : ''; ?> <?php echo !in_array('cinderaceGMAX', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/cinderaceGMAX.gif" alt="cinderaceGMAX">
                            <span class="level-req">lvl 40</span>
                        </label>

                        <label <?php echo !in_array('vulpix', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="vulpix" <?php echo ($currentPokemon == 'vulpix') ? 'checked' : ''; ?> <?php echo !in_array('vulpix', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/vulpix.gif" alt="vulpix">
                            <span class="level-req">
                                <?php 
                                if (!in_array('vulpix', $availablePets)) {
                                    echo "{$requirements['vulpix']['current']}/{$requirements['vulpix']['display']}";
                                }
                                ?>
                            </span>
                        </label>

                        <label <?php echo !in_array('ninetails', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="ninetails" <?php echo ($currentPokemon == 'ninetails') ? 'checked' : ''; ?> <?php echo !in_array('ninetails', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/ninetails.gif" alt="ninetails">
                            <span class="level-req">
                                <?php 
                                if (!in_array('ninetails', $availablePets)) {
                                    echo "{$requirements['ninetails']['current']}/{$requirements['ninetails']['display']}";
                                }
                                ?>
                            </span>
                        </label>

                        <label <?php echo !in_array('celebi', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="celebi" <?php echo ($currentPokemon == 'celebi') ? 'checked' : ''; ?> <?php echo !in_array('celebi', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/celebi.gif" alt="celebi">
                            <span class="level-req">
                                <?php 
                                if (!in_array('celebi', $availablePets)) {
                                    echo "{$requirements['celebi']['current']}/{$requirements['celebi']['display']}";
                                }
                                ?>
                            </span>
                        </label>

                        <label <?php echo !in_array('celebiPink', $availablePets) ? 'class="locked"' : ''; ?>>
                            <input type="radio" name="pokemon" value="celebiPink" <?php echo ($currentPokemon == 'celebiPink') ? 'checked' : ''; ?> <?php echo !in_array('celebiPink', $availablePets) ? 'disabled' : ''; ?>>
                            <img src="images/celebiPink.gif" alt="celebiPink">
                            <span class="level-req">
                                <?php 
                                if (!in_array('celebiPink', $availablePets)) {
                                    echo "{$requirements['celebiPink']['current']}/{$requirements['celebiPink']['display']}";
                                }
                                ?>
                            </span>
                        </label>

                    </div>

                    
                </form>
            </div>   

        </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>

    <script src="scripts/dashboard.js"></script>
</body>
</html>