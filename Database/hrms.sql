-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2022 at 05:58 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminId` int(11) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminId`, `fName`, `lName`, `email`, `password`, `photo`, `created`) VALUES
(1, 'John', 'Doe', 'sample1234@gmail.com', '$2y$10$dpcucDppzgU3ZrNmYkHpyu3JHYuO/q7TL.0.V6AQegjlNpsLUAOEq', 'ERD.jpeg', '2022-03-13 17:16:57'),
(2, 'Franz', 'Bantilan', 'sample@gmail.com', '$2y$10$HHF5vcAwwrHDdPWPy1RzgOqCuCtkao/Lw2sBSbc/6oo7adZANVh9C', '627a7eabc9b5d2.32679764bio-thumb-female-default.png', '2022-03-25 22:42:21'),
(3, 'New', 'Name', 'adadafgf@gmail.com', '$2y$10$RI7V6fQdSffSbKQINz.jeud2afp3oI10DDEe6/MTb671DtMoAOzMW', 'dfdcaps.jpeg', '2022-03-25 22:45:20'),
(4, 'adasdf', 'asfasfa', 'asdfaf@asdfa', '$2y$10$6Z9MX0aHFNt0.FP..ZkewugV4mX15QN1GLnod16q3krcbEqv2J9G2', 'ERD.jpeg', '2022-03-25 22:47:37'),
(5, 'lzxkcvlzkv', 'aflsvlkxzcv', 'qadafd@asdAf', '$2y$10$.I50iW2XreIbx8WijVTCJurQD4rvowZwVqvlQrHeEE3S8GET/lr82', 'ERD.jpeg', '2022-03-25 22:48:52'),
(6, 'azlzxc', 'xcvsdv', 'avadsf@asdfasfd', '$2y$10$CzQm7K54Zcuq9R9xRBY2A.hlQM31i1Qy3glsg0mmeqGC4D6U9sBy.', 'dfdcaps.jpeg', '2022-03-25 22:49:33'),
(7, 'lknsdlvkns', 'alnalsdf', 'asdasd@asfzxv', '$2y$10$DglJ.0oWgz3TORRhOwxLBu6z46JxCXdaR7NaIA7vYzJycKwEL5vHG', 'dfdcaps.jpeg', '2022-03-25 22:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendId` int(11) NOT NULL,
  `bioId` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `time_inAM` varchar(10) NOT NULL,
  `time_outAM` varchar(10) NOT NULL,
  `time_inPM` varchar(10) NOT NULL,
  `time_outPM` varchar(10) NOT NULL,
  `attend_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendId`, `bioId`, `date`, `time_inAM`, `time_outAM`, `time_inPM`, `time_outPM`, `attend_status`) VALUES
(1, '1', '2022-05-02', '07:00:00', '12:00:00', '14:00:00', '17:20:00', 'Late'),
(2, '1', '2022-05-03', '06:38:00', '10:00:00', '13:20:00', '17:20:00', 'Late'),
(3, '1', '2022-05-04', '07:00:00', '11:00:00', '13:00:00', '16:20:00', 'On Time'),
(4, '1', '2022-05-05', '07:10:00', '10:00:00', '13:00:00', '17:20:00', 'Late'),
(5, '1', '2022-05-06', '06:50:00', '10:00:00', '13:00:00', '17:20:00', 'On Time'),
(6, '1', '2022-05-07', '07:00:00', '10:00:00', '', '', 'On Time'),
(7, '1', '2022-05-08', '', '', '', '', 'No Work'),
(8, '1', '2022-05-09', '07:00:00', '10:00:00', '13:00:00', '17:20:00', 'On Time'),
(9, '2', '2022-05-02', '07:30:00', '11:00:00', '13:00:00', '17:20:00', 'Late'),
(10, '2', '2022-05-03', '07:30:00', '11:00:00', '13:00:00', '17:20:00', 'Late'),
(11, '2', '2022-05-04', '07:30:00', '11:00:00', '13:00:00', '17:20:00', 'Late'),
(12, '2', '2022-05-05', '07:00:00', '11:00:00', '13:00:00', '18:20:00', 'On Time'),
(13, '2', '2022-05-06', '06:38:00', '10:00:00', '13:20:00', '17:20:00', 'Late'),
(14, '2', '2022-05-07', '07:00:00', '10:00:00', '', '', 'On Time'),
(15, '2', '2022-05-08', '', '', '', '', 'No Work'),
(16, '2', '2022-05-09', '07:00:00', '10:00:00', '13:00:00', '17:20:00', 'On Time'),
(17, '3', '2022-05-02', '07:30:00', '10:00:00', '13:00:00', '19:20:00', 'Late'),
(18, '3', '2022-05-03', '07:30:00', '10:00:00', '13:00:00', '19:20:00', 'Late'),
(19, '3', '2022-05-04', '07:30:00', '10:00:00', '13:00:00', '19:20:00', 'Late'),
(20, '3', '2022-05-05', '07:00:00', '11:00:00', '13:00:00', '18:20:00', 'On Time'),
(21, '3', '2022-05-06', '06:38:00', '10:00:00', '13:20:00', '17:20:00', 'Late'),
(22, '3', '2022-05-07', '07:00:00', '10:00:00', '', '', 'On Time'),
(23, '3', '2022-05-08', '', '', '', '', 'No Work'),
(24, '3', '2022-05-09', '07:00:00', '10:00:00', '13:00:00', '17:20:00', 'On Time');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `deptId` int(11) NOT NULL,
  `deptName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`deptId`, `deptName`) VALUES
(1, 'Teaching Personnel'),
(2, 'Non-Teaching Personnel');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `bioId` int(10) NOT NULL,
  `empId` varchar(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `midName` varchar(255) NOT NULL,
  `gsis` varchar(20) NOT NULL,
  `pagibig` varchar(20) NOT NULL,
  `tin` varchar(20) NOT NULL,
  `philhealth` varchar(20) NOT NULL,
  `sss` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `emailadd` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pNumber` varchar(20) NOT NULL,
  `contactperson` varchar(20) NOT NULL,
  `contactpersonno` varchar(20) NOT NULL,
  `deptid` int(11) NOT NULL,
  `positionid` int(11) NOT NULL,
  `scheduleid` int(11) NOT NULL,
  `employment_type` varchar(100) NOT NULL,
  `employedDate` date NOT NULL,
  `status` varchar(8) NOT NULL,
  `pPhoto` varchar(255) NOT NULL,
  `update_action` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `bioId`, `empId`, `fName`, `lName`, `midName`, `gsis`, `pagibig`, `tin`, `philhealth`, `sss`, `address`, `birthdate`, `gender`, `emailadd`, `password`, `pNumber`, `contactperson`, `contactpersonno`, `deptid`, `positionid`, `scheduleid`, `employment_type`, `employedDate`, `status`, `pPhoto`, `update_action`) VALUES
(1, 1, '20186039', 'Rona Ann', 'Olivar', 'Pacamalan', '', '', '', '1234', '', 'Liloan', '1998-05-31', 'Female', 'ronaannolivar31@gmail.com', '$2y$10$fCFhrC1zD3hG.9YKbvs3XOecQlRL9kYAP2EQ2CEXVqm8w5wmUYCmC', '09123456789', '', '09876654332', 1, 1, 1, 'Probationary', '2022-05-02', 'Retired', '', '2022-05-12'),
(2, 2, '20186042', 'Sydney Ray', 'Angtud', 'Yrog-Irog', '', '', '', '', '', 'Cabadiangan, Liloan', '1997-03-19', 'Male', 'sydney@gmail.com', '$2y$10$uoOSlDGILAib6DpIUfB8NOdUb7i7pz2KYh0O0QHPlK5cq0zfiI/K2', '09316531351', '', '', 1, 1, 1, 'Probationary', '2022-02-08', 'Active', '', NULL),
(3, 3, '20186034', 'Francis Ryan', 'Pepito', 'Galdiano', '', '', '', '', '', 'Tayud, Liloan', '1999-08-30', 'Male', 'francis@gmail.com', '$2y$10$pg8PjaQF.vIKz.YZ7emdrOaS2oP57/sQGrWqN5ZzGFKiKU6NaGOiS', '09487486464', '', '', 2, 2, 3, 'Regular', '2021-11-17', 'Active', '', NULL),
(5, 1, '123', 'Franz', 'Bantilan', 'Bantiles', '', '', '', '', '', 'Liloan', '1996-07-05', 'Female', 'bantilanfranz@gmail.com', '$2y$10$7Nj0VvtH38tSSmqfQf8vduR3jHEt8xAF4w2R01T1w3CZ4urK2DHyS', '09195387162', '', '', 2, 2, 5, 'Regular', '2022-03-11', 'Active', '', '2022-05-13');

-- --------------------------------------------------------

--
-- Table structure for table `emp_annual_leave`
--

CREATE TABLE `emp_annual_leave` (
  `id` int(11) NOT NULL,
  `empId` int(11) NOT NULL,
  `year_number` int(4) NOT NULL,
  `leaveId` int(11) NOT NULL,
  `allowed_hours` int(11) NOT NULL,
  `remaining_hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_annual_leave`
--

INSERT INTO `emp_annual_leave` (`id`, `empId`, `year_number`, `leaveId`, `allowed_hours`, `remaining_hours`) VALUES
(1, 20186034, 2022, 2, 80, 80),
(2, 123, 2022, 2, 80, 80);

-- --------------------------------------------------------

--
-- Table structure for table `leave_taken`
--

CREATE TABLE `leave_taken` (
  `period_id` int(11) NOT NULL,
  `empId` int(11) NOT NULL,
  `leaveId` int(11) NOT NULL,
  `day_type` varchar(10) NOT NULL,
  `startDate` varchar(50) NOT NULL,
  `endDate` varchar(50) NOT NULL,
  `leave_reason` varchar(255) NOT NULL,
  `total_leavehrs` varchar(20) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `leave_status` varchar(20) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `date_actioned` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_taken`
--

INSERT INTO `leave_taken` (`period_id`, `empId`, `leaveId`, `day_type`, `startDate`, `endDate`, `leave_reason`, `total_leavehrs`, `dateCreated`, `leave_status`, `remarks`, `date_actioned`) VALUES
(1, 123, 2, 'Full Day', '2022-05-05', '2022-05-05', '', '0', '2022-05-13 03:30:28', 'Pending', '', ''),
(2, 123, 2, 'Full Day', '2022-05-13', '2022-05-13', '', '0', '2022-05-13 03:32:15', 'Pending', '', ''),
(3, 123, 2, 'Full Day', '2022-05-12', '2022-05-12', '', '0', '2022-05-13 03:35:33', 'Pending', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `LeaveId` int(11) NOT NULL,
  `leaveCode` varchar(50) NOT NULL,
  `leave_name` varchar(50) NOT NULL,
  `default_hours` int(11) NOT NULL,
  `deptId` int(11) NOT NULL,
  `employment_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`LeaveId`, `leaveCode`, `leave_name`, `default_hours`, `deptId`, `employment_type`) VALUES
(1, 'VL', 'VACATION LEAVE', 80, 1, 'Regular'),
(2, 'VL', 'VACATION LEAVE', 80, 2, 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `positionId` int(5) NOT NULL,
  `positionName` varchar(255) NOT NULL,
  `deptId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`positionId`, `positionName`, `deptId`) VALUES
(1, 'JHS Instructor', 1),
(2, 'Office Staff', 2),
(3, 'Junior High School Teacher', 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `scheduleId` int(11) NOT NULL,
  `time_inAm` time NOT NULL,
  `time_outAm` varchar(8) NOT NULL,
  `time_inPm` varchar(8) NOT NULL,
  `time_outPm` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`scheduleId`, `time_inAm`, `time_outAm`, `time_inPm`, `time_outPm`) VALUES
(1, '07:00:00', '12:00:00', '13:00:00', '16:30:00'),
(2, '07:00:00', '12:00:00', '13:00:00', '16:29:00'),
(3, '07:00:00', '12:00:00', '13:00:00', '16:30:00'),
(4, '07:00:00', '12:00:00', '13:00:00', '16:30:00'),
(5, '07:00:00', '12:00:00', '13:00:00', '16:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `year_autonum` varchar(20) DEFAULT NULL,
  `default_value` varchar(20) DEFAULT NULL,
  `hours_remaining` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendId`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`deptId`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_annual_leave`
--
ALTER TABLE `emp_annual_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_taken`
--
ALTER TABLE `leave_taken`
  ADD PRIMARY KEY (`period_id`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`LeaveId`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`positionId`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`scheduleId`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `deptId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `emp_annual_leave`
--
ALTER TABLE `emp_annual_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leave_taken`
--
ALTER TABLE `leave_taken`
  MODIFY `period_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leave_type`
--
ALTER TABLE `leave_type`
  MODIFY `LeaveId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `positionId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `scheduleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
