-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 22, 2020 at 07:33 PM
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

CREATE TABLE IF NOT EXISTS `g10_listitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_listid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(280) DEFAULT NULL,
  `picpath` varchar(255) DEFAULT NULL,
  `completion` date DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `g10_listid_2_fklistid` (`fk_listid`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g10_listitems`
--

INSERT INTO `g10_listitems` (`id`, `fk_listid`, `name`, `description`, `picpath`, `completion`, `private`) VALUES
(1, 1, 'Don\'t die!', 'Try my best to not die', NULL, NULL, 1),
(2, 1, 'Ride a camel', 'Ride a camel in the desert', NULL, NULL, 0),
(3, 2, 'Don\'t die', 'If I live this long, try not to die again', NULL, NULL, 1),
(4, 2, 'Go skydiving', 'Go skydiving from 13,000 ft', NULL, NULL, 0),
(5, 3, 'Add Items', 'Get add items working', NULL, NULL, 0),
(6, 3, 'View Items', 'Get view items working', NULL, NULL, 0),
(7, 3, 'Edit Items', 'Get edit items working', NULL, NULL, 0),
(8, 3, 'Delete Items', 'Get delete items working', NULL, NULL, 1),
(9, 3, 'Add List', 'Get add list working', NULL, NULL, 0),
(10, 3, 'Manage List', 'Get my list page to link to manage list with proper list id', NULL, NULL, 1),
(11, 3, 'View Lists Page', 'Get view lists page to pull all public lists', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `g10_lists`
--

CREATE TABLE IF NOT EXISTS `g10_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_userid` int(11) NOT NULL,
  `listname` varchar(50) NOT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `g10_userid_2_fkuserid` (`fk_userid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g10_lists`
--

INSERT INTO `g10_lists` (`id`, `fk_userid`, `listname`, `start`, `end`, `private`) VALUES
(1, 1, 'Complete Me By 50', '2020-03-20', NULL, 1),
(2, 1, 'Complete Me By 90', '2020-03-20', '2020-03-22', 0),
(3, 1, 'Things To Do', '2020-03-21', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `g10_users`
--

CREATE TABLE IF NOT EXISTS `g10_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `first` varchar(64) NOT NULL,
  `last` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g10_users`
--

INSERT INTO `g10_users` (`id`, `username`, `pass`, `first`, `last`, `email`, `dob`) VALUES
(1, 'master', '$2y$10$N/.jPwKf1YTiVGTCK06jLeUCuLiZjNzDQfp543IbG33hUkI9yqUUW', 'Halo', 'Master', 'hmaster@email.com', '1900-01-05'),
(2, 'matthewculin', '$2y$10$oLdbgAhG6AEQ4Zpk1XNHQebQCA6lrLvOhWHjz099eooLNUo8O.gru', 'Matthew', 'Culin', 'matthewculin@trentu.ca', '1997-10-15');

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
