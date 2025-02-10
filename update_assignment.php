<?php
include __DIR__ . '/includes/gyatt.php';
include __DIR__ . '/includes/func.php';
include __DIR__ . '/model/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $done = $data['done'];

    try {
        // Start transaction
        $db->beginTransaction();

        // Update assignment status
        $sql = "UPDATE assignments SET done = :done WHERE id = :id AND userID = :userID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':done', $done, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $_SESSION['user']['ID'], PDO::PARAM_INT);
        $success = $stmt->execute();

        if (!$success) {
            throw new Exception("Failed to update assignment status");
        }

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
            $sql = "SELECT hp_awarded FROM assignments WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $assignment = $stmt->fetch(PDO::FETCH_ASSOC);
            $hpAwarded = $assignment['hp_awarded'];

            $newXp = $pet['xp'] + $assignmentXp;
            $newHp = $pet['hp'];

            if ($newXp >= 200) {
                petLevelup($userId);
                $newXp = $newXp % 200;
            }

            if (!$hpAwarded) {
                $newHp = min(100, $newHp + (0.2 * $assignmentXp));
                $sql = "UPDATE assignments SET hp_awarded = 1 WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } else {
            $newXp = $pet['xp'] - $assignmentXp;
            $newHp = $pet['hp'];

            while ($newXp < 0) {
                petLeveldown($userId);
                $newXp += 200; 
            }
        }

        // Update pet stats
        $sql = "UPDATE pets SET xp = :xp, hp = :hp WHERE userID = :userID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':xp', $newXp, PDO::PARAM_INT);
        $stmt->bindParam(':hp', $newHp, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Commit transaction
        $db->commit();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Rollback transaction on error
        $db->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}