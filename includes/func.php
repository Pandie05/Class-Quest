<?php
include __DIR__ . '../../model/db.php';

//testing this
function getPet($id) {

    global $db;

    $sql = "SELECT * FROM pets WHERE user_id = :id";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetch();

}

function getAssignments() {
    global $db;
    
    // Only get assignments for the logged-in user
    $sql = "SELECT * FROM assignments WHERE userID = :userID";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $_SESSION['user_id'], PDO::PARAM_INT);
    
    $stmt->execute();
    
    return $stmt->fetchAll();
}

function getAssignment($id) {
    global $db;
    
    // Get specific assignment but only if it belongs to the logged-in user
    $sql = "SELECT * FROM assignments WHERE ID = :id AND userID = :userID";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $_SESSION['user_id'], PDO::PARAM_INT);
    
    $stmt->execute();
    
    return $stmt->fetch();
}

function addAssignment($title, $classname, $duedate, $assigntype, $xp) {
    global $db;
    
    $sql = "INSERT INTO assignments (userID, title, classname, duedate, assigntype, xp) VALUES (:userID, :title, :classname, :duedate, :assigntype, :xp)";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':classname', $classname, PDO::PARAM_STR);
    $stmt->bindParam(':duedate', $duedate, PDO::PARAM_STR);
    $stmt->bindParam(':assigntype', $assigntype, PDO::PARAM_STR);
    $stmt->bindParam(':xp', $xp, PDO::PARAM_INT);
    
    return $stmt->execute();
}

function daysUntilDue($duedate) {

    $now = new DateTime();
    $due = new DateTime($duedate);
    
    $diff = $now->diff($due);
    
    return $diff->days;

}

function xp($duedate, $type) {
    $typeValues = [
        'final' => 20,
        'midterm' => 17,
        'exam' => 15,
        'test' => 9,
        'quiz' => 6,
        'homework' => 4.5
    ];

    $days = daysUntilDue($duedate);

    if ($days < 0) {
        return 0;
    }

    return $typeValues[$type] * $days;
}
