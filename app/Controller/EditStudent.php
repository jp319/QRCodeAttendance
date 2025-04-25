<?php

namespace Controller;
require_once "../app/Model/Student.php";
require_once '../app/Model/User.php';
require_once '../app/Model/Sanction.php';
require_once '../app/core/config.php';


use Model\Sanction;
use Model\Student;
use Model\User;

class EditStudent extends \Controller
{
    public function index($data): void
    {
        $this->loadViewWithData('edit_student',$data);
    }
}

$user = new User();
$userData = $user->checkSession('edit_student');
if (!$userData || !isset($userData['role']) || $userData['role'] !== 'admin') {
    $uri = str_replace('/edit_student', '/login', $_SERVER['REQUEST_URI']);
    header('Location: '. $uri);
    exit();
}

$student = new Student();
$sanction = new Sanction();
$studentData = $student->getStudentData($_GET['id']);
$sanctionList = $sanction->getStudentSanctions($_GET['id']);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['sanctionH']) && isset($_POST['reason'])) {
        // Insert Sanction
        $sanction = new Sanction();
        $sanction->insertSanction($_POST['id'], $_POST['reason'], $_POST['sanctionH']);
        header("Location: " . ROOT . "adminHome?page=Students");
        exit();
    }

        // Update Student Information
        $student->updateStudent($_POST['id'], $_POST['f_name'], $_POST['l_name'], $_POST['program'], $_POST['acad_year'], $_POST['email'], $_POST['contact_num']);
        $user->updateUser($_POST['id'], $_POST['email']);
        header("Location:".ROOT ."adminHome?page=Students");
        exit();

}

$data = [
    'studentData' => $studentData,
    'sanctionList' => $sanctionList,
];
$editStudent = new EditStudent();
$editStudent->index($data);