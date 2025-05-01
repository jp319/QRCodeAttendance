<?php

namespace Controller;

class ViewAttendanceRecord2 extends \Controller
{
    public function index(){
        $this->loadView('view_attendance_record2');
    }

}

$viewAttendanceRecord2 = new ViewAttendanceRecord2();
$viewAttendanceRecord2->index();