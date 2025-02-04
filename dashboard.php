<?php
    include __DIR__ . '/includes/gyatt.php';
    include __DIR__ . '/includes/func.php';
    include __DIR__ . '/model/db.php';

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
    
    $petName = getPetName($_SESSION['user']['ID']);

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

    // Get search and sort parameters
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'duedate';

    // Get filtered assignments
    $assignments = getFilteredAssignments($search, $sortBy);

    // Sort assignments to put checked ones at the bottom
    usort($assignments, function($a, $b) use ($sortBy) {
        // First compare by done status
        if ($a['done'] !== $b['done']) {
            return $a['done'] - $b['done'];
        }
        
        // Then sort by the user's selected criteria
        switch($sortBy) {
            case 'duedate':
                return strtotime($a['duedate']) - strtotime($b['duedate']);
            case 'xp':
                return $b['xp'] - $a['xp'];
            default:
                return strcasecmp($a[$sortBy], $b[$sortBy]);
        }
    });

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
    <link rel="stylesheet" href="styles/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/themes.css">
</head>
<body class="theme-<?php echo $theme; ?>">

    <nav>
        
        <div class="logo">
            <img src="images/logo.png" alt="">
        </div>

        <div class="icon-links">
            <a class="add-btn">
                <svg class="add-svg" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="currentColor" d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z"/></svg>
            </a>
            <a class="dash-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.557 2.75H4.682A1.93 1.93 0 0 0 2.75 4.682v3.875a1.94 1.94 0 0 0 1.932 1.942h3.875a1.94 1.94 0 0 0 1.942-1.942V4.682A1.94 1.94 0 0 0 8.557 2.75m10.761 0h-3.875a1.94 1.94 0 0 0-1.942 1.932v3.875a1.943 1.943 0 0 0 1.942 1.942h3.875a1.94 1.94 0 0 0 1.932-1.942V4.682a1.93 1.93 0 0 0-1.932-1.932m0 10.75h-3.875a1.94 1.94 0 0 0-1.942 1.933v3.875a1.94 1.94 0 0 0 1.942 1.942h3.875a1.94 1.94 0 0 0 1.932-1.942v-3.875a1.93 1.93 0 0 0-1.932-1.932M8.557 13.5H4.682a1.943 1.943 0 0 0-1.932 1.943v3.875a1.93 1.93 0 0 0 1.932 1.932h3.875a1.94 1.94 0 0 0 1.942-1.932v-3.875a1.94 1.94 0 0 0-1.942-1.942"/></svg>
            </a>
            <a class="calendar-btn" href="calendar.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m0 16H5V10h14z"/></svg>
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

            <div class="pet-name">
                <?php echo "Name:  " . htmlspecialchars($petName); ?>
            </div>

            <div class="pet-cont stacked-images">
                <div class="pet-gif"></div>
            </div>

                <div class="pet-stats">
                    <div class="bars">

                        <?php
                            $bars = [
                                ['id' => 'hp', 'max' => 100, 'current' => 75, 'min' => 0],
                                ['id' => 'xp', 'max' => 200, 'current' => 130, 'min' => 0],
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
        <form class="search-top" id="searchForm" method="GET" action="dashboard.php">
            <input type="text" id="search" name="search" placeholder="Search assignment by title..." value="<?php echo htmlspecialchars($search); ?>">
            <select class="search-top" id="sort" name="sort">
                
                <option value="duedate" <?php echo $sortBy === 'duedate' ? 'selected' : ''; ?>>Due Date</option>
                <option value="assigntype" <?php echo $sortBy === 'assigntype' ? 'selected' : ''; ?>>Assignment Type</option>
                <option value="done" <?php echo $sortBy === 'done' ? 'selected' : ''; ?>>Completed</option>
            </select>
            <button class="search-top" type="submit" id="search-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 12 12"><circle cx="4.5" cy="4.5" r="3.5" fill="none" stroke="currentColor" stroke-width="2"/><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M11 11L7.5 7.5"/></svg></button>
            <br> <p>Difficulty deleting? Click <a id="search-btn" href="">here</a></p>
        </form>

        
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-confirm" class="delete-modal">
        <p>Are you sure you want to delete this assignment?</p>
        <span class="all-caps">THIS ACTION CANNOT BE UNDONE.</span>
        <div class="delete-modal-buttons">
            <button id="cancel-delete" class="cancel-button">Cancel</button>
            <button id="confirm-delete" class="delete-button">Delete</button>
        </div>
    </div>

    <div class="assignment-wrapper">
        <?php
            foreach ($assignments as $assignment) {
                echo '<div class="assignment">';
                echo '<input type="checkbox" class="assignment-checkbox"
                    onclick="fetch(\'update_assignment.php\', {
                        method: \'POST\',
                        headers: { \'Content-Type\': \'application/json\' },
                        body: JSON.stringify({
                            id: ' . $assignment['id'] . ',
                            done: ' . ($assignment['done'] ? '0' : '1') . '
                        })
                    }).then(() => window.location.reload());"
                    data-id="' . $assignment['id'] . '"
                    ' . ($assignment['done'] ? 'checked' : '') . '>';

                echo '<div class="assignment-date"><label>' . htmlspecialchars($assignment['classname']) . '</label><p>' . htmlspecialchars($assignment['title']) . '</p></div>';
                echo '<div class="assignment-date"><label>Date</label><p>' . date('F j, Y', strtotime($assignment['duedate'])) . '</p></div>';
                echo '<div class="assignment-xp"><label>' . ucfirst(htmlspecialchars($assignment['assigntype'])) . '</label><p>' . $assignment['xp'] . ' xp</p></div>';

                echo '<div class="assignment-actions">';
                echo '<button class="edit-btn"  onclick="showEditForm(' . $assignment['id'] . ')" data-assignment=\'' . json_encode($assignment) . '\'>Edit</button>';
                echo '<button class="delete-btn" onclick="showDeleteConfirm(' . $assignment['id'] . ')" data-id="' . $assignment['id'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8.106 2.553A1 1 0 0 1 9 2h6a1 1 0 0 1 .894.553L17.618 6H20a1 1 0 1 1 0 2h-1v11a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V8H4a1 1 0 0 1 0-2h2.382zM14.382 4l1 2H8.618l1-2zM11 11a1 1 0 1 0-2 0v6a1 1 0 1 0 2 0zm4 0a1 1 0 1 0-2 0v6a1 1 0 1 0 2 0z" clip-rule="evenodd"/></svg></button>';
                echo '</div>';
                echo '</div>';
            }
        ?>
    </div>

    <!-- Add/Edit Assignment Form -->
    <div class="add-assignment-form">
        <form id="assignment-form" action="dashboard.php" method="POST">
            <input type="hidden" name="id" id="assignment-id">
            <input type="text" name="title" id="assignment-title" placeholder="Title" required>
            <input type="text" name="classname" id="assignment-classname" placeholder="Class Name" required>
            <input type="date" name="duedate" id="assignment-duedate" required>
            <select name="assigntype" id="assignment-assigntype" required>
                <option value="final">Final</option>
                <option value="midterm">Midterm</option>
                <option value="exam">Exam</option>
                <option value="test">Test</option>
                <option value="quiz">Quiz</option>
                <option value="homework" selected>Homework</option>
            </select>
            <div class="button-group">
                <button type="submit">Save Changes</button>
                <button id="cancel-btn" type="button">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>

    <script src="scripts/dashboard.js"></script>
    
    <script>

    function showEditForm(assignment) {
        const form = document.querySelector('.add-assignment-form');
        document.getElementById('assignment-id').value = assignment.id;
        document.getElementById('assignment-title').value = assignment.title;
        document.getElementById('assignment-classname').value = assignment.classname;
        document.getElementById('assignment-duedate').value = assignment.duedate;
        document.getElementById('assignment-assigntype').value = assignment.assigntype;
        form.classList.add('show');
    }
        
        document.addEventListener('DOMContentLoaded', function() {
        // Existing checkbox functionality
        const checkboxes = document.querySelectorAll('.assignment-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const assignmentId = this.getAttribute('data-id');
                const done = this.checked ? 1 : 0;

                fetch('update_assignment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: assignmentId, done: done })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Get the assignment wrapper
                        const assignmentWrapper = document.querySelector('.assignment-wrapper');
                        // Get all assignments
                        const assignments = Array.from(assignmentWrapper.children);
                        
                        // Sort assignments
                        assignments.sort((a, b) => {
                            const aChecked = a.querySelector('.assignment-checkbox').checked;
                            const bChecked = b.querySelector('.assignment-checkbox').checked;
                            return aChecked - bChecked;
                        });
                        
                        // Reorder the DOM
                        assignments.forEach(assignment => {
                            assignmentWrapper.appendChild(assignment);
                        });
                    } else {
                        console.error('Failed to update assignment');
                        // Revert checkbox if update failed
                        checkbox.checked = !checkbox.checked;
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Add real-time search and sort functionality
        const sortSelect = document.getElementById('sort');
        sortSelect.addEventListener('change', function() {
            document.getElementById('searchForm').submit();
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const loadingOverlay = document.getElementById('loading-overlay');

        // Show loading overlay before page unload
        window.addEventListener('beforeunload', function() {
            loadingOverlay.style.display = 'flex';
        });

        // For checkbox clicks
        const checkboxes = document.querySelectorAll('.assignment-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', function(e) {
                loadingOverlay.style.display = 'flex';
                const assignmentId = this.getAttribute('data-id');
                const done = !this.checked; // Invert because the change hasn't processed yet

                fetch('update_assignment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                        id: assignmentId, 
                        done: done ? 0 : 1
                    })
                })
                .then(() => window.location.reload());
            });
        });

        // For sort select changes
        const sortSelect = document.getElementById('sort');
        sortSelect.addEventListener('change', function() {
            loadingOverlay.style.display = 'flex';
            document.getElementById('searchForm').submit();
        });

        // For search form submission
        const searchForm = document.getElementById('searchForm');
        searchForm.addEventListener('submit', function() {
            loadingOverlay.style.display = 'flex';
        });
    });


</script>
    
</body>
</html>