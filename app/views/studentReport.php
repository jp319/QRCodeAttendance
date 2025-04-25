<?php
$totalHours = array_sum(array_column($sanctionList, 'sanction_hours'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sanctions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-700 mb-6 text-center">Student Sanctions</h2>

    <!-- Sanctions List -->
    <div class="space-y-4">
        <?php foreach ($sanctionList as $sanction): ?>
            <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200">
                <p class="text-gray-500 text-sm"><?= htmlspecialchars($sanction['date_applied']); ?></p>
                <h3 class="text-lg font-semibold text-gray-700"><?= htmlspecialchars($sanction['sanction_reason']); ?></h3>
                <p class="text-gray-800 font-medium">Sanction Hours:
                    <span class="text-red-500"><?= htmlspecialchars($sanction['sanction_hours']); ?></span>
                </p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Total Hours Card -->
    <div class="mt-6 bg-blue-600 text-white text-lg font-semibold p-4 rounded-lg shadow-md text-center">
        Total Sanction Hours: <span><?= htmlspecialchars($totalHours); ?></span>
    </div>
</div>
</body>
</html>
