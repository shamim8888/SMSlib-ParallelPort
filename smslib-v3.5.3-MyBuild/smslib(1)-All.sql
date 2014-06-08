-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 08, 2014 at 01:42 PM
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
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `name`) VALUES
(1, 'room1'),
(2, 'room2');

-- --------------------------------------------------------

--
-- Table structure for table `smsserver_calls`
--

CREATE TABLE IF NOT EXISTS `smsserver_calls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `call_date` datetime NOT NULL,
  `gateway_id` varchar(64) NOT NULL,
  `caller_id` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `smsserver_calls`
--

INSERT INTO `smsserver_calls` (`id`, `call_date`, `gateway_id`, `caller_id`) VALUES
(2, '2013-12-11 00:26:56', 'modem1', '8080'),
(3, '2013-12-11 00:27:01', 'modem1', '8080'),
(4, '2013-12-11 00:27:07', 'modem1', '8080'),
(5, '2013-12-11 00:27:13', 'modem1', '8080'),
(6, '2013-12-11 00:27:19', 'modem1', '8080'),
(7, '2013-12-11 00:27:25', 'modem1', '8080'),
(8, '2013-12-11 00:27:31', 'modem1', '8080'),
(9, '2013-12-11 00:27:37', 'modem1', '8080');

-- --------------------------------------------------------

--
-- Table structure for table `smsserver_in`
--

CREATE TABLE IF NOT EXISTS `smsserver_in` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `process` int(11) NOT NULL,
  `originator` varchar(16) NOT NULL,
  `type` varchar(1) NOT NULL,
  `encoding` char(1) NOT NULL,
  `message_date` datetime NOT NULL,
  `receive_date` datetime NOT NULL,
  `text` varchar(1000) NOT NULL,
  `original_ref_no` varchar(64) DEFAULT NULL,
  `original_receive_date` datetime DEFAULT NULL,
  `gateway_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `smsserver_in`
--

INSERT INTO `smsserver_in` (`id`, `process`, `originator`, `type`, `encoding`, `message_date`, `receive_date`, `text`, `original_ref_no`, `original_receive_date`, `gateway_id`) VALUES
(9, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:43:02', 'The new theme song of Robi in GoonGoon! ''Chotto Ekta Kaj'' gaan ti pete', NULL, NULL, 'modem1'),
(10, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:43:02', ' dial korun*140*1*95#.Monthly Fee:15tk, Gaan download: 15Tk, 15% VAT a', NULL, NULL, 'modem1'),
(11, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:43:02', 'pply', NULL, NULL, 'modem1'),
(12, 0, '21228', 'I', '7', '2013-07-08 00:54:04', '2013-12-03 22:43:02', 'Ruling Awami League loses crucial mayor election. To know more please dial *140*66# Condition Apply', NULL, NULL, 'modem1'),
(13, 0, '8383', 'I', '7', '2013-09-30 22:03:32', '2013-12-03 22:43:02', '207:Transaction number R131001.1103.160167 to recharge 30 Tk from 1837436975 is successful and valid till 31/10/13. Dial *8444*71# for 71MB at Tk26.', NULL, NULL, 'modem1'),
(14, 0, 'Robi', 'I', '7', '2013-09-30 22:03:46', '2013-12-03 22:43:02', 'Dear User,you have got 20 Items free MMS,valid till 07/10/2013.Dear User,you have got 20MB Internet Pack,valid till 07/10/2013.', NULL, NULL, 'modem1'),
(15, 0, 'Robi', 'I', '7', '2013-09-30 22:03:46', '2013-12-03 22:43:02', 'Dear valued customer,The fee for 20MB Data Pack you purchased is TK 23.00(including VAT).', NULL, NULL, 'modem1'),
(16, 0, '8383', 'I', '7', '2013-10-03 05:54:56', '2013-12-03 22:43:02', '207:Transaction number R131003.1854.250577 to recharge 120 Tk from 1837436975 is successful and valid till 02/12/13. Dial *8444*71# for 71MB at Tk26.', NULL, NULL, 'modem1'),
(17, 0, 'Robi', 'I', '7', '2013-10-03 05:56:49', '2013-12-03 22:43:02', 'Dear User,you have got 00:30:00 free minute,valid till 09/10/2013.Dear User,you have got 100MB Internet Pack,valid till 01/11/2013.', NULL, NULL, 'modem1'),
(18, 0, 'Robi', 'I', '7', '2013-10-03 05:56:49', '2013-12-03 22:43:02', 'Dear valued customer,The fee for 100MB Data Pack you purchased is TK 115.00(including VAT).', NULL, NULL, 'modem1'),
(19, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:47:54', 'The new theme song of Robi in GoonGoon! ''Chotto Ekta Kaj'' gaan ti pete', NULL, NULL, 'modem1'),
(20, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:47:54', ' dial korun*140*1*95#.Monthly Fee:15tk, Gaan download: 15Tk, 15% VAT a', NULL, NULL, 'modem1'),
(21, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:47:54', 'pply', NULL, NULL, 'modem1'),
(22, 0, '21228', 'I', '7', '2013-07-08 00:54:04', '2013-12-03 22:47:54', 'Ruling Awami League loses crucial mayor election. To know more please dial *140*66# Condition Apply', NULL, NULL, 'modem1'),
(23, 0, '8383', 'I', '7', '2013-09-30 22:03:32', '2013-12-03 22:47:54', '207:Transaction number R131001.1103.160167 to recharge 30 Tk from 1837436975 is successful and valid till 31/10/13. Dial *8444*71# for 71MB at Tk26.', NULL, NULL, 'modem1'),
(24, 0, 'Robi', 'I', '7', '2013-09-30 22:03:46', '2013-12-03 22:47:54', 'Dear User,you have got 20 Items free MMS,valid till 07/10/2013.Dear User,you have got 20MB Internet Pack,valid till 07/10/2013.', NULL, NULL, 'modem1'),
(25, 0, 'Robi', 'I', '7', '2013-09-30 22:03:46', '2013-12-03 22:47:54', 'Dear valued customer,The fee for 20MB Data Pack you purchased is TK 23.00(including VAT).', NULL, NULL, 'modem1'),
(26, 0, '8383', 'I', '7', '2013-10-03 05:54:56', '2013-12-03 22:47:54', '207:Transaction number R131003.1854.250577 to recharge 120 Tk from 1837436975 is successful and valid till 02/12/13. Dial *8444*71# for 71MB at Tk26.', NULL, NULL, 'modem1'),
(27, 0, 'Robi', 'I', '7', '2013-10-03 05:56:49', '2013-12-03 22:47:54', 'Dear User,you have got 00:30:00 free minute,valid till 09/10/2013.Dear User,you have got 100MB Internet Pack,valid till 01/11/2013.', NULL, NULL, 'modem1'),
(28, 0, 'Robi', 'I', '7', '2013-10-03 05:56:49', '2013-12-03 22:47:54', 'Dear valued customer,The fee for 100MB Data Pack you purchased is TK 115.00(including VAT).', NULL, NULL, 'modem1'),
(29, 0, '8801719845856', 'I', '7', '2013-12-03 08:51:51', '2013-12-03 22:57:58', 'This is for testing message.', NULL, NULL, 'modem1'),
(30, 0, '8801719845856', 'S', '7', '2013-12-03 21:15:35', '2013-12-04 22:42:38', '00 - Succesful Delivery.', '37', '2013-12-03 21:15:40', 'modem1'),
(31, 0, '8801719845856', 'S', '7', '2013-12-03 21:16:30', '2013-12-04 22:42:38', '00 - Succesful Delivery.', '38', '2013-12-03 21:16:35', 'modem1'),
(32, 0, '8801719845856', 'S', '7', '2013-12-03 21:17:37', '2013-12-04 22:42:38', '00 - Succesful Delivery.', '39', '2013-12-03 21:17:42', 'modem1'),
(33, 0, '8801719845856', 'S', '7', '2013-12-03 21:18:45', '2013-12-04 22:42:38', '00 - Succesful Delivery.', '40', '2013-12-03 21:18:50', 'modem1'),
(34, 0, 'Robi', 'I', '7', '2013-12-04 02:28:57', '2013-12-04 22:42:38', 'Dial *8444*100# and enjoy 100 MB internet only BDT60. Validity 15 days. To know more Data packs dial *8444# ( toll free).', NULL, NULL, 'modem1'),
(35, 0, 'Robi', 'I', '7', '2013-12-06 02:54:29', '2013-12-11 12:03:09', 'Jekono Biroktikor call bondho korar jonno Robi Call Block service babohar korun. Matro 25 takay 30 diner jonno service ti chalu korte dial korun *818*1*1#', NULL, NULL, 'modem1'),
(36, 0, '8801789421751', 'I', '7', '2013-12-06 23:09:50', '2013-12-11 12:03:09', 'This is a test', NULL, NULL, 'modem1'),
(37, 0, 'Robi', 'I', '7', '2013-12-09 02:24:40', '2013-12-11 12:03:09', 'Robi Local Express niye elo Latest Nokia Lumia 1020 smartphone jite nebar shujog. Dial korun 2001 r ongsho nin mojar ei protijogitay. Fee projojjo', NULL, NULL, 'modem1'),
(38, 0, 'Robi', 'I', '7', '2013-12-09 03:20:22', '2013-12-11 12:03:09', 'Robi Local Express niye elo Latest Nokia Lumia 1020 smartphone jite nebar shujog. Dial korun 2001 r ongsho nin mojar ei protijogitay. Fee projojjo', NULL, NULL, 'modem1'),
(39, 0, '8801719845856', 'I', '7', '2013-12-10 08:52:34', '2013-12-11 12:03:09', 'Test 10.', NULL, NULL, 'modem1'),
(40, 0, '8801719845856', 'S', '7', '2013-12-10 22:03:45', '2013-12-11 12:13:10', '00 - Succesful Delivery.', '42', '2013-12-10 22:03:51', 'modem1'),
(41, 0, 'Robi', 'I', '7', '2013-12-11 20:16:23', '2013-12-12 11:07:13', '143 minute Bijoy BONUS! Nov theke Dec-e TK71 beshi babohar-e January-te BONUS paben. Free Register korte dial *140*16#. Dec-er babohar jante free dial *444*71#', NULL, NULL, 'modem1'),
(42, 0, 'Robi', 'I', '7', '2013-12-24 13:01:20', '2013-12-24 21:48:44', 'Dial *8444*20# Upobhog korun 20MB Internet @ 20Tk Only, Mead 7 Din. Download Korun FREE DHOOM-3 Mp3 Songs at  http://m.mp3clan.com/mp3/dhoom_3.html', NULL, NULL, 'modem1'),
(43, 0, 'Robi', 'I', '7', '2013-12-24 13:01:20', '2013-12-24 21:59:05', 'Dial *8444*20# Upobhog korun 20MB Internet @ 20Tk Only, Mead 7 Din. Download Korun FREE DHOOM-3 Mp3 Songs at  http://m.mp3clan.com/mp3/dhoom_3.html', NULL, NULL, 'modem1'),
(44, 0, '8801789421751', 'I', '7', '2013-12-24 22:35:35', '2013-12-24 22:41:16', 'Room1 all on', NULL, NULL, 'modem1'),
(45, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 12:05:25', 'Room1 all on', NULL, NULL, 'modem1'),
(46, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 12:26:20', 'Room1 all on', NULL, NULL, 'modem1'),
(47, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 12:32:11', 'Room1 all on', NULL, NULL, 'modem1'),
(48, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 12:42:11', 'Room1 all on', NULL, NULL, 'modem1'),
(49, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 12:52:11', 'Room1 all on', NULL, NULL, 'modem1'),
(50, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 12:59:48', 'Room1 all on', NULL, NULL, 'modem1'),
(51, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 13:07:17', 'Room1 all on', NULL, NULL, 'modem1'),
(52, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 13:27:09', 'Room1 all on', NULL, NULL, 'modem1'),
(53, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 13:40:44', 'Room1 all on', NULL, NULL, 'modem1'),
(54, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 13:56:50', 'Room1 all on', NULL, NULL, 'modem1'),
(55, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 13:58:56', 'Room1 all on', NULL, NULL, 'modem1'),
(56, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 15:07:33', 'Room1 all on', NULL, NULL, 'modem1'),
(57, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 15:37:33', 'Room1 all on', NULL, NULL, 'modem1'),
(58, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 15:41:41', 'Room1 all on', NULL, NULL, 'modem1'),
(59, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 15:53:20', 'Room1 all on', NULL, NULL, 'modem1'),
(60, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 16:02:34', 'Room1 all on', NULL, NULL, 'modem1'),
(61, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 16:04:01', 'Room1 all on', NULL, NULL, 'modem1'),
(62, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 16:05:29', 'Room1 all on', NULL, NULL, 'modem1'),
(63, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 17:38:37', 'Room1 all on', NULL, NULL, 'modem1'),
(64, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2013-12-25 21:57:00', 'Room1 all on', NULL, NULL, 'modem1'),
(65, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2014-01-04 19:19:05', 'Room1 all on', NULL, NULL, 'modem1'),
(66, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2014-01-04 19:24:13', 'Room1 all on', NULL, NULL, 'modem1'),
(67, 0, '8801789421751', 'I', '7', '2014-01-05 20:43:05', '2014-01-05 20:53:24', 'Room1 all on', NULL, NULL, 'modem1'),
(68, 0, '8801789421751', 'I', '7', '2014-01-05 20:43:05', '2014-01-05 21:00:20', 'Room1 all on', NULL, NULL, 'modem1'),
(69, 0, '8801789421751', 'I', '7', '2014-01-05 20:43:05', '2014-01-05 21:09:42', 'Room1 all on', NULL, NULL, 'modem1'),
(70, 0, '8801789421751', 'I', '7', '2014-01-05 20:43:05', '2014-01-05 21:11:04', 'Room1 all on', NULL, NULL, 'modem1');

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

-- --------------------------------------------------------

--
-- Table structure for table `smsserver_out`
--

CREATE TABLE IF NOT EXISTS `smsserver_out` (
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
-- Dumping data for table `smsserver_out`
--

INSERT INTO `smsserver_out` (`id`, `type`, `recipient`, `text`, `wap_url`, `wap_expiry_date`, `wap_signal`, `create_date`, `originator`, `encoding`, `status_report`, `flash_sms`, `src_port`, `dst_port`, `sent_date`, `ref_no`, `priority`, `status`, `errors`, `gateway_id`) VALUES
(2, 'O', '01719845856', 'SMS Server Test To Check For Status Report ', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-11 12:03:17', '42', 0, 'S', 0, 'modem1'),
(3, 'O', '01719845856', 'Student Name:	Williams, Bob ID:	1 Alt ID:	GA1 Grade:	Junior Gender:	Male Ethnicity:	White, Non-Hispanic Common Name:	Bob Birth Date:	Dec/4/1995 Language Spoken:	English Email ID:	robert@school.edu Phone:	678-555-1212 Home Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309 		 Mailing Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 11:36:21', '44', 0, 'S', 0, 'modem1'),
(4, 'O', '01719845856', 'Personal Information Student Name:	Williams, Bob ID:	1 Alt ID:	GA1 Grade:	Junior Gender:	Male Ethnicity:	White, Non-Hispanic Common Name:	Bob Birth Date:	Dec/4/1995 Language Spoken:	English Email ID:	robert@school.edu Phone:	678-555-1212 Home Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309 		 Mailing Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309 Primary Emergency Contact Relation :	Father First Name :	Dennis Last Name :	Williams Home Phone :	404-555-1212 Work Phone :	678-232-4300 Xt 77 Mobile Phone :	404-524-3234 Email :	dennis@email.com Address1 :	1050 Peachtree Street Address2 :	Unit 56 City :	Atlanta State :	GA Zipcode :	30309 		 Secondary Emergency Contact Relation :	Mother First Name :	Julia Last Name :	Williams Home Phone :	404-555-1212 Email :	julia@email.com Address1 :	1050 Peachtree Street Address2 :	Unit 56 City :	Atlanta State :	GA Zipcode :	30309 		 Medical Information 		 Gen', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 15:05:36', '70', 0, 'S', 0, 'modem1'),
(5, 'O', '01719845856', 'Personal Information Student Name:	Williams, Bob', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 17:25:15', '0', 0, 'S', 5, 'mysmpp'),
(6, 'O', '01719845856', 'This is network SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 17:54:44', '0', 0, 'S', 0, 'mysmpp2'),
(7, 'O', '01719845856', 'This is network Zaman SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 18:00:14', '1', 0, 'S', 0, 'mysmpp2'),
(8, 'O', '01719845856', 'This is network Taposh Pavel Zaman SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 18:16:15', '0', 0, 'S', 0, 'mysmpp2'),
(9, 'O', '01719845856', 'This is network Kanak Taposh Pavel Zaman SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 18:24:42', '0', 0, 'S', 0, 'mysmpp2');

-- --------------------------------------------------------

--
-- Table structure for table `smsserver_parallel_device_configuration`
--

CREATE TABLE IF NOT EXISTS `smsserver_parallel_device_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building_id` int(11) NOT NULL,
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
  KEY `lpt_comm_device_id` (`lpt_comm_device_id`),
  KEY `building_id` (`building_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `smsserver_parallel_device_configuration`
--

INSERT INTO `smsserver_parallel_device_configuration` (`id`, `building_id`, `room_id`, `lpt_comm_device_id`, `equipment1_id`, `equipment2_id`, `equipment3_id`, `equipment4_id`, `equipment5_id`, `equipment6_id`, `equipment7_id`, `equipment8_id`) VALUES
(1, 1, 1, 1, 1, 2, 3, 4, 5, 6, 0, 0),
(2, 1, 1, 2, 1, 2, 3, 4, 5, 6, 0, 0),
(3, 1, 2, 1, 1, 2, 3, 4, 5, 6, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `smsserver_parallel_in`
--

CREATE TABLE IF NOT EXISTS `smsserver_parallel_in` (
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
-- Dumping data for table `smsserver_parallel_in`
--

INSERT INTO `smsserver_parallel_in` (`id`, `type`, `recipient`, `text`, `wap_url`, `wap_expiry_date`, `wap_signal`, `create_date`, `originator`, `encoding`, `status_report`, `flash_sms`, `src_port`, `dst_port`, `sent_date`, `ref_no`, `priority`, `status`, `errors`, `gateway_id`) VALUES
(2, 'O', '01719845856', 'SMS Server Test To Check For Status Report ', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-11 12:03:17', '42', 0, 'S', 0, 'modem1'),
(3, 'O', '01719845856', 'Student Name:	Williams, Bob ID:	1 Alt ID:	GA1 Grade:	Junior Gender:	Male Ethnicity:	White, Non-Hispanic Common Name:	Bob Birth Date:	Dec/4/1995 Language Spoken:	English Email ID:	robert@school.edu Phone:	678-555-1212 Home Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309 		 Mailing Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 11:36:21', '44', 0, 'S', 0, 'modem1'),
(4, 'O', '01719845856', 'Personal Information Student Name:	Williams, Bob ID:	1 Alt ID:	GA1 Grade:	Junior Gender:	Male Ethnicity:	White, Non-Hispanic Common Name:	Bob Birth Date:	Dec/4/1995 Language Spoken:	English Email ID:	robert@school.edu Phone:	678-555-1212 Home Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309 		 Mailing Address Address1:	1050 Peachtree Street Address2:	Unit 56 City:	Atlanta State:	GA Zipcode:	30309 Primary Emergency Contact Relation :	Father First Name :	Dennis Last Name :	Williams Home Phone :	404-555-1212 Work Phone :	678-232-4300 Xt 77 Mobile Phone :	404-524-3234 Email :	dennis@email.com Address1 :	1050 Peachtree Street Address2 :	Unit 56 City :	Atlanta State :	GA Zipcode :	30309 		 Secondary Emergency Contact Relation :	Mother First Name :	Julia Last Name :	Williams Home Phone :	404-555-1212 Email :	julia@email.com Address1 :	1050 Peachtree Street Address2 :	Unit 56 City :	Atlanta State :	GA Zipcode :	30309 		 Medical Information 		 Gen', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 15:05:36', '70', 0, 'S', 0, 'modem1'),
(5, 'O', '01719845856', 'Personal Information Student Name:	Williams, Bob', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 17:25:15', '0', 0, 'S', 5, 'mysmpp'),
(6, 'O', '01719845856', 'This is network SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 17:54:44', '0', 0, 'S', 0, 'mysmpp2'),
(7, 'O', '01719845856', 'This is network Zaman SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 18:00:14', '1', 0, 'S', 0, 'mysmpp2'),
(8, 'O', '01719845856', 'This is network Taposh Pavel Zaman SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 18:16:15', '0', 0, 'S', 0, 'mysmpp2'),
(9, 'O', '01719845856', 'This is network Kanak Taposh Pavel Zaman SMPP TEST', NULL, NULL, NULL, '0000-00-00 00:00:00', ' ', '7', 1, 0, -1, -1, '2013-12-12 18:24:42', '0', 0, 'S', 0, 'mysmpp2');

-- --------------------------------------------------------

--
-- Table structure for table `smsserver_parallel_out`
--

CREATE TABLE IF NOT EXISTS `smsserver_parallel_out` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `process` int(11) NOT NULL,
  `originator` varchar(16) NOT NULL,
  `type` varchar(1) NOT NULL,
  `encoding` char(1) NOT NULL,
  `message_date` datetime NOT NULL,
  `receive_date` datetime NOT NULL,
  `text` varchar(1000) NOT NULL,
  `original_ref_no` varchar(64) DEFAULT NULL,
  `original_receive_date` datetime DEFAULT NULL,
  `gateway_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `smsserver_parallel_out`
--

INSERT INTO `smsserver_parallel_out` (`id`, `process`, `originator`, `type`, `encoding`, `message_date`, `receive_date`, `text`, `original_ref_no`, `original_receive_date`, `gateway_id`) VALUES
(9, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:43:02', 'The new theme song of Robi in GoonGoon! ''Chotto Ekta Kaj'' gaan ti pete', NULL, NULL, 'modem1'),
(10, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:43:02', ' dial korun*140*1*95#.Monthly Fee:15tk, Gaan download: 15Tk, 15% VAT a', NULL, NULL, 'modem1'),
(11, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:43:02', 'pply', NULL, NULL, 'modem1'),
(12, 0, '21228', 'I', '7', '2013-07-08 00:54:04', '2013-12-03 22:43:02', 'Ruling Awami League loses crucial mayor election. To know more please dial *140*66# Condition Apply', NULL, NULL, 'modem1'),
(13, 0, '8383', 'I', '7', '2013-09-30 22:03:32', '2013-12-03 22:43:02', '207:Transaction number R131001.1103.160167 to recharge 30 Tk from 1837436975 is successful and valid till 31/10/13. Dial *8444*71# for 71MB at Tk26.', NULL, NULL, 'modem1'),
(14, 0, 'Robi', 'I', '7', '2013-09-30 22:03:46', '2013-12-03 22:43:02', 'Dear User,you have got 20 Items free MMS,valid till 07/10/2013.Dear User,you have got 20MB Internet Pack,valid till 07/10/2013.', NULL, NULL, 'modem1'),
(15, 0, 'Robi', 'I', '7', '2013-09-30 22:03:46', '2013-12-03 22:43:02', 'Dear valued customer,The fee for 20MB Data Pack you purchased is TK 23.00(including VAT).', NULL, NULL, 'modem1'),
(16, 0, '8383', 'I', '7', '2013-10-03 05:54:56', '2013-12-03 22:43:02', '207:Transaction number R131003.1854.250577 to recharge 120 Tk from 1837436975 is successful and valid till 02/12/13. Dial *8444*71# for 71MB at Tk26.', NULL, NULL, 'modem1'),
(17, 0, 'Robi', 'I', '7', '2013-10-03 05:56:49', '2013-12-03 22:43:02', 'Dear User,you have got 00:30:00 free minute,valid till 09/10/2013.Dear User,you have got 100MB Internet Pack,valid till 01/11/2013.', NULL, NULL, 'modem1'),
(18, 0, 'Robi', 'I', '7', '2013-10-03 05:56:49', '2013-12-03 22:43:02', 'Dear valued customer,The fee for 100MB Data Pack you purchased is TK 115.00(including VAT).', NULL, NULL, 'modem1'),
(19, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:47:54', 'The new theme song of Robi in GoonGoon! ''Chotto Ekta Kaj'' gaan ti pete', NULL, NULL, 'modem1'),
(20, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:47:54', ' dial korun*140*1*95#.Monthly Fee:15tk, Gaan download: 15Tk, 15% VAT a', NULL, NULL, 'modem1'),
(21, 0, 'Robi', 'I', 'U', '2013-07-02 09:18:55', '2013-12-03 22:47:54', 'pply', NULL, NULL, 'modem1'),
(22, 0, '21228', 'I', '7', '2013-07-08 00:54:04', '2013-12-03 22:47:54', 'Ruling Awami League loses crucial mayor election. To know more please dial *140*66# Condition Apply', NULL, NULL, 'modem1'),
(23, 0, '8383', 'I', '7', '2013-09-30 22:03:32', '2013-12-03 22:47:54', '207:Transaction number R131001.1103.160167 to recharge 30 Tk from 1837436975 is successful and valid till 31/10/13. Dial *8444*71# for 71MB at Tk26.', NULL, NULL, 'modem1'),
(24, 0, 'Robi', 'I', '7', '2013-09-30 22:03:46', '2013-12-03 22:47:54', 'Dear User,you have got 20 Items free MMS,valid till 07/10/2013.Dear User,you have got 20MB Internet Pack,valid till 07/10/2013.', NULL, NULL, 'modem1'),
(25, 0, 'Robi', 'I', '7', '2013-09-30 22:03:46', '2013-12-03 22:47:54', 'Dear valued customer,The fee for 20MB Data Pack you purchased is TK 23.00(including VAT).', NULL, NULL, 'modem1'),
(26, 0, '8383', 'I', '7', '2013-10-03 05:54:56', '2013-12-03 22:47:54', '207:Transaction number R131003.1854.250577 to recharge 120 Tk from 1837436975 is successful and valid till 02/12/13. Dial *8444*71# for 71MB at Tk26.', NULL, NULL, 'modem1'),
(27, 0, 'Robi', 'I', '7', '2013-10-03 05:56:49', '2013-12-03 22:47:54', 'Dear User,you have got 00:30:00 free minute,valid till 09/10/2013.Dear User,you have got 100MB Internet Pack,valid till 01/11/2013.', NULL, NULL, 'modem1'),
(28, 0, 'Robi', 'I', '7', '2013-10-03 05:56:49', '2013-12-03 22:47:54', 'Dear valued customer,The fee for 100MB Data Pack you purchased is TK 115.00(including VAT).', NULL, NULL, 'modem1'),
(29, 0, '8801719845856', 'I', '7', '2013-12-03 08:51:51', '2013-12-03 22:57:58', 'This is for testing message.', NULL, NULL, 'modem1'),
(30, 0, '8801719845856', 'S', '7', '2013-12-03 21:15:35', '2013-12-04 22:42:38', '00 - Succesful Delivery.', '37', '2013-12-03 21:15:40', 'modem1'),
(31, 0, '8801719845856', 'S', '7', '2013-12-03 21:16:30', '2013-12-04 22:42:38', '00 - Succesful Delivery.', '38', '2013-12-03 21:16:35', 'modem1'),
(32, 0, '8801719845856', 'S', '7', '2013-12-03 21:17:37', '2013-12-04 22:42:38', '00 - Succesful Delivery.', '39', '2013-12-03 21:17:42', 'modem1'),
(33, 0, '8801719845856', 'S', '7', '2013-12-03 21:18:45', '2013-12-04 22:42:38', '00 - Succesful Delivery.', '40', '2013-12-03 21:18:50', 'modem1'),
(34, 0, 'Robi', 'I', '7', '2013-12-04 02:28:57', '2013-12-04 22:42:38', 'Dial *8444*100# and enjoy 100 MB internet only BDT60. Validity 15 days. To know more Data packs dial *8444# ( toll free).', NULL, NULL, 'modem1'),
(35, 0, 'Robi', 'I', '7', '2013-12-06 02:54:29', '2013-12-11 12:03:09', 'Jekono Biroktikor call bondho korar jonno Robi Call Block service babohar korun. Matro 25 takay 30 diner jonno service ti chalu korte dial korun *818*1*1#', NULL, NULL, 'modem1'),
(36, 0, '8801789421751', 'I', '7', '2013-12-06 23:09:50', '2013-12-11 12:03:09', 'This is a test', NULL, NULL, 'modem1'),
(37, 0, 'Robi', 'I', '7', '2013-12-09 02:24:40', '2013-12-11 12:03:09', 'Robi Local Express niye elo Latest Nokia Lumia 1020 smartphone jite nebar shujog. Dial korun 2001 r ongsho nin mojar ei protijogitay. Fee projojjo', NULL, NULL, 'modem1'),
(38, 0, 'Robi', 'I', '7', '2013-12-09 03:20:22', '2013-12-11 12:03:09', 'Robi Local Express niye elo Latest Nokia Lumia 1020 smartphone jite nebar shujog. Dial korun 2001 r ongsho nin mojar ei protijogitay. Fee projojjo', NULL, NULL, 'modem1'),
(39, 0, '8801719845856', 'I', '7', '2013-12-10 08:52:34', '2013-12-11 12:03:09', 'Test 10.', NULL, NULL, 'modem1'),
(40, 0, '8801719845856', 'S', '7', '2013-12-10 22:03:45', '2013-12-11 12:13:10', '00 - Succesful Delivery.', '42', '2013-12-10 22:03:51', 'modem1'),
(41, 0, 'Robi', 'I', '7', '2013-12-11 20:16:23', '2013-12-12 11:07:13', '143 minute Bijoy BONUS! Nov theke Dec-e TK71 beshi babohar-e January-te BONUS paben. Free Register korte dial *140*16#. Dec-er babohar jante free dial *444*71#', NULL, NULL, 'modem1'),
(42, 0, 'Robi', 'I', '7', '2013-12-24 13:01:20', '2013-12-24 21:35:54', 'Dial *8444*20# Upobhog korun 20MB Internet @ 20Tk Only, Mead 7 Din. Download Korun FREE DHOOM-3 Mp3 Songs at  http://m.mp3clan.com/mp3/dhoom_3.html', NULL, NULL, 'modem1'),
(43, 0, 'Robi', 'I', '7', '2013-12-24 13:01:20', '2013-12-24 21:39:54', 'Dial *8444*20# Upobhog korun 20MB Internet @ 20Tk Only, Mead 7 Din. Download Korun FREE DHOOM-3 Mp3 Songs at  http://m.mp3clan.com/mp3/dhoom_3.html', NULL, NULL, 'modem1'),
(44, 0, 'Robi', 'I', '7', '2013-12-24 13:01:20', '2013-12-24 21:47:25', 'Dial *8444*20# Upobhog korun 20MB Internet @ 20Tk Only, Mead 7 Din. Download Korun FREE DHOOM-3 Mp3 Songs at  http://m.mp3clan.com/mp3/dhoom_3.html', NULL, NULL, 'modem1'),
(45, 0, 'Robi', 'I', '7', '2013-12-24 13:01:20', '2013-12-24 21:48:44', 'Dial *8444*20# Upobhog korun 20MB Internet @ 20Tk Only, Mead 7 Din. Download Korun FREE DHOOM-3 Mp3 Songs at  http://m.mp3clan.com/mp3/dhoom_3.html', NULL, NULL, 'modem1'),
(46, 0, 'Robi', 'I', '7', '2013-12-24 13:01:20', '2013-12-24 21:59:05', 'Dial *8444*20# Upobhog korun 20MB Internet @ 20Tk Only, Mead 7 Din. Download Korun FREE DHOOM-3 Mp3 Songs at  http://m.mp3clan.com/mp3/dhoom_3.html', NULL, NULL, 'modem1'),
(47, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2014-01-04 19:19:05', 'Room1 all on', NULL, NULL, 'modem1'),
(48, 0, '8801789421751', 'I', '7', '2013-12-24 22:51:45', '2014-01-04 19:24:13', 'Room1 all on', NULL, NULL, 'modem1'),
(49, 0, '8801789421751', 'I', '7', '2014-01-05 20:43:05', '2014-01-05 20:53:24', 'Room1 all on', NULL, NULL, 'modem1'),
(50, 0, '8801789421751', 'I', '7', '2014-01-05 20:43:05', '2014-01-05 21:00:20', 'Room1 all on', NULL, NULL, 'modem1'),
(51, 0, '8801789421751', 'I', '7', '2014-01-05 20:43:05', '2014-01-05 21:09:42', 'Room1 all on', NULL, NULL, 'modem1'),
(52, 0, '8801789421751', 'I', '7', '2014-01-05 20:43:05', '2014-01-05 21:11:04', 'Room1 all on', NULL, NULL, 'modem1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `smsserver_parallel_device_configuration`
--
ALTER TABLE `smsserver_parallel_device_configuration`
  ADD CONSTRAINT `smsserver_parallel_device_configuration_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `building` (`id`),
  ADD CONSTRAINT `smsserver_parallel_device_configuration_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`),
  ADD CONSTRAINT `smsserver_parallel_device_configuration_ibfk_3` FOREIGN KEY (`lpt_comm_device_id`) REFERENCES `device` (`id`);


CREATE TABLE IF NOT EXISTS `smsserver_parallel_controls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building_id` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL,
  `flat_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `lpt_comm_device_id` int(11) NOT NULL,
  `equipment1_id` int(11) NOT NULL,
  `equipment2_id` int(11) NOT NULL,
  `equipment3_id` int(11) NOT NULL,
  `equipment4_id` int(11) NOT NULL,
  `equipment5_id` int(11) NOT NULL,
  `equipment6_id` int(11) NOT NULL,
  `equipment7_id` int(11) NOT NULL,
  `equipment8_id` int(11) NOT NULL,
  `command_name` varchar(6),
  `started_since` datetime,
  `start_time` datetime,
  `stop_time` datetime,
  PRIMARY KEY (`id`),
  KEY `lpt_comm_device_id` (`lpt_comm_device_id`),
  KEY `building_id` (`building_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
