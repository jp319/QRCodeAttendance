<?php
$allowed_pages = ['Dashboard', 'Students', 'Attendance', 'Users', 'ProfileAdmin'];
$page = $_GET['page'] ?? 'Dashboard';

if (in_array($page, $allowed_pages)) {
    require_once "../app/Controller/{$page}.php";
} else {
    echo "<p class='text-red-500'>Invalid page.</p>";
}
