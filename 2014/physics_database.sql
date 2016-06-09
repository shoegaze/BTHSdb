-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql102.byethost6.com
-- Generation Time: Jan 26, 2014 at 12:41 AM
-- Server version: 5.6.15-56
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b6_13984388_Physics`
--

-- --------------------------------------------------------

--
-- Table structure for table `containers`
--

CREATE TABLE IF NOT EXISTS `containers` (
  `section_id` int(8) NOT NULL,
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `label` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`),
  KEY `label` (`label`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `containers`
--

INSERT INTO `containers` (`section_id`, `id`, `label`, `type`) VALUES
(1, 1, 'A', 'Shelf'),
(1, 2, 'B', 'Drawer'),
(2, 3, 'A', 'Drawer'),
(2, 4, 'B', 'Drawer'),
(2, 5, 'C', 'Drawer');

-- --------------------------------------------------------

--
-- Table structure for table `container_item_assignments`
--

CREATE TABLE IF NOT EXISTS `container_item_assignments` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `container_id` int(8) NOT NULL,
  `item_id` int(8) NOT NULL,
  `quantity` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `container_id` (`container_id`,`item_id`,`quantity`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `container_item_assignments`
--

INSERT INTO `container_item_assignments` (`id`, `container_id`, `item_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 2, 1, 5),
(3, 3, 2, 8),
(14, 3, 1, 2),
(16, 5, 8, 1),
(6, 5, 3, 6),
(9, 5, 4, 1),
(15, 1, 3, 3),
(19, 2, 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `name` varchar(32) NOT NULL,
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `description` varchar(32) NOT NULL,
  `serial_number` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`name`, `id`, `description`, `serial_number`) VALUES
('Mass', 1, 'mass', ''),
('Newton''s Craddle', 2, 'Demonstrates Newton''s laws', ''),
('Tennis Ball', 3, 'A pack of Tennis balls', ''),
('Cat', 4, 'Demonstrate angular momentum', ''),
('ping pong', 10, 'ball', ''),
('Bob', 8, 'A bob', ''),
('fur', 9, 'rabbit fur', '');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `number` varchar(32) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`),
  UNIQUE KEY `id_2` (`id`),
  UNIQUE KEY `id_3` (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `id` (`id`),
  KEY `id_4` (`id`),
  KEY `id_5` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `number`, `name`) VALUES
(1, '3E8', 'Storage room'),
(2, '2E8', 'Lab Equipment');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `room_id` int(8) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `room_id` (`room_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `room_id`, `name`) VALUES
(1, 1, 'A'),
(2, 1, 'B'),
(3, 1, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `subject_area`
--

CREATE TABLE IF NOT EXISTS `subject_area` (
  `name` varchar(32) NOT NULL,
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subject_area_item_assignments`
--

CREATE TABLE IF NOT EXISTS `subject_area_item_assignments` (
  `subject_area_id` int(8) NOT NULL,
  `item_id` int(8) NOT NULL,
  KEY `subject_area_id` (`subject_area_id`,`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `level` varchar(32) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(256) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`level`, `id`, `email`, `password`) VALUES
('admin', 1, 'physicsmanager@bths.edu', '8cfb10d3dd0ae49a87320653cbfa587e'),
('teacher', 2, 'physicsteacher@bths.edu', '8cfb10d3dd0ae49a87320653cbfa587e'),
('teacher', 6, 'jc@penny.com', '5f4dcc3b5aa765d61d8327deb882cf99'),
('teacher', 7, 'jhorvitz@bths.edu', '8cfb10d3dd0ae49a87320653cbfa587e'),
('admin', 8, 'jake@statefarm.com', '8cfb10d3dd0ae49a87320653cbfa587e');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
