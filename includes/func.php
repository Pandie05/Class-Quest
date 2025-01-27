<?php
include __DIR__ . '../../model/db.php';


function getAssignments() {

    global $db;

    $sql = "SELECT * FROM assignments";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll();

}

function getAssignment($id) {

    global $db;

    $sql = "SELECT * FROM assignments WHERE id = :id";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetch();

}

/*
Midterm / Final: 20
Exam: 16
Test: 7
Quiz: 5
Homework: 3.5
*/

echo "assignment is due: " . getAssignment(1)['duedate'];

