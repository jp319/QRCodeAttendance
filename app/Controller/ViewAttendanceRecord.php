<?php

namespace Controller;
require_once "../app/Model/User.php";
require_once "../app/Model/Student.php";
require_once "../app/Model/Attendances.php";
use Controller;
use Model\Attendances;
use Model\Student;
use Model\User;

class ViewAttendanceRecord extends Controller
{
    public function index($data): void
    {
        $this->loadViewWithData('view_attendance_record',$data);
    }
}

$user = new User();
$user_de = $user->checkSession('add_attendance');
if ($user_de['role'] !== 'admin') {
    $uri = str_replace('/view_records', '/404', $_SERVER['REQUEST_URI']);
    header('Location: ' . $uri);
}
$attendance = new Attendances();
$student = new Student();


$attendanceDetails = $attendance->getAttendanceDetails($_GET['id'], $_GET['eventName']);
$requireProgram = $attendanceDetails['required_attendees'];
$EventName = $attendanceDetails['event_name'];
$EventID = $attendanceDetails['atten_id'];

$totalStudents = $student->getUserCount();
$attendedCount = $attendance->countAttendanceRecord($attendanceDetails['atten_id']);




$year = $student->getAllYear();
$programList = $student->getAllProgram();
$attendanceList = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['year']) && isset($_POST['program'])) {
        $attendanceList = $attendance->AttendanceRecord($_POST['program'], $_POST['year'], $_GET['id']);
    }elseif (isset($_POST['program'])){
        $attendanceList = $attendance->AttendanceRecord($_POST['program'], $_POST['year'], $_GET['id']);
    }else{
        $attendanceList = $attendance->getAttendanceRecord($requireProgram, $_GET['id'],$_POST['search']);
    }
}elseif (isset($_GET['view']) && $_GET['view'] === 'not_attended') {
    // Get students who did NOT attend
    $attendanceList = $attendance->getStudentsWhoDidNotAttend($EventID,$_GET['program'], $_GET['year']);
}

$data = [
    'year' => $year,
    'programList' => $programList,
    'attendanceList' => $attendanceList,
    'EventName' => $EventName,
    'EventID' => $EventID,
    'totalStudents' =>  $totalStudents,
    'attendedCount' => $attendedCount
];

$viewAttendanceRecord = new ViewAttendanceRecord();
$viewAttendanceRecord->index($data);