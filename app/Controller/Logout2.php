<?php

namespace Controller;

require '../app/core/config.php';
require '../app/core/Database.php';
class Logout2
{
    use \Database;
    public function updateStatus($userId, $status): void
    {
        $query = "UPDATE users SET state = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$status, $userId]);

    }

    public function index(): void
    {
            $userId = $_GET['sessionID'];
            // Update user status to 'offline'
            $this->updateStatus($_GET['user_id'], 'offline');

            // Delete this session from the database
            $stmt = $this->connect()->prepare("DELETE FROM user_sessions WHERE id = ?");
            $stmt->execute([$userId]);
            header('Location: ' . ROOT . 'adminHome?page=Users');
    }

}

$logout2 = new Logout2();
$logout2->index();