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

        // Redirect back to the previous page with a success flag
        $previous = $_SERVER['HTTP_REFERER'] ?? ROOT . 'history'; // fallback to history
        header("Location: " . $previous . "?removed=1");
        exit;
    }


}
$removeSanction = new RemoveSanction();
$removeSanction->index();