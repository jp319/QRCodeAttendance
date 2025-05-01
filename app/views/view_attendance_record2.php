<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Event Attendance</title>
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT?>assets/images/LOGO_QRCODE_v2.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            /* Hide non-essential elements */
            .no-print, .no-print * {
                display: none !important;
            }

            /* Adjust table styles for better readability */
            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
            }

            th, td {
                font-size: 12px;
                border: 1px solid black !important;
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #f0f0f0 !important;
                color: black !important;
                font-size: 14px;
                font-weight: bold;
            }

            /* Increase spacing for better readability */
            body {
                background: none;
                padding: 20px;
            }

            .text-center {
                text-align: center;
            }

            .text-4xl {
                font-size: 24px !important;
                font-weight: bold;
            }

            .text-2xl {
                font-size: 18px !important;
                font-weight: bold;
            }

            .text-gray-600 {
                color: black !important;
            }

            /* Add a page break after every few rows to avoid splitting tables */
            tr:nth-child(20n) {
                page-break-after: always;
            }
        }
        /* Prevent URLs from printing */
        a[href]:after {
            content: none !important;
        }

        /* Add a page break after every few rows to avoid splitting tables */
        tr:nth-child(20n) {
            page-break-after: always;
        }
    </style>

</head>
<body class="bg-gray-100 p-6">

</body>
</html>