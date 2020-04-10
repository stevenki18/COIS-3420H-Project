-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 10, 2020 at 03:15 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g10_listitems`
--

INSERT INTO `g10_listitems` (`id`, `fk_listid`, `name`, `description`, `picpath`, `completion`, `private`) VALUES
(1, 1, 'Don\'t die!', 'Try my best to not die', NULL, NULL, 1),
(2, 1, 'Ride a camel', 'Ride a camel in the desert', NULL, NULL, 0),
(5, 3, 'Add Items', 'Get add items working.\r\n\r\nAdd items is working', NULL, '2020-04-04', 1),
(7, 3, 'Edit Items', 'Get edit items working\r\n\r\nEdit items complete', NULL, '2020-04-06', 1),
(8, 3, 'Delete Items', 'Get delete items working\r\n\r\nConfirm via JS', NULL, NULL, 0),
(9, 3, 'Add List', 'Get add list working\r\n\r\nAdd List Works', NULL, '2020-04-08', 1),
(10, 3, 'Manage List', 'Get my list page to link to manage list with proper list id\r\n\r\nManage List Done', NULL, '2020-04-08', 1),
(13, 3, 'View Items', 'Get View items working\r\n\r\nView Items Working', NULL, '2020-04-08', 1),
(14, 3, 'Clean Up Styling', 'Clean up styling on finished pages', NULL, NULL, 0),
(16, 3, 'Delete Account', 'Account deletion (please not master)', NULL, NULL, 0),
(17, 3, 'Delete List', 'Delete A List (button should only show up if the user who owns the list is logged in)\r\n\r\nConfirm via JS', NULL, NULL, 0),
(24, 3, 'Edit List', 'Add ability to edit list information after creation... list name & public/private', NULL, NULL, 0),
(25, 3, 'Image Upload', 'Allow for image upload for bucket list items', NULL, NULL, 0),
(26, 3, 'Logout', 'Deal with logout php page\r\n\r\nKind of required for sign off (Can we leave it?)\r\n\r\nM - Logout can stay as is, just renamed file to remove ~', NULL, '2020-04-09', 1),
(27, 1, 'Go skydiving', 'Go skydiving from 10, 000 feet', NULL, NULL, 0),
(28, 1, 'Go to California', 'Go to California\r\n\r\n- Los Angeles\r\n- Disneyland\r\n- Big Sur', NULL, NULL, 0),
(29, 1, 'Climb a mountain', 'Climb a mountain\r\n\r\nClimbed Mount Etna in Sicily, Italy', NULL, '2016-03-16', 0),
(30, 3, 'Google Login?', 'Are we doing the Google login option?\r\n\r\nGoogle log in now works. (What a mess!)', NULL, '2020-04-09', 1),
(33, 3, 'Add List From Display Lists', 'M - Add list button on the display list page doesn\'t work (works from nav). We can just remove it if that is fine to go from there', NULL, '2020-04-09', 1),
(34, 3, 'Search', 'Search for items\r\n', NULL, NULL, 0),
(35, 3, 'I Feel Lucky', '', NULL, NULL, 0),
(36, 3, 'JS Pluggin', '', NULL, NULL, 0),
(37, 3, 'Form Validation Login (JS)', 'Alert boxes for:\r\n- password mismatch\r\n- account changes\r\n\r\nTurn off auto fill for passwords\r\n', NULL, NULL, 0),
(38, 3, 'Case Sensitivity for Register', '', NULL, NULL, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g10_lists`
--

INSERT INTO `g10_lists` (`id`, `fk_userid`, `listname`, `start`, `end`, `private`) VALUES
(1, 1, 'Complete Me By 50', '2020-03-12', NULL, 1),
(3, 1, 'Things To Do', '2020-03-21', NULL, 0),
(12, 2, 'Matt\'s List', '2020-04-10', NULL, 0),
(13, 1, 'Master\'s New List', '2020-04-10', NULL, 0);

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
  `dob` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `g10_users`
--

INSERT INTO `g10_users` (`id`, `username`, `pass`, `first`, `last`, `email`, `dob`) VALUES
(1, 'master', '$2y$10$BJ/e/Kkj3A1R62XiBEqjrednvlG/Flj1lCu9U/mGVq/xF/wNy84ES', 'Master', 'Chief', 'hmaster@email.com', '1900-01-05'),
(2, 'matthewculin', '$2y$10$oLdbgAhG6AEQ4Zpk1XNHQebQCA6lrLvOhWHjz099eooLNUo8O.gru', 'Matthew', 'Culin', 'matthewculin@trentu.ca', '1997-10-15'),
(3, 'airstu85@gmail.com', '$2y$10$YG0eGSNq9txFEp1GryEns.tjKO97SwZ1d8Bwzev5SZZ1XkdRM6QqO', 'Steven', 'Ki', 'airstu85@gmail.com', NULL),
(4, 'culinm@gmail.com', '$2y$10$ZqVFp9Mf4B.9nHfYlYl13OiEnOBVN84bEk7lMBzyOM7dj7qKZTvl6', 'Matthew', 'Culin', 'culinm@gmail.com', NULL),
(5, 'matthewculin@trentu.ca', '$2y$10$p1E1kVQ0l9gj9HxnqtppheGZQEOP5S6ky3Lh3vzJBCj0bBGW7NKMS', 'Matthew', 'Culin', 'matthewculin@trentu.ca', NULL);

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
