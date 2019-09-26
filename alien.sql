-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2019 at 02:00 AM
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
USE alien;
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
-- Dumping data for table `organisers`
--

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
('a', 'a', 'a', 'a', 'a', 'a', '1234', 'a', '0000-00-00', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `volounteer_times`
--

CREATE TABLE `volounteer_times` (
  `vol_time_id` int(10) UNSIGNED NOT NULL,
  `vol_email` char(50) NOT NULL,
  `time_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NULL,
  `description` varchar(240) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `task_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `time_slot_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `volounteer_times`
--
ALTER TABLE `volounteer_times`
  MODIFY `vol_time_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `volounteer_times`
--
ALTER TABLE `volounteer_times`
  ADD CONSTRAINT `task_id_fk` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`),
  ADD CONSTRAINT `time_id_fk` FOREIGN KEY (`time_id`) REFERENCES `time_slots` (`time_slot_id`),
  ADD CONSTRAINT `vol_email_fk` FOREIGN KEY (`time_d`) REFERENCES `volounteer` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
