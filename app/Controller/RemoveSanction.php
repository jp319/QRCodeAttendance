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

        // Redirect to history page with a success flag
        header("Location: " . ROOT . "history?removed=1");
        exit;
    }

}
$removeSanction = new RemoveSanction();
$removeSanction->index();