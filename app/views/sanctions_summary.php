<?php
global $imageSource, $imageSource2, $imageSource4;
    require "../app/core/imageConfig.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanctions Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="<?php echo $imageSource?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Loading overlay styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }
        .loading-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        .loading-spinner {
            position: relative;
            width: 60px;
            height: 60px;
        }
        .loading-spinner:before,
        .loading-spinner:after {
            content: '';
            position: absolute;
            border-radius: 50%;
            animation: pulse 1.5s linear infinite;
        }
        .loading-spinner:before {
            width: 100%;
            height: 100%;
            background: rgba(220, 38, 38, 0.2);
            animation-delay: -0.5s;
        }
        .loading-spinner:after {
            width: 75%;
            height: 75%;
            background: #dc2626;
            top: 12.5%;
            left: 12.5%;
            animation-delay: -1s;
        }
        .loading-text {
            color: #dc2626;
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            animation: fadeInOut 1.5s ease-in-out infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1); opacity: 1; }
            100% { transform: scale(0.8); opacity: 0.5; }
        }
        @keyframes fadeInOut {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-container">
            <div class="loading-spinner"></div>
            <div class="loading-text">Loading...</div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-sm p-6 mb-6">
        <div class="max-w-7xl mx-auto flex items-center space-x-3">
            <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
            <h1 class="text-3xl font-bold text-gray-900">Sanctions Summary</h1>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <input type="text" 
                       id="searchInput" 
                       placeholder="Search by student ID, name, or program..." 
                       class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-200"
                >
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <!-- Sanctions Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sanction Hours</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="sanctionsTableBody">
                        <?php foreach ($data['sanctionSummary'] as $sanction): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($sanction['student_id']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($sanction['f_name'] . ' ' . $sanction['l_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($sanction['program']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($sanction['acad_year']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold <?php echo $sanction['sanction_hours'] > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'; ?>">
                                        <?php echo htmlspecialchars($sanction['sanction_hours']); ?> hours
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <a href="?page=Attendance&student_id=<?php echo htmlspecialchars($sanction['student_id']); ?>" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        View Attendance Record
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('sanctionsTableBody');
            const rows = tableBody.getElementsByTagName('tr');
            const loadingOverlay = document.getElementById('loadingOverlay');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                loadingOverlay.style.display = 'flex';

                setTimeout(() => {
                    Array.from(rows).forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                    loadingOverlay.style.display = 'none';
                }, 300);
            });
        });
    </script>
</body>
</html>