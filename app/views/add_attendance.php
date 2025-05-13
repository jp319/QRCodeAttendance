<?php
require_once '../app/core/config.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Attendance System • Create Attendance</title>
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT?>assets/images/LOGO_QRCODE_v2.png">
</head>
<body>

<!-- Main modal -->
<div id="crud-modal" tabindex="-1" aria-hidden="false" class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-md max-h-full overflow-y-auto">
        <!-- Modal content -->
        <div class="relative bg-gray-50 rounded-lg shadow"> <!-- Changed to bg-gray-50 -->
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200"> <!-- Changed border color -->
                <h3 class="text-lg font-semibold text-gray-800"> <!-- Changed text color -->
                    Create New Attendance
                </h3>
                <a href="<?php echo ROOT?>adminHome?page=Attendance" type="button" class="text-gray-500 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-close="crud-modal"> <!-- Changed text and hover colors -->
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </a>
            </div>
            <!-- Modal body -->
            <form method="POST" class="p-4 md:p-5" action="<?php echo ROOT?>add_attendance">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="eventName" class="block mb-2 text-sm font-medium text-gray-700">Event Name</label>
                        <input type="text" name="eventName" id="eventName" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Event name" required>
                        <label class="block mb-2 mt-10 text-sm font-medium text-gray-700">Required Attendees</label>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="program" class="block mb-2 text-sm font-medium text-gray-700">Program</label>
                        <select name="program[]" class="program-select bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="">Select program</option>
                            <?php foreach ($programs as $program): ?>
                                <option value="<?php echo htmlspecialchars($program['program']); ?>">
                                    <?php echo htmlspecialchars($program['program']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="year" class="block mb-2 text-sm font-medium text-gray-700">Year</label>
                        <select name="year[]" class="year-select bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Select year</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?php echo htmlspecialchars($year['acad_year']); ?>">
                                    <?php echo htmlspecialchars($year['acad_year']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="space-y-1 mt-2">
                        <div id="additional-fields"></div>
                        <!-- Add Button -->
                        <button type="button"
                                onclick="addFieldSet()"
                                class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            + Add
                        </button>
                    </div>

                    <script>
                        // Fetch programs and years from PHP
                        let programs = <?php echo json_encode($programs); ?>;
                        let years = <?php echo json_encode($years); ?>;
                    </script>

                    <div class="col-span-2">
                        <label for="sanction" class="block mb-2 text-sm font-medium text-gray-700">Required Attendance Record</label>

                        <div class="flex items-center space-x-4">
                            <!-- Time In (Always Required - Disabled and Checked) -->
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="required_attendance[]" value="time_in" checked required
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                <span class="text-sm text-gray-700">Time In (Default)</span>
                            </label>

                            <!-- Time Out (Optional) -->
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="required_attendance[]" value="time_out"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                <span class="text-sm text-gray-700">Time Out</span>
                            </label>
                        </div>
                    </div>


                    <div class="col-span-2">
                        <label for="sanction" class="block mb-2 text-sm font-medium text-gray-700">Sanction (in hours)</label>
                        <input type="number" name="sanction" id="sanction"
                               class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                               placeholder="Sanction" required>
                    </div>

                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Done
                </button>

            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Check if there's a success message from PHP
    <?php if (isset($_SESSION['success_message'])): ?>
    Swal.fire({
        title: 'Success!',
        text: '<?php echo $_SESSION['success_message']; ?>',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    <?php unset($_SESSION['success_message']); // Clear the message after displaying ?>
    <?php endif; ?>
</script>


<!-- Backdrop -->
<div id="crud-modal-backdrop" class="fixed inset-0 z-40 bg-black bg-opacity-50"></div>


</body>
<script>
    function addFieldSet() {
        let container = document.getElementById("additional-fields");

        // Create a wrapper div
        let fieldSet = document.createElement("div");
        fieldSet.className = "relative bg-gray-100 p-4 rounded-lg shadow-md border border-gray-300";

        // Create Program select dropdown
        let programDiv = document.createElement("div");
        programDiv.className = "mb-2";
        let programLabel = document.createElement("label");
        programLabel.className = "block mb-2 text-sm font-medium text-gray-700";
        programLabel.textContent = "Program";

        let programSelect = document.createElement("select");
        programSelect.name = "program[]";
        programSelect.className = "program-select bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5";
        programSelect.required = true;

        // Populate Program dropdown
        let programOptions = `<option value="">Select program</option>`;
        programs.forEach(program => {
            programOptions += `<option value="${program.program}">${program.program}</option>`;
        });
        programSelect.innerHTML = programOptions;

        programDiv.appendChild(programLabel);
        programDiv.appendChild(programSelect);

        // Create Year select dropdown
        let yearDiv = document.createElement("div");
        let yearLabel = document.createElement("label");
        yearLabel.className = "block mb-2 text-sm font-medium text-gray-700";
        yearLabel.textContent = "Year";

        let yearSelect = document.createElement("select");
        yearSelect.name = "year[]";
        yearSelect.className = "year-select bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5";
        yearSelect.required = true;

        // Populate Year dropdown
        let yearOptions = `<option value="">Select year</option>`;
        years.forEach(year => {
            yearOptions += `<option value="${year.acad_year}">${year.acad_year}</option>`;
        });
        yearSelect.innerHTML = yearOptions;

        yearDiv.appendChild(yearLabel);
        yearDiv.appendChild(yearSelect);

        // Remove button
        let removeBtn = document.createElement("button");
        removeBtn.className = "absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-lg hover:bg-red-600";
        removeBtn.textContent = "Remove";
        removeBtn.onclick = function () {
            container.removeChild(fieldSet);
        };

        // Append all elements
        fieldSet.appendChild(removeBtn);
        fieldSet.appendChild(programDiv);
        fieldSet.appendChild(yearDiv);

        // Append fieldset to container
        container.appendChild(fieldSet);
    }
</script>

</html>