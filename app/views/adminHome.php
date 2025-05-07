<?php
global $imageSource, $OSASLogo, $username;
require_once "../app/core/imageConfig.php";


// Determine which component to load
$page = $_GET['page'] ?? 'Dashboard'; // Default to 'dashboard'
$allowed_pages = ['Dashboard', 'Students', 'Attendance', 'Users', 'ProfileAdmin'];




?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="<?php echo ROOT?>assets/js/dropdown.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/x-icon" href="<?php echo $imageSource ?>">
    <title>Attendance System • Admin </title>
</head>
<body>
<div class="min-h-full">
    <nav class="bg-[#840307] shadow-lg sticky top-0 z-50 border-b-8 border-[#691212]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-40 items-center justify-between">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <img style="width: 200px; height: 130px;" src= "<?php echo $imageSource ?>" alt="OSAS Logo">
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <nav>
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <a href="?page=Dashboard" data-page="Dashboard" style="padding: 10px 20px; font-size: 16px; font-weight: bold; color: #ccc;" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-red-800 hover:text-gray-200">Dashboard</a>
                                <a href="?page=Students" data-page="Students" style="padding: 10px 20px; font-size: 16px; font-weight: bold; color: #ccc;" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-red-800 hover:text-gray-200">Students</a>
                                <a href="?page=Attendance" data-page="Attendance" style="padding: 10px 20px; font-size: 16px; font-weight: bold; color: #ccc;" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-red-800 hover:text-gray-200">Attendance</a>
                                <a href="?page=Users" data-page="Users" style="padding: 10px 20px; font-size: 16px; font-weight: bold; color: #ccc;" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-red-800 hover:text-gray-200">Accounts</a>
                                <a href="?page=ProfileAdmin" data-page="Reports" style="padding: 10px 20px; font-size: 16px; font-weight: bold; color: #ccc;" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-red-800 hover:text-gray-200">Profile</a>
                            </nav>
                            <script>
                                const links = document.querySelectorAll('.nav-link');
                                links.forEach(link => {
                                    link.addEventListener('click', () => {
                                        links.forEach(item => item.classList.remove('bg-red-800', 'text-white'));

                                        link.classList.add('bg-red-800', 'text-white');
                                    });
                                });

                                const currentPage = new URL(window.location.href).searchParams.get('page');
                                links.forEach(link => {
                                    if (link.href.includes(`page=${currentPage}`)) {
                                        link.classList.add('bg-red-800', 'text-white');
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button type="button"  class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <img style="height: 64px; width: 64px; " class="rounded-full" src="<?php echo $OSASLogo?>" alt="">
                                </button>
                            </div>

                            <div id="notification-menu" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-hidden hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0"><?php echo $username?></a>
                                <button onclick="logout('<?php echo ROOT; ?>')" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="md:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                <nav class=" top-0 z-50">
                    <a href="#"  data-page="Dashboard" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-red-800 hover:text-gray-200">Dashboard</a>
                    <a href="#" data-page="Students" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-red-800 hover:text-gray-200">Students</a>
                    <a href="#" data-page="Attendance" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-red-800 hover:text-gray-200">Attendance</a>
                    <a href="#" data-page="Users" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-red-800 hover:text-gray-200">Accounts</a>
                    <a href="#" data-page="Reports" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-red-800 hover:text-gray-200">Profile</a>
                </nav>
                <script>
                    const links = document.querySelectorAll('.nav-link');

                    links.forEach(link => {
                        link.addEventListener('click', () => {
                            links.forEach(item => item.classList.remove('bg-red-800', 'text-white'));
                            link.classList.add('bg-red-800', 'text-white');
                        });
                    });
                    const currentPage = new URL(window.location.href).searchParams.get('page');
                    links.forEach(link => {
                        if (link.href.includes(`page=${currentPage}`)) {
                            link.classList.add('bg-red-800', 'text-white');
                        }
                    });
                </script>
            </div>
            <div class="border-t border-gray-700 pt-4 pb-3">
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <img class="size-10 rounded-full" src="<?php echo $OSASLogo?>" alt="">
                    </div>
                    <div class="ml-3">
                        <div class="text-base/5 font-medium text-white">Welcome Admin</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-red-800 hover:text-white"><?php echo $username?></a>
                    <button onclick="logout('<?php echo ROOT; ?>')" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-red-800 hover:text-white">Sign out</button>
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
            </div>
        </div>
    </nav>
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8" id="page-content">
          
        </div>
    </main>

    <script>
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent full reload
                const page = this.getAttribute('data-page');

                // Load the content dynamically
                fetch(`adminHome?page=${page}`)
                    .then(response => {
                        if (!response.ok) throw new Error("Page not found.");
                        return response.text();
                    })
                    .then(data => {
                        document.getElementById('page-content').innerHTML = data;

                        // Optional: highlight the active menu item
                        document.querySelectorAll('.nav-link').forEach(l => {
                            l.classList.remove('bg-red-800', 'text-white');
                        });
                        this.classList.add('bg-red-800', 'text-white');
                    })
                    .catch(err => {
                        document.getElementById('page-content').innerHTML = "<p class='text-red-500'>Failed to load page.</p>";
                        console.error(err);
                    });
            });
        });
    </script>


</div>
</body>
</html>