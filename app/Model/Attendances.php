<?php

namespace Model;
require_once '../app/core/Database.php';
use Database;
use PDO;

class Attendances
{
    use Database;

    public function insertAttendance($name, $requiredAttendees, $year, $requiredAttendanceRecord, $sanction): false|string
    {
        $status = 'not started';  // default

        // Convert arrays to JSON format
        $requiredAttendeesJson = json_encode($requiredAttendees);
        $yearJson = json_encode($year);
        $requiredAttendanceRecordJson = json_encode($requiredAttendanceRecord);

        $query = "CALL InsertAttendance(:name, :status, :requiredAttendees, :year, :sanction,:requiredAttendanceRecord)";
        $params = [
            ':name' => $name,
            ':status' => $status,
            ':requiredAttendees' => $requiredAttendeesJson,
            ':year' => $yearJson,
            ':requiredAttendanceRecord' => $requiredAttendanceRecordJson,
            ':sanction' => $sanction
        ];
        // Execute the query
        return $this->query2($query, $params);
    }
    public function deleteAttendance($id): bool|array
    {
        $query = "DELETE FROM attendance WHERE atten_id = :id";
        $query2 = "DELETE FROM attendance_record WHERE atten_id = :id";
        $params2 = [
            ':id' => $id
        ];
        $params = [
            ':id' => $id
        ];
        $this->query($query2, $params2);
        return $this->query($query, $params);
    }

    function getAllAttendance(): array
    {
        $query = "SELECT * FROM viewattendance";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAttendanceDetails($id, $eventName): bool|array
    {
        $query = "CALL getAttendanceDetails(:id, :event_name)";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":event_name", $eventName);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countAttendanceRecord($eventID){
        $qury = "CALL countStudentAttend(:eventID)";
        $stmt = $this->connect()->prepare($qury);
        $stmt->bindParam(":eventID", $eventID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function AttendanceRecord($program,$year,$atten_id): bool|array
    {
        $query = "CALL getAttendanceRecord(?,?,?)";
        return $this->query($query,[$program,$year,$atten_id]);
    }

    public function getAttendanceRecord($programJson, $eventID, $searchQuery): array
    {
        // Ensure $programJson is a valid JSON string or convert it to an array
        if (is_string($programJson)) {
            $programs = json_decode($programJson, true);
        } elseif (is_array($programJson)) {
            $programs = $programJson;
        } else {
            $programs = []; // Default to an empty array
        }

        if (empty($programs)) {
            return []; // Prevent errors if decoding fails
        }

        $sql = "CALL getStudentAttendanceRecord(?, ?, ?, ?, ?)";
        $sql2 = "CALL getStudentAttendanceRecord2(?, ?, ?, ?)";

        if (!in_array('AllStudents', $programs)) {
            $programList = json_encode($programs); // Ensure valid JSON for MySQL JSON functions
            $attendanceRecords = $this->query($sql, [$searchQuery, $searchQuery, $searchQuery, $programList, $eventID]);
        } else {
            $attendanceRecords = $this->query($sql2, [$searchQuery, $searchQuery, $searchQuery, $eventID]);
        }

        // Ensure query result is an array
        return is_array($attendanceRecords) ? $attendanceRecords : [];
    }


    public function deleteAttendanceRecord($id1, $id2): bool|array{
        $query = "DELETE FROM attendance_record WHERE atten_id = :id1 AND student_id = :id2";
        $params = [
            ':id1' => $id1,
            ':id2' => $id2
        ];
        return $this->query($query, $params);
    }

    public function AttendanceRecord2($atten_id): array
    {
        $sql = 'CALL AttendanceRecord(:id)';
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":id", $atten_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkAttendanceOnGoing(): bool|array
    {
        $sql = "CALL checkAttendanceOnGoing()";
        return $this->query($sql);
    }

    public function searchAttendance($searchQuery): array{
        $sql = "CALL searchAttendance(:searchQuery)";
        $search = '%'.$searchQuery.'%';
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':searchQuery', $search);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentsWhoDidNotAttend($eventID, $program, $year): array
    {
        $query = "CALL getStudentNotAttended(:eventID,:program,:year)";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":eventID", $eventID);
        $stmt->bindParam(":program", $program);
        $stmt->bindParam(":year", $year);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function vwStudentSanctioned($event): array
    {
        $query = 'CALL vw_sanctioned(:event)';
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":event", $event);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function StudentAttendanceRecord($id): array
    {
        $query = "CALL student_attendance_record(:student_id)";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":student_id", $id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}