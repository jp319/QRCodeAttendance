<?php

namespace Controller;
require_once '../app/Model/Sanction.php';
require_once '../app/Model/Attendances.php';

use Model\Attendances;
use Model\Sanction;

class StudentReport extends \Controller
{
    public function index(): void
    {
        $sanction = new Sanction();
        $attendance = new Attendances();



        $userSessions = json_decode($_COOKIE['user_data'], true);
        $userID = $userSessions[0]['user_id']; // Get the first logged-in user
        $sanctionList = $sanction->getStudentSanctions($userID);
        $attendanceRecord = $attendance->StudentAttendanceRecord($userID);

        $data = [
            'sanctionList' => $sanctionList,
            'attendanceRecord' => $attendanceRecord
        ];
        $this->loadViewWithData('studentReport', $data);
    }
}

$studentReport= new StudentReport();
$studentReport->index();