-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2014 at 02:32 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `EVENTOSMDP`
--
CREATE DATABASE IF NOT EXISTS `u185673925_event` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- USE `EVENTOSMDP`;

USE `u185673925_event`;
-- --------------------------------------------------------

--
-- Table structure for table `ALERT`
--

CREATE TABLE IF NOT EXISTS `ALERT` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_area` int(11) DEFAULT NULL,
  `is_subarea` int(11) DEFAULT NULL,
  `keyword` varchar(100) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`,`is_subarea`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `ALERT`:
--   `id_area`
--       `AREA` -> `id`
--   `id_user`
--       `USER` -> `id`
--   `is_subarea`
--       `SUBAREA` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `AREA`
--

CREATE TABLE IF NOT EXISTS `AREA` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(300) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `COMMENT`
--

CREATE TABLE IF NOT EXISTS `COMMENT` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(300) NOT NULL,
  `id_status_comment` int(11) NOT NULL DEFAULT '1',
  `id_event` int(11) NOT NULL,
  `stars` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `COMMENT`:
--   `id_event`
--       `EVENT` -> `id`
--   `id_status_comment`
--       `STATUS_COMMENT` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `EVENT`
--

CREATE TABLE IF NOT EXISTS `EVENT` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(3000) NOT NULL,
  `description_short` varchar(1000) DEFAULT NULL,
  `name_place` varchar(100) DEFAULT NULL,
  `address_place` varchar(300) DEFAULT NULL,
  `price` decimal(30,0) DEFAULT NULL,
  `frecuency` varchar(100) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `repeat` varchar(100) DEFAULT NULL,
  `all_day` int(1) NOT NULL DEFAULT '0',
  `image_url` varchar(500) DEFAULT NULL,
  `image_url_small` varchar(500) DEFAULT NULL,
  `id_area` int(11) NOT NULL,
  `id_subarea` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_event` (`id_event`),
  KEY `id_area` (`id_area`,`id_subarea`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `EVENT`:
--   `id_area`
--       `AREA` -> `id`
--   `id_subarea`
--       `SUBAREA` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `STATUS_COMMENT`
--

CREATE TABLE IF NOT EXISTS `STATUS_COMMENT` (
  `id` int(11) NOT NULL,
  `description` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `STATUS_COMMENT`
--

INSERT INTO `STATUS_COMMENT` (`id`, `description`) VALUES
(1, 'Pendiente Aprobación'),
(2, 'Aprobado'),
(3, 'Denunciado'),
(4, 'Eliminado');

-- --------------------------------------------------------

--
-- Table structure for table `SUBAREA`
--

CREATE TABLE IF NOT EXISTS `SUBAREA` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) CHARACTER SET utf8 NOT NULL,
  `id_area` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `SUBAREA`:
--   `id_area`
--       `AREA` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE IF NOT EXISTS `USER` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `id_user_type` int(11) NOT NULL,
  `fcbk_token` varchar(100) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `EMAIL` (`email`),
  UNIQUE KEY `FCBK_TOKEN` (`fcbk_token`),
  KEY `id_user_type` (`id_user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `USER`:
--   `id_user_type`
--       `USER_TYPE` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `USER_TYPE`
--

CREATE TABLE IF NOT EXISTS `USER_TYPE` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `USER_TYPE`
--

INSERT INTO `USER_TYPE` (`id`, `description`) VALUES
(1, 'Administrador'),
(2, 'Publicador'),
(3, 'Usuario General');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
