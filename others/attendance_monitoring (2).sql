-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2020 at 04:48 AM
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
-- Database: `attendance_monitoring`
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
  `log_date` date DEFAULT NULL,
  `rfid_id` int(5) DEFAULT NULL,
  `attendance_id` int(5) NOT NULL,
  `time_in` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_out` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `remarks` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`logs_id`, `person_id`, `log_date`, `rfid_id`, `attendance_id`, `time_in`, `time_out`, `remarks`) VALUES
(11, 8, '2019-12-04', 1, 1, '2019-12-03 22:58:22', '2019-12-03 23:59:11', NULL),
(12, 1, '2019-12-04', 0, 1, '2019-12-03 22:53:14', '2019-12-03 23:13:00', NULL),
(19, 8, '2019-12-06', 1, 1, '2019-12-05 23:41:58', '2019-12-05 23:43:54', NULL),
(20, 1, '2019-12-06', 0, 1, '2019-12-05 23:44:10', '2019-12-05 23:44:27', NULL);

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
(1, 'staff1@iics.ust.edu.ph', 'Staff 1', 'Staff', 'cbb9d0bd363a429d6d4bb85cdf509ee9b53e69fd', 1, 0, 0, '2019-12-01 19:34:09', '2020-02-12 21:20:30'),
(8, 'user1@gmail.com', 'User 1', 'User', 'b3daa77b4c04a9551b8781d03191fe098f325e67', 2, 12312312, 1, '2019-12-03 00:01:38', '2020-02-12 21:20:26'),
(10, 'user1@iics.ust.edu.ph', 'asdfasdfasdf', 'wrqewr', '6725c7a24766f2e262239eda538cd0f57f52bb5b', 2, 2147483647, 0, '2019-12-03 00:07:46', '2020-02-15 03:22:55'),
(11, 'user12@gmail.com', 'sdfsdf', NULL, 'f2e0e4f9007b031a856ccdec30e4daf979be47c5', 2, 123123123, 0, '2019-12-03 00:08:47', '2019-12-03 00:08:47'),
(13, 'asdfasdf@ust.com', 'sdfsdsdf', NULL, 'a7c10fafbdd94e7ee670ade46375d28721d7e0c1', 2, 1231231321, 0, '2019-12-03 00:14:29', '2019-12-03 00:14:29');

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
(1, 'Staff'),
(2, 'Faculty');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(10) NOT NULL,
  `person_id` int(10) NOT NULL,
  `request_date` date NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `course_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  `room_id` int(10) NOT NULL,
  `status_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `person_id`, `request_date`, `time_from`, `time_to`, `course_id`, `section_id`, `room_id`, `status_id`) VALUES
(2, 8, '2019-12-09', '07:30:00', '09:30:00', 1, 3, 2, 1),
(3, 8, '2019-12-10', '01:01:00', '13:00:00', 2, 4, 1, 1);

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
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `day` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `room_id`, `person_id`, `course_id`, `section_id`, `start_time`, `end_time`, `day`) VALUES
(1, 2, 8, 1, 5, '07:00:00', '08:00:00', 3),
(3, 3, 1, 3, 4, '09:00:00', '11:00:00', 4),
(4, 1, 10, 1, 1, '01:30:00', '03:30:00', 2);

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
(3, 'Rejected');

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
  ADD KEY `faculty_id` (`person_id`);

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
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `rfid`
--
ALTER TABLE `rfid`
  ADD PRIMARY KEY (`rfid_id`);

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
  ADD KEY `section_id` (`section_id`);

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
  MODIFY `logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `person_position`
--
ALTER TABLE `person_position`
  MODIFY `position_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rfid`
--
ALTER TABLE `rfid`
  MODIFY `rfid_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `status_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
