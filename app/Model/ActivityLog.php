<?php

namespace Model;
require_once '../app/core/Database.php';

use Database;
use DateMalformedStringException;
use DateTime;
use DateTimeZone;
use PDO;
class ActivityLog
{
    use Database;

    /**
     * @throws DateMalformedStringException
     */
    public function createActivityLog($userID, $role, $activityLog, $event): false|string
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Manila'));
        $formattedTime = $date->format('Y-m-d H:i:s'); // FULL Date and Time
        $query = 'CALL sp_create_activity_log(:id, :activity, :role, :event, :time)';
        $params = [
            'id' => $userID,
            'role' => $role,
            'activity' => $activityLog,
            'time' => $formattedTime,
            'event' => $event
        ];
        return $this->query2($query, $params);
    }

    public function getActivityLogForFaci($userID, $evnt): array
    {
        $query = 'CALL sp_get_user_activity_log(:userID, :evnt)';
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":userID",$userID);
        $stmt->bindParam(":evnt",$evnt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivityLogForUser($evnt): array
    {
        $query = 'CALL sp_get_activity_log_on_atten(:evnt)';
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":evnt",$evnt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}