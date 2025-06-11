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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
        
        :root {
            --maroon: #800000;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-image: 
                radial-gradient(circle at 1px 1px, #e2e8f0 1px, transparent 0),
                linear-gradient(to right, rgba(255,255,255,0.2), rgba(255,255,255,0.2));
            background-size: 24px 24px;
            background-color: #f8f9fa;
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <header class="bg-gradient-to-r from-[var(--maroon)] to-red-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex items-center space-x-4">
                <img src="<?php echo $imageSource ?>" alt="Logo" class="h-12 w-auto">
                <span class="text-2xl font-bold">USeP QR</span>
            </div>
            <a href="/public/login" 
               class="bg-white text-[var(--maroon)] px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg">
                Sign In
            </a>
        </div>
    </header>

    <section class="flex-grow flex flex-col items-center justify-center text-center p-8 relative overflow-hidden">
        <div class="max-w-6xl mx-auto z-10">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
                <span class="text-[var(--maroon)] drop-shadow-sm">Welcome to the</span>
                <br class="hidden md:block">
                <span class="bg-gradient-to-r from-[var(--maroon)] to-red-900 text-transparent bg-clip-text">
                    QR Code Attendance System
                </span>
            </h1>
            
            <p class="text-gray-700 text-lg md:text-2xl mb-12 font-medium max-w-4xl mx-auto leading-relaxed">
                University of Southeastern Philippines Tagum-Mabini Campus QR Code Attendance System.
                Experience seamless attendance tracking through secure QR code scanning.
            </p>

            <div class="flex flex-col md:flex-row gap-6 justify-center items-center mb-16">
                <a href="/public/login" 
                   class="inline-flex items-center bg-gradient-to-r from-[var(--maroon)] to-red-900 text-white font-bold py-4 px-10 rounded-full shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 group">
                    Get Started
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="glass-card rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 floating">
                    <img src="https://img.freepik.com/free-vector/qr-code-characters-their-laptop_23-2148626341.jpg"
                         alt="QR Code Attendance" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[var(--maroon)] mb-2">QR Code Scanning</h3>
                        <p class="text-gray-600">Quick and efficient attendance tracking using modern QR technology.</p>
                    </div>
                </div>
                
                <div class="glass-card rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 floating" style="animation-delay: 0.2s">
                    <img src="https://img.freepik.com/free-vector/data-analyst-oversees-governs-income-expenses-with-magnifier-financial-management-system-finance-software-it-management-tool-concept_335657-1891.jpg"
                         alt="Data Analytics" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[var(--maroon)] mb-2">Real-time Analytics</h3>
                        <p class="text-gray-600">Comprehensive attendance data and insights at your fingertips.</p>
                    </div>
                </div>
                
                <div class="glass-card rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 floating" style="animation-delay: 0.4s">
                    <img src="https://img.freepik.com/free-vector/confirmed-attendance-concept-illustration_114360-30959.jpg"
                         alt="Checklist Attendance" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[var(--maroon)] mb-2">Automated Tracking</h3>
                        <p class="text-gray-600">Streamlined attendance management for school activities.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gradient-to-r from-[var(--maroon)] to-red-900 text-white py-8 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <p class="text-sm">&copy; <?php echo date('Y'); ?> University of Southeastern Philippines. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-gray-300 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-300 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-gray-300 transition-colors">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>
