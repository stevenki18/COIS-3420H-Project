-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 10, 2020 at 04:51 PM
-- Server version: 5.7.29
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `matthewculin`
--

-- --------------------------------------------------------

--
-- Table structure for table `g10_listitems`
--

CREATE TABLE `g10_listitems` (
  `id` int(11) NOT NULL,
  `fk_listid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(280) DEFAULT NULL,
  `picpath` varchar(255) DEFAULT NULL,
  `completion` date DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `g10_lists`
--

CREATE TABLE `g10_lists` (
  `id` int(11) NOT NULL,
  `fk_userid` int(11) NOT NULL,
  `listname` varchar(50) NOT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `g10_users`
--

CREATE TABLE `g10_users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `first` varchar(64) NOT NULL,
  `last` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `dob` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g10_users`
--

INSERT INTO `g10_users` (`id`, `username`, `pass`, `first`, `last`, `email`, `dob`) VALUES
(1, 'master', '$2y$10$N/.jPwKf1YTiVGTCK06jLeUCuLiZjNzDQfp543IbG33hUkI9yqUUW', 'Halo', 'Master', 'hmaster@email.com', '1900-01-05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `g10_listitems`
--
ALTER TABLE `g10_listitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `g10_listid_2_fklistid` (`fk_listid`);

--
-- Indexes for table `g10_lists`
--
ALTER TABLE `g10_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `g10_userid_2_fkuserid` (`fk_userid`);

--
-- Indexes for table `g10_users`
--
ALTER TABLE `g10_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `g10_listitems`
--
ALTER TABLE `g10_listitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `g10_lists`
--
ALTER TABLE `g10_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `g10_users`
--
ALTER TABLE `g10_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `g10_listitems`
--
ALTER TABLE `g10_listitems`
  ADD CONSTRAINT `g10_listid_2_fklistid` FOREIGN KEY (`fk_listid`) REFERENCES `g10_lists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `g10_lists`
--
ALTER TABLE `g10_lists`
  ADD CONSTRAINT `g10_userid_2_fkuserid` FOREIGN KEY (`fk_userid`) REFERENCES `g10_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
