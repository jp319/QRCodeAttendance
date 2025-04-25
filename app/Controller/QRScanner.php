<?php

namespace Controller;


require_once '../app/Model/QRCode.php';
require_once '../app/Model/Student.php';
require_once '../app/Model/User.php';
require_once '../app/Model/ActivityLog.php';
use Controller;


use DateTime;
use Exception;
use Model\ActivityLog;
use Model\QRCode;
use Model\Student;
use Model\User;

session_start();
class QRScanner extends Controller
{

    public function processScannedData($data, $attenId, $RequiredProgram, $year, $onTimeCheck,$confirm = false): void
    {
        global $EventName;
        $userSessions = json_decode($_COOKIE['user_data'], true);

        $qrcode = new QRCode();
        $activityLog = new ActivityLog();

        try {
            $result = $qrcode->getQRData($data);

            if (!empty($result) && isset($result[0]['student_id'])) {
                $studentId = $result[0]['student_id'];

                $studentData = $qrcode->getStudentData($studentId);

                if (!empty($studentData)) {
                    $student = $studentData[0];

                    // Convert BLOB to base64
                    $studentProfileBase64 = !empty($student['studentProfile']) ? base64_encode($student['studentProfile']) : null;
                    $name = $student['f_name'].' '.$student['l_name'];
                    $program = $student['program'];
                    if (!$confirm) {
                        echo json_encode([
                            "status" => "success",
                            "student" => $name,
                            "studentProfile" => $studentProfileBase64,
                            "program" => $program

                        ]);
                        exit;
                    }

                    // Check if the student has already scanned
                    if($onTimeCheck == 0){
                        $attendanceExists = $qrcode->checkAttendance($attenId, $studentId);
                        if (!empty($attendanceExists)) {
                            echo json_encode([
                                "status" => "error",
                                "student" => $studentId,
                                "message" => "Student has already scanned!"
                            ]);
                            exit;
                        }
                    }elseif ($onTimeCheck == 1){
                        $attendanceExists = $qrcode->checkAttendance2($attenId, $studentId);
                        if (!empty($attendanceExists)) {
                            echo json_encode([
                                "status" => "error",
                                "student" => $studentId,
                                "message" => "Student has already scanned!"
                            ]);
                            exit;
                        }
                    }


                    // Check program requirement
                    if (in_array('AllStudents',$RequiredProgram)){
                        try {
                            if ($onTimeCheck == 0){
                                $qrcode->recordAttendance($attenId, $studentId,);

                                $activityLog->createActivityLog($_SESSION['user_id'], $_SESSION['role'],$_SESSION['username'] .' Scanned student: '. $studentId . ' (Time in)',$EventName);
                                echo json_encode([
                                    "status" => "success",
                                    "student" => $studentId,
                                    "message" => "QR Code Scanned Successfully! (Time in)"
                                ]);
                            }else{
                                $qrcode->recordAttendance2($attenId, $studentId,);
                                $activityLog->createActivityLog($_SESSION['user_id'], $_SESSION['role'],$_SESSION['username'] .' Scanned student: '. $studentId . ' (Time out)',$EventName );
                                echo json_encode([
                                    "status" => "success",
                                    "student" => $studentId,
                                    "message" => "QR Code Scanned Successfully! (Time out)"
                                ]);
                            }

                        } catch (Exception $e) {
                            echo json_encode([
                                "status" => "error",
                                "message" => "Database error: " . $e->getMessage()
                            ]);
                        }
                    } elseif (in_array($student['program'], $RequiredProgram) && in_array($student['acad_year'], $year)) {

                        try {
                            if ($onTimeCheck == 0){
                                $qrcode->recordAttendance($attenId, $studentId);
                                $activityLog->createActivityLog($_SESSION['user_id'], $_SESSION['role'],$_SESSION['username'] .' Scanned student: '. $studentId . ' (Time in)',$EventName);
                                echo json_encode([
                                    "status" => "success",
                                    "student" => $studentId,
                                    "message" => "QR Code Scanned Successfully! (Time in)"
                                ]);
                            }else{
                                $qrcode->recordAttendance2($attenId, $studentId,);
                                $activityLog->createActivityLog($_SESSION['user_id'], $_SESSION['role'],$_SESSION['username'] .' Scanned student: '. $studentId . ' (Time out)',$EventName);
                                echo json_encode([
                                    "status" => "success",
                                    "student" => $studentId,
                                    "message" => "QR Code Scanned Successfully! (Time out)"
                                ]);
                            }
                        } catch (Exception $e) {
                            echo json_encode([
                                "status" => "error",
                                "message" => "Database error: " . $e->getMessage()
                            ]);
                        }

                    }elseif (in_array($student['program'], $RequiredProgram) && in_array('',$year)){
                        try {
                            if ($onTimeCheck == 0){
                                $qrcode->recordAttendance($attenId, $studentId,);
                                $activityLog->createActivityLog($_SESSION['user_id'], $_SESSION['role'],$_SESSION['username'] .' Scanned student: '. $studentId . ' (Time in)',$EventName);
                                echo json_encode([
                                    "status" => "success",
                                    "student" => $studentId,
                                    "message" => "QR Code Scanned Successfully! (Time in)"
                                ]);
                            }else{
                                $qrcode->recordAttendance2($attenId, $studentId,);
                                $activityLog->createActivityLog($_SESSION['user_id'], $_SESSION['role'], $_SESSION['username'] .' Scanned student: '. $studentId . ' (Time out)',$EventName);
                                echo json_encode([
                                    "status" => "success",
                                    "student" => $studentId,
                                    "message" => "QR Code Scanned Successfully! (Time out)"
                                ]);
                            }
                        } catch (Exception $e) {
                            echo json_encode([
                                "status" => "error",
                                "message" => "Database error: " . $e->getMessage()
                            ]);
                        }
                    } else {
                        echo json_encode([
                            "status" => "error",
                            "student" => $studentId,
                            "message" => "Student is not required to attend!"
                        ]);
                    }

                }
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Student not found!"
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => "An error occurred: " . $e->getMessage()
            ]);
        }
        exit;
    }

    public function updateStatus($username, $status): void
    {
        $user = new User();
        $user->updateStatus($username, $status);
    }


    public function index($data): void
    {
        $this->loadViewWithData('scanner', $data);
    }
}

//make sure this page is protected
//$user = new User();
//$user_de = $user->checkSession('scanner');
//if ($user_de['role'] !== 'Facilitator') {
//    $uri = str_replace('/scanner', '/404', $_SERVER['REQUEST_URI']);
//    header('Location: ' . $uri);
//}
$user = new User();
$userData = $user->checkSession('canner');

if (!$userData || !isset($userData['role']) || $userData['role'] !== 'Facilitator') {
    $uri = str_replace('/facilitator', '/login', $_SERVER['REQUEST_URI']);
    header('Location: ' . $uri);
    exit();
}


$qrcode = new QRCode();
$qrCodeScanner = new QRScanner();
$attendanceList = $qrcode->getAttendance();

$AttendanceID = '';
$EventName = 'No Event';
$EventDate = 'No Date';
$EventTime = 'No Time';
$ProgramRequired = NULL;
$YearRequired = NULL;
$onTimeCheck = 0;
$isOngoing = false;

foreach ($attendanceList as $attendance) {
    if ($attendance['atten_status'] == 'on going') {
        $EventName = htmlspecialchars($attendance['event_name']);
        try {
            $dateTime = new DateTime($attendance['atten_started']);
        } catch (\DateMalformedStringException $e) {

        }
        $EventDate = $dateTime->format('F j, Y');
        $EventTime = $dateTime->format('h:i A');
        $AttendanceID = htmlspecialchars($attendance['atten_id']);
        $isOngoing = true;
        $ProgramRequired = json_decode($attendance['required_attendees'], true) ?? [];
        $YearRequired = json_decode($attendance['acad_year']);
        $onTimeCheck = $attendance['atten_OnTimeCheck'];
        break;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['qrData']) && isset($_POST['atten_id'])) {
    $confirm = isset($_POST['confirm']) && $_POST['confirm'] === 'true';
    $qrCodeScanner->processScannedData($_POST['qrData'], $_POST['atten_id'], $ProgramRequired, $YearRequired, $onTimeCheck, $confirm);
}


$data = [
    "attendanceList" => $attendanceList,
    "attendanceID" => $AttendanceID,
    "EventName" => $EventName,
    "EventDate" => $EventDate,
    "EventTime" => $EventTime,
    "ProgramRequired" => $ProgramRequired,
    "YearRequired" => $YearRequired,
    "isOngoing" => $isOngoing

];


$qrCodeScanner->index($data);