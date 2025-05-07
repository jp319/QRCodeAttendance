<?php

namespace Controller;
require_once '../app/core/Model.php';
require_once '../app/Model/User.php';
require_once '../app/core/Controller.php';

use Model\User;

class Users extends \Controller
{
    public function index($data): void
    {
        $this->loadViewWithData('userAdmin',$data);
    }

}

$userAdmin = new Users();
$user = new User();
//$limit = 7; // Number of users per page
//$page = isset($_POST['page1']) ? (int)$_POST['page1'] : 1;
//
//$offset = ($page - 1) * $limit;
//
//$totalUsers = $user->getUserCount();
//$totalPages = ceil($totalUsers / $limit);

$userList = $user->getAllUsers();


    if (!empty($_GET["search"])) {

        $searchQuery = $_GET["search"];
        $userList = $user->searchUsers($searchQuery);
    }


$data = [
    'userList' => $userList,
];


$userAdmin->index($data);