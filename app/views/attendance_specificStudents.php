<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Create Specific Student Attendance</title>
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT?>assets/images/LOGO_QRCODE_v2.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-6">
    <h1 class="text-2xl font-bold text-gray-700 mb-6">Create Attendance (Specific Students)</h1>

    <!-- Attendance Details -->
    <form action="#" method="POST">
        <div class="mb-4">
            <label for="attendanceName" class="block mb-1 text-gray-600 font-semibold">Attendance Name</label>
            <input type="text" id="attendanceName" name="attendanceName" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300" placeholder="e.g. Seminar for Scholars">
        </div>

        <!-- Additional Attendance Details -->
        <div class="mb-4">
            <label for="sanctionHours" class="block mb-1 text-gray-600 font-semibold">Sanction in Hours</label>
            <input type="number" id="sanctionHours" name="sanctionHours" min="1" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300"
                   placeholder="e.g. 3">
        </div>

        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" id="timeoutRequired" name="timeoutRequired" class="form-checkbox h-5 w-5 text-blue-600" checked>
                <span class="ml-2 text-gray-700 font-medium">Time Out Required</span>
            </label>
        </div>



        <!-- Search and Add Students -->
        <div class="mb-6">
            <label for="studentSearch" class="block mb-1 text-gray-600 font-semibold">Search Student</label>
            <input type="text" id="studentSearch" placeholder="Type student name or ID..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300 mb-3">

            <ul id="studentResults" class="border border-gray-300 rounded-md max-h-40 overflow-y-auto hidden bg-white shadow-md">
                <!-- JS will populate this -->
            </ul>
        </div>

        <!-- Selected Students -->
        <div class="mb-6">
            <label class="block mb-1 text-gray-600 font-semibold">Selected Students</label>
            <ul id="selectedStudents" class="space-y-2">
                <!-- Selected students will show up here -->
            </ul>
        </div>

        <!-- Hidden inputs to submit selected students -->
        <div id="selectedInputs"></div>

        <script>
            // Simulated student data (replace with AJAX call later if needed)
            const allStudents = [
                { id: "20230001", name: "Juan Dela Cruz - BSIT 3" },
                { id: "20230002", name: "Maria Santos - BSED 2" },
                { id: "20230003", name: "Jose Ramirez - BSA 1" },
                { id: "20230004", name: "Anna Lopez - BSME 4" },
                { id: "20230005", name: "Kim Reyes - BSCS 2" },
            ];

            const studentSearch = document.getElementById("studentSearch");
            const studentResults = document.getElementById("studentResults");
            const selectedStudents = document.getElementById("selectedStudents");
            const selectedInputs = document.getElementById("selectedInputs");

            const selectedIds = new Set();

            studentSearch.addEventListener("input", function () {
                const query = this.value.toLowerCase();
                studentResults.innerHTML = "";
                if (query === "") {
                    studentResults.classList.add("hidden");
                    return;
                }

                const filtered = allStudents.filter(s =>
                    s.name.toLowerCase().includes(query) || s.id.includes(query)
                );

                if (filtered.length === 0) {
                    studentResults.innerHTML = "<li class='p-2 text-gray-500'>No results found.</li>";
                } else {
                    filtered.forEach(student => {
                        const li = document.createElement("li");
                        li.className = "p-2 hover:bg-gray-100 cursor-pointer";
                        li.textContent = `${student.name}`;
                        li.onclick = () => addStudent(student);
                        studentResults.appendChild(li);
                    });
                }

                studentResults.classList.remove("hidden");
            });

            function addStudent(student) {
                if (selectedIds.has(student.id)) return;

                selectedIds.add(student.id);
                const li = document.createElement("li");
                li.className = "flex justify-between items-center bg-gray-100 p-2 rounded";

                li.innerHTML = `
            <span>${student.name}</span>
            <button type="button" class="text-red-500 hover:text-red-700 font-bold" onclick="removeStudent('${student.id}', this)">Remove</button>
        `;

                selectedStudents.appendChild(li);

                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "students[]";
                hiddenInput.value = student.id;
                hiddenInput.id = `hidden-${student.id}`;
                selectedInputs.appendChild(hiddenInput);

                studentSearch.value = "";
                studentResults.classList.add("hidden");
            }

            function removeStudent(id, btn) {
                selectedIds.delete(id);
                btn.closest("li").remove();
                document.getElementById(`hidden-${id}`).remove();
            }
        </script>


        <!-- Submit -->
        <div class="mt-6">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md font-medium">
                Create Attendance
            </button>
        </div>
    </form>
</div>
</body>
</html>
