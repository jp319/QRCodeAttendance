<?php

// Ensure data is set to avoid undefined variable errors
$programList = $data['programList'] ?? [];
$yearList = $data['yearList'] ?? [];
$studentsList = $data['studentsList'] ?? [];
$numOfStudent = $data['numOfStudent'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Admin</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 font-sans">

<!-- Header -->
<header class="bg-white shadow p-6">
    <div class="max-w-7xl mx-auto flex items-center space-x-3">
        <i class="fas fa-user-graduate text-gray-800 text-2xl"></i>
        <h1 class="text-3xl font-bold text-gray-800">Students</h1>
    </div>
</header>

<!-- Main Content -->
<main class="max-w-7xl mx-auto p-6">
    <!-- Search and Filter Section -->
    <section class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Search Input -->
            <div class="flex items-center gap-2 w-full md:w-auto">
                <input
                        type="text"
                        id="search-input"
                        placeholder="Search by name or ID..."
                        class="w-full md:w-80 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        aria-label="Search students"
                >
                <button
                        id="search-btn"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2"
                        aria-label="Search"
                >
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <!-- Student Count -->
            <div class="text-gray-600">
                Number of Students: <span id="student-count" class="font-bold"><?php echo htmlspecialchars($numOfStudent); ?></span>
            </div>
        </div>

        <!-- Filters -->
        <div class="mt-4 flex flex-col sm:flex-row gap-4">
            <select
                    id="program-filter"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                    aria-label="Filter by program"
            >
                <option value="">All Programs</option>
                <?php foreach ($programList as $program): ?>
                    <option value="<?php echo htmlspecialchars($program['program']); ?>">
                        <?php echo htmlspecialchars($program['program']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select
                    id="year-filter"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                    aria-label="Filter by year"
            >
                <option value="">All Years</option>
                <?php foreach ($yearList as $year): ?>
                    <option value="<?php echo htmlspecialchars($year['acad_year']); ?>">
                        <?php echo htmlspecialchars($year['acad_year']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button
                    id="filter-btn"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2"
                    aria-label="Apply filters"
            >
                <i class="fas fa-filter"></i> Apply
            </button>
        </div>

        <!-- Add Student Button -->
        <a
                href="<?php echo ROOT; ?>add_student"
                class="mt-4 inline-block bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium text-center"
                aria-label="Add new student"
        >
            <i class="fas fa-user-plus mr-2"></i>Add Student
        </a>
    </section>

    <!-- Students Cards -->
    <section id="students-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Populated by JavaScript -->
    </section>
</main>

<!-- JavaScript -->
<script>
    // Student data from PHP
    const allStudents = <?php echo json_encode($studentsList) ?: '[]'; ?>;

    // Debounce function to limit search/filter calls
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Escape HTML to prevent XSS
    function escapeHtml(str) {
        return String(str).replace(/[&<>"']/g, match => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        }[match]));
    }

    // Render students as cards
    function renderStudents(students) {
        const container = document.getElementById('students-container');
        const count = document.getElementById('student-count');

        container.innerHTML = '';
        if (!students || students.length === 0) {
            container.innerHTML = '<p class="col-span-full text-center text-gray-600">No students found.</p>';
            count.textContent = '0';
            return;
        }

        students.forEach(student => {
            // Handle missing fields
            const fullName = `${student.f_name || ''} ${student.l_name || ''}`.trim() || 'N/A';
            const studentId = student.student_id || 'N/A';
            const program = student.program || 'N/A';
            const acadYear = student.acad_year || 'N/A';
            const email = student.email || 'N/A';
            const contactNum = student.contact_num || 'N/A';

            container.insertAdjacentHTML('beforeend', `
                <div class="bg-white rounded-lg shadow-md p-6 flex flex-col space-y-3 hover:shadow-lg transition-shadow">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user-graduate text-red-600 text-xl"></i>
                        <h2 class="text-lg font-semibold text-gray-800">${escapeHtml(fullName)}</h2>
                    </div>
                    <p class="text-gray-600"><strong>ID:</strong> ${escapeHtml(studentId)}</p>
                    <p class="text-gray-600"><strong>Program:</strong> ${escapeHtml(program)}</p>
                    <p class="text-gray-600"><strong>Year:</strong> ${escapeHtml(acadYear)}</p>
                    <p class="text-gray-600"><strong>Email:</strong> ${escapeHtml(email)}</p>
                    <p class="text-gray-600"><strong>Contact:</strong> ${escapeHtml(contactNum)}</p>
                    <div class="flex justify-between mt-4">
                        <a
                            href="<?php echo ROOT; ?>edit_student?id=${encodeURIComponent(studentId)}"
                            class="text-blue-600 hover:text-blue-700 flex items-center gap-1"
                            aria-label="Edit student ${escapeHtml(fullName)}"
                        >
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form
                            action="<?php echo ROOT; ?>delete_student"
                            method="POST"
                            class="delete-form"
                            aria-label="Delete student ${escapeHtml(fullName)}"
                        >
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="id" value="${encodeURIComponent(studentId)}">
                            <button
                                type="submit"
                                class="text-red-600 hover:text-red-700 flex items-center gap-1"
                            >
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            `);
        });

        count.textContent = students.length;

        // Attach delete form listeners
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then(result => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    }

    // Filter and search students
    function filterAndSearch() {
        const search = (document.getElementById('search-input').value || '').toLowerCase().trim();
        const program = (document.getElementById('program-filter').value || '').toLowerCase();
        const year = (document.getElementById('year-filter').value || '').toLowerCase();

        const filtered = allStudents.filter(student => {
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

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        // Render all students initially
        renderStudents(allStudents);

        // Debounced search/filter
        const debouncedSearch = debounce(filterAndSearch, 300);

        // Event listeners
        document.getElementById('search-btn').addEventListener('click', debouncedSearch);
        document.getElementById('filter-btn').addEventListener('click', debouncedSearch);
        document.getElementById('search-input').addEventListener('input', debouncedSearch);
        document.getElementById('program-filter').addEventListener('change', debouncedSearch);
        document.getElementById('year-filter').addEventListener('change', debouncedSearch);
    });
</script>

</body>
</html>