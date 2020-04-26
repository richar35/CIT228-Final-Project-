-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2020 at 02:07 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `races`
--

-- --------------------------------------------------------

--
-- Table structure for table `date`
--

CREATE TABLE `date` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `month` varchar(30) DEFAULT NULL,
  `day` char(2) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `date`
--

INSERT INTO `date` (`id`, `master_id`, `date_added`, `date_modified`, `month`, `day`, `year`) VALUES
(13, 34, '2020-04-06 20:00:33', '2020-04-06 20:00:33', 'May', '23', '2020'),
(15, 36, '2020-04-06 20:03:31', '2020-04-06 20:03:31', 'july', '2', '2020');

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `master_id`, `date_added`, `date_modified`, `email`) VALUES
(13, 34, '2020-04-06 20:00:33', '2020-04-06 20:00:33', 'richar35@mail.nmc.edu'),
(15, 36, '2020-04-06 20:03:31', '2020-04-06 20:03:31', 'richar35@mail.nmc.edu');

-- --------------------------------------------------------

--
-- Table structure for table `master_racename`
--

CREATE TABLE `master_racename` (
  `id` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `race_name` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_racename`
--

INSERT INTO `master_racename` (`id`, `date_added`, `date_modified`, `race_name`) VALUES
(34, '2020-04-06 20:00:33', '2020-04-06 20:00:33', 'Bayshore Marathon'),
(36, '2020-04-06 20:03:31', '2020-04-06 20:03:31', 'Gazelle Girl');

-- --------------------------------------------------------

--
-- Table structure for table `racelocation`
--

CREATE TABLE `racelocation` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `type` enum('Marathon','Half Marathon','10k','5k') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `racelocation`
--

INSERT INTO `racelocation` (`id`, `master_id`, `date_added`, `date_modified`, `city`, `state`, `zipcode`, `type`) VALUES
(3, 34, '2020-04-06 20:00:33', '2020-04-06 20:00:33', 'Traverse City', 'MI', '49686', '10k'),
(5, 36, '2020-04-06 20:03:31', '2020-04-06 20:03:31', 'Traverse City', 'MI', '49686', '5k');

-- --------------------------------------------------------

--
-- Table structure for table `race_notes`
--

CREATE TABLE `race_notes` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `note` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `race_notes`
--

INSERT INTO `race_notes` (`id`, `master_id`, `date_added`, `date_modified`, `note`) VALUES
(9, 36, '2020-04-06 20:03:31', '2020-04-06 20:03:31', 'bla');

-- --------------------------------------------------------

--
-- Table structure for table `telephone`
--

CREATE TABLE `telephone` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `tel_number` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `telephone`
--

INSERT INTO `telephone` (`id`, `master_id`, `date_added`, `date_modified`, `tel_number`) VALUES
(27, 34, '2020-04-06 20:00:33', '2020-04-06 20:00:33', '2315449999'),
(29, 36, '2020-04-06 20:03:31', '2020-04-06 20:03:31', '2315449999');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `date`
--
ALTER TABLE `date`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_racename`
--
ALTER TABLE `master_racename`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `racelocation`
--
ALTER TABLE `racelocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `race_notes`
--
ALTER TABLE `race_notes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `master_id` (`master_id`);

--
-- Indexes for table `telephone`
--
ALTER TABLE `telephone`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `date`
--
ALTER TABLE `date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `master_racename`
--
ALTER TABLE `master_racename`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `racelocation`
--
ALTER TABLE `racelocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `race_notes`
--
ALTER TABLE `race_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `telephone`
--
ALTER TABLE `telephone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
