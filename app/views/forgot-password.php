<?php
global $imageSource, $imageSource2, $imageSource4;
require "../app/core/imageConfig.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="<?php echo $imageSource?>">
    <link rel="stylesheet" href="<?php echo ROOT?>assets/css/loginStyle.css">
    <title>Forgot Password • USeP QR Attendance</title>
</head>
<body class="bg-[#f8f9fa]">

<!-- Toast Notification -->
<?php if (isset($_SESSION['error'])): ?>
    <div id="toast" class="toast fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg flex items-center justify-between">
        <span><?php echo $_SESSION['error']; ?></span>
        <button onclick="hideToast()" class="ml-4 text-red-700 hover:text-red-900">&times;</button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="min-h-screen flex flex-col items-center justify-center p-4">
    <!-- Header -->
    <div class="w-full max-w-4xl flex items-center justify-between mb-8">
        <div class="flex items-center">
            <img style="width: 550px; height: 150px" src="<?php echo $imageSource4?>" alt="Logo" />
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full max-w-4xl flex flex-col md:flex-row items-center justify-between">
        <!-- Illustration -->
        <div class="w-full md:w-1/2 flex justify-center order-1 md:order-2 md:pl-12">
            <img class="w-full max-w-md" src="<?php echo $imageSource2?>" alt="Illustration" />
        </div>

        <!-- Form -->
        <div class="w-full md:w-1/2 flex flex-col items-start mb-8 md:mb-0 md:pr-12 order-2 md:order-1">
            <div class="text-[#515050] text-4xl md:text-6xl font-extrabold mb-8">FORGOT PASSWORD</div>
            <p class="text-[#515050] text-lg mb-8">Enter your email address and we'll send you an OTP to reset your password.</p>
            
            <form method="POST" class="w-full" action="<?php echo ROOT;?>forgot-password">
                <div class="w-full mb-6">
                    <label class="text-[#515050] text-xl font-normal mb-2">Email Address</label>
                    <input type="email" name="email" required
                           class="w-full h-12 pl-4 text-[#515050] text-lg border border-[#ddd] rounded-lg"
                           placeholder="Enter your email address">
                </div>
                
                <div class="w-full flex space-x-4">
                    <button type="submit" class="w-1/2 h-12 bg-[#a31d1d] text-white text-xl font-bold rounded-lg">SEND OTP</button>
                    <a href="<?php echo ROOT;?>login" class="w-1/2 h-12 bg-gray-500 text-white text-xl font-bold rounded-lg flex items-center justify-center">BACK TO LOGIN</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="w-full max-w-4xl mt-8 text-center">
        <div class="text-[#515050] text-lg font-normal">Copyright © 2025. All Rights Reserved.</div>
    </div>
</div>

<script>
    // Hide the toast after 5 seconds
    setTimeout(() => {
        hideToast();
    }, 5000);

    function hideToast() {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.classList.add('hide');
            setTimeout(() => {
                toast.remove();
            }, 500);
        }
    }
</script>
</body>
</html> 