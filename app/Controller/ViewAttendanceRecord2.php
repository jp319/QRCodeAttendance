<?php

namespace Controller;

use Model\Attendances;
require_once "../app/Model/Attendances.php";
class ViewAttendanceRecord2 extends \Controller
{
    public function index($data): void
    {
        $this->loadViewWithData('view_attendance_record2', $data);
    }

}
$attendance = new Attendances();
$sanctioned = $attendance->vwStudentSanctioned($_GET['eventName']);
$data = [
    'sanctioned' => $sanctioned
];
$viewAttendanceRecord2 = new ViewAttendanceRecord2();
$viewAttendanceRecord2->index($data);