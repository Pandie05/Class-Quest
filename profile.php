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
    <title>Profile</title>

    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/themes.css">
    <link rel="stylesheet" href="styles/nav.css">
    <link rel="stylesheet" href="styles/noscroll.css">
    <link rel="stylesheet" href="styles/profile.css">
    <script src='scripts/nav.js' defer></script>
    

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

<div class="dashboard-wrapper">

    <div class="left-panel-2">

        

        <div class="sec1">
            
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

            <div class="profile-info">
                <h2>Hi!, <?php echo $_SESSION['user']['username']; ?></h2>
                <p>Email: <?php echo $_SESSION['user']['email']; ?></p>
                
                <div class="password-change-section">

                    <div class="password-input">
                        <label for="new-password">New Password:</label>
                        <div style="position: relative;">
                            <input type="password" name="new-password" id="new-password" placeholder="New Password" maxlength="20" style="padding-right: 30px;">
                            <svg id="toggleNewPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/>
                            </svg>
                        </div>
                    </div>

                    <div class="password-input">
                        <label for="confirm-password">Confirm Password:</label>
                        <div style="position: relative;">
                            <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" maxlength="20" style="padding-right: 30px;">
                            <svg id="toggleConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/>
                            </svg>
                        </div>
                        
                    </div>
                    <div class="savepw">
                    <button id="change-password-btn">Save Password</button>
                    </div>
                </div>


                <script src="scripts/login.js"></script>
                <script src="scripts/profile.js"></script>
          </div>
          
        </div>

    </div>
   
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" style="display: none;">
    <div class="loading-spinner"></div>
</div>

</body>
</html>