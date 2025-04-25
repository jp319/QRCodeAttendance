<?php

namespace Model;
require_once '../app/core/Database.php';

use Database;
use PDO;
class ActivityLog
{
    use Database;
    public function createActivityLog($userID,$role,  $activityLog,$event): false|string
    {
        $query = 'CALL createActivityLog(:id,:activity, :role, :event)';
        $params = [
            'id' => $userID,
            'activity' => $activityLog,
            'role' => $role,
            'event' => $event

        ];
        return $this->query2($query, $params);
    }

    public function getActivityLogForFaci($userID, $evnt): array
    {
        $query = 'CALL getUserActivityLog(:userID, :evnt)';
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":userID",$userID);
        $stmt->bindParam(":evnt",$evnt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivityLogForUser($evnt): array
    {
        $query = 'CALL getActivityLogOnAtten(:evnt)';
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":evnt",$evnt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}