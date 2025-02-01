<?php
    include __DIR__ . '/includes/gyatt.php';
    include __DIR__ . '/includes/func.php';
    include __DIR__ . '/model/db.php';

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $classname = $_POST['classname'];
        $duedate = $_POST['duedate'];
        $assigntype = $_POST['assigntype'];
        $xp = xp($duedate, $assigntype);

        addAssignment($title, $classname, $duedate, $assigntype, $xp);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Quest</title>
    <link rel="stylesheet" href="styles/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<?php
    $theme = 'grass';
?>

<body class="theme-<?php echo $theme; ?>">

    <nav>
        
        <div class="logo">
            <img src="images/logo.png" alt="">
        </div>

        <div class="icon-links">
            <a class="add-btn">
                <svg class="add-svg" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="currentColor" d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z"/></svg>
            </a>
            <a class="home-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12.204c0-2.289 0-3.433.52-4.381c.518-.949 1.467-1.537 3.364-2.715l2-1.241C9.889 2.622 10.892 2 12 2s2.11.622 4.116 1.867l2 1.241c1.897 1.178 2.846 1.766 3.365 2.715S22 9.915 22 12.203v1.522c0 3.9 0 5.851-1.172 7.063S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.212S2 17.626 2 13.725z"/><path stroke-linecap="round" d="M12 15v3"/></g></svg>
            </a>
            <a class="dash-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.557 2.75H4.682A1.93 1.93 0 0 0 2.75 4.682v3.875a1.94 1.94 0 0 0 1.932 1.942h3.875a1.94 1.94 0 0 0 1.942-1.942V4.682A1.94 1.94 0 0 0 8.557 2.75m10.761 0h-3.875a1.94 1.94 0 0 0-1.942 1.932v3.875a1.943 1.943 0 0 0 1.942 1.942h3.875a1.94 1.94 0 0 0 1.932-1.942V4.682a1.93 1.93 0 0 0-1.932-1.932m0 10.75h-3.875a1.94 1.94 0 0 0-1.942 1.933v3.875a1.94 1.94 0 0 0 1.942 1.942h3.875a1.94 1.94 0 0 0 1.932-1.942v-3.875a1.93 1.93 0 0 0-1.932-1.932M8.557 13.5H4.682a1.943 1.943 0 0 0-1.932 1.943v3.875a1.93 1.93 0 0 0 1.932 1.932h3.875a1.94 1.94 0 0 0 1.942-1.932v-3.875a1.94 1.94 0 0 0-1.942-1.942"/></svg>
            </a>
            <a class="pet-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="currentColor" d="M9.5 22q-1.475 0-2.488-1.012T6 18.5q0-.225.063-.35t-.013-.2t-.2-.012T5.5 18q-1.475 0-2.488-1.012T2 14.5t1.013-2.488T5.5 11q.575 0 1.05.15t.9.45l4.15-4.15q-.3-.425-.45-.9T11 5.5q0-1.475 1.013-2.488T14.5 2t2.488 1.013T18 5.5q0 .225-.062.35t.012.2t.2.013T18.5 6q1.475 0 2.488 1.013T22 9.5t-1.012 2.488T18.5 13q-.575 0-1.05-.15t-.9-.45l-4.15 4.15q.3.425.45.9T13 18.5q0 1.475-1.012 2.488T9.5 22m0-2q.65 0 1.075-.425T11 18.5q0-.225-.062-.437t-.188-.413q-.425-.6-.35-1.287t.6-1.213L15.15 11q.525-.525 1.213-.6t1.287.35q.2.125.413.188T18.5 11q.65 0 1.075-.425T20 9.5t-.425-1.075T18.5 8q-.875 0-1.225-.088t-.725-.462t-.462-.725T16 5.5q0-.65-.425-1.075T14.5 4t-1.075.425T13 5.5q0 .275.05.463t.2.387q.425.6.35 1.288T13 8.85L8.85 13q-.525.525-1.213.6t-1.287-.35q-.2-.125-.412-.187T5.5 13q-.65 0-1.075.425T4 14.5t.425 1.075T5.5 16q.875 0 1.225.088t.725.462t.462.725T8 18.5q0 .65.425 1.075T9.5 20m2.5-8"/></svg>
            </a>
            <a class="logout-btn" href="logout.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 20 20"><path fill="currentColor" fill-rule="evenodd" d="M3 3a1 1 0 0 0-1 1v12a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1m10.293 9.293a1 1 0 0 0 1.414 1.414l3-3a1 1 0 0 0 0-1.414l-3-3a1 1 0 1 0-1.414 1.414L14.586 9H7a1 1 0 1 0 0 2h7.586z" clip-rule="evenodd"/></svg>
            </a>
        <div>

    </nav>

    <div class="dashboard-wrapper">

        <div class="left-panel">

            <div class="breds">
                <h1>
                    Home / <span>Dashboard</span>
                </h1>

                <div class="seperator-line"></div>
                    
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

            <div class="pet-board">

            <div class="pet-cont stacked-images">
                <img class="pet-gif" src="images/mewtwo.gif" alt="Pet GIF">
            </div>

                <div class="pet-stats">
                    <div class="bars">
                        <?php
                            $bars = [
                                ['id' => 'hp', 'max' => 100, 'current' => 75, 'min' => 0],
                                ['id' => 'xp', 'max' => 200, 'current' => 130, 'min' => 0],
                                ['id' => 'pwr', 'max' => 50, 'current' => 50, 'min' => 0]
                            ];

                            foreach ($bars as $bar) {
                                echo '<div class="bar" id="' . $bar['id'] . '" data-max="' . $bar['max'] . '" data-current="' . $bar['current'] . '" data-min="' . $bar['min'] . '">';
                                echo '<span class="bar-label">' . $bar['current'] . '/' . $bar['max'] . '</span>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                    <div class="labels">
                        <?php
                            foreach ($bars as $bar) {
                                echo '<div><span class="label-s">' . $bar['id']  . '</span><span>' . $bar['current'] . '</span></div>';
                            }
                        ?>
                    </div>
                    <div class="info">
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="assignment-board">
          
            <div class="search-sort">
                <input type="text" id="search" placeholder="Search assignments...">
                <select id="sort">
                    <option value="title">Title</option>
                    <option value="classname">Class Name</option>
                    <option value="duedate">Due Date</option>
                    <option value="assigntype">Assignment Type</option>
                    <option value="xp">XP</option>
                </select>
                <button id="search-btn">Search</button>
            </div>


            <div class="assignment-wrapper">
                <?php 
                    $assignments = getAssignments();

                    foreach ($assignments as $assignment) {
                        echo '<div class="assignment">';
                        echo '<h2>' . $assignment['title'] . '</h2>';
                        echo '<p>' . $assignment['classname'] . '</p>';
                        echo '<p>' . $assignment['duedate'] . '</p>';
                        echo '<p>' . $assignment['assigntype'] . '</p>';
                        echo '<p>' . $assignment['xp'] . '</p>';
                        echo '</div>';
                    }
                ?>
            </div>
        

    <div>

    <div>
        
    
    
    <div>
    </div>

    <!-- HIDDEN ADD ASSIGNMENT FORM (for popup) -->


    <div class="add-assignment-form">
        <form action="dashboard.php" method="POST">
            <input type="text" name="title" placeholder="Title" required>
            <input type="text" name="classname" placeholder="Class Name" required>
            <input type="date" name="duedate" required>
            <select name="assigntype" required>
                <option value="final">Final</option>
                <option value="midterm">Midterm</option>
                <option value="exam">Exam</option>
                <option value="test">Test</option>
                <option value="quiz">Quiz</option>
                <option value="homework" selected>Homework</option>
            </select>
            <div class="button-group">
                <button type="submit">Add Assignment</button>
                <button id="cancel-btn" type="button">Cancel</button>
            </div>
        </form>
    </div>

    <script src="scripts/dashboard.js"></script>
</body>
</html>