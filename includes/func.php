<?php

$dueDate = "2025-01-20";

//test for assignment creation xp (change to datetime for more accuracy)
function creation_xp($dueDate){

    $currentDate = new DateTime();
    
    $dueDateTime = new DateTime($dueDate);

    $interval = $currentDate->diff($dueDateTime);
    
    if ($dueDateTime > $currentDate) {
        return $interval->days; 
    } else {
        return 0; 
    }
    
}

echo "Days until due: " . creation_xp($dueDate);

function getAssignments() {

    $skibidi = 1;

}