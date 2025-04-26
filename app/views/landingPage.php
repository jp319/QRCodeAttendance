<?php
global $imageSource;
require "../app/core/imageConfig.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?php echo $imageSource ?>">
    <title>Attendance System • Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --maroon: #800000;
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
<header class="bg-[var(--maroon)] text-white">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">

    </div>
</header>
<section class="flex-grow flex flex-col items-center justify-center text-center p-8">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-5xl md:text-7xl font-extrabold text-[var(--maroon)] mb-6 leading-tight">
            Welcome to the <br> QR Code Attendance System
        </h1>
        <p class="text-gray-700 text-lg md:text-2xl mb-8 font-medium">
            University of Southeastern Philippines Tagum-Mabini Campus QR Code Attendance System.
            <br class="hidden md:block">
            This platform streamlines student attendance tracking through secure QR code scanning,
            ensuring accuracy, reliability, and real-time monitoring for school activities.
        </p>
        <a href="/public/login" class="inline-block bg-[var(--maroon)] hover:bg-red-700 text-white font-bold py-4 px-10 rounded-full shadow-lg transition transform hover:scale-105 duration-300">
            Get Started
        </a>
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-300">
                <img src="https://img.freepik.com/free-vector/qr-code-characters-their-laptop_23-2148626341.jpg?t=st=1745660972~exp=1745664572~hmac=d09c618d59c2ec53b074801ad670d929a891e338044a158707efcd2812f9c4f0&w=996"
                     alt="QR Code Attendance" class="w-full h-64 object-cover">
            </div>
            <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-300">
                <img src="https://img.freepik.com/free-vector/data-analyst-oversees-governs-income-expenses-with-magnifier-financial-management-system-finance-software-it-management-tool-concept_335657-1891.jpg?t=st=1745660844~exp=1745664444~hmac=bbbd6e822e1f2b4857ed85d114421a6e66a6f6fd0c72af0975b438a0634b05b3&w=996"
                     alt="Data Analytics" class="w-full h-64 object-cover">
            </div>
            <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-300">
                <img src="https://img.freepik.com/free-vector/confirmed-attendance-concept-illustration_114360-30959.jpg?t=st=1745661282~exp=1745664882~hmac=dc8da9e0f15c298e244c05b65f3621d35dc51faacaebc4b45009a3b64b3f0177&w=740"
                     alt="Checklist Attendance" class="w-full h-64 object-cover">
            </div>
        </div>
    </div>
</section>
<footer class="bg-[var(--maroon)] text-white text-center p-6 mt-12">
    <p class="text-sm">&copy; <?php echo date('Y'); ?> University of Southeastern Philippines. All rights reserved.</p>
</footer>
</body>
</html>
