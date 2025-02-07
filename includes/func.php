<?php
include __DIR__ . '../../model/db.php';

function getPet($id) {

    global $db;

    $sql = "SELECT * FROM pets WHERE userID = :id";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetch();

}

function updatePassword($id, $password) {
    global $db;
    $sql = "UPDATE users SET password = :password WHERE ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function getPetPokemon($userID) {
    global $db;
    $sql = "SELECT pokemon FROM pets WHERE userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Function to get the pet level for avaliable pets
function getAvailablePets($level) {
    $available = ['shinx', 'ralts', 'zorua', 'toxel']; // Base pets always available
    
    if ($level >= 5) {
        $available[] = 'luxio';
        $available[] = 'kirlia';
    }
    
    if ($level >= 8) {
        $available[] = 'zoroark';
        $available[] = 'toxtricity';
    }
    
    if ($level >= 10) {
        $available[] = 'luxray';
        $available[] = 'gardevoir';
    }
    
    if ($level >= 15) {
        $available[] = 'megaGardevoir';
    }

    if ($level >= 25) {
        $available[] = 'toxtricityGigantamax';
    }
    
    return $available;
}

function getPetData($userId) {
    global $db;
    $sql = "SELECT hp, xp, lvl FROM pets WHERE userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        return ['hp' => 100, 'xp' => 0, 'lvl' => 1]; // Default values if no pet found
    }
    return $result;
}

// Function to get the pet name
function getPetName($userID) {
    global $db;
    $sql = "SELECT petname FROM pets WHERE userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function petLevelup($userID) {
    global $db;
    $sql = "UPDATE pets SET lvl = lvl + 1 WHERE userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    return $stmt->execute();
}

function petHpDown($userID , $hp) {
    global $db;
    $sql = "UPDATE pets SET hp = hp - :hp WHERE userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':hp', $hp, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    return $stmt->execute();
}

// Get user's pet theme from database
function getUserPetTheme($userID) {
    global $db;
    $sql = "SELECT pokemon FROM pets WHERE userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() ?: 'umbreon'; // default to umbreon if no pet found
}

function getAssignments() {
    global $db;
    
    // Only get assignments for the logged-in user
    $sql = "SELECT * FROM assignments WHERE userID = :userID";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $_SESSION['user']['ID'], PDO::PARAM_INT);
    
    $stmt->execute();
    
    return $stmt->fetchAll();
}

function getAssignment($id) {
    global $db;
    
    // Get specific assignment but only if it belongs to the logged-in user
    $sql = "SELECT * FROM assignments WHERE ID = :id AND userID = :userID";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $_SESSION['user']['ID'], PDO::PARAM_INT);
    
    $stmt->execute();
    
    return $stmt->fetch();
}

function getAssignmentsByUser($userId) {
    global $db;
    $sql = "SELECT title, classname, duedate, done FROM assignments WHERE userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addAssignment($title, $classname, $duedate, $assigntype, $xp) {
    global $db;

    
    $sql = "SELECT COUNT(*) FROM assignments WHERE userID = :userID AND title = :title AND classname = :classname AND duedate = :duedate AND assigntype = :assigntype";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $_SESSION['user']['ID'], PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':classname', $classname, PDO::PARAM_STR);
    $stmt->bindParam(':duedate', $duedate, PDO::PARAM_STR);
    $stmt->bindParam(':assigntype', $assigntype, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
       
        return false;
    } else {
        
        $sql = "INSERT INTO assignments (userID, title, classname, duedate, assigntype, xp) VALUES (:userID, :title, :classname, :duedate, :assigntype, :xp)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':userID', $_SESSION['user']['ID'], PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':classname', $classname, PDO::PARAM_STR);
        $stmt->bindParam(':duedate', $duedate, PDO::PARAM_STR);
        $stmt->bindParam(':assigntype', $assigntype, PDO::PARAM_STR);
        $stmt->bindParam(':xp', $xp, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

function updateAssignment($id, $title, $classname, $duedate, $assigntype, $xp) {
    global $db;
    $sql = "UPDATE assignments SET title = :title, classname = :classname, duedate = :duedate, assigntype = :assigntype, xp = :xp WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':classname', $classname);
    $stmt->bindParam(':duedate', $duedate);
    $stmt->bindParam(':assigntype', $assigntype);
    $stmt->bindParam(':xp', $xp);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function getFilteredAssignments($search = '', $sortBy = 'duedate') {
    global $db;
    
    $sql = "SELECT * FROM assignments WHERE userID = :userID";
    $params = array();
    $params[':userID'] = $_SESSION['user']['ID'];
    
    // Add search conditions if search term is provided
    if (!empty($search)) {
        $sql .= " AND (title LIKE :searchTitle OR classname LIKE :searchClass OR assigntype LIKE :searchType)";
        $searchTerm = "%{$search}%";
        $params[':searchTitle'] = $searchTerm;
        $params[':searchClass'] = $searchTerm;
        $params[':searchType'] = $searchTerm;
    }
    
    // Special handling for 'done' sort to show only completed assignments
    if ($sortBy === 'done') {
        $sql .= " AND done = 1";
    }
    
    // Add ORDER BY clause based on sort parameter
    switch ($sortBy) {
        case 'duedate':
            $sql .= " ORDER BY done ASC, duedate ASC";
            break;
        case 'assigntype':
            $sql .= " ORDER BY done ASC, assigntype ASC";
            break;
        case 'done':
            $sql .= " ORDER BY duedate ASC";
            break;
        default:
            if (in_array($sortBy, ['title', 'classname', 'xp'])) {
                $sql .= " ORDER BY done ASC, {$sortBy} ASC";
            }
    }
    
    $stmt = $db->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    
    $stmt->execute();
    return $stmt->fetchAll();
}

function daysUntilDue($duedate) {

    $now = new DateTime();
    $due = new DateTime($duedate);
    
    $diff = $now->diff($due);
    
    return $diff->days;

}

function xp($duedate, $type) {
    $typeValues = [
        'final' => 350,
        'midterm' => 250,
        'test' => 90,
        'quiz' => 70,
        'homework' => 30,
        'Vhard' => 250,
        'hard' => 150,
        'med' => 70,
        'easy' => 35
    ];

    return $typeValues[$type];
}

/* function xp($duedate, $type) {
    $typeValues = [
        'final' => 20,
        'midterm' => 17,
        'exam' => 15,
        'test' => 9,
        'quiz' => 6,
        'homework' => 4.5
    ];

    return $typeValues[$type];
} */
