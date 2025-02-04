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

</head>
<body class="theme-<?php echo $theme; ?>">

    <nav>
        
        <div class="logo">
            <img src="images/logo.png" alt="">
        </div>

        <div class="icon-links">

            <a class="dash-btn" style="margin-top: 100px;" href="dashboard.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.557 2.75H4.682A1.93 1.93 0 0 0 2.75 4.682v3.875a1.94 1.94 0 0 0 1.932 1.942h3.875a1.94 1.94 0 0 0 1.942-1.942V4.682A1.94 1.94 0 0 0 8.557 2.75m10.761 0h-3.875a1.94 1.94 0 0 0-1.942 1.932v3.875a1.943 1.943 0 0 0 1.942 1.942h3.875a1.94 1.94 0 0 0 1.932-1.942V4.682a1.93 1.93 0 0 0-1.932-1.932m0 10.75h-3.875a1.94 1.94 0 0 0-1.942 1.933v3.875a1.94 1.94 0 0 0 1.942 1.942h3.875a1.94 1.94 0 0 0 1.932-1.942v-3.875a1.93 1.93 0 0 0-1.932-1.932M8.557 13.5H4.682a1.943 1.943 0 0 0-1.932 1.943v3.875a1.93 1.93 0 0 0 1.932 1.932h3.875a1.94 1.94 0 0 0 1.942-1.932v-3.875a1.94 1.94 0 0 0-1.942-1.942"/></svg>
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
                    <form class="pet-pick" action="change_pet.php" method="POST">
                    <h6>Change your pet:</h6>

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