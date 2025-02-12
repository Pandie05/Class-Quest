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

    // Get search and sort parameters
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'duedate';

    // Get filtered assignments
    $assignments = getFilteredAssignments($search, $sortBy);

    // Check for past due assignments and decrease HP if necessary
    foreach ($assignments as $assignment) {
        if (!$assignment['done'] && new DateTime($assignment['duedate']) < new DateTime() && !$assignment['hp_awarded']) {
            $newHp = max(0, $petData['hp'] - 5);
            petHpDown($userId, 10);

            // Update assignment to mark HP as awarded
            $sql = "UPDATE assignments SET hp_awarded = 1 WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $assignment['id'], PDO::PARAM_INT);
            $stmt->execute();

            // Update pet HP in session
            $petData['hp'] = $newHp;
        }
    }

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
    <link rel="stylesheet" href="styles/noscroll.css">
    <link rel="stylesheet" href="styles/nav.css">
    <link rel="stylesheet" href="styles/addTask.css">
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
        <a class="add-btn">
            <svg class="add-svg" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="currentColor" d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z"/></svg>
        </a>
        <a class="dash-btn">
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

        <div class="pet-lvl">
            
            <?php echo "Level:  " . htmlspecialchars($petData['lvl']); ?>
            
        </div>

        <div class="pet-cont stacked-images">
            <div class="pet-gif"></div>
        </div>

            <div class="pet-stats">
                <div class="bars">

                    <?php
                    
                        $bars = [
                            ['id' => 'hp', 'max' => 100, 'current' => $petData['hp'], 'min' => 0],
                            ['id' => 'xp', 'max' => 200, 'current' => $petData['xp'], 'min' => 0],
                        ];

                        foreach ($bars as $bar): ?>

                            <div class="bar" id="<?php echo $bar['id']; ?>" data-max="<?php echo $bar['max']; ?>" data-current="<?php echo $bar['current']; ?>" data-min="<?php echo $bar['min']; ?>">
                                <span class="bar-label"><?php echo $bar['current']; ?>/<?php echo $bar['max']; ?></span>
                            </div>

                        <?php endforeach; ?>

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
        <br> <p><a id="search-btn" href=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 11A8.1 8.1 0 0 0 4.5 9M4 5v4h4m-4 4a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/></svg></a></p>
    </form>

    
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-confirm" class="delete-modal">
    <p>Are you sure you want to delete this assignment?</p>
    <p>Difficulty deleting? click the refresh button next to search.</p>
    <span class="all-caps">THIS ACTION CANNOT BE UNDONE.</span>
    
    <div class="delete-modal-buttons">
        <button id="cancel-delete" class="cancel-button">Cancel</button>
        <button id="confirm-delete" class="delete-button">Delete</button>
    </div>
</div>

<div class="assignment-wrapper">
    <?php foreach ($assignments as $assignment): ?>
        <div class="assignment">
        <input type="checkbox" class="assignment-checkbox"
        data-id="<?php echo $assignment['id']; ?>"
        <?php echo $assignment['done'] ? 'checked' : ''; ?>>

        <div class="assignment-date">
            <label><?php echo htmlspecialchars($assignment['classname']); ?></label>
            <p><?php echo htmlspecialchars($assignment['title']); ?></p>
        </div>
        <div class="assignment-date">
            <label>Date</label>
            <p><?php echo date('F j, Y', strtotime($assignment['duedate'])); ?></p>
        </div>
        <div class="assignment-xp">
            <label><?php echo ucfirst(htmlspecialchars($assignment['assigntype'])); ?></label>
            <p><?php echo $assignment['xp']; ?> xp</p>
        </div>

        <div class="assignment-actions">
            <a href="#" class="edit-btn" onclick="showEditForm(<?php echo $assignment['id']; ?>)" data-assignment='<?php echo json_encode($assignment); ?>'>Edit</a>
            <button class="delete-btn" onclick="showDeleteConfirm(<?php echo $assignment['id']; ?>)" data-id="<?php echo $assignment['id']; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor" fill-rule="evenodd" d="M8.106 2.553A1 1 0 0 1 9 2h6a1 1 0 0 1 .894.553L17.618 6H20a1 1 0 1 1 0 2h-1v11a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V8H4a1 1 0 0 1 0-2h2.382zM14.382 4l1 2H8.618l1-2zM11 11a1 1 0 1 0-2 0v6a1 1 0 1 0 2 0zm4 0a1 1 0 1 0-2 0v6a1 1 0 1 0 2 0z" clip-rule="evenodd"/>
            </svg>
            </button>
        </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Add Assignment Form -->
<div class="add-assignment-form">
    <form id="assignment-form" action="dashboard.php" method="POST">
        <input type="hidden" name="id" id="assignment-id">
        <input type="text" name="title" id="assignment-title" placeholder="Title" maxlength="18" required>
        <input type="text" name="classname" id="assignment-classname" placeholder="Class Name" maxlength="15" required>
        <input type="date" name="duedate" id="assignment-duedate" required>
        <select name="assigntype" id="assignment-assigntype" required>
            <optgroup label="Assignment">
                <option value="final">Final</option>
                <option value="midterm">Midterm</option>
                <option value="test">Test</option>
                <option value="homework">Homework</option>
                <option value="quiz">Quiz</option>
            </optgroup>
            <optgroup label="Or Difficulty">
                <option value="Vhard">Very Hard</option>
                <option value="hard">Hard</option>
                <option value="med">Medium</option>
                <option value="easy" selected>Easy</option>
            </optgroup>
        </select>
        <div class="button-group">
            <button type="submit">Add</button>
            <button id="cancel-btn" type="button">Cancel</button>
        </div>
    </form>
</div>

<!-- Edit Assignment Form -->
<div class="edit-assignment-form">
    <form id="edit-assignment-form" action="dashboard.php" method="POST">
        <input type="hidden" name="id" id="edit-assignment-id">
        <input type="text" name="title" id="edit-assignment-title" placeholder="Title" maxlength="18" required>
        <input type="text" name="classname" id="edit-assignment-classname" placeholder="Class Name" maxlength="15" required>
        <input type="date" name="duedate" id="edit-assignment-duedate" required>
        <select name="assigntype" id="edit-assignment-assigntype" required>
            <optgroup label="Assignment">
                <option value="final">Final</option>
                <option value="midterm">Midterm</option>
                <option value="test">Test</option>
                <option value="homework">Homework</option>
                <option value="quiz">Quiz</option>
            </optgroup>
            <optgroup label="Or Difficulty">
                <option value="Vhard">Very Hard</option>
                <option value="hard">Hard</option>
                <option value="med">Medium</option>
                <option value="easy" selected>Easy</option>
            </optgroup>
        </select>
        <div class="button-group">
            <button type="submit">Save Changes</button>
            <button id="cancel-edit-btn" type="button">Cancel</button>
        </div>
    </form>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" style="display: none;">
    <div class="loading-spinner"></div>
</div>

<script src="scripts/dashboard.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingOverlay = document.getElementById('loading-overlay');
    
    // show loading overlay before page unload
    window.addEventListener('beforeunload', function() {
        loadingOverlay.style.display = 'flex';
    });
    
    // add a flag to track if we're processing a checkbox
    let isProcessing = false;
    
    // checkbox handling - first event listener
    const checkboxes = document.querySelectorAll('.assignment-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (isProcessing) return; // prevent multiple clicks
            isProcessing = true;
            
            loadingOverlay.style.display = 'flex';
            const assignmentId = this.getAttribute('data-id');
            const done = this.checked ? 1 : 0;

            fetch('update_assignment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 
                    id: assignmentId, 
                    done: done 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    console.error('Failed to update assignment');
                    checkbox.checked = !checkbox.checked;
                    loadingOverlay.style.display = 'none';
                    isProcessing = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                checkbox.checked = !checkbox.checked;
                loadingOverlay.style.display = 'none';
                isProcessing = false;
            });
        });

        // second event listener for the same checkboxes
        checkbox.addEventListener('click', function(e) {
            if (isProcessing) {
                e.preventDefault(); // prevent the click if we're processing
                return;
            }
            isProcessing = true;
            
            loadingOverlay.style.display = 'flex';
            const assignmentId = this.getAttribute('data-id');
            const done = !this.checked; // invert because the change hasn't processed yet

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

    // for sort select changes
    const sortSelect = document.getElementById('sort');
    sortSelect.addEventListener('change', function() {
        loadingOverlay.style.display = 'flex';
        document.getElementById('searchForm').submit();
    });

    // for search form submission
    const searchForm = document.getElementById('searchForm');
    searchForm.addEventListener('submit', function() {
        loadingOverlay.style.display = 'flex';
    });
});
</script>

</body>
</html>