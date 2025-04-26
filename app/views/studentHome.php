<?php


global $imageSource;
require_once '../app/core/imageConfig.php'; // Include your configuration file

$page = $_GET['page'] ?? 'studentProfile'; // Default to 'studentProfile'
$allowed_pages = ['StudentProfile', 'StudentQRCode', 'StudentReport'];

// Prevent loading invalid files
if (!in_array($page, $allowed_pages)) {
    $page = 'StudentProfile';
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="<?php echo $imageSource ?>">
    <title>Student Home • QRCode Attendance System</title>
    <style>
        /* Maroon Color Theme */
        .maroon {
            background-color: #800000;
        }
        .maroon-light {
            background-color: #a52a2a;
        }
        .maroon-hover:hover {
            background-color: #660000;
        }
        .text-maroon {
            color: #800000;
        }
        .text-maroon-hover:hover {
            color: #660000;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

<!-- Container -->
<div class="min-h-screen flex flex-col">

    <!-- Header Section -->
    <header class="bg-white shadow-md w-full">
        <div class="max-w-7xl mx-auto p-4 flex flex-col md:flex-row items-center justify-between">
            <img class="h-20 w-auto mb-2 md:mb-0" src="<?php echo $imageSource4 ?>" alt="Logo" />

        </div>
    </header>

    <!-- Navigation Section -->
    <nav class="w-full bg-white shadow-md">
        <div class="max-w-7xl mx-auto p-4 flex flex-col md:flex-row justify-center space-y-2 md:space-y-0 md:space-x-4">
            <a href="?page=studentProfile"
               class="px-6 py-2 rounded-full text-lg font-semibold transition
                  <?php echo $page === 'studentProfile' ? 'maroon text-white' : 'bg-gray-200 text-gray-700'; ?>
                  hover:maroon-hover hover:text-white">
                Profile
            </a>
            <a href="?page=StudentQRCode"
               class="px-6 py-2 rounded-full text-lg font-semibold transition
                  <?php echo $page === 'StudentQRCode' ? 'maroon text-white' : 'bg-gray-200 text-gray-700'; ?>
                  hover:maroon-hover hover:text-white">
                QR Code
            </a>
            <a href="?page=StudentReport"
               class="px-6 py-2 rounded-full text-lg font-semibold transition
                  <?php echo $page === 'StudentReport' ? 'maroon text-white' : 'bg-gray-200 text-gray-700'; ?>
                  hover:maroon-hover hover:text-white">
                Reports
            </a>
            <a href="<?php echo ROOT ?>logout"
               class="px-6 py-2 rounded-full text-lg font-semibold transition bg-red-600 text-white hover:bg-red-800">
                Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 flex justify-center items-center p-4">
        <div class="bg-white shadow-lg rounded-lg w-full max-w-4xl p-6">
            <?php require "../app/Controller/{$page}.php"; ?>
        </div>
    </main>

    <!-- Footer Section (Sticky) -->
    <footer class="maroon text-white py-4 w-full flex-shrink-0">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center">
            <div class="text-sm">
                &copy; <?php echo date('Y'); ?> QRCode Attendance System. All rights reserved.
            </div>

        </div>
    </footer>
</div>

</body>

<script>
    // Disable right-click
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // Disable F12, Ctrl+Shift+I, Ctrl+U
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F12' ||
            (e.ctrlKey && e.shiftKey && e.key === 'I') ||
            (e.ctrlKey && e.key === 'u')) {
            e.preventDefault();
        }
    });
</script>


</html>
