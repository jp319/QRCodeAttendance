<?php

namespace Controller;

require_once '../app/Model/Sanction.php';
require_once '../app/Model/User.php';

use Model\Sanction;
use Model\User;

class SanctionSummary extends \Controller
{
    public function index($data)
    {
        $this->loadViewWithData('sanctions_summary',$data);
    }
}

$user = new User();
$userData = $user->checkSession('sanctions_summary');
if (!$userData || !isset($userData['role']) || $userData['role'] !== 'admin') {
    $uri = str_replace('/sanctions_summary', '/login', $_SERVER['REQUEST_URI']);
    header('Location: '. $uri);
    exit();
}

$sanction = new Sanction();
$sanctionSummary = $sanction->getSanctionSummary();

$data = [
    'sanctionSummary' => $sanctionSummary
];

$sanctionSummary->index($data);
