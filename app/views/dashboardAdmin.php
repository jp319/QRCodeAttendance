<?php
global $numberOfStudents, $numberOfAttendance, $numberOfFaci, $listOfAttendance, $listOfFaci;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
    /* Hide scrollbar while keeping scroll functionality */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    /* Hover animations for cards */
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
</style>
<body class="bg-[#f3f4f6] text-gray-800">

<!-- Header -->
<header class="bg-white shadow-md p-6 mb-6">
    <div class="max-w-7xl mx-auto flex items-center space-x-3">
        <i class="fas fa-chart-line text-[#9e1e1e] text-3xl"></i>
        <h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
    </div>
</header>

<!-- Overview Cards -->
<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
    <a href="?page=Students" class="bg-[#9e1e1e] text-white rounded-2xl p-6 flex flex-col items-center hover-card transition-transform duration-300">
        <h2 class="text-2xl font-bold">Total Students</h2>
        <p class="text-5xl font-extrabold"><?php echo $data['numberOfStudents']?></p>
    </a>
    <a href="?page=Attendance" class="bg-[#d62828] text-white rounded-2xl p-6 flex flex-col items-center hover-card transition-transform duration-300">
        <h2 class="text-2xl font-bold">Total Attendance</h2>
        <p class="text-5xl font-extrabold"><?php echo $data['numberOfAttendance']?></p>
    </a>
    <a href="?page=Users" class="bg-[#f77f00] text-white rounded-2xl p-6 flex flex-col items-center hover-card transition-transform duration-300">
        <h2 class="text-2xl font-bold">Total Facilitators</h2>
        <p class="text-5xl font-extrabold"><?php echo $data['numberOfFaci']?></p>
    </a>
</div>

<!-- Details Section -->
<div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">

    <!-- Facilitators Status -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-3xl font-bold text-[#9e1e1e]">Facilitators Status</h2>
        <div class="mt-4 space-y-4 max-h-64 overflow-y-auto hide-scrollbar">
            <?php foreach ($data['listOfFaci'] as $faci): ?>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex justify-between items-center">
                    <span class="text-lg font-semibold"><?php echo htmlspecialchars($faci[1])?></span>
                    <span class="text-lg font-bold <?php echo ($faci[4] === 'login' || $faci[4] === 'scanning') ? 'text-green-600' : 'text-red-600'; ?>">
                            <?php echo ucfirst($faci[4]) ?>
                        </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Recent Attendance -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-3xl font-bold text-[#9e1e1e]">Recent Attendance</h2>
        <div class="mt-4 space-y-4 max-h-64 overflow-y-auto hide-scrollbar">
            <?php foreach ($data['listOfAttendance'] as $attendance):?>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex justify-between items-center">
                    <span class="text-lg font-semibold"><?php echo htmlspecialchars($attendance[1])?></span>
                    <span class="text-lg font-semibold"><?php echo htmlspecialchars($attendance[5])?></span>
                </div>
            <?php endforeach?>
        </div>
        <div class="flex justify-center mt-6">
            <a href="?page=Attendance" class="bg-[#9e1e1e] text-white px-6 py-3 rounded-2xl text-lg font-medium shadow-md hover:bg-[#7a1818] transition-colors duration-300">
                View More
            </a>
        </div>
    </div>
</div>
</body>
</html>
