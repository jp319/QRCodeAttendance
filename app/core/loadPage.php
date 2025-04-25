<?php
require_once "../app/core/config.php"; // Load necessary configurations

$allowed_pages = ['Dashboard', 'Students', 'Attendance', 'Users', 'Reports'];
$page = $_GET['page'] ?? 'Dashboard';

// Validate page request
if (!in_array($page, $allowed_pages)) {
    $page = 'Dashboard'; // Default to Dashboard if invalid
}

$filePath = "../app/Controller/{$page}.php";

// Check if file exists before including
if (file_exists($filePath)) {
    require $filePath;
} else {
    echo "<p class='text-red-600'>Error: Page not found!</p>";
}
