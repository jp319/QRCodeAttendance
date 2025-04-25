<?php

// Generate QR value containing student details
$student_id = htmlspecialchars($studentData['student_id'] ?? 'N/A');
$f_name = htmlspecialchars($studentData['f_name'] ?? 'N/A');
$l_name = htmlspecialchars($studentData['l_name'] ?? 'N/A');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student QR Code</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: 50px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .student-info {
            font-size: 1rem;
            font-weight: bold;
            color: #555;
            background: #eaf2ff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        #qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        #qrcode img {
            width: 250px;
            height: 250px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #downloadBtn {
            display: none;
            padding: 12px 18px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        #downloadBtn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Student QR Code</h1>
    <?php if ($checker) {?>
        <div class="student-info">
            <?= "Name: $f_name $l_name" ?><br>
            <?= "Student ID: $student_id" ?>
        </div>

        <div id="qrcode"></div>
        <button id="downloadBtn">Download QR Code</button>
    <?php } else { ?>
        <p style="color: #d9534f; font-size: 1.1rem;">⚠ Please upload a profile picture to view your QR Code.</p>
    <?php } ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const qrValue = <?php echo json_encode($qr_value, JSON_HEX_TAG); ?>;
        const qrCodeContainer = document.getElementById('qrcode');
        const downloadBtn = document.getElementById('downloadBtn');

        if (qrValue) {
            QRCode.toDataURL(qrValue, { width: 250 })
                .then(url => {
                    const img = document.createElement('img');
                    img.src = url;
                    img.alt = "QR Code";
                    qrCodeContainer.appendChild(img);

                    // Show Download Button
                    downloadBtn.style.display = "inline-block";
                    downloadBtn.addEventListener("click", function () {
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = "Student_QRCode.png";
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    });
                })
                .catch(error => console.error("QR Code generation error:", error));
        }
    });
</script>

</body>
</html>
