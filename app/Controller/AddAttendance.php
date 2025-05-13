<?php

namespace Controller;
require_once "../app/Model/Student.php";
require_once "../app/Model/User.php";
require_once "../app/Model/Attendances.php";
use Controller;
use Model\Attendances;
use Model\Student;
use Model\User;

session_start();
class AddAttendance extends Controller
{
    public function index($data): void
    {
        $this->loadViewWithData('add_attendance',$data);
    }
}
$attendance = new Attendances();
$user = new User();
$user_de = $user->checkSession('add_attendance');
if ($user_de['role'] !== 'admin') {
    $uri = str_replace('/add_attendance', '/login', $_SERVER['REQUEST_URI']);
    header('Location: ' . $uri);
}
$student = new Student();
$program = $student->getAllProgram();
$year = $student->getAllYear();

$data = [
    'programs' => $program,
    'years' => $year
];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!$attendance->getAttendanceDetails(0,$_POST['eventName'])){

        // Ensure the values are arrays before converting to JSON
        $programs = $_POST['program'] ?? [];
        $years = $_POST['year'] ?? [];
        $requiredAttendanceRecord = $_POST['required_attendance'] ?? [];

        // Filter out empty year values and ensure they are properly formatted
        $years = array_filter($years, function($year) {
            return !empty($year) && $year !== '';
        });

        // If no years are selected, set a default empty array
        if (empty($years)) {
            $years = [];
        }

        // Ensure programs and years arrays are aligned
        if (count($programs) > count($years)) {
            // Pad years array with empty strings to match programs length
            $years = array_pad($years, count($programs), '');
        }
        print_r($years);

        $attendance->insertAttendance($_POST['eventName'], $programs, $years, $requiredAttendanceRecord, $_POST['sanction']);
        $_SESSION['success_message'] = 'Attendance successfully added!';
    }else{
        echo "<script>alert('Invalid event name. Event already exists!');</script>";
    }
}
$attendance = new AddAttendance();
$attendance->index($data);