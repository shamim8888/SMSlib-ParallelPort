-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 01, 2014 at 07:35 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smslib`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE IF NOT EXISTS `building` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`id`, `name`) VALUES
(1, 'Bhaban1'),
(2, 'Bhaban2');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE IF NOT EXISTS `device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`id`, `name`) VALUES
(1, 'LPT1'),
(2, 'LPT2');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`) VALUES
(6, 'Ac'),
(1, 'Computer'),
(4, 'Fan'),
(5, 'Refrigerator'),
(3, 'TubeLight'),
(2, 'TV');

-- --------------------------------------------------------

--
-- Table structure for table `flat`
--

CREATE TABLE IF NOT EXISTS `flat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `flat`
--

INSERT INTO `flat` (`id`, `name`) VALUES
(1, 'flat1'),
(2, 'flat2');

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

CREATE TABLE IF NOT EXISTS `floor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `floor`
--

INSERT INTO `floor` (`id`, `name`) VALUES
(1, 'floor1'),
(2, 'floor2');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `host_address` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `name`, `host_address`) VALUES
(1, 'room1', '192.168.10.204'),
(2, 'room2', '192.168.10.205');

-- --------------------------------------------------------

--
-- Table structure for table `smsserver_parallel_comm_device_configuration`
--

CREATE TABLE IF NOT EXISTS `smsserver_parallel_comm_device_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building_id` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL,
  `flat_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `lpt_comm_device_id` int(11) NOT NULL,
  `equipment1_id` int(11) NOT NULL,
  `equipment2_id` int(11) NOT NULL,
  `equipment3_id` int(11) NOT NULL,
  `equipment4_id` int(11) NOT NULL,
  `equipment5_id` int(11) NOT NULL,
  `equipment6_id` int(11) NOT NULL,
  `equipment7_id` int(11) NOT NULL,
  `equipment8_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `building_id` (`building_id`),
  KEY `floor_id` (`floor_id`),
  KEY `flat_id` (`flat_id`),
  KEY `room_id` (`room_id`),
  KEY `lpt_comm_device_id` (`lpt_comm_device_id`),
  KEY `equipment1_id` (`equipment1_id`),
  KEY `equipment2_id` (`equipment2_id`),
  KEY `equipment3_id` (`equipment3_id`),
  KEY `equipment4_id` (`equipment4_id`),
  KEY `equipment5_id` (`equipment5_id`),
  KEY `equipment6_id` (`equipment6_id`),
  KEY `equipment7_id` (`equipment7_id`),
  KEY `equipment8_id` (`equipment8_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `smsserver_parallel_comm_device_configuration`
--

INSERT INTO `smsserver_parallel_comm_device_configuration` (`id`, `building_id`, `floor_id`, `flat_id`, `room_id`, `lpt_comm_device_id`, `equipment1_id`, `equipment2_id`, `equipment3_id`, `equipment4_id`, `equipment5_id`, `equipment6_id`, `equipment7_id`, `equipment8_id`) VALUES
(1, 1, 1, 1, 1, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(2, 1, 1, 1, 1, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(3, 1, 1, 1, 2, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(4, 1, 1, 1, 2, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(5, 1, 1, 2, 1, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(6, 1, 1, 2, 1, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(7, 1, 1, 2, 2, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(8, 1, 1, 2, 2, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(9, 1, 2, 1, 1, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(10, 1, 2, 1, 1, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(11, 1, 2, 1, 2, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(12, 1, 2, 1, 2, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(13, 1, 2, 2, 1, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(14, 1, 2, 2, 1, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(15, 1, 2, 2, 2, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(16, 1, 2, 2, 2, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(17, 2, 1, 1, 1, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(18, 2, 1, 1, 1, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(19, 2, 1, 1, 2, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(20, 2, 1, 1, 2, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(21, 2, 1, 2, 1, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(22, 2, 1, 2, 1, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(23, 2, 1, 2, 2, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(24, 2, 1, 2, 2, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(25, 2, 2, 1, 1, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(26, 2, 2, 1, 1, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(27, 2, 2, 1, 2, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(28, 2, 2, 1, 2, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(29, 2, 2, 2, 1, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(30, 2, 2, 2, 1, 2, 1, 2, 3, 4, 5, 6, 7, 8),
(31, 2, 2, 2, 2, 1, 1, 2, 3, 4, 5, 6, 7, 8),
(32, 2, 2, 2, 2, 2, 1, 2, 3, 4, 5, 6, 7, 8);