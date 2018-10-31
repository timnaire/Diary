-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2018 at 07:14 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diary`
--

-- --------------------------------------------------------

--
-- Table structure for table `diary`
--

CREATE TABLE `diary` (
  `diary_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `diary_datecreated` date DEFAULT NULL,
  `diary_label` varchar(50) DEFAULT NULL,
  `diary_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `diary`
--

INSERT INTO `diary` (`diary_id`, `owner_id`, `diary_datecreated`, `diary_label`, `diary_status`) VALUES
(1, 1, '2018-09-28', 'Friday Sept', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `time_unseen` datetime DEFAULT NULL,
  `time_seen` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` int(11) NOT NULL,
  `owner_lastname` varchar(30) DEFAULT NULL,
  `owner_firstname` varchar(30) DEFAULT NULL,
  `owner_alias` varchar(50) DEFAULT NULL,
  `owner_username` varchar(30) DEFAULT NULL,
  `owner_password` varchar(50) DEFAULT NULL,
  `owner_img` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_id`, `owner_lastname`, `owner_firstname`, `owner_alias`, `owner_username`, `owner_password`, `owner_img`) VALUES
(1, 'Donaire', 'Timmy', 'Aizaya', 'timmy345', '0192023a7bbd73250516f069df18b500', 0x2e2e2f766965772f696d616765732f757365727069632f74696d2e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `story`
--

CREATE TABLE `story` (
  `story_id` int(11) NOT NULL,
  `diary_id` int(11) NOT NULL,
  `story_date` date DEFAULT NULL,
  `owner_id` int(11) NOT NULL,
  `story_title` varchar(50) DEFAULT NULL,
  `story_content` varchar(1000) DEFAULT NULL,
  `story_privacy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `story`
--

INSERT INTO `story` (`story_id`, `diary_id`, `story_date`, `owner_id`, `story_title`, `story_content`, `story_privacy`) VALUES
(1, 1, '2018-09-28', 1, 'Finish Project', 'Dear Diary, Today I finished my diary project in PHP. I worked so alone and did my very best to complete this. I am so happy', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diary`
--
ALTER TABLE `diary`
  ADD PRIMARY KEY (`diary_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `story_id` (`story_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `story`
--
ALTER TABLE `story`
  ADD PRIMARY KEY (`story_id`),
  ADD KEY `diary_id` (`diary_id`,`owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diary`
--
ALTER TABLE `diary`
  MODIFY `diary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `story`
--
ALTER TABLE `story`
  MODIFY `story_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
