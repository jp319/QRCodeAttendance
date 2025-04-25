<?php

namespace Controller;
require "../app/core/Model.php";
use Controller;
use Model;

class Dashboard extends Controller
{
    use Model;
    public function index($numberOfStudents, $numberOfAttendance, $numberOfFaci, $listOfFaci, $listOfAttendance){
        $data = [
            'numberOfStudents' => $numberOfStudents,
            'numberOfAttendance' => $numberOfAttendance,
            'numberOfFaci' => $numberOfFaci,
            'listOfFaci' => $listOfFaci,
            'listOfAttendance' => $listOfAttendance
        ];
        $this->loadViewWithData('dashboardAdmin', $data);
    }
}
$dash = new Dashboard();
$numberOfStudents = $dash->getAllStudentsCount();
$numberOfAttendance = $dash->getAllAttendanceCount();
$numberOfFaci = $dash->getAllFaciCount();

$listOfFaci = $dash->getAllFaci();
$listOfAttendance = $dash->getAllAttendance();
$dash->index($numberOfStudents,$numberOfAttendance,$numberOfFaci,$listOfFaci,$listOfAttendance);