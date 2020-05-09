-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2020 at 07:03 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id13604405_attendance_moitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(5) NOT NULL,
  `attendance_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `attendance_name`) VALUES
(0, ''),
(1, 'Present'),
(2, 'Absent');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(10) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_code`, `course_name`) VALUES
(1, 'ICS112', 'Introduction to Object-Oriented Programming'),
(2, 'ICS113', 'Web Programming with J2EE'),
(3, 'IT201', 'Data Communications and Networking 1');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `logs_id` int(11) NOT NULL,
  `person_id` int(10) NOT NULL,
  `schedule_id` int(10) NOT NULL,
  `log_date` date DEFAULT NULL,
  `rfid_id` int(5) DEFAULT NULL,
  `attendance_id` int(5) NOT NULL,
  `time_in` timestamp NULL DEFAULT NULL,
  `time_out` timestamp NULL DEFAULT NULL,
  `remarks` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`logs_id`, `person_id`, `schedule_id`, `log_date`, `rfid_id`, `attendance_id`, `time_in`, `time_out`, `remarks`) VALUES
(55, 11, 7, '2020-04-19', 1, 1, '2020-04-18 23:11:25', '2020-04-18 23:11:34', NULL),
(56, 8, 8, '2020-04-19', 1, 2, '2020-04-18 22:56:42', '2020-04-18 23:11:15', 'ZXcZxc'),
(66, 10, 1, '2020-04-24', NULL, 2, NULL, NULL, 'Surpassed 15 minute grace period.'),
(67, 8, 14, '2020-04-23', 1, 1, '2020-04-23 03:34:01', '2020-04-23 03:34:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `make_up_requests`
--

CREATE TABLE `make_up_requests` (
  `request_id` int(10) NOT NULL,
  `schedule_id` int(10) NOT NULL,
  `status_id` int(3) NOT NULL,
  `request_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `make_up_requests`
--

INSERT INTO `make_up_requests` (`request_id`, `schedule_id`, `status_id`, `request_date`) VALUES
(4, 18, 4, '2020-04-26'),
(5, 17, 4, '2020-04-21'),
(6, 19, 4, '2020-04-27');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `position_Id` int(10) NOT NULL,
  `person_number` int(11) DEFAULT NULL,
  `rfid_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `email`, `first_name`, `last_name`, `password`, `position_Id`, `person_number`, `rfid_id`, `created_at`, `updated_at`) VALUES
(1, 'staff1@iics.ust.edu.ph', 'Staff 1', 'Staff', 'cbb9d0bd363a429d6d4bb85cdf509ee9b53e69fd', 2, 342342, 0, '2019-12-01 19:34:09', '2020-04-25 03:48:15'),
(8, 'user1@gmail.com', 'User 1', 'User', 'b3daa77b4c04a9551b8781d03191fe098f325e67', 3, 12312312, 1, '2019-12-03 00:01:38', '2020-04-25 03:48:19'),
(10, 'user1@iics.ust.edu.ph', 'asdfasdfasdf', 'wrqewr', '6725c7a24766f2e262239eda538cd0f57f52bb5b', 3, 2147483647, 0, '2019-12-03 00:07:46', '2020-04-25 03:48:31'),
(11, 'user12@gmail.com', 'sdfsdf', NULL, 'f2e0e4f9007b031a856ccdec30e4daf979be47c5', 3, 123123123, 0, '2019-12-03 00:08:47', '2020-04-25 03:48:34'),
(15, 'admin.iics@ust.edu.ph', 'admin 1', 'admin', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a', 1, 1, NULL, '2020-04-25 03:49:43', '2020-04-25 03:49:43'),
(16, 'user3@gmail.com', 'User3', 'User3', '9d659d4e096559ac2dfd4f771ab06ec0f2c0f0f8', 2, 23423422, 0, '2020-04-26 09:41:52', '2020-04-26 09:41:52');

-- --------------------------------------------------------

--
-- Table structure for table `person_position`
--

CREATE TABLE `person_position` (
  `position_id` int(10) NOT NULL,
  `position` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person_position`
--

INSERT INTO `person_position` (`position_id`, `position`) VALUES
(1, 'Admin'),
(2, 'Staff'),
(3, 'Faculty');

-- --------------------------------------------------------

--
-- Table structure for table `rfid`
--

CREATE TABLE `rfid` (
  `rfid_id` int(10) NOT NULL,
  `rfid_data` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rfid`
--

INSERT INTO `rfid` (`rfid_id`, `rfid_data`) VALUES
(0, 'C679B4F8'),
(1, '79C8A099');

-- --------------------------------------------------------

--
-- Table structure for table `rfid_counter`
--

CREATE TABLE `rfid_counter` (
  `counter_id` int(11) NOT NULL,
  `rfid_name_1` varchar(100) NOT NULL,
  `rfid_name_2` varchar(100) NOT NULL,
  `datetime_1` datetime NOT NULL,
  `datetime_2` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rfid_counter`
--

INSERT INTO `rfid_counter` (`counter_id`, `rfid_name_1`, `rfid_name_2`, `datetime_1`, `datetime_2`) VALUES
(1, '79C8A099', '79C8A099', '2020-04-11 22:30:31', '2020-04-11 22:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(5) NOT NULL,
  `room_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`) VALUES
(1, 'Netlab'),
(2, '314'),
(3, '47'),
(4, '49'),
(5, '52');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(10) NOT NULL,
  `room_id` int(5) NOT NULL,
  `person_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `day` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `room_id`, `person_id`, `course_id`, `section_id`, `type_id`, `start_time`, `end_time`, `day`) VALUES
(1, 2, 10, 1, 5, 0, '07:00:00', '08:00:00', 3),
(3, 3, 10, 3, 4, 0, '09:00:00', '11:00:00', 2),
(4, 1, 10, 1, 1, 0, '11:30:00', '13:30:00', 2),
(5, 5, 10, 1, 5, 0, '13:00:00', '14:00:00', 6),
(7, 5, 11, 2, 4, 2, '16:00:00', '17:00:00', 1),
(8, 5, 8, 1, 5, 2, '14:00:00', '15:00:00', 1),
(14, 3, 8, 2, 3, 2, '11:00:00', '13:00:00', 2),
(15, 3, 10, 1, 1, 2, '16:00:00', '17:00:00', 2),
(16, 3, 10, 1, 1, 2, '07:00:00', '08:00:00', 2),
(17, 1, 10, 1, 1, 2, '08:00:00', '09:00:00', 2),
(18, 5, 10, 3, 4, 2, '09:00:00', '10:00:00', 1),
(19, 5, 8, 3, 3, 2, '10:00:00', '12:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_type`
--

CREATE TABLE `schedule_type` (
  `type_id` int(10) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule_type`
--

INSERT INTO `schedule_type` (`type_id`, `type_name`) VALUES
(1, 'Regular'),
(2, 'Make Up Class');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` int(10) NOT NULL,
  `section_name` varchar(20) NOT NULL,
  `year_level` int(11) DEFAULT NULL,
  `section_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `section_name`, `year_level`, `section_type_id`) VALUES
(1, '1CSA', 1, 1),
(2, '1ITA', 1, 1),
(3, '2ISB', 2, 1),
(4, '3ITA', 3, 1),
(5, '4ITB', 4, 1),
(6, 'PMATH203', 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `section_type`
--

CREATE TABLE `section_type` (
  `section_type_id` int(10) NOT NULL,
  `section_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section_type`
--

INSERT INTO `section_type` (`section_type_id`, `section_type`) VALUES
(1, 'Regular'),
(2, 'Irregular');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(10) NOT NULL,
  `status_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(1, 'Pending'),
(2, 'Approved'),
(3, 'Rejected'),
(4, 'Complete');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`logs_id`),
  ADD KEY `faculty_id` (`person_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `make_up_requests`
--
ALTER TABLE `make_up_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`),
  ADD UNIQUE KEY `username` (`email`),
  ADD KEY `position_id` (`position_Id`) USING BTREE;

--
-- Indexes for table `person_position`
--
ALTER TABLE `person_position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `rfid`
--
ALTER TABLE `rfid`
  ADD PRIMARY KEY (`rfid_id`);

--
-- Indexes for table `rfid_counter`
--
ALTER TABLE `rfid_counter`
  ADD PRIMARY KEY (`counter_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `faculty_id` (`person_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `schedule_type`
--
ALTER TABLE `schedule_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `section_type_id` (`section_type_id`);

--
-- Indexes for table `section_type`
--
ALTER TABLE `section_type`
  ADD PRIMARY KEY (`section_type_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `make_up_requests`
--
ALTER TABLE `make_up_requests`
  MODIFY `request_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `person_position`
--
ALTER TABLE `person_position`
  MODIFY `position_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rfid`
--
ALTER TABLE `rfid`
  MODIFY `rfid_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rfid_counter`
--
ALTER TABLE `rfid_counter`
  MODIFY `counter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `schedule_type`
--
ALTER TABLE `schedule_type`
  MODIFY `type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `section_type`
--
ALTER TABLE `section_type`
  MODIFY `section_type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `insert_logs_from_requests_event` ON SCHEDULE EVERY 1 DAY STARTS '2020-04-23 01:30:00' ON COMPLETION PRESERVE ENABLE DO Insert Into `logs` (person_id, schedule_id, log_date)
Select person_id, s.schedule_id, CURRENT_DATE from `schedule` s INNER JOIN `make_up_requests` mur on s.schedule_id = mur.schedule_id where mur.request_date = CURRENT_DATE AND mur.status_id = 2$$

CREATE DEFINER=`root`@`localhost` EVENT `insert_logs_event` ON SCHEDULE EVERY 1 DAY STARTS '2020-04-20 00:15:00' ON COMPLETION PRESERVE ENABLE DO INSERT INTO `logs` (person_id, schedule_id, log_date) Select person_id, schedule_id, CURRENT_DATE FROM `schedule` s where s.day = DAYOFWEEK(CURRENT_DATE)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
