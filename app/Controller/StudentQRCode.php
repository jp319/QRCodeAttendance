<?php

namespace Controller;
require_once '../app/Model/QRCode.php';
require_once '../app/Model/Student.php';
use Model\QRCode;
use Model\Student;

class StudentQRCode extends \Controller
{
    public function index($data): void
    {
        $this->loadViewWithData('studentQRCode', $data);
    }
}

$studentQRCode = new StudentQRCode();
$student = new Student();
// Create an instance of qr_code
$qr_code = new QRCode();
$userSessions = json_decode($_COOKIE['user_data'], true);
$username = $userSessions[0]['username']; // Get the first logged-in user
$qr_value = $qr_code->getQRValue($username); // Fetch QR value
$checker = $qr_code->checkIfStudentHasProfile($username);

$studentData = $student->getStudentInfo();


$data =[
    'qr_value' => $qr_value,
    'checker' => $checker,
    'studentData' => $studentData
];
$studentQRCode->index($data);