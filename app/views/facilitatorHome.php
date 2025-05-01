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
                confirmButtonColor: '#800000',
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

    <!-- Attendance Dropdown -->
    <div class="mb-6 relative">
        <button id="attendanceDropdownButton"
                class="w-full sm:w-auto bg-maroon hover:bg-maroon-hover text-white px-4 py-2 rounded-lg flex items-center justify-between gap-2 shadow-md focus:outline-none">
            <span>View Events</span>
            <i class="fas fa-chevron-down" id="dropdownIcon"></i>
        </button>
        <div id="attendanceDropdownMenu"
             class="hidden absolute z-10 w-full sm:w-80 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
            <?php if (empty($attendanceList2)) { ?>
                <div class="p-4 text-center text-gray-500">
                    No attendance records found.
                </div>
            <?php } else { ?>
                <?php foreach ($attendanceList2 as $attendance) { ?>
                    <a href=""
                       class="flex items-center justify-between p-3 border-b border-gray-200 hover:bg-gray-50">
                        <div>
                            <p class="text-sm font-semibold text-maroon"><?php echo htmlspecialchars($attendance['event_name']); ?></p>
                            <p class="text-xs text-gray-600"><?php echo htmlspecialchars($attendance['date_created']); ?></p>
                        </div>
                        <i class="fas fa-eye text-maroon hover:text-maroon-hover" title="View Details"></i>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <script>
        const dropdownButton = document.getElementById('attendanceDropdownButton');
        const dropdownMenu = document.getElementById('attendanceDropdownMenu');
        const dropdownIcon = document.getElementById('dropdownIcon');

        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
            dropdownIcon.classList.toggle('fa-chevron-down');
            dropdownIcon.classList.toggle('fa-chevron-up');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
                dropdownIcon.classList.add('fa-chevron-down');
                dropdownIcon.classList.remove('fa-chevron-up');
            }
        });

        // Close dropdown when an item is clicked
        dropdownMenu.querySelectorAll('a').forEach(item => {
            item.addEventListener('click', () => {
                dropdownMenu.classList.add('hidden');
                dropdownIcon.classList.add('fa-chevron-down');
                dropdownIcon.classList.remove('fa-chevron-up');
            });
        });
    </script>
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

    <!-- Activity Log Section -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <button onclick="toggleLogs()" class="bg-maroon hover:bg-maroon-hover text-white px-4 py-2 rounded-lg flex items-center gap-2 mb-4">
            <i class="fas fa-clock"></i> View Activity Log
        </button>
        <div id="activity-log" class="mt-4 hidden">
            <h3 class="text-xl font-bold mb-2 text-maroon">Activity Log</h3>
            <div class="flex flex-col md:flex-row md:items-center gap-2 mb-1">
                <input type="text" id="search-input" placeholder="Search..."
                       class="w-full md:w-80 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-maroon">
                <button type="button" id="search-btn"
                        class="bg-maroon hover:bg-maroon-hover text-white px-4 py-2 rounded-lg flex items-center gap-4">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
            <div class="h-60 overflow-y-auto border border-gray-200 rounded-lg p-2 bg-gray-50">
                <ul class="space-y-2" id="activity-log-list">
                    <!-- Logs will be rendered here by JS -->
                </ul>
            </div>
        </div>
    </div>

    <script>
        function renderLogs(logs) {
            const list = document.getElementById("activity-log-list");
            list.innerHTML = '';
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

        document.getElementById("search-btn").addEventListener("click", () => {
            const keyword = document.getElementById("search-input").value.toLowerCase();
            const filtered = fullActivityLog.filter(log =>
                log.activity.toLowerCase().includes(keyword) ||
                log.time_created.toLowerCase().includes(keyword)
            );
            renderLogs(filtered);
        });

        document.getElementById("search-input").addEventListener("keypress", function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById("search-btn").click();
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            renderLogs(fullActivityLog);
        });

        function toggleLogs() {
            const logSection = document.getElementById("activity-log");
            logSection.classList.toggle("hidden");
        }
    </script>
</div>
</body>
</html>