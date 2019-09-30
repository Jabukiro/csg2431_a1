-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2019 at 05:51 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alien`
--
CREATE DATABASE IF NOT EXISTS `alien` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `alien`;

-- --------------------------------------------------------

--
-- Table structure for table `organisers`
--

CREATE TABLE `organisers` (
  `username` char(10) NOT NULL,
  `first_name` char(50) NOT NULL,
  `surname` char(50) NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organisers`
--

INSERT INTO `organisers` (`username`, `first_name`, `surname`, `password`) VALUES
('msorn', 'Mi Aie', 'Sorn', '1234567'),
('dbarihut', 'Herve-Daniel', 'Barihuta', '1234567');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(10) UNSIGNED NOT NULL,
  `task_name` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`) VALUES
(1, 'Admissions'),
(10, 'Cleaning'),
(2, 'Crowd Control'),
(14, 'Human Shield'),
(12, 'Pack Up'),
(11, 'Run Competition'),
(8, 'Set Up'),
(7, 'Worker');

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `time_slot_id` int(10) UNSIGNED NOT NULL,
  `time_slot_name` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`time_slot_id`, `time_slot_name`) VALUES
(1, 'Day 1, Morning'),
(2, 'Day 1, Afternoon'),
(3, 'Day 1, Night'),
(4, 'Day 2, Morning'),
(5, 'Day 2, Afternoon'),
(6, 'Day 2, Night');

-- --------------------------------------------------------

--
-- Table structure for table `volounteers`
--

CREATE TABLE `volounteers` (
  `email` char(50) NOT NULL,
  `first_name` char(100) NOT NULL,
  `surname` char(50) NOT NULL,
  `mobile` char(10) NOT NULL,
  `address` char(100) NOT NULL,
  `suburb` char(50) NOT NULL,
  `postcode` char(5) NOT NULL,
  `address_2` char(100) DEFAULT NULL,
  `dob` date NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `volounteers`
--

INSERT INTO `volounteers` (`email`, `first_name`, `surname`, `mobile`, `address`, `suburb`, `postcode`, `address_2`, `dob`, `password`) VALUES
('abcd@bacd.com', 'Ay-Ay', 'Ron', '0412345678', 'Yagomala, 99', 'Perth', '1234', NULL, '1987-19-39', '12345'),
('d.barihuta@gmail.com', 'Herve-Daniel', 'Barihuta', '0431006280', 'Wadhurst ST, 26C', 'Perth', '6061', 'Wadhurst ST', '1997-12-11', '12345'),
('jon@gamil.com', 'Jon', 'Doe', '0404040404', '33, Street', 'Street', '12345', '', '2000-01-01', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `volounteer_times`
--

CREATE TABLE `volounteer_times` (
  `vol_time_id` int(10) UNSIGNED NOT NULL,
  `vol_email` char(50) NOT NULL,
  `time_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED DEFAULT NULL,
  `description` varchar(240) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `volounteer_times`
--

INSERT INTO `volounteer_times` (`vol_time_id`, `vol_email`, `time_id`, `task_id`, `description`) VALUES
(7, 'abcd@bacd.com', 6, 11, 'See who reaches the fence first'),
(8, 'abcd@bacd.com', 2, NULL, NULL),
(9, 'd.barihuta@gmail.com', 4, NULL, NULL),
(10, 'd.barihuta@gmail.com', 5, NULL, NULL),
(11, 'd.barihuta@gmail.com', 1, 2, 'Hype up the other raiders'),
(8, 'abcd@bacd.com', 2, 14, 'Be part of the 1st wave of raiders');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vol_time_full_details`
-- (See below for the actual view)
--
CREATE TABLE `vol_time_full_details` (
`vol_time_id` int(10) unsigned
,`vol_email` char(50)
,`full_name` varchar(152)
,`time_id` int(10) unsigned
,`time_slot_name` char(20)
,`task_id` int(10) unsigned
,`task_name` char(20)
,`description` varchar(240)
);

-- --------------------------------------------------------

--
-- Structure for view `vol_time_full_details`
--
DROP TABLE IF EXISTS `vol_time_full_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vol_time_full_details`  AS  select `volounteer_times`.`vol_time_id` AS `vol_time_id`,`volounteer_times`.`vol_email` AS `vol_email`,concat(`volounteers`.`first_name`,', ',ucase(`volounteers`.`surname`)) AS `full_name`,`volounteer_times`.`time_id` AS `time_id`,`time_slots`.`time_slot_name` AS `time_slot_name`,`volounteer_times`.`task_id` AS `task_id`,`tasks`.`task_name` AS `task_name`,`volounteer_times`.`description` AS `description` from (((`volounteer_times` join `volounteers` on((`volounteer_times`.`vol_email` = `volounteers`.`email`))) join `time_slots` on((`volounteer_times`.`time_id` = `time_slots`.`time_slot_id`))) left join `tasks` on((`volounteer_times`.`task_id` = `tasks`.`task_id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD UNIQUE KEY `tsk_name_uq` (`task_name`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`time_slot_id`);

--
-- Indexes for table `volounteers`
--
ALTER TABLE `volounteers`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `volounteer_times`
--
ALTER TABLE `volounteer_times`
  ADD PRIMARY KEY (`vol_time_id`),
  ADD KEY `vol_email` (`vol_email`),
  ADD KEY `time_id` (`time_id`),
  ADD KEY `task_id` (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `time_slot_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `volounteer_times`
--
ALTER TABLE `volounteer_times`
  MODIFY `vol_time_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
