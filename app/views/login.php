<?php
global $imageSource, $imageSource2, $imageSource4;
    require "../app/core/imageConfig.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="<?php echo ROOT?>assets/js/handleIssue.js"></script>
    <link rel="icon" type="image/x-icon" href="<?php echo $imageSource?>">
    <link rel="stylesheet" href="<?php echo ROOT?>assets/css/loginStyle.css">
    <title>Attendance System • LogIn</title>

</head>
<body class="bg-[#f8f9fa]">

<!-- Toast Notification -->
<?php if (isset($_SESSION['error'])): ?>
    <div id="toast" class="toast fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg flex items-center justify-between">
        <span><?php echo $_SESSION['error']; ?></span>
        <button onclick="hideToast()" class="ml-4 text-red-700 hover:text-red-900">&times;</button>
    </div>
    <?php unset($_SESSION['error']); // Clear the error message after displaying ?>
<?php endif; ?>

<!-- Boxes Section -->
<div class="hidden md:block"> <!-- Hide on mobile, show on medium screens and larger -->
    <div class="w-[90px] h-5 left-[70px] top-[880px] absolute">
        <div class="w-5 h-5 left-0 top-0 absolute bg-[#ec9e3d]"></div>
        <div class="w-5 h-5 left-[35px] top-0 absolute bg-[#ec9e3d]"></div>
        <div class="w-5 h-5 left-[70px] top-0 absolute bg-[#ec9e3d]"></div>
    </div>
    <div class="w-[90px] h-5 left-[107px] top-[920px] absolute">
        <div class="w-5 h-5 left-0 top-0 absolute bg-[#ec9e3d]"></div>
        <div class="w-5 h-5 left-[35px] top-0 absolute bg-[#ec9e3d]"></div>
        <div class="w-5 h-5 left-[70px] top-0 absolute bg-[#ec9e3d]"></div>
    </div>
    <div class="w-[90px] h-5 left-[915px] top-[930px] absolute">
        <div class="w-5 h-5 left-0 top-0 absolute border-2 border-[#ec9e3d]"></div>
        <div class="w-5 h-5 left-[35px] top-0 absolute border-2 border-[#ec9e3d]"></div>
        <div class="w-5 h-5 left-[70px] top-0 absolute border-2 border-[#ec9e3d]"></div>
    </div>
    <div class="w-[90px] h-5 left-[1751px] top-[40px] absolute">
        <div class="w-5 h-5 left-0 top-0 absolute border-2 border-[#ec9e3d]"></div>
        <div class="w-5 h-5 left-[35px] top-0 absolute border-2 border-[#ec9e3d]"></div>
        <div class="w-5 h-5 left-[35px] top-0 absolute border-2 border-[#ec9e3d]"></div>
        <div class="w-5 h-5 left-[70px] top-0 absolute border-2 border-[#ec9e3d]"></div>
    </div>
</div>

<div class="min-h-screen flex flex-col items-center justify-center p-4">
    <!-- Header -->
    <div class="w-full max-w-4xl flex items-center justify-between mb-8">
        <div class="flex items-center">
            <img style="width: 550px; height: 150px" src="<?php echo $imageSource4?>" alt="Logo" />
<!--            <div class="text-center">-->
<!--                <span class="text-[#e59c24] text-2xl md:text-3xl font-medium">One</span>-->
<!--                <span class="text-[#515050] text-2xl md:text-3xl font-medium"> </span>-->
<!--                <span class="text-[#973939] text-2xl md:text-3xl font-medium">Data</span>-->
<!--                <span class="text-[#515050] text-2xl md:text-3xl font-medium">. </span>-->
<!--                <span class="text-[#ec9e3d] text-2xl md:text-3xl font-medium">One</span>-->
<!--                <span class="text-[#515050] text-2xl md:text-3xl font-medium"> </span>-->
<!--                <span class="text-[#973939] text-2xl md:text-3xl font-medium">USeP.</span>-->
<!--                <div class="text-[#515050] text-xl md:text-2xl font-medium">Attendance System</div>-->
<!--            </div>-->
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full max-w-4xl flex flex-col md:flex-row items-center justify-between">
        <!-- Illustration (Top on Mobile) -->
        <div class="w-full md:w-1/2 flex justify-center order-1 md:order-2 md:pl-12">
            <img class="w-full max-w-md" src="<?php echo $imageSource2?>" alt="Illustration" />
        </div>

        <!-- Form Fields (Bottom on Mobile) -->
        <form method="POST" class="w-full md:w-1/2 flex flex-col items-start mb-8 md:mb-0 md:pr-12 order-2 md:order-1" action="<?php echo ROOT;?>login">
            <div class="text-[#515050] text-4xl md:text-6xl font-extrabold mb-8">SIGN IN</div>
            <div class="w-full mb-6">
                <label class="text-[#515050] text-xl font-normal mb-2">Username</label>
                <input type="text" id="username" name="username" class="w-full h-12 pl-4 text-[#515050] text-lg border border-[#ddd] rounded-lg" placeholder="Enter your username">
            </div>
            <div class="w-full mb-6 relative">
                <label class="text-[#515050] text-xl font-normal mb-2">Password</label>
                <input type="password" id="password" name="password"
                       class="w-full h-12 pl-4 pr-12 text-[#515050] text-lg border border-[#ddd] rounded-lg"
                       placeholder="Enter your password">

                <!-- Eye Icon -->
                <button type="button" onclick="togglePassword()"
                        class="absolute right-4 top-10 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>

            <script>
                function togglePassword() {
                    const passwordInput = document.getElementById('password');
                    const eyeIcon = document.getElementById('eyeIcon');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.07 10.07 0 012.615-4.042m3.056-2.132A9.974 9.974 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.618 5.133M15 12a3 3 0 00-3-3m0 0a3 3 0 013 3m-3-3L3 3" />
            `;
                    } else {
                        passwordInput.type = 'password';
                        eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
                    }
                }
            </script>

            <div class="w-full mb-6">
                <a href="javascript:void(0);" onclick="showIssueForm()" class="text-[#a31d1d] text-lg font-normal hover:underline">Need help?</a>
            </div>
            <div class="w-full flex space-x-4">
                <button type="submit" class="w-1/2 h-12 bg-[#a31d1d] text-white text-xl font-bold rounded-lg">LOGIN</button>
            </div>
        </form>
    </div>

    <!-- Hidden Issue Form (Fixed Centered Position) -->
    <div id="issue-form" class="w-full mb-6 hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white shadow-lg rounded-xl p-4 border border-gray-200 max-w-sm mx-auto z-50">
        <label for="issueDetails" class="text-[#515050] text-xl font-normal mb-2">Please specify the issue:</label>
        <textarea id="issueDetails" name="issueDetails" class="w-full h-24 pl-4 text-[#515050] text-lg border border-[#ddd] rounded-lg mb-4" placeholder="Please include your ID number or email"></textarea>

        <div class="w-full flex space-x-4">
            <button type="button" onclick="submitIssue()" class="w-1/2 h-12 bg-[#a31d1d] text-white text-xl font-bold rounded-lg">Submit</button>
            <button type="button" onclick="hideIssueForm()" class="w-1/2 h-12 bg-gray-500 text-white text-xl font-bold rounded-lg">Cancel</button>
        </div>
    </div>



    <!-- Footer -->
    <div class="w-full max-w-4xl mt-8 text-center">
        <div class="text-[#515050] text-lg font-normal">Copyright © 2025. All Rights Reserved.</div>
        <div class="flex justify-center space-x-4 mt-2">
            <a href="#" onclick="showCookieNotice()" class="text-[#515050] text-lg font-bold underline">Cookies notice</a>
            <div class="w-px h-6 bg-[#515050]"></div>
            <a href="https://www.usep.edu.ph/usep-data-privacy-statement/" target="_blank" class="text-[#515050] text-lg font-bold underline">Privacy Policy</a>
        </div>
    </div>

    <!-- Cookie Notice -->
    <div id="cookie-notice" class="fixed bottom-4 left-4 right-4 md:left-auto md:right-6 md:bottom-6 bg-white shadow-xl rounded-2xl p-6 border border-gray-200 max-w-sm mx-auto z-50 transition-transform duration-300 ease-in-out hidden">
        <div class="text-base text-gray-800 mb-4 leading-relaxed">
            This website uses a session cookie to keep you logged in securely. By using this site, you agree to our use of cookies.
        </div>
        <div class="flex justify-end">
            <button id="accept-cookie" class="bg-blue-600 hover:bg-blue-700 text-white text-base px-5 py-2.5 rounded-lg font-semibold shadow-md">
                Accept
            </button>
        </div>
    </div>

    <script>
        const cookieNotice = document.getElementById("cookie-notice");
        const acceptBtn = document.getElementById("accept-cookie");

        // Show cookie notice if not already accepted
        if (!localStorage.getItem("cookieAccepted")) {
            cookieNotice.classList.remove("hidden");
        }

        // Accept button
        acceptBtn.addEventListener("click", function () {
            localStorage.setItem("cookieAccepted", "true");
            cookieNotice.classList.add("hidden");
        });

        // Show cookie notice on "Cookies notice" link click
        function showCookieNotice() {
            cookieNotice.classList.remove("hidden");
        }
    </script>


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
            }, 500); // Wait for the animation to finish
        }
    }
</script>

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
</body>
</html>