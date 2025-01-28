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
Final: 25
Midterm: 20
Exam: 16
Test: 7
Quiz: 5
Homework: 3.5
*/

function xp ($duedate, $type) {

    $typeValues = [
        'Midterm' => 25,
        'Final' => 20,
        'Exam' => 16,
        'Test' => 8,
        'Quiz' => 5,
        'Homework' => 3.5
    ];

    if (array_key_exists($type, $typeValues)) {
        return $duedate * $typeValues[$type];
    } else {
        return 0; 
    }

}

function getxp($assignments) {

    $xp = 0;

    foreach ($assignments as $assignment) {
        $xp += xp($assignment['duedate'], $assignment['assigntype']);
    }

    return $xp;

}

echo xp(10, 'Midterm');