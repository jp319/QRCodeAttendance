<?php

namespace Controller;
require_once '../app/Model/Sanction.php';
use Model\Sanction;

class StudentReport extends \Controller
{
    public function index(): void
    {
        $sanction = new Sanction();
        $userSessions = json_decode($_COOKIE['user_data'], true);
        $userID = $userSessions[0]['user_id']; // Get the first logged-in user
        $sanctionList = $sanction->getStudentSanctions($userID);
        $data = [
            'sanctionList' => $sanctionList
        ];
        $this->loadViewWithData('studentReport', $data);
    }
}

$studentReport= new StudentReport();
$studentReport->index();