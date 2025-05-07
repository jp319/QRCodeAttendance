<?php
session_start(); // Make sure session is started
global $isFiltered;

// CSRF Token
if (empty($_SESSION['csrf_token'])) {
    try {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } catch (\Exception $e) {
        // Handle error or log it
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?php echo ROOT ?>assets/css/students.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Students</title>
</head>
<body class="bg-[#f8f9fa]">

<!-- Header -->
<header class="bg-white shadow-sm p-6">
    <div class="max-w-7xl mx-auto flex items-center space-x-2">
        <i class="fas fa-user-graduate text-gray-900 text-2xl"></i>
        <h1 class="text-3xl font-bold text-gray-900">Students</h1>
    </div>
</header>

<div class="container">
    <!-- Search and Filter Section -->
    <div class="search-bar">
        <form id="searchForm" class="flex flex-col md:flex-row items-center gap-4 bg-white p-4 rounded-lg shadow-md w-full">
            <input type="hidden" name="page" value="Students">
            <div class="flex items-center w-full md:w-auto gap-2">
                <input type="text" name="search" id="search-input" placeholder="Search..."
                       class="w-full md:w-80 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-maroon">
                <button type="submit" id="search-btn" class="bg-maroon hover:bg-maroon-hover text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="fas fa-search" style="color: black"></i>
                </button>
            </div>
            <div class="text-gray-600 text-sm">
                Number of Students: <span class="font-bold" id="studentCount"><?php echo $numOfStudent ?></span>
            </div>
        </form>

        <!-- Filter Form -->
        <form id="filterForm" class="filter-container mt-4 flex gap-4">
            <input type="hidden" name="page" value="Students">
            <select name="program" id="program-filter" class="p-2 border border-gray-300 rounded-lg">
                <option value="">Select Program</option>
                <?php foreach ($programList as $program): ?>
                    <option value="<?php echo htmlspecialchars($program['program']); ?>">
                        <?php echo htmlspecialchars($program['program']); ?>
                    </option>
                <?php endforeach ?>
            </select>

            <select name="year" id="year-filter" class="p-2 border border-gray-300 rounded-lg">
                <option value="">Select Year</option>
                <?php foreach ($yearList as $year): ?>
                    <option value="<?php echo htmlspecialchars($year['acad_year']); ?>">
                        <?php echo htmlspecialchars($year['acad_year']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="px-4 py-2 bg-red-800 text-white rounded-lg shadow hover:bg-red-700 transition duration-200 ease-in-out">
                <i class="fas fa-filter"></i> Apply Filter
            </button>
        </form>

        <!-- Add Student Button -->
        <a href="<?php echo ROOT ?>add_student"
           class="block mt-4 text-white bg-red-800 hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            <i class="fas fa-user-graduate"></i> Add Student
        </a>
    </div>

    <!-- Students Cards Container (moved out of <table>) -->
    <div id="studentsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <!-- Rendered by JS -->
    </div>
</div>

<!-- JavaScript Data and Logic -->
<script>
    const allStudents = <?php echo json_encode($studentsList); ?>;

    function confirmDelete(event, url) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function renderStudents(data) {
        const container = document.getElementById('studentsContainer');
        const count = document.getElementById('studentCount');

        container.innerHTML = '';
        if (data.length === 0) {
            container.innerHTML = `<p class="text-center text-gray-600 mt-6">No students found.</p>`;
            return;
        }

        data.forEach(student => {
            container.insertAdjacentHTML('beforeend', `
                <div class="bg-white rounded-lg shadow-md p-6 flex flex-col space-y-3 border border-gray-200 transition-transform hover:scale-105 hover:shadow-lg duration-300">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user-graduate text-red-800 text-2xl"></i>
                        <h2 class="text-xl font-semibold text-gray-900">${student.f_name} ${student.l_name}</h2>
                    </div>
                    <p class="text-gray-700"><strong>ID:</strong> ${student.student_id}</p>
                    <p class="text-gray-700"><strong>Program:</strong> ${student.program}</p>
                    <p class="text-gray-700"><strong>Year:</strong> ${student.acad_year}</p>
                    <p class="text-gray-700"><strong>Email:</strong> ${student.email}</p>
                    <p class="text-gray-700"><strong>Contact No.:</strong> ${student.contact_num}</p>
                    <div class="flex justify-between mt-4">
                        <a href="<?php echo ROOT ?>edit_student?id=${student.student_id}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?php echo ROOT ?>delete_student?id=${student.student_id}" onclick="return confirmDelete(event, this.href);" class="text-red-600 hover:text-red-800 flex items-center gap-1">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                </div>
            `);
        });

        count.textContent = data.length;
    }

    function filterAndSearch() {
        const search = document.getElementById('search-input').value.toLowerCase();
        const program = document.getElementById('program-filter').value.toLowerCase();
        const year = document.getElementById('year-filter').value.toLowerCase();

        const filtered = allStudents.filter(student => {
            const fullName = `${student.f_name} ${student.l_name}`.toLowerCase();
            const id = student.student_id.toLowerCase();
            return (
                (fullName.includes(search) || id.includes(search)) &&
                (program === "" || student.program.toLowerCase() === program) &&
                (year === "" || student.acad_year.toLowerCase() === year)
            );
        });

        renderStudents(filtered);
    }

    document.getElementById('searchForm').addEventListener('submit', e => {
        e.preventDefault();
        filterAndSearch();
    });

    document.getElementById('filterForm').addEventListener('submit', e => {
        e.preventDefault();
        filterAndSearch();
    });

    document.addEventListener('DOMContentLoaded', () => {
        renderStudents(allStudents);
    });
</script>

</body>
</html>
