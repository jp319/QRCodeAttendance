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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Event Attendance</title>
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT?>assets/images/LOGO_QRCODE_v2.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            /* Hide non-essential elements */
            .no-print, .no-print * {
                display: none !important;
            }

            /* Adjust table styles for better readability */
            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
            }

            th, td {
                font-size: 12px;
                border: 1px solid black !important;
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #f0f0f0 !important;
                color: black !important;
                font-size: 14px;
                font-weight: bold;
            }

            /* Increase spacing for better readability */
            body {
                background: none;
                padding: 20px;
            }

            .text-center {
                text-align: center;
            }

            .text-4xl {
                font-size: 24px !important;
                font-weight: bold;
            }

            .text-2xl {
                font-size: 18px !important;
                font-weight: bold;
            }

            .text-gray-600 {
                color: black !important;
            }

            /* Add a page break after every few rows to avoid splitting tables */
            tr:nth-child(20n) {
                page-break-after: always;
            }
        }
        /* Prevent URLs from printing */
        a[href]:after {
            content: none !important;
        }

        /* Add a page break after every few rows to avoid splitting tables */
        tr:nth-child(20n) {
            page-break-after: always;
        }
    </style>

</head>
<body class="bg-gray-100 p-6">
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">

    <!-- HEADER -->
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-gray-800">Attendance Record</h1>
        <p class="text-gray-600"><?php echo $EventName?></p>
    </div>

    <!-- BUTTONS -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0">
        <h2 class="text-xl sm:text-2xl font-semibold text-gray-700">Event Attendance</h2>
        <div class="flex flex-wrap justify-center sm:justify-end space-x-2 sm:space-x-3">
            <a href="<?php echo ROOT ?>adminHome?page=Attendance" class="px-3 py-2 sm:px-4 sm:py-2 bg-gray-500 text-white text-sm sm:text-base rounded-lg hover:bg-gray-600 no-print">
                Back
            </a>
            <a href="<?php echo ROOT ?>view_record2?id=<?php echo htmlspecialchars($_GET['id']) ?>&eventName=<?php echo htmlspecialchars($_GET['eventName']); ?>" class="px-3 py-2 sm:px-4 sm:py-2 bg-red-600 text-white text-sm sm:text-base rounded-lg hover:bg-red-700 no-print">
                View Sanctioned
            </a>
            <button onclick="window.print()" class="px-3 py-2 sm:px-4 sm:py-2 bg-blue-600 text-white text-sm sm:text-base rounded-lg hover:bg-blue-700 no-print">
                Print
            </button>
        </div>
    </div>

    <!-- FILTER FORM -->
    <form action="" method="post" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select name="program" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-3" required>
                <option value="">Select program</option>
                <?php foreach ($programList as $program): ?>
                    <option value="<?= $program['program']; ?>" <?= (isset($_POST['program']) && $_POST['program'] === $program['program']) ? 'selected' : ''; ?>>
                        <?= $program['program']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="year" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-3" required>
                <option value="">Select year</option>
                <?php foreach ($year as $yr): ?>
                    <option value="<?= $yr['acad_year']; ?>" <?= (isset($_POST['year']) && $_POST['year'] === $yr['acad_year']) ? 'selected' : ''; ?>>
                        <?= $yr['acad_year']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 no-print">View</button>
        </div>
    </form>
    <!-- SUMMARY -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 no-print">
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded shadow">
            <p class="text-sm">Total Students</p>
            <p class="text-2xl font-bold"><?= $totalStudents ?></p>
        </div>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow">
            <p class="text-sm">Number Attended</p>
            <p class="text-2xl font-bold"><?= $attendedCount["COUNT(student_id)"] ?></p>
        </div>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow">
            <p class="text-sm">Not Yet Attended</p>
            <p class="text-2xl font-bold"><?= $totalStudents - $attendedCount["COUNT(student_id)"] ?></p>
        </div>
    </div>


    <!-- SEARCH FORM -->
    <form action="" method="post" class="mb-6">
        <div class="flex gap-4">

            <input type="text" name="search" placeholder="Search by name or ID" value="<?= $_POST['search'] ?? ''; ?>"
                   class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-3 flex-grow shadow-md no-print" required>
            <button type="submit" name="searchBtn" class="px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 no-print">Search</button>

        </div>
    </form>

    <!-- ATTENDANCE TABLE -->
    <?php if (!empty($attendanceList)): ?>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 shadow-md rounded-lg">
                <thead class="sticky top-0 z-10">
                <tr class="bg-blue-600 text-white text-m">
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
                            <a class="text-red-500 hover:text-red-700 delete-btn no-print"
                               href="<?php echo ROOT?>delete_attendance_record?atten_id=<?php echo $EventID; ?>&student_id=<?php echo $record['student_id'];?>">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
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
        </div>
    <?php else: ?>
        <p class="text-gray-600 text-center mt-6">No attendance records found.</p>
    <?php endif; ?>

</div>

<script>
    document.getElementById('filterProgram')?.addEventListener('change', filterTable);
    document.getElementById('filterYear')?.addEventListener('change', filterTable);

    function filterTable() {
        const programFilter = document.getElementById('filterProgram').value;
        const yearFilter = document.getElementById('filterYear').value;
        const rows = document.querySelectorAll('#attendanceTable tr');

        rows.forEach(row => {
            const program = row.getAttribute('data-program');
            const year = row.getAttribute('data-year');
            const show = (programFilter === 'all' || program === programFilter) &&
                (yearFilter === 'all' || year === yearFilter);
            row.style.display = show ? '' : 'none';
        });
    }
</script>
</body>
</html>
