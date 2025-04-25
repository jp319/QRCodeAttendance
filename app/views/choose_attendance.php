<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Attendance System • Choose Attendance</title>
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT?>assets/images/LOGO_QRCODE_v2.png">
</head>
<body>
<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center px-4 py-10">
    <div class="bg-white shadow-xl rounded-lg p-8 max-w-md w-full text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Attendance Type</h2>
        <p class="text-gray-600 mb-6">Choose the type of attendance you want to create:</p>

        <div class="space-y-4">
            <a href="<?php echo ROOT?>add_attendance"
               class="block w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition text-lg font-medium">
                Mandatory Attendance
            </a>

            <a href="create_specific_attendance.php"
               class="block w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition text-lg font-medium">
                Attendance for Specific Students
            </a>

            <a href="create_other_attendance.php"
               class="block w-full bg-yellow-500 text-white py-3 px-6 rounded-lg hover:bg-yellow-600 transition text-lg font-medium">
                Other Attendance Type
            </a>
        </div>
    </div>
</div>
</body>
</html>