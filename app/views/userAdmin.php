<?php

if (empty($_SESSION['csrf_token'])) {
    try {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } catch (\Random\RandomException $e) {

    }
}
?>

<!doctype html>
<html lang="en">
<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?php echo ROOT ?>assets/css/students.css">
</header>

<body class="bg-[#f8f9fa]">
<header class="bg-white shadow-sm p-6">
    <div class="max-w-7xl mx-auto flex items-center space-x-2">
        <i class="fas fa-users-gear text-gray-900 text-2xl"></i>
        <h1 class="text-3xl font-bold text-gray-900">Users</h1>
    </div>
</header>

<div class="container">
    <!-- Search and Filter Section -->

    <!-- Search and Filter Section -->
    <div class="flex items-center gap-4 mb-4">
        <!-- Search Input -->
        <form action="<?php echo ROOT ?>adminHome" method="get" class="flex-grow flex items-center border border-gray-300 rounded-lg overflow-hidden">
            <input type="hidden" name="page" value="Users">
            <input type="text" id="search-input" name="search" placeholder="Search..."
                   class="flex-grow px-4 py-2 border-none outline-none">
            <button type="submit" id="search-btn" class="px-4 py-2 bg-gray-100 hover:bg-gray-200">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Add User Button -->
        <a href="<?php echo ROOT ?>add_user"
           class="text-white bg-red-800 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            <i class="fas fa-users-gear"></i> Add User
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <?php if (!empty($userList)):?>
            <?php foreach ($userList as $user): ?>
                <div class="bg-white rounded-lg shadow-md p-6 flex flex-col space-y-3 border border-gray-200
                        transition-transform transform hover:scale-105 hover:shadow-lg duration-300">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user text-red-800 text-2xl"></i>
                        <h2 class="text-xl font-semibold text-gray-900">
                            <?php echo htmlspecialchars($user['username']); ?>
                        </h2>
                    </div>
                    
                    <p class="text-gray-700"><strong>Role:</strong> <?php echo htmlspecialchars($user['roles']); ?></p>
                    <p class="text-gray-700">
                        <strong>Status:</strong>
                        <?php if ($user['state'] === 'login'): ?>
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
                            <i class="fas fa-check-circle mr-1"></i> Active
                        </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full">
                            <i class="fas fa-times-circle mr-1"></i> Inactive
                        </span>
                        <?php endif; ?>
                    </p>

                    <div class="flex justify-between mt-4">
                        <a href="<?php echo ROOT ?>edit_user?id=<?php echo htmlspecialchars($user['id']); ?>"
                           class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?php echo ROOT ?>delete_user?id=<?php echo htmlspecialchars($user['id']); ?>"
                           onclick="return confirmDelete(event, this.href);"
                           class="text-red-600 hover:text-red-800 flex items-center gap-1">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else:?>
            <p class="text-center text-gray-600 mt-6">Users Information will be displayed here.</p>
        <?php endif; ?>
    </div>


    <!-- Pagination -->
  <!--  <div class="pagination flex justify-left items-center gap-4 mt-6">
        <form id="paginationForm" action="" method="post" class="flex items-center space-x-4">
            <input type="hidden" name="page1" id="pageInput" value="<?= $page ?>">

            Previous Button
            <?php if ($page > 1): ?>
                <button type="button" onclick="changePage(<?= $page - 1 ?>)"
                        class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg shadow hover:bg-gray-300 transition duration-200 ease-in-out">
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
            <?php endif; ?>

             Page Indicator
            <span class="text-gray-700 font-semibold text-lg">
                Page <?= $page ?> of <?= $totalPages ?>
            </span>

             Next Button
            <?php if ($page < $totalPages): ?>
                <button type="button" onclick="changePage(<?= $page + 1 ?>)"
                        class="px-4 py-2 bg-red-800 text-white rounded-lg shadow hover:bg-red-700 transition duration-200 ease-in-out">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            <?php endif; ?>
        </form>
    </div> -->

    <script>
        function changePage(pageNumber) {
            document.getElementById('pageInput').value = pageNumber;
            document.getElementById('paginationForm').submit();
        }

        function confirmDelete(event) {
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
                    window.location.href = event.currentTarget.href; // Redirects to delete URL
                }
            });
        }
    </script>

</body>
</html>