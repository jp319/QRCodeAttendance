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
        /* Custom maroon theme */
        :root {
            --maroon: #800000;
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

<!-- Hero Section -->
<section class="flex-grow flex flex-col items-center justify-center text-center p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-6xl font-extrabold text-[var(--maroon)] mb-6">
            Welcome to the QR Attendance System
        </h1>
        <p class="text-gray-700 text-lg md:text-xl mb-8">
            Track student attendance seamlessly and efficiently. Simplified, secure, and built for you.
        </p>

        <!-- Get Started Button -->
        <a href="/public/login" class="inline-block bg-[var(--maroon)] hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition duration-300">
            Get Started
        </a>

        <!-- Infographic Images -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Infographic 1 -->
            <div class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                <img src="https://img.freepik.com/free-vector/qr-code-characters-their-laptop_23-2148626341.jpg?t=st=1745660972~exp=1745664572~hmac=d09c618d59c2ec53b074801ad670d929a891e338044a158707efcd2812f9c4f0&w=996"
                     alt="QR Code Attendance" class="w-full h-60 object-cover">
            </div>

            <!-- Infographic 2 -->
            <div class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                <img src="https://cdn.pixabay.com/photo/2021/10/01/13/35/data-6672201_1280.jpg"
                     alt="Data Analytics" class="w-full h-60 object-cover">
            </div>

            <!-- Infographic 3 -->
            <div class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                <img src="https://cdn.pixabay.com/photo/2017/01/31/15/39/checklist-2023737_1280.png"
                     alt="Checklist Attendance" class="w-full h-60 object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-[var(--maroon)] text-white text-center p-4">
    &copy; <?php echo date('Y'); ?> Attendance System. All rights reserved.
</footer>

</body>
</html>
