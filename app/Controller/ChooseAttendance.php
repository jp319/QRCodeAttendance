<?php

namespace Controller;
require_once '../app/core/config.php';
require_once '../app/Model/User.php';
use Controller;
use Model\User;

class ChooseAttendance extends Controller
{
    public function index()
    {
        $this->loadView('choose_attendance');
    }
}
$user = new User();
$user_de = $user->checkSession('choose_attendance');
if ($user_de['role'] !== 'admin') {
    $uri = str_replace('/add_attendance', '/login', $_SERVER['REQUEST_URI']);
    header('Location: ' . $uri);
}

$chooseAttendance = new ChooseAttendance();
$chooseAttendance->index();