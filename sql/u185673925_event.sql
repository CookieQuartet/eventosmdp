-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 04, 2014 at 02:00 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `u185673925_event`
--
CREATE DATABASE IF NOT EXISTS `u185673925_event` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `u185673925_event`;

-- --------------------------------------------------------

--
-- Table structure for table `ALERT`
--

DROP TABLE IF EXISTS `ALERT`;
CREATE TABLE IF NOT EXISTS `ALERT` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_area` int(11) DEFAULT NULL,
  `id_subarea` int(11) DEFAULT NULL,
  `keyword` varchar(100) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `AREA`
--

DROP TABLE IF EXISTS `AREA`;
CREATE TABLE IF NOT EXISTS `AREA` (
`id` int(11) NOT NULL,
  `description` varchar(300) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `COMMENT`
--

DROP TABLE IF EXISTS `COMMENT`;
CREATE TABLE IF NOT EXISTS `COMMENT` (
`id` int(11) NOT NULL,
  `text` varchar(300) NOT NULL,
  `id_status_comment` int(11) NOT NULL DEFAULT '1',
  `id_event` int(11) NOT NULL,
  `stars` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `EVENT`
--

DROP TABLE IF EXISTS `EVENT`;
CREATE TABLE IF NOT EXISTS `EVENT` (
`Id` int(11) NOT NULL,
  `IdUser` int(11) DEFAULT NULL,
  `Active` int(1) NOT NULL DEFAULT '1',
  `Altura` varchar(100) DEFAULT NULL,
  `Calle` varchar(300) DEFAULT NULL,
  `DescripcionCalendario` varchar(3000) DEFAULT NULL,
  `DescripcionEvento` varchar(3000) DEFAULT NULL,
  `Destacado` int(1) DEFAULT NULL,
  `DetalleTexto` varchar(3000) DEFAULT NULL,
  `DireccionEvento` varchar(500) DEFAULT NULL,
  `FechaHoraFin` varchar(500) DEFAULT NULL,
  `FechaHoraInicio` varchar(500) DEFAULT NULL,
  `Frecuencia` varchar(300) DEFAULT NULL,
  `IdArea` int(11) NOT NULL,
  `IdCalendario` int(11) NOT NULL,
  `IdEvento` int(11) NOT NULL,
  `IdSubarea` int(11) NOT NULL,
  `Latitud` varchar(500) DEFAULT NULL,
  `Longitud` varchar(500) DEFAULT NULL,
  `Lugar` varchar(500) DEFAULT NULL,
  `NombreArea` varchar(500) NOT NULL,
  `NombreCalendario` varchar(500) NOT NULL,
  `NombreEvento` varchar(500) NOT NULL,
  `NombreSubAreaFormat` varchar(500) NOT NULL,
  `NombreSubarea` varchar(500) NOT NULL,
  `Precio` decimal(10,0) DEFAULT NULL,
  `Repetir` varchar(500) DEFAULT NULL,
  `RutaImagen` varchar(2000) DEFAULT NULL,
  `RutaImagenMiniatura` varchar(2000) DEFAULT NULL,
  `TodoDia` int(1) DEFAULT NULL,
  `ZonaHoraria` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `EVENT-not-used`
--

DROP TABLE IF EXISTS `EVENT-not-used`;
CREATE TABLE IF NOT EXISTS `EVENT-not-used` (
`id` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(3000) NOT NULL,
  `description_short` varchar(1000) NOT NULL,
  `name_place` varchar(100) NOT NULL,
  `address_place` varchar(300) DEFAULT NULL,
  `price` decimal(30,0) DEFAULT NULL,
  `frecuency` varchar(100) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `repeat_event` varchar(100) NOT NULL,
  `all_day` int(11) NOT NULL DEFAULT '0',
  `image_url` varchar(500) DEFAULT NULL,
  `image_url_small` varchar(500) DEFAULT NULL,
  `id_area` int(11) NOT NULL,
  `id_subarea` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `EVENT_API`
--

DROP TABLE IF EXISTS `EVENT_API`;
CREATE TABLE IF NOT EXISTS `EVENT_API` (
  `Altura` varchar(100) NOT NULL,
  `Calle` varchar(300) NOT NULL,
  `DescripcionCalendario` varchar(3000) NOT NULL,
  `DescripcionEvento` varchar(3000) NOT NULL,
  `Destacado` int(1) NOT NULL,
  `DetalleTexto` varchar(3000) NOT NULL,
  `DireccionEvento` varchar(500) NOT NULL,
  `FechaHoraFin` varchar(500) NOT NULL,
  `FechaHoraInicio` varchar(500) NOT NULL,
  `Frecuencia` varchar(300) NOT NULL,
  `IdArea` int(11) NOT NULL,
  `IdCalendario` int(11) NOT NULL,
  `IdEvento` int(11) NOT NULL,
  `IdSubarea` int(11) NOT NULL,
  `Latitud` varchar(500) NOT NULL,
  `Longitud` varchar(500) NOT NULL,
  `Lugar` varchar(500) NOT NULL,
  `NombreArea` varchar(500) NOT NULL,
  `NombreCalendario` varchar(500) NOT NULL,
  `NombreEvento` varchar(500) NOT NULL,
  `NombreSubAreaFormat` varchar(500) NOT NULL,
  `NombreSubarea` varchar(500) NOT NULL,
  `Precio` decimal(10,0) NOT NULL,
  `Repetir` varchar(500) NOT NULL,
  `RutaImagen` varchar(2000) NOT NULL,
  `RutaImagenMiniatura` varchar(2000) NOT NULL,
  `TodoDia` int(1) NOT NULL,
  `ZonaHoraria` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `STATUS_COMMENT`
--

DROP TABLE IF EXISTS `STATUS_COMMENT`;
CREATE TABLE IF NOT EXISTS `STATUS_COMMENT` (
  `id` int(11) NOT NULL,
  `description` varchar(30) NOT NULL
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

DROP TABLE IF EXISTS `SUBAREA`;
CREATE TABLE IF NOT EXISTS `SUBAREA` (
`id` int(11) NOT NULL,
  `description` varchar(100) CHARACTER SET utf8 NOT NULL,
  `id_area` int(11) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

DROP TABLE IF EXISTS `USER`;
CREATE TABLE IF NOT EXISTS `USER` (
`id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `id_user_type` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`id`, `name`, `email`, `password`, `id_user_type`, `active`) VALUES
(1, 'Martin', 'mmaestri@gmail.com', '123456', 2, 1),
(19, 'usuario@mail.com', 'usuario@mail.com', '123456', 2, 1),
(39, 'user@mail.com', 'user@mail.com', '123456', 2, 1),
(40, 'otro@mail.com', 'otro@mail.com', '123456', 2, 1),
(41, 'pablo@gmail.com', 'pablo@gmail.com', '1234', 2, 1),
(42, 'martin@gmail.com', 'martin@gmail.com', '1234', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `USER_TYPE`
--

DROP TABLE IF EXISTS `USER_TYPE`;
CREATE TABLE IF NOT EXISTS `USER_TYPE` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `USER_TYPE`
--

INSERT INTO `USER_TYPE` (`id`, `description`) VALUES
(1, 'Administrador'),
(2, 'Publicador'),
(3, 'Usuario General');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ALERT`
--
ALTER TABLE `ALERT`
 ADD PRIMARY KEY (`id`), ADD KEY `id_user` (`id_user`,`id_subarea`);

--
-- Indexes for table `AREA`
--
ALTER TABLE `AREA`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `COMMENT`
--
ALTER TABLE `COMMENT`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `EVENT`
--
ALTER TABLE `EVENT`
 ADD PRIMARY KEY (`Id`), ADD UNIQUE KEY `Id_2` (`Id`), ADD UNIQUE KEY `IdEvento` (`IdEvento`), ADD KEY `Id` (`Id`), ADD KEY `IdEvento_2` (`IdEvento`);

--
-- Indexes for table `EVENT-not-used`
--
ALTER TABLE `EVENT-not-used`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_event` (`id_event`), ADD KEY `id_area` (`id_area`,`id_subarea`), ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `STATUS_COMMENT`
--
ALTER TABLE `STATUS_COMMENT`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `SUBAREA`
--
ALTER TABLE `SUBAREA`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `EMAIL` (`email`), ADD KEY `id_user_type` (`id_user_type`);

--
-- Indexes for table `USER_TYPE`
--
ALTER TABLE `USER_TYPE`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ALERT`
--
ALTER TABLE `ALERT`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `AREA`
--
ALTER TABLE `AREA`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `COMMENT`
--
ALTER TABLE `COMMENT`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `EVENT`
--
ALTER TABLE `EVENT`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `EVENT-not-used`
--
ALTER TABLE `EVENT-not-used`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `SUBAREA`
--
ALTER TABLE `SUBAREA`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `USER`
--
ALTER TABLE `USER`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
