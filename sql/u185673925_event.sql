-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-11-2014 a las 04:53:23
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `u185673925_event`
--
CREATE DATABASE IF NOT EXISTS `u185673925_event` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `u185673925_event`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ALERT`
--

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
-- Estructura de tabla para la tabla `AREA`
--

CREATE TABLE IF NOT EXISTS `AREA` (
`id` int(11) NOT NULL,
  `description` varchar(300) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMMENT`
--

CREATE TABLE IF NOT EXISTS `COMMENT` (
`id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `idCommentStatus` int(11) NOT NULL DEFAULT '1',
  `idEvent` int(11) NOT NULL,
  `eventFromApi` int(1) NOT NULL DEFAULT '1',
  `stars` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMMENT_STATUS`
--

CREATE TABLE IF NOT EXISTS `COMMENT_STATUS` (
  `id` int(11) NOT NULL,
  `description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `COMMENT_STATUS`
--

INSERT INTO `COMMENT_STATUS` (`id`, `description`) VALUES
(1, 'Pendiente Aprobación'),
(2, 'Aprobado'),
(3, 'Denunciado'),
(4, 'Eliminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EVENT`
--

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
-- Estructura de tabla para la tabla `EVENT_API`
--

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
-- Estructura de tabla para la tabla `FAVORITE_EVENT_USER`
--

CREATE TABLE IF NOT EXISTS `FAVORITE_EVENT_USER` (
`id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `eventFromApi` int(1) NOT NULL DEFAULT '1' COMMENT '1: idEvent is from EVENT_API / 2: idEvent is from EVENT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SUBAREA`
--

CREATE TABLE IF NOT EXISTS `SUBAREA` (
`id` int(11) NOT NULL,
  `description` varchar(100) CHARACTER SET utf8 NOT NULL,
  `id_area` int(11) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USER`
--

CREATE TABLE IF NOT EXISTS `USER` (
`id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `id_user_type` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Volcado de datos para la tabla `USER`
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
-- Estructura de tabla para la tabla `USER_TYPE`
--

CREATE TABLE IF NOT EXISTS `USER_TYPE` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `USER_TYPE`
--

INSERT INTO `USER_TYPE` (`id`, `description`) VALUES
(1, 'Administrador'),
(2, 'Publicador'),
(3, 'Usuario General');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ALERT`
--
ALTER TABLE `ALERT`
 ADD PRIMARY KEY (`id`), ADD KEY `id_user` (`id_user`,`id_subarea`);

--
-- Indices de la tabla `AREA`
--
ALTER TABLE `AREA`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `COMMENT`
--
ALTER TABLE `COMMENT`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `COMMENT_STATUS`
--
ALTER TABLE `COMMENT_STATUS`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `EVENT`
--
ALTER TABLE `EVENT`
 ADD PRIMARY KEY (`Id`), ADD UNIQUE KEY `Id_2` (`Id`), ADD UNIQUE KEY `IdEvento` (`IdEvento`), ADD KEY `Id` (`Id`), ADD KEY `IdEvento_2` (`IdEvento`);

--
-- Indices de la tabla `EVENT_API`
--
ALTER TABLE `EVENT_API`
 ADD PRIMARY KEY (`IdEvento`), ADD UNIQUE KEY `IdEvento` (`IdEvento`), ADD KEY `IdEvento_2` (`IdEvento`);

--
-- Indices de la tabla `FAVORITE_EVENT_USER`
--
ALTER TABLE `FAVORITE_EVENT_USER`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `SUBAREA`
--
ALTER TABLE `SUBAREA`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `USER`
--
ALTER TABLE `USER`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `EMAIL` (`email`), ADD KEY `id_user_type` (`id_user_type`);

--
-- Indices de la tabla `USER_TYPE`
--
ALTER TABLE `USER_TYPE`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ALERT`
--
ALTER TABLE `ALERT`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `AREA`
--
ALTER TABLE `AREA`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `COMMENT`
--
ALTER TABLE `COMMENT`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `EVENT`
--
ALTER TABLE `EVENT`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `FAVORITE_EVENT_USER`
--
ALTER TABLE `FAVORITE_EVENT_USER`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `SUBAREA`
--
ALTER TABLE `SUBAREA`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `USER`
--
ALTER TABLE `USER`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
