<?php

namespace Controller;
require_once '../app/Model/Sanction.php';
require_once '../app/core/config.php';
use Controller;
use Model\Sanction;

class RemoveSanction extends Controller
{

    public function index(): void
    {
        $sanction = new Sanction();
        $sanction->deleteSanction($_GET['id']);
        // Redirect back to the home page or list view
        header("Location: " . ROOT . "adminHome?page=Students");
        exit;

    }
}
$removeSanction = new RemoveSanction();
$removeSanction->index();