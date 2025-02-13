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



function getPetData($userId) {
    global $db;
    $sql = "SELECT hp, xp, lvl FROM pets WHERE userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        return ['hp' => 100, 'xp' => 0, 'lvl' => 1]; // default values if no pet found
    }
    return $result;
}

// get the pet name
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

function petLeveldown($userID) {
    global $db;
    $sql = "UPDATE pets SET lvl = lvl - 1 WHERE userID = :userID";
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

// get user's pet theme from database
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
    
    // only get assignments for the logged-in user
    $sql = "SELECT * FROM assignments WHERE userID = :userID";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $_SESSION['user']['ID'], PDO::PARAM_INT);
    
    $stmt->execute();
    
    return $stmt->fetchAll();
}

function getAssignment($id) {
    global $db;
    
    // get specific assignment but only if it belongs to the logged-in user
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
    
    // add search conditions if search term is provided
    if (!empty($search)) {
        $sql .= " AND (title LIKE :searchTitle OR classname LIKE :searchClass OR assigntype LIKE :searchType)";
        $searchTerm = "%{$search}%";
        $params[':searchTitle'] = $searchTerm;
        $params[':searchClass'] = $searchTerm;
        $params[':searchType'] = $searchTerm;
    }
    
    // handling for done sort to show only completed assignments
    if ($sortBy === 'done') {
        $sql .= " AND done = 1";
    }
    
    // add ORDER BY clause based on sort parameter
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

function getTaskCompletionCounts($userID) {
    global $db;
    $sql = "SELECT 
        COUNT(*) as total_tasks,
        SUM(CASE WHEN assigntype = 'quiz' THEN 1 ELSE 0 END) as quizzes,
        SUM(CASE WHEN assigntype = 'test' THEN 1 ELSE 0 END) as tests,
        SUM(CASE WHEN assigntype = 'homework' THEN 1 ELSE 0 END) as homework,
        SUM(CASE WHEN assigntype = 'final' THEN 1 ELSE 0 END) as finals,
        SUM(CASE WHEN assigntype = 'vhard' THEN 1 ELSE 0 END) as vhard,
        SUM(CASE WHEN assigntype = 'hard' THEN 1 ELSE 0 END) as hard,
        SUM(CASE WHEN assigntype = 'med' THEN 1 ELSE 0 END) as med,
        SUM(CASE WHEN assigntype = 'easy' THEN 1 ELSE 0 END) as easy
        FROM assignments 
        WHERE userID = :userID AND done = 1";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// function to get the pet level and tasks needed for avaliable pets
function getAvailablePets($level) {
    global $db;
    $userID = $_SESSION['user']['ID'];
    $taskCounts = getTaskCompletionCounts($userID);
    
    // make task counts 0 if no assignments are completed
    $taskCounts = array_map(function($count) {
        return $count ?? 0;
    }, $taskCounts);

    // requirements for task-based unlocks
    $requirements = [
        'vulpix' => ['tasks' => 3, 'type' => 'easy', 'display' => '3 easy tasks'],
        'ninetails' => ['tasks' => 8, 'type' => 'easy', 'display' => '8 easy tasks'],
        'celebi' => ['tasks' => 1, 'type' => 'finals', 'display' => '1 final'],
        'celebiPink' => ['tasks' => 7, 'type' => 'quizzes', 'display' => '7 quizzes']
    ];
    
    // starter pets
    $available = ['shinx', 'ralts', 'zorua', 'toxel', 'charcadet', 'petilil'];
    $unlockInfo = [];
    
    // level-based unlocks
    if ($level >= 5) {
        $available[] = 'luxio';
        $available[] = 'kirlia';
        $available[] = 'lilligant';
    }
    if ($level >= 8) {
        $available[] = 'zoroark';
        $available[] = 'toxtricity';
        $available[] = 'armorouge';
        $available[] = 'ceruledge';
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
    if ($level >= 30) {
        $available[] = 'machamp';
    }
    if ($level >= 40) {
        $available[] = 'cinderaceGMAX';
    }

    // task-based unlocks 
    foreach ($requirements as $pokemon => $req) {
        if (is_array($req['tasks'])) {
            $allTasksMet = true;
            foreach ($req['tasks'] as $type => $count) {
                if ($taskCounts[$type] < $count) {
                    $allTasksMet = false;
                    break;
                }
            }
            if ($allTasksMet) {
                $available[] = $pokemon;
            }
        } else {
            if ($taskCounts[$req['type']] >= $req['tasks']) {
                $available[] = $pokemon;
            }
        }
        $unlockInfo[$pokemon] = [
            'current' => is_array($req['tasks']) ? array_map(function($type) use ($taskCounts) { return $taskCounts[$type]; }, array_keys($req['tasks'])) : $taskCounts[$req['type']],
            'required' => $req['tasks'],
            'display' => $req['display']
        ];
    }
    
    return ['available' => $available, 'requirements' => $unlockInfo];
}
