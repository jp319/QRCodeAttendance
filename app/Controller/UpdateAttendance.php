<?php

namespace Controller;
require_once '../app/core/Database.php';
require_once '../app/core/config.php';
require_once '../app/Model/Attendances.php';
require_once '../app/Model/Student.php';
require_once '../app/Model/Sanction.php';
require_once '../app/Model/QRCode.php';
use Database;
use DateTime;
use DateTimeZone;
use Exception;
use Model\Attendances;
use Model\QRCode;
use Model\Sanction;
use Model\Student;
use PDOException;

class UpdateAttendance
{
    use Database;
    public function updateAttendance(): void
    {
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the event ID and action from the request
            $eventId = $_POST['atten_id'] ?? null;
            $action = $_POST['action'] ?? null;
            $eventName = $_POST['eventName'] ?? null;
            $hours = $_POST['sanction'] ?? null;

            // Validate event ID and action
            if (!$eventId || !$action) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request data.']);
                exit;
            }

            // Update the attendance status in the database based on the action
            try {
                $attendance = new Attendances();
                switch ($action) {
                    case 'start':
                        if (!$attendance->checkAttendanceOnGoing()){
                            $date = new DateTime("now", new DateTimeZone('Asia/Manila'));
                            $formattedTime = $date->format('h:i:s A'); // 12-hour format with AM/PM
                            $stmt = $this->connect()->prepare("UPDATE attendance SET atten_status = 'on going', atten_started = :date WHERE atten_id = :eventId");
                            $stmt->bindParam(':eventId', $eventId);
                            $stmt->bindParam(':date', $formattedTime);
                            $stmt->execute();
                            $message = 'Attendance started successfully.';
                        }else{
                            $message = 'Oops! only one attendance at a time...';
                        }
                        break;
                    case 'continue':
                        if (!$attendance->checkAttendanceOnGoing()){
                            $stmt = $this->connect()->prepare("UPDATE attendance SET atten_status = 'on going', atten_OnTimeCheck = 1 WHERE atten_id = :eventId");
                            $stmt->bindParam(':eventId', $eventId);
                            $stmt->execute();
                            $message = 'Attendance continued successfully.';
                        }else{
                            $message = 'Oops! only one attendance at a time...';
                        }
                        break;

                    case 'save changes of':
                        $eventName = $_POST['eventName'] ?? '';
                        $sanction = $_POST['sanction'] ?? 0;

                        $stmt = $this->connect()->prepare("
                        UPDATE attendance 
                        SET event_name = :eventName, 
                            sanction = :sanction 
                        WHERE atten_id = :eventId
                    ");
                        $stmt->execute([
                            ':eventId' => $eventId,
                            ':eventName' => $eventName,
                            ':sanction' => $sanction
                        ]);
                        $message = 'Attendance marked as done successfully.';
                        break;

                    case 'stopped':
                        $stmt = $this->connect()->prepare("UPDATE attendance SET atten_status = 'stopped' WHERE atten_id = :eventId");
                        $stmt->bindParam(':eventId', $eventId);
                        $stmt->execute();
                        $message = 'Attendance stopped successfully.';
                        break;

                    case 'finished':
                        $stmt = $this->connect()->prepare("UPDATE attendance SET atten_status = 'finished', atten_ended = NOW() WHERE atten_id = :eventId");
                        $stmt->bindParam(':eventId', $eventId);
                        $stmt->execute();

                        //add sanction to students
                        $sanction = new Sanction();
                        $student = new Student();
                        $attendances = new Attendances();
                        $qrCode = new QRCode();
                        $attendanceDetails = $attendances->getAttendanceDetails($eventId, $eventName);
                        $requiredAttendees = json_decode($attendanceDetails['required_attendees'], true);
                        $acad_year = json_decode($attendanceDetails['acad_year'], true);
                        $requiredAttendance = json_decode($attendanceDetails['required_attenRecord'], true);

                        $studentList = $student->getAllStudent(); // Fetch students as associative arrays

                        $attendanceRecordList = array_map('strval', array_column($attendances->AttendanceRecord2($eventId), 'student_id'));


                        if (in_array('AllStudents', $requiredAttendees )) {
                            foreach ($studentList as $student) {
                                $student_id = (string) $student['student_id'];
                                if(in_array('time_out', $requiredAttendance)){
                                    if(in_array($student_id, $attendanceRecordList, true)){
                                        //check if naka time out
                                        if(!$qrCode->checkAttendance2($eventId, $student_id)){
                                            $sanction->insertSanction($student_id, 'Unable to attend ' . $eventName . ' event', $hours);
                                        }
                                    }
                                }
                                if (!in_array($student_id, $attendanceRecordList, true)){
                                    $sanction->insertSanction($student_id, 'Unable to attend ' . $eventName . ' event', $hours);
                                }
                            }

                        }else{

                            foreach ($studentList as $student) {
                                $student_id = (string) $student['student_id'];
                                $student_program = (string) $student['program'];
                                $student_year = (string) $student['acad_year'];

                                $studentIsRequired = false;


                                for ($i = 0; $i < count($requiredAttendees); $i++) {
                                    $requiredProgram = (string) $requiredAttendees[$i];
                                    $requiredYear = isset($acad_year[$i]) ? (string) $acad_year[$i] : '';

                                    if ($student_program === $requiredProgram) { // Program Match
                                        if ($requiredYear === $student_year) {
                                            $studentIsRequired = true;
                                            break;
                                        }
                                        if ($requiredYear === "") {
                                            $studentIsRequired = true;
                                            break;
                                        }
                                    }
                                }

                                // If student is required but did NOT attend
                                if ($studentIsRequired && in_array($student_id, $attendanceRecordList, true)) {
                                    if(in_array('time_out',$requiredAttendance)){
                                        if(in_array($student_id, $attendanceRecordList, true)){
                                            //check if naka time out
                                            if(!$qrCode->checkAttendance2($eventId, $student_id)){
                                                $sanction->insertSanction($student_id, 'Unable to time out ' . $eventName . ' event', $hours);
                                            }
                                        }
                                    }
                                }elseif($studentIsRequired && !in_array($student_id, $attendanceRecordList, true)){
                                    $sanction->insertSanction($student_id, 'Unable to attend ' . $eventName . ' event', $hours);
                                }
                            }
                        }

                        $message = 'Attendance finished successfully.';
                        break;

                    default:
                        throw new Exception('Invalid action.');
                }
                echo "<script>
                    alert('$message');
                    window.location.href = '" . str_replace('/update_attendance', '/adminHome?page=Attendance', $_SERVER['REQUEST_URI']) . "';
                </script>";
                exit;


            } catch (PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update attendance: ' . $e->getMessage()]);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        }
    }

}

$updateAttendance = new UpdateAttendance();
$updateAttendance->updateAttendance();