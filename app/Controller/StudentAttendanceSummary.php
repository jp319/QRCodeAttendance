<?php

namespace Controller;
require_once '../app/Model/Sanction.php';
require_once '../app/Model/Attendances.php';
require_once '../app/Model/User.php';

use Model\Sanction;
use Model\Attendances;
use Model\User;

class StudentAttendanceSummary extends \Controller
{
  

    public function index(): void
    {
        $sanction = new Sanction();
        $attendance = new Attendances();
    
    
        $userID = $_GET['student_id'];
        $sanctionList = $sanction->getStudentSanctions($userID);
        $attendanceRecord = $attendance->StudentAttendanceRecord($userID);
    
        $data = [
            'sanctionList' => $sanctionList,
            'attendanceRecord' => $attendanceRecord
        ];
        $this->loadViewWithData('student_attendance_summary', $data);
    }
    
}
$user = new User();
$userData = $user->checkSession('sanctions_summary');
if (!$userData || !isset($userData['role']) || $userData['role'] !== 'admin') {
    $uri = str_replace('/sanctions_summary', '/login', $_SERVER['REQUEST_URI']);
    header('Location: '. $uri);
    exit();
}

$studentAttendanceSummary = new StudentAttendanceSummary();
$studentAttendanceSummary->index();

