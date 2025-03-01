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
$assignments = getAssignmentsByUser($userId);

$theme = getUserPetTheme($_SESSION['user']['ID']);
    /* themes: absol, blaziken, venasaur, thundurus, pangoru, snorlax, scizor, 
    celebi, umbreon */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <link href='styles/calendar.css' rel='stylesheet' />
    <link href='styles/themes.css' rel='stylesheet' />
    <script src='scripts/nav.js' defer></script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js'></script>
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
            
        </div>
    </nav>

    <div id="calendar"></div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            // get the last selected view from localStorage or default to month view
            var lastView = localStorage.getItem('calendarViewType') || 'dayGridMonth';
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: lastView,
                views: {
                    dayGridMonth: { buttonText: 'Month' },
                    timeGridWeek: { buttonText: 'Week' }
                },
                headerToolbar: {
                    left: 'prev,next,dayGridMonth,timeGridWeek,today',
                    center: 'title',
                    right: ''
                },
                events: [
                    <?php foreach ($assignments as $assignment): ?>
                        {
                            title: '<?php echo htmlspecialchars($assignment['title'] . ' (' . $assignment['classname'] . ')'); ?>',
                            start: '<?php echo $assignment['duedate']; ?>',
                            allDay: true,
                            url: 'dashboard.php?search=<?php echo urlencode($assignment['title']); ?>&sort=duedate',
                            className: '<?php echo $assignment['done'] ? "completed" : ""; ?>',
                            backgroundColor: <?php echo $assignment['done'] ? "'#808080'" : "'#3788d8'"; ?>
                        },
                    <?php endforeach; ?>
                ]
            });

            // add event listener for view changes
            calendar.on('_viewChange', function(arg) {
                localStorage.setItem('calendarViewType', calendar.view.type);
            });

            // also save view when switching via the toolbar buttons
            calendar.on('datesSet', function() {
                localStorage.setItem('calendarViewType', calendar.view.type);
            });

            calendar.render();
        });
    </script>
</body>
</html>