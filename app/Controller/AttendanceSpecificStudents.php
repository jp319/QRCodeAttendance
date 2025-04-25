<?php

namespace Controller;
require_once '../app/core/config.php';
require_once '../app/Model/User.php';
use Model\User;


class AttendanceSpecificStudents extends \Controller
{
    public function index(): void
    {
        $this->loadView('attendance_specificStudents');
    }
}
$user = new User();
$user_de = $user->checkSession('create_attendance_for_student');
if ($user_de['role'] !== 'admin') {
    $uri = str_replace('/add_attendance', '/login', $_SERVER['REQUEST_URI']);
    header('Location: ' . $uri);
}


$attendanceSpecificStudents = new AttendanceSpecificStudents();
$attendanceSpecificStudents->index();