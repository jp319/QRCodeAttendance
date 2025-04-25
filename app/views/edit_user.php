<?php global $userData; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT; ?>assets/images/LOGO_QRCODE_v2.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>User Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="max-w-6xl mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- User Management Card -->
    <div class="bg-white shadow-lg rounded-lg p-6 w-full text-center">
        <form id="userForm" action="edit_user?id=<?php echo $_GET['id']; ?>" method="POST">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Username</h3>
            <input name="username" type="text" value="<?php echo htmlspecialchars($userData[0]['username']); ?>"
                   class="w-full px-4 py-2 border rounded-md text-center text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />

            <!-- Password Fields -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Change Password</h3>
                <input name="newPassword" type="password" placeholder="New Password"
                       class="mt-2 w-full px-4 py-2 border rounded-md text-center text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
                <input name="confirmPassword" type="password" placeholder="Confirm Password"
                       class="mt-2 w-full px-4 py-2 border rounded-md text-center text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex flex-col space-y-4">
                <button type="button" onclick="confirmAction('saveChanges')" class="bg-blue-600 text-white font-medium px-6 py-2 rounded-md hover:bg-blue-700">
                    Save Changes
                </button>

                <button type="button" onclick="confirmAction('changePassword')" class="bg-yellow-600 text-white font-medium px-6 py-2 rounded-md hover:bg-yellow-700">
                    Change Password
                </button>

                <button type="button" onclick="confirmAction('deleteUser')" class="bg-red-600 text-white font-medium px-6 py-2 rounded-md hover:bg-red-700">
                    Delete User
                </button>

                <a href="<?php echo ROOT ?>adminHome?page=Users" class="block bg-gray-500 text-white font-medium px-6 py-2 rounded-md hover:bg-gray-600">
                    Back
                </a>
            </div>

            <input type="hidden" id="actionType" name="actionType">
        </form>
    </div>

    <!-- Session Details Card -->
    <div class="bg-white shadow-lg rounded-lg p-6 w-full text-center">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Session Details</h3>
        <div class="max-h-96 overflow-y-auto space-y-4 pr-2">
            <?php foreach ($userData as $userSession): ?>
                <div class="bg-gray-50 p-4 rounded-md text-left">
                    <p class="text-gray-600"><strong>IP Address:</strong> <?php echo ($userSession['ip_address']); ?></p>
                    <p class="text-gray-600"><strong>Device Info:</strong> <?php echo ($userSession['deviceInfo']); ?></p>
                    <p class="text-gray-600"><strong>Last Login:</strong> <?php echo ($userSession['created_at']); ?></p>
                    <a href="<?php echo ROOT ?>logout2?sessionID=<?php echo urlencode($userSession['SessionID']) ?>&user_id=<?php echo urlencode($userSession['id']) ?>"
                       class="mt-2 inline-block bg-red-500 text-white font-medium px-6 py-2 rounded-md hover:bg-red-600">
                        Logout
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<script>
    function confirmAction(action) {
        let messages = {
            saveChanges: "Are you sure you want to update the username?",
            changePassword: "Are you sure you want to change the password?",
            deleteUser: "This action is irreversible. Are you sure you want to delete this user?"
        };

        let confirmButtonColor = action === 'deleteUser' ? '#d33' : '#3085d6';

        Swal.fire({
            title: "Confirm Action",
            text: messages[action],
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: "#aaa",
            confirmButtonText: "Yes, proceed!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('actionType').value = action;
                document.getElementById('userForm').submit();
            }
        });
    }

    // Show alerts if there's a success message
    <?php if (isset($_GET['success'])): ?>
    Swal.fire({
        title: "Success",
        text: "Changes saved successfully!",
        icon: "success",
        confirmButtonColor: "#3085d6"
    });
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    Swal.fire({
        title: "Error",
        text: "Something went wrong. Please try again.",
        icon: "error",
        confirmButtonColor: "#d33"
    });
    <?php endif; ?>
</script>

</body>
</html>
