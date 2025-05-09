<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Record</title>
    <link rel="stylesheet" href="<?php echo ROOT ?>assets/css/attendance.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>

    </style>
</head>
<body>
<header>
    <div class="header-content">
        <i class="fas fa-file-alt"></i>
        <h1>Attendance Record</h1>
    </div>
</header>

<div class="container">
    <div class="search-add-container">

        <div class="search-bar">
            <form action="<?php echo ROOT?>adminHome" method="GET">
                <input type="hidden" name="page" value="Attendance">
                <input type="text" name="search" placeholder="Search">
                <button class="btn" type="submit">Search</button>
            </form>
        </div>

        <div class="flex gap-4">
            <a class="btn" id="add-attendance" href="<?php echo ROOT ?>add_attendance">
                <i class="fas fa-plus mr-2"></i>Add Attendance
            </a>
            <a class="btn bg-red-600 hover:bg-red-700" href="<?php echo ROOT ?>sanctions_summary">
                <i class="fas fa-exclamation-triangle mr-2"></i>View Sanctions
            </a>
        </div>
    </div>

    <div class="event-list-header">
        <div>Attendance Records</div>
    </div>

    <?php if (!empty($attendanceList)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <?php foreach ($attendanceList as $attendance): ?>
                <div class="bg-white rounded-lg shadow-md p-6 flex flex-col space-y-3 border border-gray-200
                        transition-transform transform hover:scale-105 hover:shadow-lg duration-300">
                    <h2 class="text-lg font-semibold text-gray-900">
                        <?php echo htmlspecialchars($attendance['event_name']); ?>
                    </h2>
                    <p class="text-gray-700"><strong>Date Created:</strong> <?php echo htmlspecialchars($attendance['date_created']); ?></p>

                    <p class="text-gray-700 flex items-center">
                        <strong>Status:</strong>
                        <span class="ml-2 px-3 py-1 text-sm font-medium rounded-full
                    <?php
                        if ($attendance['atten_status'] === 'on going') {
                            echo 'bg-blue-500 text-white';
                        } elseif ($attendance['atten_status'] === 'stopped') {
                            echo 'bg-yellow-500 text-white';
                        } elseif ($attendance['atten_status'] === 'finished') {
                            echo 'bg-green-500 text-white';
                        } elseif ($attendance['atten_status'] === 'closed') {
                            echo 'bg-red-500 text-white';
                        } else {
                            echo 'bg-gray-500 text-white';
                        }
                        ?>">
                    <?php echo htmlspecialchars($attendance['atten_status']); ?>
                </span>
                    </p>

                    <div class="flex justify-between mt-4">
                        <a href="<?php echo ROOT ?>view_records?id=<?php echo htmlspecialchars($attendance['atten_id']) ?>&eventName=<?php echo htmlspecialchars($attendance['event_name']); ?>"
                           class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="<?php echo ROOT ?>edit_attendance?id=<?php echo htmlspecialchars($attendance['atten_id']) ?>&eventName=<?php echo htmlspecialchars($attendance['event_name']); ?>"
                           class="text-yellow-600 hover:text-yellow-800 flex items-center gap-1">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <a href="<?php echo ROOT ?>delete_attendance?id=<?php echo htmlspecialchars($attendance['atten_id']); ?>"
                           onclick="return confirmDelete(event, this.href);"
                           class="text-red-600 hover:text-red-800 flex items-center gap-1">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="mt-6 text-center text-gray-600 text-lg">
            No attendance records found.
        </div>
    <?php endif; ?>


</div>

<script>
    function confirmDelete(event,url) {
        event.preventDefault(); // Prevents immediate navigation

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url; // Redirects to delete URL
            }
        });
    }
</script>
</body>
</html>
