<?php

namespace Controller;
require "../app/Model/Attendances.php";
require "../app/Model/ActivityLog.php";
use Controller;
use Model\ActivityLog;
use Model\Attendances;
session_start();
class DeleteAttendanceRecord extends Controller
{
    public function index(){
        $attendance = new Attendances();
        $activityLog = new ActivityLog();
        $attendance->deleteAttendanceRecord($_GET['atten_id'], $_GET['student_id']);
        $activityLog->createActivityLog($_SESSION['user_id'], $_SESSION['role'],$_SESSION['username'] .'<p style="color:red;"> Deleted attendance record: <p>'. $_GET['student_id'], $_SESSION['evnt_name']);
    }
}

$deleteAttendanceRecord = new DeleteAttendanceRecord();
$deleteAttendanceRecord->index();