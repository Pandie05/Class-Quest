<?php
include __DIR__ . '/includes/gyatt.php';
include __DIR__ . '/includes/func.php';
include __DIR__ . '/model/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $done = $data['done'];

    $sql = "UPDATE assignments SET done = :done WHERE id = :id AND userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':done', $done, PDO::PARAM_BOOL);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $_SESSION['user']['ID'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Fetch assignment XP
        $sql = "SELECT xp FROM assignments WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $assignment = $stmt->fetch(PDO::FETCH_ASSOC);
        $assignmentXp = $assignment['xp'];

        // Update pet XP and HP
        $userId = $_SESSION['user']['ID'];
        $sql = "SELECT hp, xp FROM pets WHERE userID = :userID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $pet = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($done) {
            // Add XP and update HP
            $newXp = $pet['xp'] + $assignmentXp;
            $newHp = $pet['hp'];

            // Level up if XP exceeds 150
            if ($newXp >= 150) {
                petLevelup($userId); // Increment level
                $newXp = $newXp % 150; // Remainder after leveling up
            }

            // Increase HP by 20% of assignment XP, capped at 100
            $newHp = min(100, $newHp + (0.2 * $assignmentXp));
        } else {
            // Subtract XP and update HP
            $newXp = $pet['xp'] - $assignmentXp;
            $newHp = $pet['hp'];

            // Ensure XP is not negative
            if ($newXp < 0) {
                $newXp = 0;
            }
        }

        // Update pet XP and HP in the database
        $sql = "UPDATE pets SET xp = :xp, hp = :hp WHERE userID = :userID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':xp', $newXp, PDO::PARAM_INT);
        $stmt->bindParam(':hp', $newHp, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->errorInfo()]);
    }
}
?>