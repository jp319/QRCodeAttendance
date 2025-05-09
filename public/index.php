<?php
require '../app/core/init.php';


$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$routes = [
    '/login' => '../app/Controller/LoginPage.php',
    '/logout' => '../app/Controller/Logout.php',
    '/logout2' => '../app/Controller/Logout2.php',
    '/adminHome' => '../app/Controller/AdminHome.php',
    '/facilitator' => '../app/Controller/Facilitator.php',
    '/delete_student' => '../app/Controller/DeleteStudent.php',
    '/edit_attendance'=>'../app/Controller/EditAttendance.php',
    '/update_attendance'=>'../app/Controller/UpdateAttendance.php',
    '/add_student'=>'../app/Controller/AddStudent.php',
    '/edit_student'=>'../app/Controller/EditStudent.php',
    '/edit_user' => '../app/Controller/EditUser.php',
    '/add_user' => '../app/Controller/AddUser.php',

    '/remove_sanction' => '../app/Controller/RemoveSanction.php',

    '/scanner' => '../app/Controller/QRScanner.php',
    '/upload_file' => '../app/Controller/UploadFile.php',
    '/student' => '../app/Controller/StudentHome.php',
    '/qr_code' => '../app/Controller/StudentQRCode.php',

    '/choose_attendance' => '../app/Controller/ChooseAttendance.php',
    '/add_attendance' => '../app/Controller/AddAttendance.php',
    '/create_attendance_for_student' => '../app/Controller/AttendanceSpecificStudents.php',
    '/delete_attendance' => '../app/Controller/DeleteAttendance.php',
    '/delete_attendance_record' => '../app/Controller/DeleteAttendanceRecord.php',

    '/view_records' => '../app/Controller/ViewAttendanceRecord.php',

    '/' => '../app/Controller/LandingPage.php',

    '/public/login' => '../app/Controller/LoginPage.php',
    '/public/logout' => '../app/Controller/Logout.php',
    '/public/logout2' => '../app/Controller/Logout2.php',
    '/public/adminHome' => '../app/Controller/AdminHome.php',
    '/public/delete_student' => '../app/Controller/DeleteStudent.php',
    '/public/edit_attendance' => '../app/Controller/EditAttendance.php',
    '/public/update_attendance' => '../app/Controller/UpdateAttendance.php',
    '/public/add_student' => '../app/Controller/AddStudent.php',
    '/public/edit_student' => '../app/Controller/EditStudent.php',
    '/public/edit_user' => '../app/Controller/EditUser.php',
    '/public/add_user' => '../app/Controller/AddUser.php',

    '/public/sanctions_summary' => '../app/Controller/SanctionSummary.php',
    '/public/remove_sanction' => '../app/Controller/RemoveSanction.php',

    '/public/facilitator' => '../app/Controller/Facilitator.php',
    '/public/scanner' => '../app/Controller/QRScanner.php',
    '/public/upload_file' => '../app/Controller/UploadFile.php',
    '/public/student' => '../app/Controller/StudentHome.php',
    '/public/qr_code' => '../app/Controller/StudentQRCode.php',

    '/public/choose_attendance' => '../app/Controller/ChooseAttendance.php',

    '/public/add_attendance' => '../app/Controller/AddAttendance.php',
    '/public/create_attendance_for_student' => '../app/Controller/AttendanceSpecificStudents.php',
    '/public/delete_attendance' => '../app/Controller/DeleteAttendance.php',
    '/public/delete_attendance_record' => '../app/Controller/DeleteAttendanceRecord.php',

    '/public/view_records' => '../app/Controller/ViewAttendanceRecord.php',
    '/public/view_record2' => '../app/Controller/ViewAttendanceRecord2.php',


];



if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    require '../app/Controller/_404.php';
    die();
}