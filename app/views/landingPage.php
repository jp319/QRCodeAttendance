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
                <img src="https://images.unsplash.com/photo-1630934458093-04247d2b7d94?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400"
                     alt="Attendance Infographic" class="w-full h-60 object-cover">
            </div>

            <!-- Infographic 2 -->
            <div class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                <img src="https://images.unsplash.com/photo-1613145999591-ff1cb9f3d73c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400"
                     alt="QR Code Infographic" class="w-full h-60 object-cover">
            </div>

            <!-- Infographic 3 -->
            <div class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                <img src="https://images.unsplash.com/photo-1591696205602-2b6a06bda8f3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400"
                     alt="Analytics Infographic" class="w-full h-60 object-cover">
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
