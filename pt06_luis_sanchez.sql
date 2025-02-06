-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-02-2025 a las 18:18:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pt06_luis_sanchez`
--
CREATE DATABASE IF NOT EXISTS `pt06_luis_sanchez` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pt06_luis_sanchez`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animales`
--

CREATE TABLE `animales` (
  `id` int(11) NOT NULL,
  `nombre_comun` varchar(55) NOT NULL,
  `nombre_cientifico` varchar(55) NOT NULL,
  `descripcion` text NOT NULL,
  `ruta_imagen` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_insercion` timestamp NOT NULL DEFAULT current_timestamp(),
  `es_mamifero` tinyint(1) NOT NULL,
  `publicado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `animales`
--

INSERT INTO `animales` (`id`, `nombre_comun`, `nombre_cientifico`, `descripcion`, `ruta_imagen`, `usuario_id`, `fecha_insercion`, `es_mamifero`, `publicado`) VALUES
(1, 'León', 'Panthera leo', 'El león es conocido como el rey de la selva.', 'vista/imagenes/imagenes/leon.jpg', 1, '2024-10-28 15:02:47', 1, 1),
(3, 'Águila Calva', 'Haliaeetus leucocephalus', 'El águila calva es el símbolo nacional de los Estados Unidos.', 'vista/imagenes/imagenes/aguila_calva.jpg', 3, '2024-10-28 15:02:47', 0, 1),
(4, 'Oso Polar', 'Ursus maritimus', 'El oso polar vive en el Ártico y es un mamífero carnívoro.', 'vista/imagenes/imagenes/oso_polar.jpg', 1, '2024-10-28 15:02:47', 1, 1),
(5, 'Pingüino Emperador', 'Aptenodytes forsteri', 'El pingüino emperador habita en la Antártida y es ovíparo.', 'vista/imagenes/imagenes/pinguino.jpg', 1, '2024-10-28 15:02:47', 0, 1),
(6, 'Elefante Africano', 'Loxodonta africana', 'El elefante africano es el mamífero terrestre más grande.', 'vista/imagenes/imagenes/elefante.jpg', 3, '2024-10-28 15:02:47', 1, 1),
(8, 'Canguro Rojo', 'Macropus rufus', 'El canguro rojo es el marsupial más grande del mundo.', 'vista/imagenes/imagenes/canguro.jpg', 7, '2024-10-28 15:02:47', 1, 1),
(9, 'Pato Mallard', 'Anas platyrhynchos', 'El pato mallard es un ave acuática común en el hemisferio norte.', 'vista/imagenes/imagenes/pato.jpg', 7, '2024-10-28 15:02:47', 0, 1),
(10, 'Gorila de Montaña', 'Gorilla beringei beringei', 'El gorila de montaña es un primate mamífero que vive en África.', 'vista/imagenes/imagenes/gorila.jpg', 7, '2024-10-28 15:02:47', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animales_copia`
--

CREATE TABLE `animales_copia` (
  `id` int(11) NOT NULL,
  `nombre_comun` varchar(55) NOT NULL,
  `nombre_cientifico` varchar(55) NOT NULL,
  `descripcion` text NOT NULL,
  `ruta_imagen` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_insercion` timestamp NULL DEFAULT current_timestamp(),
  `es_mamifero` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `animales_copia`
--

INSERT INTO `animales_copia` (`id`, `nombre_comun`, `nombre_cientifico`, `descripcion`, `ruta_imagen`, `usuario_id`, `fecha_insercion`, `es_mamifero`) VALUES
(15, 'Águila Calva', 'Haliaeetus leucocephalus', 'El águila calva es el símbolo nacional de los Estados Unidos.', 'vista/imagenes/imagenes/aguila_calva.jpg', 7, '2025-01-27 18:20:49', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_recuperacion` varchar(64) DEFAULT NULL,
  `expiracion_token` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `nombre`, `apellido`, `email`, `password`, `avatar`, `token`, `token_recuperacion`, `expiracion_token`) VALUES
(0, 'anonymous', '', '', 'anonymous@example.com', '', NULL, NULL, NULL, NULL),
(1, 'luis', '', '', 'luis010993@gmail.com', '$2y$10$ouqONxD/UE.YV3twy/yVYudLM/PpdyeWWFDFbZ7sH1n3R/cEPTdhO', NULL, NULL, NULL, NULL),
(3, 'pepe', '', '', '123@123.com', '$2y$10$ouqONxD/UE.YV3twy/yVYudLM/PpdyeWWFDFbZ7sH1n3R/cEPTdhO', NULL, NULL, NULL, NULL),
(4, 'admin', '', '', '1553@admin.com', '$2y$10$ouqONxD/UE.YV3twy/yVYudLM/PpdyeWWFDFbZ7sH1n3R/cEPTdhO', NULL, NULL, NULL, NULL),
(7, '1234', '', '', '12@12.com', '$2y$10$ouqONxD/UE.YV3twy/yVYudLM/PpdyeWWFDFbZ7sH1n3R/cEPTdhO', NULL, 'ccdceebb4574fe56cc55a5ded1719c6a946b7ccf0e1f06ed8b1d141993152e3c', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `animales`
--
ALTER TABLE `animales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `animales_copia`
--
ALTER TABLE `animales_copia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `idx_nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `animales`
--
ALTER TABLE `animales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `animales_copia`
--
ALTER TABLE `animales_copia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `animales`
--
ALTER TABLE `animales`
  ADD CONSTRAINT `animales_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `animales_copia`
--
ALTER TABLE `animales_copia`
  ADD CONSTRAINT `animales_copia_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
