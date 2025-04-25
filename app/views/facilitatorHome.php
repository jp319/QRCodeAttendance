<?php
global $imageSource, $imageSource2, $imageSource3, $programList, $selectedProgram, $EventName, $EventDate, $EventTime, $EventLocation, $attendanceRecordList, $EventID;



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT?>assets/images/LOGO_QRCODE_v2.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Facilitator Home • USep Attendance System</title>
    <style>
        /* Custom Maroon Dark Red */
        .bg-maroon { background-color: #800000; }
        .hover\:bg-maroon-hover:hover { background-color: #660000; }
        .text-maroon { color: #800000; }
        .border-maroon { border-color: #800000; }
        .focus\:ring-maroon:focus { --tw-ring-color: #800000; }
    </style>
</head>
<body class="bg-gray-100 font-sans">
<div class="max-w-7xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="flex items-center gap-4">
            <img src="<?php echo $imageSource; ?>" alt="OSAS Logo" class="w-20">
            <h1 class="text-2xl font-bold text-maroon">Attendance System</h1>
        </div>
        <button onclick="logout('<?php echo ROOT; ?>')" class="bg-maroon hover:bg-maroon-hover text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </div>
    <script>
        function logout(root) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of the system.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#800000', // Custom maroon color
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = root + "logout";
                }
            });
        }
    </script>

    <!-- Dashboard Title -->
    <h2 class="text-3xl font-bold text-center text-maroon mb-6">Dashboard</h2>
    <!-- Activity Log Toggle -->
    <!-- Pass PHP array to JS -->
    <script>
        const fullActivityLog = <?php echo json_encode($activityLogList); ?>;
    </script>

    <!-- Students Section -->
    <!-- Search Form -->
    <div class="mb-4">
        <form action="<?php echo ROOT ?>facilitator" method="GET" class="flex flex-col md:flex-row gap-2">

            <input type="text" name="student" placeholder="Search student..." class="w-full p-2 border border-maroon rounded-lg focus:outline-none focus:ring-2 focus:ring-maroon">
            <button type="submit" class="bg-maroon hover:bg-maroon-hover text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
    </div>
    <!-- Students Section -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg hidden md:table">
                <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-maroon">Student ID</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-maroon">Student Name</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-maroon">Program</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-maroon">Year/Section</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-maroon">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($attendanceRecordList as $attendanceRecord) { ?>
                    <tr class="border-t border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm text-gray-600"><?php echo htmlspecialchars($attendanceRecord['student_id'])?></td>
                        <td class="py-3 px-4 text-sm text-gray-600 data-student-name"><?php echo htmlspecialchars($attendanceRecord['f_name'] . ' ' . $attendanceRecord['l_name'])?></td>
                        <td class="py-3 px-4 text-sm text-gray-600"><?php echo htmlspecialchars($attendanceRecord['program'])?></td>
                        <td class="py-3 px-4 text-sm text-gray-600"><?php echo htmlspecialchars($attendanceRecord['acad_year'])?></td>
                        <td class="py-3 px-4 text-sm text-gray-600">
                            <a class="text-red-500 hover:text-red-700 delete-btn"
                               href="<?php echo ROOT?>delete_attendance_record?atten_id=<?php echo $EventID; ?>&student_id=<?php echo $attendanceRecord['student_id'];?>&event_name=<?php echo $EventName?>">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.querySelectorAll(".delete-btn").forEach(function(button) {
                            button.addEventListener("click", function(event) {
                                event.preventDefault(); // Prevent default link action
                                let deleteUrl = this.getAttribute("href");

                                Swal.fire({
                                    title: "Are you sure?",
                                    text: "You won't be able to revert this!",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#d33",
                                    cancelButtonColor: "#3085d6",
                                    confirmButtonText: "Yes, delete it!"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        fetch(deleteUrl, { method: "GET" })
                                            .then(response => response.text())
                                            .then(data => {
                                                Swal.fire({
                                                    title: "Deleted!",
                                                    text: "The attendance record has been deleted.",
                                                    icon: "success",
                                                    timer: 1500,
                                                    showConfirmButton: false
                                                });
                                                setTimeout(() => {
                                                    window.location.reload();
                                                }, 1600);
                                            })
                                            .catch(error => {
                                                Swal.fire({
                                                    title: "Error!",
                                                    text: "Something went wrong while deleting.",
                                                    icon: "error"
                                                });
                                            });
                                    }
                                });
                            });
                        });
                    });
                </script>

            </table>
            <!-- Cards for Mobile View -->
            <div class="md:hidden">
                <?php foreach ($attendanceRecordList as $attendanceRecord) { ?>
                    <div class="bg-gray-100 border border-gray-200 rounded-lg p-4 mb-4">
                        <h3 class="text-lg font-bold text-maroon"><?php echo htmlspecialchars($attendanceRecord['f_name'] . ' ' . $attendanceRecord['l_name'])?></h3>
                        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($attendanceRecord['student_id'])?></p>
                        <p><strong>Program:</strong> <?php echo htmlspecialchars($attendanceRecord['program'])?></p>
                        <p><strong>Year/Section:</strong> <?php echo htmlspecialchars($attendanceRecord['acad_year'])?></p>
                        <a class="text-red-500 hover:text-red-700 delete-btn"
                           href="<?php echo ROOT?>delete_attendance_record?atten_id=<?php echo $EventID; ?>&student_id=<?php echo $attendanceRecord['student_id'];?>">
                            <i class="fas fa-trash"></i>Delete
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Event Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-maroon rounded-2xl text-white text-center shadow-lg p-6">
            <a href="<?php echo ROOT ?>scanner">
                <img src="<?php echo $imageSource3; ?>" alt="Scan QR Code" class="mx-auto w-60 rounded-lg mb-4">
            </a>
            <a href="<?php echo ROOT ?>scanner" class="text-xl font-semibold hover:underline">Scan QR Code</a>
        </div>
        <div class="bg-maroon rounded-2xl text-white text-center shadow-lg p-6">
            <h2 class="text-2xl font-bold"><?php echo htmlspecialchars($EventName)?></h2>
            <p class="text-lg"><?php echo htmlspecialchars($EventDate)?></p>
            <p class="text-lg"><?php echo 'Time started: ' . htmlspecialchars($EventTime)?></p>
            <p class="text-lg"><?php echo htmlspecialchars($EventLocation)?></p>
        </div>
    </div>




    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <!-- Toggle -->
        <button onclick="toggleLogs()" class="bg-maroon hover:bg-maroon-hover text-white px-4 py-2 rounded-lg flex items-center gap-2 mb-4">
            <i class="fas fa-clock"></i> View Activity Log
        </button>

        <!-- Log List -->
        <div id="activity-log" class="mt-4">
            <h3 class="text-xl font-bold mb-2 text-maroon">Activity Log</h3>

            <!-- Search -->
            <div class="flex flex-col md:flex-row md:items-center gap-2 mb-1">
                <input type="text" id="search-input"
                       placeholder="Search..."
                       class="w-full md:w-80 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-maroon">

                <button type="button" id="search-btn"
                        class="bg-maroon hover:bg-maroon-hover text-white px-4 py-2 rounded-lg flex items-center gap-4">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>

            <!-- Scrollable container -->
            <div class="h-60 overflow-y-auto border border-gray-200 rounded-lg p-2 bg-gray-50">
                <ul class="space-y-2" id="activity-log-list">
                    <!-- Logs will be rendered here by JS -->
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Render logs
        function renderLogs(logs) {
            const list = document.getElementById("activity-log-list");
            list.innerHTML = ''; // Clear
            if (logs.length === 0) {
                list.innerHTML = '<li class="text-gray-500 text-sm">No logs found.</li>';
            } else {
                logs.forEach(log => {
                    const item = document.createElement("li");
                    item.className = "border border-gray-200 rounded-lg p-3 text-gray-700 bg-white";
                    item.innerHTML = `
                    <span class="font-semibold">${log.activity}</span><br>
                    <span class="text-sm text-gray-500">${log.time_created}</span>
                `;
                    list.appendChild(item);
                });
            }
        }

        // Search functionality
        document.getElementById("search-btn").addEventListener("click", () => {
            const keyword = document.getElementById("search-input").value.toLowerCase();
            const filtered = fullActivityLog.filter(log =>
                log.activity.toLowerCase().includes(keyword) ||
                log.time_created.toLowerCase().includes(keyword)
            );
            renderLogs(filtered);
        });

        // Optional: Enter key triggers search
        document.getElementById("search-input").addEventListener("keypress", function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById("search-btn").click();
            }
        });


        // ✅ Render logs by default on page load
        document.addEventListener("DOMContentLoaded", () => {
            renderLogs(fullActivityLog);
        });
    </script>


    <script>
        function toggleLogs() {
            const logSection = document.getElementById("activity-log");
            logSection.classList.toggle("hidden");
        }
    </script>
</div>
</body>
<script>
    //// Track if the user is navigating away or submitting a form
    //let isNavigating = false;
    //
    //// Detect clicks on links or buttons that lead to navigation
    //document.addEventListener('click', function(event) {
    //    const target = event.target.closest('a, button[type="submit"], input[type="submit"]');
    //    if (target) {
    //        isNavigating = true;
    //    }
    //});
    //
    //// Detect form submissions
    //document.addEventListener('submit', function() {
    //    isNavigating = true;
    //});
    //
    //// Use beforeunload to detect when the user is leaving the page
    //window.addEventListener('beforeunload', function(event) {
    //    // If the user is NOT navigating or submitting a form, they are closing the tab/browser
    //    if (!isNavigating) {
    //        navigator.sendBeacon('<?php //echo ROOT; ?>//logout', new URLSearchParams({
    //            action: 'logOutOnClose'
    //        }));
    //    }
    //});
</script>


</html>

