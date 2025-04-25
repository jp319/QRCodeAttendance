<?php

namespace Controller;
use JetBrains\PhpStorm\NoReturn;
use Model\QRCode;
use Model\Sanction;
use Model\Student;
use Model\User;

require '../app/core/config.php';
require '../app/core/Model.php';
require '../app/Model/QRCode.php';
require '../app/Model/User.php';
require '../app/Model/Student.php';
require '../app/Model/Sanction.php';
class DeleteStudent
{
    use \Model;
    #[NoReturn] public function index(): void
    {
        $qrcode = new QrCode();
        $student = new Student();
        $user = new User();
        $sanction = new Sanction();
        if (!empty($_GET['id'])) {
            $studentId = htmlspecialchars($_GET['id']); // Sanitize input
            $qrcode->deleteQRcode($studentId);//delete qrcode
            $this->deleteAttendanceRecord($studentId);
            $sanction->deleteSanction2($studentId);
            $student->deleteStudent($studentId);
            $user->deleteUsers($studentId);

        }

        // Redirect back to the home page or list view
        header("Location: " . ROOT . "adminHome?page=Students");
        exit;
    }

}

$deleteStudent = new DeleteStudent();
$deleteStudent->index();