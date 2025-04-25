<?php

namespace Controller;
require_once '../app/core/config.php';
require_once '../app/core/Model.php';
require_once '../app/Model/User.php';
use Controller;
use Model\User;

session_start();

class StudentHome extends Controller
{
    use \Model;
    public function index(): void
    {
        $userSessions = json_decode($_COOKIE['user_data'], true);
        $username = $userSessions[0]['username']; // Get the first logged-in user
        $this->updateStatus($username, 'login');
        $this->loadView('studentHome');
    }
}


//$user = new User();
//$user_de = $user->checkSession('student');
//if ($user_de['role'] !== 'student') {
//    $uri = str_replace('/student', '/404', $_SERVER['REQUEST_URI']);
//    header('Location: ' . $uri);
//}
$user = new User();
$userData = $user->checkSession('student');

if (!$userData || !isset($userData['role']) || $userData['role'] !== 'student') {
    $uri = str_replace('/student', '/login', $_SERVER['REQUEST_URI']);
    header('Location: ' . $uri);
    exit();
}



$studentHome = new StudentHome();
$studentHome->index();