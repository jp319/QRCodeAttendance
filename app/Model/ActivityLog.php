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
        $query = 'CALL createActivityLog(:id, :role,:activity, :time, :event)';
        $params = [
            'id' => $userID,
            'activity' => $activityLog,
            'role' => $role,
            'time' => $formattedTime,
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