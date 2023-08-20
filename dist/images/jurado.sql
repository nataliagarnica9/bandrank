-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-08-2023 a las 03:25:59
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bandrank`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jurado`
--

CREATE TABLE `jurado` (
  `id` int(11) NOT NULL,
  `documento_identificacion` varchar(30) NOT NULL,
  `nombres` varchar(120) NOT NULL,
  `apellidos` varchar(120) NOT NULL,
  `celular` int(11) DEFAULT NULL,
  `correo` varchar(150) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `id_concurso` int(11) NOT NULL,
  `firma` varchar(255) DEFAULT NULL COMMENT 'Nombre del archivo imagen de la firma'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `jurado`
--

INSERT INTO `jurado` (`id`, `documento_identificacion`, `nombres`, `apellidos`, `celular`, `correo`, `fecha_registro`, `id_concurso`, `firma`) VALUES
(1, '34434', 'natalia', 'eee', 4343, 'natagarge@htomi.com', '2023-07-10 11:48:57', 0, NULL),
(2, '20390934', 'Agua', 'Arena', 4930954, 'aguareanq@mar.com', '2023-07-10 12:02:31', 0, NULL),
(3, '3', 'e', 'e', 4, 'aguareanq@mar.com', '2023-07-10 12:03:47', 0, NULL),
(4, '43434', 'ww', 'w', 34345354, 'w@e.co', '2023-08-12 21:02:04', 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `jurado`
--
ALTER TABLE `jurado`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `jurado`
--
ALTER TABLE `jurado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
