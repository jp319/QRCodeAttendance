<?php
global $AttendanceID, $EventName, $EventDate, $EventTime, $isOngoing;
require_once '../app/core/config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT?>assets/images/LOGO_QRCODE_v2.png">
    <title>QR Code Scanner</title>
<!--    <script src="../node_modules/html5-qrcode/html5-qrcode.min.js"></script>-->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            background-color: #4a4a4a;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        h1 {
            color: #f8f8f8;
        }
        #reader {
            width: 90%;
            max-width: 500px;
            height: auto;
            margin: 20px auto;
            position: relative;
        }
        #result, #student-info {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        #student-info {
            color: #4CAF50;
        }
        .btn-container {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        button, a {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }
        button:hover, a:hover {
            background-color: #388e3c;
        }
        @media (max-width: 600px) {
            #reader {
                width: 100%;
            }
            button, a {
                width: 100%;
                padding: 15px;
            }
        }

        /* Responsive styles for the confirmation modal */
        #confirmation-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }
        #confirmation-modal > div {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            max-width: 90%;
            width: 400px;
            color: black;
        }
        #student-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin: 20px auto;
            display: block;
        }

        #confirmation-modal button {
            margin: 5px;
        }

        .loader {
            border: 8px solid #f3f3f3; /* Light gray */
            border-top: 8px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<h1>QR Code Scanner</h1>

<?php if ($isOngoing): ?>
    <p><strong>Event Name:</strong> <?= $EventName; ?></p>
    <p><strong>Date Started:</strong> <?= $EventDate; ?></p>
    <p><strong>Time Started:</strong> <?= $EventTime; ?></p>
    <div id="reader"></div>
    <div id="result"></div>
    <div id="student-info"></div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal">
        <div>
            <h3>Confirm Attendance</h3>
            <img id="student-image" src="" alt="Student Profile">
            <p id="student-name"></p>
            <p id="student-program"></p>
            <div>
                <button id="confirm-btn">Confirm</button>
                <button id="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <button id="restart-btn" style="display: none;">Scan Again</button>
    <div class="btn-container">
        <button id="flip-camera-btn">Flip Camera</button>
        <a id="back-btn" href="<?php echo ROOT ?>facilitator">Back</a>
    </div>

    <script>

        let html5QrCode = new Html5Qrcode("reader");
        let currentFacingMode = { facingMode: "environment" }; // Default camera mode

        function startScanner() {
            document.getElementById("result").textContent = "Waiting for scan...";
            document.getElementById("restart-btn").style.display = "none";
            document.getElementById("student-info").textContent = "";

            html5QrCode.start(
                currentFacingMode,
                { fps: 10, qrbox: { width: 300, height: 300 } },
                (decodedText) => {
                    document.getElementById("result").innerHTML = `<p>Decoded QR Code: ${decodedText}</p>`;

                    // Fetch student details before confirming attendance
                    fetch("", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: `qrData=${encodeURIComponent(decodedText)}&atten_id=${encodeURIComponent("<?= $AttendanceID; ?>")}&fetchStudent=true`
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Fetched Student Data:", data); // Debugging

                            document.getElementById("loading-screen").style.display = "flex";

                            if (data.status === "success") {
                                document.getElementById("student-name").textContent = `Student: ${data.student}`;
                                document.getElementById("student-program").textContent = `Program: ${data.program}`;

                                // Then handle image asynchronously
                                if (data.studentProfile) {
                                    const img = new Image();
                                    img.onload = function() {
                                        document.getElementById("student-image").src = this.src;
                                        document.getElementById("student-image").style.display = "block";
                                        document.getElementById("student-image").style.maxWidth = "150px";
                                        document.getElementById("student-image").style.maxHeight = "150px";

                                        // Show confirmation modal AFTER image loads
                                        document.getElementById("confirmation-modal").style.display = "flex";
                                    };
                                    img.src = `data:image/jpeg;base64,${data.studentProfile}`;
                                    // Hide image container while loading
                                    document.getElementById("student-image").style.display = "none";
                                } else {
                                    document.getElementById("student-image").style.display = "none";
                                    // Show confirmation modal immediately if no image
                                    document.getElementById("confirmation-modal").style.display = "flex";
                                }

                                // Show confirmation modal
                                document.getElementById("confirmation-modal").style.display = "flex";

                                // Confirm attendance
                                document.getElementById("confirm-btn").onclick = () => {
                                    document.getElementById("confirmation-modal").style.display = "none";

                                    // Proceed with recording attendance
                                    fetch("", {
                                        method: "POST",
                                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                        body: `qrData=${encodeURIComponent(decodedText)}&atten_id=${encodeURIComponent("<?= $AttendanceID; ?>")}&confirm=true`
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            const studentInfoElement = document.getElementById("student-info");

                                            if (data.status === "success") {
                                                studentInfoElement.innerHTML = `Student: ${data.student} <br> ${data.message}`;
                                                studentInfoElement.style.color = "#4CAF50";
                                            } else {
                                                studentInfoElement.innerHTML = data.message;
                                                studentInfoElement.style.color = "red";
                                            }

                                            // Show "Scan Again" button
                                            document.getElementById("restart-btn").style.display = "block";
                                        })
                                        .catch(error => {
                                            console.error("Error:", error);
                                            document.getElementById("student-info").textContent = "An error occurred: " + error.message;
                                            document.getElementById("student-info").style.color = "red";
                                            document.getElementById("restart-btn").style.display = "block";
                                        });
                                };

                                // Cancel attendance
                                document.getElementById("cancel-btn").onclick = () => {
                                    document.getElementById("confirmation-modal").style.display = "none";
                                    document.getElementById("result").innerHTML = `<p style="color:red;">Attendance recording cancelled.</p>`;

                                    // Show "Scan Again" button
                                    document.getElementById("restart-btn").style.display = "block";
                                };
                            } else {
                                document.getElementById("student-info").textContent = data.message;
                                document.getElementById("student-info").style.color = "red";

                                // Show "Scan Again" button
                                document.getElementById("restart-btn").style.display = "block";
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            document.getElementById("student-info").textContent = "An error occurred: " + error.message;
                            document.getElementById("student-info").style.color = "red";

                            // Show "Scan Again" button
                            document.getElementById("restart-btn").style.display = "block";
                        });

                    html5QrCode.stop();
                }
            );
        }

        // Restart button handler
        document.getElementById("restart-btn").addEventListener("click", () => {
            document.getElementById("restart-btn").style.display = "none";
            location.reload();
        });

        // Flip camera button handler
        document.getElementById("flip-camera-btn").addEventListener("click", () => {
            currentFacingMode.facingMode = currentFacingMode.facingMode === "environment" ? "user" : "environment";
            html5QrCode.stop().then(startScanner).catch(console.error);
        });

        // Start the initial scanner
        startScanner();
    </script>
<?php else: ?>
    <p style="color: red;">No ongoing attendance event available.</p>
    <a id="back-btn" href="<?php echo ROOT ?>facilitator">Back</a>
<?php endif; ?>

<!-- Loading Screen -->
<div id="loading-screen" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.8); z-index:1000; align-items:center; justify-content:center;">
    <div class="text-center">
        <div class="loader"></div>
        <p>Loading student data...</p>
    </div>
</div>

<script>

</script>
</body>
<script>
    //// Track if the user is navigating away or submitting a form
    //let isNavigating = false;
    //
    //// Detect clicks on links or buttons that lead to navigation
    //document.addEventListener('click', function(event) {
    //    const target = event.target.closest('a, button[type="submit"], input[type="submit"]');
    //    if (target) {
    //        isNavigating = true;
    //    }
    //});
    //
    //// Detect form submissions
    //document.addEventListener('submit', function() {
    //    isNavigating = true;
    //});
    //
    //// Use beforeunload to detect when the user is leaving the page
    //window.addEventListener('beforeunload', function(event) {
    //    // If the user is NOT navigating or submitting a form, they are closing the tab/browser
    //    if (!isNavigating) {
    //        navigator.sendBeacon('<?php //echo ROOT; ?>//logout', new URLSearchParams({
    //            action: 'logOutOnClose'
    //        }));
    //    }
    //});

</script>
</html>