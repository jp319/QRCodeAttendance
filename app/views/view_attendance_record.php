<?php
global $EventID;
require_once "../app/core/imageConfig.php";

$selectedProgram = $_POST['program'] ?? $_GET['program'] ?? '';
$selectedYear = $_POST['year'] ?? $_GET['year'] ?? '';
$viewNotAttended = $_GET['view'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Attendance</title>
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT ?>assets/images/LOGO_QRCODE_v2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print, .no-print * { display: none !important; }
            table { width: 100%; border-collapse: collapse; font-size: 14px; }
            th, td { font-size: 12px; border: 1px solid black !important; padding: 10px; text-align: left; }
            th { background-color: #f0f0f0 !important; color: black !important; font-size: 14px; font-weight: bold; }
            body { background: none; padding: 20px; }
            .text-center { text-align: center; }
            .text-4xl { font-size: 24px !important; font-weight: bold; }
            .text-2xl { font-size: 18px !important; font-weight: bold; }
            .text-gray-600 { color: black !important; }
            tr:nth-child(20n) { page-break-after: always; }
        }
        a[href]:after { content: none !important; }
        tr:nth-child(20n) { page-break-after: always; }
    </style>
</head>
<body class="bg-gray-100 p-6 font-sans">
<div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-xl">

    <div class="text-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Attendance Record</h1>
        <p class="text-gray-500 italic text-lg"><?php echo $EventName ?></p>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Event Attendance</h2>
        <div class="flex gap-3">
            <button onclick="history.back()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 no-print">Back</button>
            <a href="<?php echo ROOT ?>view_record2?id=<?= htmlspecialchars($_GET['id']) ?>&eventName=<?= htmlspecialchars($_GET['eventName']); ?>" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 no-print">View Sanctioned</a>
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 no-print">Print</button>
        </div>
    </div>

    <form action="" method="post" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select name="program" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-3 shadow-sm" required>
                <option value="">Select program</option>
                <?php foreach ($programList as $program): ?>
                    <option value="<?= $program['program']; ?>" <?= ($selectedProgram === $program['program']) ? 'selected' : ''; ?>><?= $program['program']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="year" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-3 shadow-sm" required>
                <option value="">Select year</option>
                <?php foreach ($year as $yr): ?>
                    <option value="<?= $yr['acad_year']; ?>" <?= ($selectedYear === $yr['acad_year']) ? 'selected' : ''; ?>><?= $yr['acad_year']; ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm">View</button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded shadow-sm">
            <p class="text-sm">Total Students</p>
            <p class="text-2xl font-bold"><?= $totalStudents ?></p>
        </div>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
            <p class="text-sm">Number Attended</p>
            <p class="text-2xl font-bold"><?= $attendedCount["COUNT(student_id)"] ?></p>
        </div>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-sm">
            <p class="text-sm">Not Yet Attended</p>
            <p class="text-2xl font-bold"><?= $totalStudents - $attendedCount["COUNT(student_id)"] ?></p>
        </div>
    </div>

    <form action="" method="post" class="mb-6">
        <div class="flex gap-4">
            <input type="text" name="search" placeholder="Search by name or ID" value="<?= $_POST['search'] ?? ''; ?>" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-3 flex-grow shadow-sm no-print" required>
            <button type="submit" name="searchBtn" class="px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-sm no-print">Search</button>
        </div>
    </form>

    <?php if (!empty($attendanceList)): ?>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 shadow-md rounded-lg">
                <thead class="sticky top-0 z-10 bg-blue-600 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-3">Student ID</th>
                    <th class="border border-gray-300 px-4 py-3">First Name</th>
                    <th class="border border-gray-300 px-4 py-3">Last Name</th>
                    <th class="border border-gray-300 px-4 py-3">Program</th>
                    <th class="border border-gray-300 px-4 py-3">Year</th>
                    <th class="border border-gray-300 px-4 py-3">Email</th>
                    <?php if ($viewNotAttended !== 'not_attended'): ?>
                        <th class="border border-gray-300 px-4 py-3">Time In</th>
                        <th class="border border-gray-300 px-4 py-3">Time Out</th>
                        <th class="border border-gray-300 px-4 py-3 no-print"></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($attendanceList as $record): ?>
                    <tr class="odd:bg-gray-100 even:bg-white hover:bg-gray-200 transition">
                        <td class="border border-gray-300 px-4 py-3"><?= $record['student_id']; ?></td>
                        <td class="border border-gray-300 px-4 py-3"><?= $record['f_name']; ?></td>
                        <td class="border border-gray-300 px-4 py-3"><?= $record['l_name']; ?></td>
                        <td class="border border-gray-300 px-4 py-3"><?= $record['program']; ?></td>
                        <td class="border border-gray-300 px-4 py-3"><?= $record['acad_year']; ?></td>
                        <td class="border border-gray-300 px-4 py-3"><?= $record['email']; ?></td>
                        <td class="border border-gray-300 px-4 py-3"><?= $record['time_in']; ?></td>
                        <td class="border border-gray-300 px-4 py-3"><?= $record['time_out']; ?></td>
                        <td class="py-3 px-4 text-sm text-gray-600 no-print">
                            <a class="text-red-500 hover:text-red-700 delete-btn" href="<?php echo ROOT ?>delete_attendance_record?atten_id=<?= $EventID; ?>&student_id=<?= $record['student_id']; ?>">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-600 text-center mt-6">No attendance records found.</p>
    <?php endif; ?>
</div>
</body>
</html>