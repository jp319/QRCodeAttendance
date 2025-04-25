<!doctype html>
<html lang="en">
<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?php echo ROOT ?>assets/css/students.css">
</header>

<body class="bg-[#f8f9fa]">
<header class="bg-white shadow-sm p-6">
    <div class="max-w-7xl mx-auto flex items-center space-x-2">
        <i class="fas fa-user text-gray-900 text-2xl"></i>
        <h1 class="text-3xl font-bold text-gray-900">Profile</h1>
    </div>
</header>

<div class="container mx-auto max-w-4xl p-6">
    <div class="bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Profile Settings</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Username Section -->
            <div class="bg-gray-100 p-6 rounded-lg border border-gray-300 shadow">
                <label class="block text-gray-700 font-semibold mb-2">Username</label>
                <form action="" method="POST">
                    <input type="text" id="username" name="username"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                           value="<?php echo htmlspecialchars($userData[0]['username']); ?>">

                    <button type="submit"
                            class="mt-4 w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
                        Save
                    </button>
                </form>
            </div>

            <!-- Password Change Section -->
            <div class="bg-gray-100 p-6 rounded-lg border border-gray-300 shadow">
                <label class="block text-gray-700 font-semibold mb-2">Change Password</label>
                <form id="passwordForm" action="" method="POST">
                    <input type="password" id="newPassword" name="password"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-400 focus:outline-none"
                           placeholder="New Password">
                    <input type="password" id="confirmPassword"
                           class="w-full border border-gray-300 rounded-lg p-3 mt-3 focus:ring-2 focus:ring-green-400 focus:outline-none"
                           placeholder="Confirm Password">
                    <button type="submit"
                            class="mt-4 w-full bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition">
                        Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Session Details -->
    <div class="bg-white p-6 shadow-lg rounded-lg mt-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">Session Details</h3>

        <?php foreach ($userData as $userSession): ?>
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-300 shadow-md mb-4">
                <p class="text-gray-600"><strong>IP Address:</strong> <?php echo htmlspecialchars($userSession['ip_address']); ?></p>
                <p class="text-gray-600"><strong>Device Info:</strong> <?php echo htmlspecialchars($userSession['deviceInfo']); ?></p>
                <p class="text-gray-600"><strong>Last Login:</strong> <?php echo htmlspecialchars($userSession['created_at']); ?></p>

                <a href="<?php echo ROOT?>logout2?sessionID=<?php echo urlencode($userSession['SessionID'])?>&user_id=<?php echo urlencode($userSession['id'])?>"
                   class="mt-4 inline-block px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                    Logout
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.getElementById('passwordForm').addEventListener('submit', function (event) {
        let newPassword = document.getElementById('newPassword').value;
        let confirmPassword = document.getElementById('confirmPassword').value;

        if (newPassword.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password must be at least 8 characters long!'
            });
            event.preventDefault(); // Stop form submission
            return;
        }

        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Passwords do not match!'
            });
            event.preventDefault(); // Stop form submission

        }
    });
</script>

</body>
</html>
