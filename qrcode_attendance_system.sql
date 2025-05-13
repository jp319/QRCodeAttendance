-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 25, 2025 at 09:10 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qrcode_attendance_system`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AttendanceRecord` (IN `id_in` INT)   BEGIN	
    SELECT a.event_name, s.student_id, s.l_name, s.program, s.acad_year, ar.time_in 
    FROM students s LEFT JOIN attendance_record ar ON s.student_id = ar.student_id 
    INNER JOIN attendance a ON a.atten_id = ar.atten_id WHERE ar.atten_id = id_in;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkAttendanceOnGoing` ()   BEGIN
	Select * FROM attendance WHERE atten_status = 'on going';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkIfUserNameExists` (IN `input_username` VARCHAR(255), IN `input_id` VARCHAR(255))   BEGIN
    SELECT * FROM users WHERE username = input_username OR id = input_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkSession` (IN `id` VARCHAR(255))   BEGIN
	SELECT * FROM user_sessions WHERE user_id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countFilteredStudents` (IN `programFilter` VARCHAR(255), IN `yearFilter` VARCHAR(255))   BEGIN 
 SELECT COUNT(*) FROM students
 WHERE (program = programFilter OR programFilter = '') AND (acad_year = yearFilter OR yearFilter = '');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countStudentAttend` (IN `eventID` INT(11))   BEGIN
	SELECT COUNT(student_id) FROM vwattendancerecord WHERE atten_id = eventID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createActivityLog` (IN `IDuser` VARCHAR(255), IN `activityLog` VARCHAR(255), IN `roleB` VARCHAR(255), IN `evntB` VARCHAR(150))   BEGIN
	INSERT INTO activity_log(user_id, role, activity,time_created, evnt) VALUES(IDuser, roleB, activityLog, NOW(), evntB);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSanction` (IN `id` INT)   BEGIN
	DELETE FROM sanction WHERE sanction_id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `filterStudents` (IN `programFilter` VARCHAR(255), IN `yearFilter` VARCHAR(255))   BEGIN
    SELECT * 
    FROM students
    WHERE (program = programFilter OR programFilter = '')
    AND (acad_year = yearFilter OR yearFilter = '');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getActivityLogOnAtten` (IN `evntB` VARCHAR(255))   BEGIN
	SELECT * FROM vwactivitylog WHERE evnt LIKE evntB ORDER BY time_created DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllProgram` ()   BEGIN
SELECT DISTINCT(program) FROM students;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllStudents` (IN `limitNum` INT, IN `offsetNum` INT)   BEGIN
		SELECT * FROM students LIMIT limitNum OFFSET offsetNum;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllYear` ()   BEGIN
SELECT DISTINCT(acad_year) FROM students ORDER BY acad_year;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAttendanceDetails` (IN `id_input` INT, IN `eventName_input` VARCHAR(255))   BEGIN
    SELECT * FROM attendance WHERE atten_id = id_input OR event_name = eventName_input;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAttendanceRecord` (IN `program_in` VARCHAR(255), IN `year_in` VARCHAR(11), IN `attenID` INT(11))   BEGIN
    SELECT 
        s.student_id, s.f_name, s.l_name, s.program, s.acad_year, s.email, ar.time_in, ar.time_out
    FROM students s 
    INNER JOIN attendance_record ar ON
        s.student_id = ar.student_id
    INNER JOIN attendance a ON ar.atten_id = a.atten_id 
    WHERE
ar.atten_id = attenID AND
s.program = program_in AND
s.acad_year  = year_in;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getStudentAttendanceRecord` (IN `firstName` VARCHAR(255), IN `lastName` VARCHAR(255), IN `studentID` VARCHAR(255), IN `program1` VARCHAR(255), IN `attenID` INT)   BEGIN 
    SELECT 
        ar.*, 
        s.f_name, 
        s.l_name, 
        s.program, 
        s.acad_year,
        s.email
    FROM attendance_record ar
    INNER JOIN students s ON ar.student_id = s.student_id
    WHERE (s.f_name LIKE firstName OR s.l_name LIKE lastName OR s.student_id LIKE studentID)
      AND (JSON_CONTAINS(program1, JSON_QUOTE(s.program)) AND ar.atten_id = attenID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getStudentAttendanceRecord2` (IN `firstName` VARCHAR(255), IN `lastName` VARCHAR(255), IN `studentID` VARCHAR(255), IN `attenID` INT)   BEGIN 
	SELECT 
                ar.*, 
                s.f_name, 
                s.l_name, 
                s.program, 
                s.acad_year,
s.email
            FROM attendance_record ar
            INNER JOIN students s ON ar.student_id = s.student_id
            WHERE (s.f_name LIKE firstName OR s.l_name LIKE lastName OR s.student_id LIKE studentID)
              AND (ar.atten_id = attenID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getStudentData` (IN `id` VARCHAR(255))   BEGIN
	SELECT * FROM students WHERE student_id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getStudentNotAttended` (IN `in_eventID` INT, IN `in_program` VARCHAR(255), IN `in_year` VARCHAR(255))   BEGIN
	SELECT s.student_id, s.f_name, s.l_name, s.program, s.acad_year, s.email
              FROM students s
              WHERE s.student_id NOT IN (
                  SELECT a.student_id FROM attendance_record a WHERE a.atten_id = in_eventID
              ) AND s.program = in_program AND s.acad_year = in_year;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getStudentSanctions` (IN `id` VARCHAR(255))   BEGIN
	SELECT * FROM sanction WHERE student_id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserActivityLog` (IN `IDuser` VARCHAR(255), IN `EvntB` VARCHAR(150))   BEGIN
	SELECT * FROM vwactivitylog WHERE user_id = IDuser AND evnt LIKE EvntB ORDER BY time_created DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserData` (IN `id_in` VARCHAR(255))   BEGIN
	SELECT u.id, u.username, u.pass, u.roles, u.state, us.id as SessionID, us.user_id, us.ip_address, us.user_agent, us.deviceInfo, us.created_at FROM users u 
    LEFT JOIN user_sessions us 
    ON u.id = us.user_id
    WHERE u.id = id_in;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserDetails` ()   BEGIN
    SELECT * FROM users WHERE roles != 'Admin' AND roles = 'Facilitator';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_attendance` (IN `eventName` VARCHAR(255), IN `a_status` VARCHAR(255), IN `requiredAttendees` JSON, IN `acadYear` JSON, IN `sanction` VARCHAR(255), IN `requireAttndanceRecord` JSON)   BEGIN
    INSERT INTO attendance (event_name, date_created, atten_status, atten_OnTimeCheck, required_attendees, acad_year, required_AttenRecord, sanction) 
    VALUES (eventName, NOW(), a_status, 0, requiredAttendees, acadYear, requireAttndanceRecord, sanction);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertAttendanceRecord` (IN `attenID` INT(11), IN `studentID` VARCHAR(255), IN `TimeIn` VARCHAR(50))   BEGIN
	INSERT INTO attendance_record (atten_id, student_id, time_in) VALUES (attenID,studentID,TimeIn);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertAttendanceRecordTimeOut` (IN `attenID` VARCHAR(255), IN `idStudent` VARCHAR(255), IN `timeOut` VARCHAR(50))   BEGIN
	UPDATE attendance_record  SET time_out = timeOut WHERE atten_id=attenID AND student_id=idStudent;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertSanction` (IN `id` VARCHAR(255), IN `reason` VARCHAR(255), IN `hours` INT)   BEGIN
	INSERT INTO sanction(student_id,date_applied,sanction_reason,sanction_hours) VALUES(id, NOW(),reason,hours);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchAttendance` (IN `searchQuery` VARCHAR(255))   BEGIN
    	SELECT * FROM attendance WHERE atten_id LIKE searchQuery OR
        event_name LIKE searchQuery;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchStudents` (IN `searchQuery` VARCHAR(255))   BEGIN
    SELECT * FROM students
    WHERE student_id LIKE searchQuery
    OR f_name LIKE searchQuery
    OR l_name LIKE searchQuery
    OR program LIKE searchQuery
    OR acad_year LIKE searchQuery
    OR email LIKE searchQuery
    OR contact_num LIKE searchQuery;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchUsers` (IN `searchQuery` VARCHAR(255))   BEGIN
    SELECT * FROM users
    WHERE id LIKE searchQuery
    OR username LIKE searchQuery;
   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ValidateUser` (IN `username_input` VARCHAR(100), IN `pass_input` VARCHAR(100))   BEGIN
    SELECT id, username, roles
    FROM users
    WHERE username = BINARY username_input
    AND pass = SHA2(pass_input, 256);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `verify_pass` (IN `pass_in` VARCHAR(255), IN `id_in` VARCHAR(255))   BEGIN
 	SELECT pass FROM users WHERE pass = SHA2(pass_in, 256) AND id = id_in;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `activity` varchar(255) NOT NULL,
  `evnt` varchar(150) DEFAULT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `atten_id` int NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `date_created` date DEFAULT NULL,
  `atten_started` datetime DEFAULT NULL,
  `atten_ended` datetime DEFAULT NULL,
  `atten_status` varchar(50) DEFAULT NULL,
  `atten_OnTimeCheck` tinyint DEFAULT NULL,
  `required_attendees` json DEFAULT NULL,
  `acad_year` json DEFAULT NULL,
  `required_attenRecord` json DEFAULT NULL,
  `sanction` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_record`
--

CREATE TABLE `attendance_record` (
  `atten_id` int NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `time_in` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `time_out` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `countattendance`
-- (See below for the actual view)
--
CREATE TABLE `countattendance` (
`COUNT(*)` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `countfaci`
-- (See below for the actual view)
--
CREATE TABLE `countfaci` (
`COUNT(*)` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `countstudents`
-- (See below for the actual view)
--
CREATE TABLE `countstudents` (
`COUNT(*)` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `countusers`
-- (See below for the actual view)
--
CREATE TABLE `countusers` (
`COUNT(*)` bigint
);

-- --------------------------------------------------------

--
-- Table structure for table `qr_code`
--

CREATE TABLE `qr_code` (
  `qr_value` varchar(255) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sanction`
--

CREATE TABLE `sanction` (
  `sanction_id` int NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `date_applied` datetime DEFAULT NULL,
  `sanction_reason` varchar(255) NOT NULL,
  `sanction_hours` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `acad_year` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_num` varchar(50) DEFAULT NULL,
  `studentProfile` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `roles` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `token` varchar(64) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `deviceInfo` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `user_sessions`
--
DELIMITER $$
CREATE TRIGGER `update_user_status_after_session_delete` AFTER DELETE ON `user_sessions` FOR EACH ROW BEGIN
    UPDATE users SET state = 'offline' WHERE id = OLD.user_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewattendance`
-- (See below for the actual view)
--
CREATE TABLE `viewattendance` (
`acad_year` json
,`atten_ended` datetime
,`atten_id` int
,`atten_started` datetime
,`atten_status` varchar(50)
,`date_created` date
,`event_name` varchar(100)
,`required_attendees` json
,`sanction` int
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewfaci`
-- (See below for the actual view)
--
CREATE TABLE `viewfaci` (
`id` varchar(255)
,`pass` varchar(255)
,`roles` varchar(50)
,`state` varchar(50)
,`username` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vwactivitylog`
-- (See below for the actual view)
--
CREATE TABLE `vwactivitylog` (
`activity` varchar(255)
,`evnt` varchar(150)
,`id` int
,`role` varchar(255)
,`time_created` datetime
,`user_id` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vwattendancerecord`
-- (See below for the actual view)
--
CREATE TABLE `vwattendancerecord` (
`atten_id` int
,`student_id` varchar(255)
,`time_in` varchar(50)
,`time_out` varchar(50)
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`atten_id`);

--
-- Indexes for table `attendance_record`
--
ALTER TABLE `attendance_record`
  ADD KEY `atten_id` (`atten_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `qr_code`
--
ALTER TABLE `qr_code`
  ADD PRIMARY KEY (`qr_value`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `sanction`
--
ALTER TABLE `sanction`
  ADD PRIMARY KEY (`sanction_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `atten_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `sanction`
--
ALTER TABLE `sanction`
  MODIFY `sanction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=447;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=317;

-- --------------------------------------------------------

--
-- Structure for view `countattendance`
--
DROP TABLE IF EXISTS `countattendance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `countattendance`  AS SELECT count(0) AS `COUNT(*)` FROM `attendance` ;

-- --------------------------------------------------------

--
-- Structure for view `countfaci`
--
DROP TABLE IF EXISTS `countfaci`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `countfaci`  AS SELECT count(0) AS `COUNT(*)` FROM `users` WHERE (`users`.`roles` = 'Facilitator') ;

-- --------------------------------------------------------

--
-- Structure for view `countstudents`
--
DROP TABLE IF EXISTS `countstudents`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `countstudents`  AS SELECT count(0) AS `COUNT(*)` FROM `students` ;

-- --------------------------------------------------------

--
-- Structure for view `countusers`
--
DROP TABLE IF EXISTS `countusers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `countusers`  AS SELECT count(0) AS `COUNT(*)` FROM `users` WHERE (`users`.`roles` = 'Facilitator') ;

-- --------------------------------------------------------

--
-- Structure for view `viewattendance`
--
DROP TABLE IF EXISTS `viewattendance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewattendance`  AS SELECT `attendance`.`atten_id` AS `atten_id`, `attendance`.`event_name` AS `event_name`, `attendance`.`date_created` AS `date_created`, `attendance`.`atten_started` AS `atten_started`, `attendance`.`atten_ended` AS `atten_ended`, `attendance`.`atten_status` AS `atten_status`, `attendance`.`required_attendees` AS `required_attendees`, `attendance`.`acad_year` AS `acad_year`, `attendance`.`sanction` AS `sanction` FROM `attendance` ORDER BY `attendance`.`date_created` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `viewfaci`
--
DROP TABLE IF EXISTS `viewfaci`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewfaci`  AS SELECT `users`.`id` AS `id`, `users`.`username` AS `username`, `users`.`pass` AS `pass`, `users`.`roles` AS `roles`, `users`.`state` AS `state` FROM `users` WHERE (`users`.`roles` = 'Facilitator') ;

-- --------------------------------------------------------

--
-- Structure for view `vwactivitylog`
--
DROP TABLE IF EXISTS `vwactivitylog`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwactivitylog`  AS SELECT `activity_log`.`id` AS `id`, `activity_log`.`user_id` AS `user_id`, `activity_log`.`role` AS `role`, `activity_log`.`activity` AS `activity`, `activity_log`.`evnt` AS `evnt`, `activity_log`.`time_created` AS `time_created` FROM `activity_log` ;

-- --------------------------------------------------------

--
-- Structure for view `vwattendancerecord`
--
DROP TABLE IF EXISTS `vwattendancerecord`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwattendancerecord`  AS SELECT `attendance_record`.`atten_id` AS `atten_id`, `attendance_record`.`student_id` AS `student_id`, `attendance_record`.`time_in` AS `time_in`, `attendance_record`.`time_out` AS `time_out` FROM `attendance_record` ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_record`
--
ALTER TABLE `attendance_record`
  ADD CONSTRAINT `attendance_record_ibfk_1` FOREIGN KEY (`atten_id`) REFERENCES `attendance` (`atten_id`),
  ADD CONSTRAINT `attendance_record_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `qr_code`
--
ALTER TABLE `qr_code`
  ADD CONSTRAINT `qr_code_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `sanction`
--
ALTER TABLE `sanction`
  ADD CONSTRAINT `sanction_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `auto_expire_sessions` ON SCHEDULE EVERY 5 MINUTE STARTS '2025-02-25 22:17:30' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM user_sessions WHERE expires_at < NOW()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
