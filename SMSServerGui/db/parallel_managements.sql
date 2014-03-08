-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 18, 2014 at 12:49 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `parallelport`
--

-- --------------------------------------------------------

--
-- Structure for view `parallel_comm_port_view`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `parallel_managements` AS select `spcdc`.`id` AS `id`,`spcdc`.`id` AS `record_number`,`spcdc`.`building_id` AS `building_id`,`bld`.`name` AS `building_name`,`spcdc`.`floor_id` AS `floor_id`,`flr`.`name` AS `floor_name`,`spcdc`.`flat_id` AS `flat_id`,`flt`.`name` AS `flat_name`,`spcdc`.`room_id` AS `room_id`,`rom`.`name` AS `room_name`,`spcdc`.`host_id` AS `host_id`,`hst`.`address` AS `host_address`,`hst`.`name` AS `host_name`,`spcdc`.`device_id` AS `device_id`,`dvc`.`name` AS `device_name`,`dvc`.`address` AS `device_address`,`spcdc`.`equipment1_id` AS `equipment1_id`,`eqpmt`.`name` AS `equipment_name1`,`spcdc`.`equipment2_id` AS `equipment2_id`,`eqpmt1`.`name` AS `equipment_name2`,`spcdc`.`equipment3_id` AS `equipment3_id`,`eqpmt2`.`name` AS `equipment_name3`,`spcdc`.`equipment4_id` AS `equipment4_id`,`eqpmt3`.`name` AS `equipment_name4`,`spcdc`.`equipment5_id` AS `equipment5_id`,`eqpmt4`.`name` AS `equipment_name5`,`spcdc`.`equipment6_id` AS `equipment6_id`,`eqpmt5`.`name` AS `equipment_name6`,`spcdc`.`equipment7_id` AS `equipment7_id`,`eqpmt6`.`name` AS `equipment_name7`,`spcdc`.`equipment8_id` AS `equipment8_id`,`eqpmt7`.`name` AS `equipment_name8` from ((((((((((((((`parallel_configurations` `spcdc` join `buildings` `bld`) join `floors` `flr`) join `flats` `flt`) join `rooms` `rom`) join `hosts` `hst`) join `devices` `dvc`) join `equipments` `eqpmt`) join `equipments` `eqpmt1`) join `equipments` `eqpmt2`) join `equipments` `eqpmt3`) join `equipments` `eqpmt4`) join `equipments` `eqpmt5`) join `equipments` `eqpmt6`) join `equipments` `eqpmt7`) where ((`spcdc`.`building_id` = `bld`.`id`) and (`spcdc`.`floor_id` = `flr`.`id`) and (`spcdc`.`flat_id` = `flt`.`id`) and (`spcdc`.`room_id` = `rom`.`id`) and (`spcdc`.`host_id` = `hst`.`id`) and (`spcdc`.`device_id` = `dvc`.`id`) and (`spcdc`.`equipment1_id` = `eqpmt`.`id`) and (`spcdc`.`equipment2_id` = `eqpmt1`.`id`) and (`spcdc`.`equipment3_id` = `eqpmt2`.`id`) and (`spcdc`.`equipment4_id` = `eqpmt3`.`id`) and (`spcdc`.`equipment5_id` = `eqpmt4`.`id`) and (`spcdc`.`equipment6_id` = `eqpmt5`.`id`) and (`spcdc`.`equipment7_id` = `eqpmt6`.`id`) and (`spcdc`.`equipment8_id` = `eqpmt7`.`id`));

--
-- VIEW  `parallel_managements`
-- Data: None
--

