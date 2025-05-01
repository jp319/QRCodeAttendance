<?php
$totalHours = array_sum(array_column($sanctionList, 'sanction_hours'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sanctions & Attendance • USep Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom Maroon Dark Red */
        .bg-maroon { background-color: #800000; }
        .hover\:bg-maroon-hover:hover { background-color: #660000; }
        .text-maroon { color: #800000; }
        .border-maroon { border-color: #800000; }
        .focus\:ring-maroon:focus { --tw-ring-color: #800000; }
    </style>
</head>
<body class="bg-gray-100 p-6 font-sans">
<div class="max-w-5xl mx-auto">

    <!-- Sanctions Section -->
    <div class="mb-8">
        <h3 class="text-xl font-bold text-maroon mb-4">Sanctions</h3>
        <div class="space-y-4">
            <?php if (empty($sanctionList)): ?>
                <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200 text-center text-gray-500">
                    No sanctions found.
                </div>
            <?php else: ?>
                <?php foreach ($sanctionList as $sanction): ?>
                    <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                        <p class="text-gray-500 text-sm"><?= htmlspecialchars($sanction['date_applied']); ?></p>
                        <h4 class="text-lg font-semibold text-gray-700"><?= htmlspecialchars($sanction['sanction_reason']); ?></h4>
                        <p class="text-gray-800 font-medium">
                            Sanction Hours:
                            <span class="text-red-500"><?= htmlspecialchars($sanction['sanction_hours']); ?></span>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!-- Total Hours Card -->
        <div class="mt-4 bg-maroon text-white text-lg font-semibold p-4 rounded-lg shadow-md text-center">
            Total Sanction Hours: <span><?= htmlspecialchars($totalHours); ?></span>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-xl font-bold text-maroon mb-4">Recent Attended Activities</h3>
        <!-- Desktop Table -->
        <div class="overflow-x-auto hidden md:block">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-maroon">Student Name</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-maroon">Event Name</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-maroon">Event Date</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-maroon">Time In</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-maroon">Time Out</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($attendanceRecord)): ?>
                    <tr>
                        <td colspan="4" class="py-3 px-4 text-center text-gray-500">No attendance records found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($attendanceRecord as $record): ?>

                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm text-gray-600"><?= htmlspecialchars($record['Name'] ?? 'N/A'); ?></td>
                            <td class="py-3 px-4 text-sm text-gray-600"><?= htmlspecialchars($record['event_name'] ?? 'N/A'); ?></td>
                            <td class="py-3 px-4 text-sm text-gray-600"><?= htmlspecialchars($record['atten_started'] ?? 'N/A'); ?></td>
                            <td class="py-3 px-4 text-sm text-gray-600"><?= htmlspecialchars($record['time_in'] ?? 'N/A'); ?></td>
                            <td class="py-3 px-4 text-sm text-gray-600"><?= htmlspecialchars($record['time_out'] ?? 'N/A'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Mobile Cards -->
        <div class="md:hidden space-y-4">
            <?php if (empty($attendanceRecord)): ?>
                <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200 text-center text-gray-500">
                    No attendance records found.
                </div>
            <?php else: ?>
                <?php foreach ($attendanceRecord as $record): ?>

                    <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                        <h4 class="text-sm font-semibold text-maroon"><?= htmlspecialchars($record['Name'] ?? 'N/A'); ?></h4>
                        <p class="text-xs text-gray-600"><strong>Event:</strong> <?= htmlspecialchars($record['event_name'] ?? 'N/A'); ?></p>
                        <p class="text-xs text-gray-600"><strong>Event:</strong> <?= htmlspecialchars($record['atten_started'] ?? 'N/A'); ?></p>
                        <p class="text-xs text-gray-600"><strong>Time In:</strong> <?= htmlspecialchars($record['time_in'] ?? 'N/A'); ?></p>
                        <p class="text-xs text-gray-600"><strong>Time Out:</strong> <?= htmlspecialchars($record['time_out'] ?? 'N/A'); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>