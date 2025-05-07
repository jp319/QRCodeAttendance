<?php
global $studentData, $imageSource5;
require "../app/core/imageConfig.php";
// Calculate total sanction hours
$totalSanctionHours = array_sum(array_column($sanctionList, 'sanction_hours'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Details</title>
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT?>assets/images/LOGO_QRCODE_v2.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <!-- Student Profile -->
    <div class="flex flex-col items-center">
        <?php if (!empty($studentData['studentProfile'])): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($studentData['studentProfile']) ?>"
                 class="w-32 h-32 object-cover rounded-full border-4 border-gray-300 shadow-md"
                 alt="Profile Picture">
        <?php else: ?>
            <img src="<?php echo $imageSource5 ?>"
                 class="w-32 h-32 object-cover rounded-full border-4 border-gray-300 shadow-md"
                 alt="Default Profile">
        <?php endif; ?>
        <h2 class="text-xl font-bold text-gray-800 mt-3"><?php echo $studentData['f_name'] . " " . $studentData['l_name'] ?></h2>
        <p class="text-gray-600"><?php echo $studentData['program'] ?></p>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 text-center my-6">Edit Student Details</h1>

    <form id="studentForm" method="post" action="">
        <!-- Student Details -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Student ID</label>
            <input type="text" name="id" id="id" class="w-full border-gray-300 rounded-lg p-2.5 bg-gray-200 cursor-not-allowed"
                   value="<?php echo $studentData['student_id']?>" readonly>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold">First Name</label>
                <input type="text" name="f_name" id="f_name" class="w-full border-gray-300 rounded-lg p-2.5"
                       value="<?php echo $studentData['f_name']?>">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold">Last Name</label>
                <input type="text" name="l_name" id="l_name" class="w-full border-gray-300 rounded-lg p-2.5"
                       value="<?php echo $studentData['l_name']?>">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Email</label>
                <input type="email" name="email" id="email" class="w-full border-gray-300 rounded-lg p-2.5"
                       value="<?php echo $studentData['email']?>">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold">Phone No.</label>
                <input type="text" name="contact_num" id="contact_num" class="w-full border-gray-300 rounded-lg p-2.5"
                       value="<?php echo $studentData['contact_num']?>">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-gray-700 font-semibold">Program</label>
                <input class="w-full border-gray-300 rounded-lg p-2.5" name="program" id="program"
                       value="<?php echo $studentData['program']?>">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold">Year Level</label>
                <input class="w-full border-gray-300 rounded-lg p-2.5" type="text" name="acad_year" id="acad_year"
                       value="<?php echo $studentData['acad_year']?>" min="1">
            </div>
        </div>

        <!-- Student Account Section -->
        <div class="mt-6 bg-gray-100 p-4 rounded-lg border border-gray-300">
            <h2 class="text-lg font-semibold text-gray-800">Student Account</h2>
            <p class="text-gray-700 mt-2"><strong>Username:</strong> <?php echo $studentData['email']; ?></p>
        </div>


        <!-- Submit Button -->
        <div class="mt-6 text-right">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Changes</button>
        </div>

    </form>


    <!-- Separate Form for Sanctions -->
    <form id="sanctionForm" method="post" action="" class="p-5 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Apply Sanction</h2>

        <input type="hidden" name="id" value="<?php echo $studentData['student_id']; ?>">

        <!-- Sanction Hours Input -->
        <label for="sanctionHours" class="block text-gray-700 mb-1">Sanction Hours</label>
        <input type="number" name="sanctionH" id="sanctionHours"
               placeholder="Enter hours" min="1"
               class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-red-500 focus:border-red-500 transition">

        <!-- Reason Input (Initially Hidden) -->
        <div id="reasonContainer" class="mt-3 hidden">
            <label for="sanctionReason" class="block text-gray-700 mb-1">Reason for Sanction</label>
            <textarea name="reason" id="sanctionReason"
                      placeholder="Enter reason..."
                      class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-red-500 focus:border-red-500 transition"></textarea>
        </div>

        <!-- Apply Button -->
        <button type="submit" id="applySanction"
                class="mt-4 w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                disabled>Apply Sanction</button>
    </form>

    <script>
        document.getElementById('sanctionHours').addEventListener('input', function () {
            let hours = this.value;
            let reasonContainer = document.getElementById('reasonContainer');
            let applyButton = document.getElementById('applySanction');

            // Show reason input only if hours are valid
            if (hours > 0) {
                reasonContainer.classList.remove('hidden');
            } else {
                reasonContainer.classList.add('hidden');
                document.getElementById('sanctionReason').value = ''; // Clear input
            }

            checkFormValidity();
        });

        document.getElementById('sanctionReason').addEventListener('input', checkFormValidity);

        function checkFormValidity() {
            let hours = document.getElementById('sanctionHours').value;
            let reason = document.getElementById('sanctionReason').value.trim();
            let applyButton = document.getElementById('applySanction');

            applyButton.disabled = !(hours > 0 && reason.length > 0);
        }
    </script>


    <!-- Sanctions Section -->
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Student Sanctions</h2>

        <!-- Sanctions List -->
        <div class="space-y-4">
            <?php foreach ($sanctionList as $sanction): ?>
                <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200 flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm"><?= htmlspecialchars($sanction['date_applied']); ?></p>
                        <h3 class="text-lg font-semibold text-gray-700"><?= htmlspecialchars($sanction['sanction_reason']); ?></h3>
                        <p class="text-gray-800 font-medium">Sanction Hours:
                            <span class="text-red-500"><?= htmlspecialchars($sanction['sanction_hours']); ?></span>
                        </p>
                    </div>
                    <a href="<?php echo ROOT?>remove_sanction?id=<?php echo htmlspecialchars($sanction['sanction_id']); ?>"
                            class="text-red-500 hover:text-red-700"
                       onclick="return confirmDelete(event, this.href);">
                        🗑️
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Total Sanction Hours -->
        <div class="mt-6 bg-blue-600 text-white text-lg font-semibold p-4 rounded-lg shadow-md text-center">
            Total Sanction Hours: <span><?= htmlspecialchars($totalSanctionHours); ?></span>
        </div>
    </div>

    <script>
        function confirmDelete(event, url) {
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


</div>

<script>
    document.getElementById('studentForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission initially

        let email = document.getElementById("email").value.trim();
        let acadYear = document.getElementById("acad_year").value.trim();
        let requiredFields = ["f_name", "l_name", "email", "contact_num", "program", "acad_year"];
        let allFilled = true;

        // Check if all required fields are filled
        requiredFields.forEach(field => {
            let input = document.getElementById(field);
            if (input.value.trim() === "") {
                allFilled = false;
                input.classList.add("border-red-500");
            } else {
                input.classList.remove("border-red-500");
            }
        });

        // Check if email ends with "usep.edu.ph"
        if (!email.endsWith("@usep.edu.ph")) {
            alert('Error: Email must end with "@usep.edu.ph"');
            return;
        }


        // Ensure all fields are filled before proceeding
        if (!allFilled) {
            alert('Error: All fields are required!');
            return;
        }

        // Confirmation before submission
        let confirmUpdate = confirm("Are you sure you want to update this student’s details?");
        if (confirmUpdate) {
            document.getElementById("studentForm").submit(); // Submit the form if confirmed
        }
    });
</script>




</body>
</html>
