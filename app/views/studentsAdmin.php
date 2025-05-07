<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<div class="container mx-auto p-6">
    <div class="search-bar">
        <!-- Search Input -->
        <div class="flex flex-col md:flex-row items-center gap-4 bg-white p-4 rounded-lg shadow-md w-full">
            <div class="flex items-center w-full md:w-auto gap-2">
                <input type="text" id="search-input" placeholder="Search by name or ID..."
                       class="w-full md:w-80 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-maroon">
                <button id="search-btn" class="bg-red-800 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="fas fa-search text-white"></i> <!-- Fixed icon color -->
                </button>
            </div>
            <div class="text-gray-600 text-sm">
                Number of Students: <span class="font-bold" id="studentCount"><?php echo htmlspecialchars($numOfStudent); ?></span>
            </div>
        </div>

        <!-- Filter Container -->
        <div class="filter-container mt-4 flex flex-col md:flex-row gap-4">
            <select id="program-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                <option value="">All Programs</option>
                <?php foreach ($programList as $program): ?>
                    <option value="<?php echo htmlspecialchars($program['program']); ?>">
                        <?php echo htmlspecialchars($program['program']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select id="year-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                <option value="">All Years</option>
                <?php foreach ($yearList as $year): ?>
                    <option value="<?php echo htmlspecialchars($year['acad_year']); ?>">
                        <?php echo htmlspecialchars($year['acad_year']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button id="filter-btn" class="px-4 py-2 bg-red-800 text-white rounded-lg shadow hover:bg-red-700 transition duration-200 ease-in-out">
                <i class="fas fa-filter"></i> Apply Filter
            </button>
        </div>

        <!-- Add Student Button -->
        <a href="<?php echo ROOT ?>add_student"
           class="inline-block text-white bg-red-800 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-4">
            <i class="fas fa-user-graduate"></i> Add Student
        </a>
    </div>

    <!-- Students Cards Container -->
    <div id="studentsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <!-- Rendered by JS -->
    </div>
</div>

<!-- JavaScript Data and Logic -->
<script>
    // Initialize students data (ensure it's valid)
    const allStudents = <?php echo json_encode($studentsList) ?: '[]'; ?>;

    // Debounce function to limit search/filter calls
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Render students to the DOM
    function renderStudents(data) {
        const container = document.getElementById('studentsContainer');
        const count = document.getElementById('studentCount');

        container.innerHTML = '';
        if (!data || data.length === 0) {
            container.innerHTML = `<p class="text-center text-gray-600 mt-6">No students found.</p>`;
            count.textContent = '0';
            return;
        }

        data.forEach(student => {
            // Ensure all fields exist to prevent undefined errors
            const fullName = `${student.f_name || ''} ${student.l_name || ''}`.trim();
            const studentId = student.student_id || 'N/A';
            const program = student.program || 'N/A';
            const acadYear = student.acad_year || 'N/A';
            const email = student.email || 'N/A';
            const contactNum = student.contact_num || 'N/A';

            container.insertAdjacentHTML('beforeend', `
                <div class="bg-white rounded-lg shadow-md p-6 flex flex-col space-y-3 border border-gray-200 transition-transform hover:scale-105 hover:shadow-lg duration-300">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user-graduate text-red-800 text-2xl"></i>
                        <h2 class="text-xl font-semibold text-gray-900">${escapeHtml(fullName)}</h2>
                    </div>
                    <p class="text-gray-700"><strong>ID:</strong> ${escapeHtml(studentId)}</p>
                    <p class="text-gray-700"><strong>Program:</strong> ${escapeHtml(program)}</p>
                    <p class="text-gray-700"><strong>Year:</strong> ${escapeHtml(acadYear)}</p>
                    <p class="text-gray-700"><strong>Email:</strong> ${escapeHtml(email)}</p>
                    <p class="text-gray-700"><strong>Contact No.:</strong> ${escapeHtml(contactNum)}</p>
                    <div class="flex justify-between mt-4">
                        <a href="<?php echo ROOT ?>edit_student?id=${encodeURIComponent(studentId)}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="<?php echo ROOT ?>delete_student" method="POST" class="delete-form">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="id" value="${encodeURIComponent(studentId)}">
                            <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-1">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            `);
        });

        count.textContent = data.length;
    }

    // Escape HTML to prevent XSS
    function escapeHtml(str) {
        return str.replace(/[&<>"']/g, match => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        }[match]));
    }

    // Filter and search students
    function filterAndSearch() {
        const search = (document.getElementById('search-input').value || '').toLowerCase().trim();
        const program = (document.getElementById('program-filter').value || '').toLowerCase();
        const year = (document.getElementById('year-filter').value || '').toLowerCase();

        const filtered = allStudents.filter(student => {
            // Ensure fields exist and are strings
            const fullName = `${student.f_name || ''} ${student.l_name || ''}`.toLowerCase().trim();
            const id = (student.student_id || '').toLowerCase();
            const studentProgram = (student.program || '').toLowerCase();
            const studentYear = (student.acad_year || '').toLowerCase();

            return (
                (fullName.includes(search) || id.includes(search)) &&
                (program === '' || studentProgram === program) &&
                (year === '' || studentYear === year)
            );
        });

        renderStudents(filtered);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        // Render initial students
        renderStudents(allStudents);

        // Debounced search/filter function
        const debouncedSearch = debounce(filterAndSearch, 300);

        // Event listeners
        document.getElementById('search-btn').addEventListener('click', debouncedSearch);
        document.getElementById('filter-btn').addEventListener('click', debouncedSearch);
        document.getElementById('search-input').addEventListener('input', debouncedSearch);
        document.getElementById('program-filter').addEventListener('change', debouncedSearch);
        document.getElementById('year-filter').addEventListener('change', debouncedSearch);

        // Handle delete form submissions
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
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
                        this.submit();
                    }
                });
            });
        });
    });
</script>
</body>
</html>