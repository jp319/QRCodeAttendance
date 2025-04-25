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


    '/QRCodeAttendance/public/login' => '../app/Controller/LoginPage.php',
    '/QRCodeAttendance/public/logout' => '../app/Controller/Logout.php',
    '/QRCodeAttendance/public/logout2' => '../app/Controller/Logout2.php',
    '/QRCodeAttendance/public/adminHome' => '../app/Controller/AdminHome.php',
    '/QRCodeAttendance/public/delete_student' => '../app/Controller/DeleteStudent.php',
    '/QRCodeAttendance/public/edit_attendance' => '../app/Controller/EditAttendance.php',
    '/QRCodeAttendance/public/update_attendance' => '../app/Controller/UpdateAttendance.php',
    '/QRCodeAttendance/public/add_student' => '../app/Controller/AddStudent.php',
    '/QRCodeAttendance/public/edit_student' => '../app/Controller/EditStudent.php',
    '/QRCodeAttendance/public/edit_user' => '../app/Controller/EditUser.php',
    '/QRCodeAttendance/public/add_user' => '../app/Controller/AddUser.php',

    '/QRCodeAttendance/public/remove_sanction' => '../app/Controller/RemoveSanction.php',

    '/QRCodeAttendance/public/facilitator' => '../app/Controller/Facilitator.php',
    '/QRCodeAttendance/public/scanner' => '../app/Controller/QRScanner.php',
    '/QRCodeAttendance/public/upload_file' => '../app/Controller/UploadFile.php',
    '/QRCodeAttendance/public/student' => '../app/Controller/StudentHome.php',
    '/QRCodeAttendance/public/qr_code' => '../app/Controller/StudentQRCode.php',

    '/QRCodeAttendance/public/choose_attendance' => '../app/Controller/ChooseAttendance.php',

    '/QRCodeAttendance/public/add_attendance' => '../app/Controller/AddAttendance.php',
    '/QRCodeAttendance/public/create_attendance_for_student' => '../app/Controller/AttendanceSpecificStudents.php',
    '/QRCodeAttendance/public/delete_attendance' => '../app/Controller/DeleteAttendance.php',
    '/QRCodeAttendance/public/delete_attendance_record' => '../app/Controller/DeleteAttendanceRecord.php',

    '/QRCodeAttendance/public/view_records' => '../app/Controller/ViewAttendanceRecord.php',


];



if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    require '../app/Controller/_404.php';
    die();
}