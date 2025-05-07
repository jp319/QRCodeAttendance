<?php

namespace Controller;
require_once "../app/Model/User.php";
require_once '../app/core/Controller.php';
use Model\User;

class ProfileAdmin extends \Controller
{
    public function index(): void
    {
        if (!isset($_COOKIE['user_data'])) {
            die("Unauthorized Access!");
        }

        $userSession = json_decode($_COOKIE['user_data'], true);
        if (!$userSession || !isset($userSession[0]['username'], $userSession[0]['user_id'])) {
            die("Invalid session data!");
        }

        $username = $userSession[0]['username'];
        $userID = $userSession[0]['user_id'];

        $user = new User();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['username'])) {
                $user->updateUser($userID, $_POST['username']);
                echo "<script>Swal.fire('Success', 'Username Updated Successfully!', 'success');</script>";
            }

            if (!empty($_POST['password'])) {
                if (strlen($_POST['password']) < 8) {
                    echo "<script>Swal.fire('Error', 'Password must be at least 8 characters long!', 'error');</script>";
                } else {
                    $user->updatePassword($userID, $_POST['password']);
                    echo "<script>Swal.fire('Success', 'Password Updated Successfully!', 'success');</script>";
                }
            }
        }

        $userData = $user->getUserData($userID);

        $data = [
            'username' => $username,
            'userData' => $userData
        ];

        $this->loadViewWithData('profile', $data);
    }
}

$profileAdmin = new ProfileAdmin();
$profileAdmin->index();
