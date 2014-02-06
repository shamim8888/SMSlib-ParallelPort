-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 08, 2014 at 01:45 PM
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
-- Table structure for table `smsserver_mail_out`
--

CREATE TABLE IF NOT EXISTS `smsserver_mail_out` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(1) NOT NULL DEFAULT 'O',
  `recipient` varchar(16) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `wap_url` varchar(100) DEFAULT NULL,
  `wap_expiry_date` datetime DEFAULT NULL,
  `wap_signal` varchar(1) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `originator` varchar(16) NOT NULL DEFAULT ' ',
  `encoding` varchar(1) NOT NULL DEFAULT '7',
  `status_report` int(1) NOT NULL DEFAULT '0',
  `flash_sms` int(1) NOT NULL DEFAULT '0',
  `src_port` int(6) NOT NULL DEFAULT '-1',
  `dst_port` int(6) NOT NULL DEFAULT '-1',
  `sent_date` datetime DEFAULT NULL,
  `ref_no` varchar(64) DEFAULT NULL,
  `priority` int(5) NOT NULL DEFAULT '0',
  `status` varchar(1) NOT NULL DEFAULT 'U',
  `errors` int(2) NOT NULL DEFAULT '0',
  `gateway_id` varchar(64) NOT NULL DEFAULT '*',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `smsserver_mail_out`
--

INSERT INTO `smsserver_mail_out` (`id`, `type`, `recipient`, `text`, `wap_url`, `wap_expiry_date`, `wap_signal`, `create_date`, `originator`, `encoding`, `status_report`, `flash_sms`, `src_port`, `dst_port`, `sent_date`, `ref_no`, `priority`, `status`, `errors`, `gateway_id`) VALUES
(2, 'O', '01719845856', 'SMS Server Test To Check For Status Report ', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-11 12:03:17', '42', 0, 'S', 0, 'modem1'),
(3, 'O', '01719845856', 'Student Name:	Williams, Bob ID:	1 Alt ID:	GA1 Grade:	Junior Gender:	Male Ethnicity:	White, Non-Hispanic Common Name:	Bob Birth Date:	Dec/4/1995 Language Spoken:	English Email ID:	robert@school.edu Phone:	678-555-1212 Home Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309 		 Mailing Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 11:36:21', '44', 0, 'S', 0, 'modem1'),
(4, 'O', '01719845856', 'Personal Information Student Name:	Williams, Bob ID:	1 Alt ID:	GA1 Grade:	Junior Gender:	Male Ethnicity:	White, Non-Hispanic Common Name:	Bob Birth Date:	Dec/4/1995 Language Spoken:	English Email ID:	robert@school.edu Phone:	678-555-1212 Home Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309 		 Mailing Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309 Primary Emergency Contact Relation :	Father First Name :	Dennis Last Name :	Williams Home Phone :	404-555-1212 Work Phone :	678-232-4300 Xt 77 Mobile Phone :	404-524-3234 Email :	dennis@email.com Address1 :	1050 Peachtree Street Address2 :	Unit 56 City :	Atlanta State :	GA Zipcode :	30309 		 Secondary Emergency Contact Relation :	Mother First Name :	Julia Last Name :	Williams Home Phone :	404-555-1212 Email :	julia@email.com Address1 :	1050 Peachtree Street Address2 :	Unit 56 City :	Atlanta State :	GA Zipcode :	30309 		 Medical Information 		 Gen', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 15:05:36', '70', 0, 'S', 0, 'modem1'),
(5, 'O', '01719845856', 'Personal Information Student Name:	Williams, Bob', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 17:25:15', '0', 0, 'S', 5, 'mysmpp'),
(6, 'O', '01719845856', 'This is network SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 17:54:44', '0', 0, 'S', 0, 'mysmpp2'),
(7, 'O', '01719845856', 'This is network Zaman SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 18:00:14', '1', 0, 'S', 0, 'mysmpp2'),
(8, 'O', '01719845856', 'This is network Taposh Pavel Zaman SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 18:16:15', '0', 0, 'S', 0, 'mysmpp2'),
(9, 'O', '01719845856', 'This is network Kanak Taposh Pavel Zaman SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 18:24:42', '0', 0, 'S', 0, 'mysmpp2');
