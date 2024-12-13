-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-10-2024 a las 19:25:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: pt05_luis_sanchez
--
DROP DATABASE IF EXISTS pt05_luis_sanchez;
CREATE DATABASE IF NOT EXISTS pt05_luis_sanchez DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE pt05_luis_sanchez;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla animales
--

DROP TABLE IF EXISTS animales;
CREATE TABLE animales (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre_comun varchar(55) NOT NULL, 
  nombre_cientifico varchar(55) NOT NULL, 
  descripcion text NOT NULL, 
  ruta_imagen varchar(255) DEFAULT NULL,
  usuario_id int(11) DEFAULT NULL,
  fecha_insercion TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha de inserción
  es_mamifero BOOLEAN NOT NULL, -- 1 para mamíferos, 0 para ovíparos
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla animales
--
INSERT INTO animales (id, nombre_comun, nombre_cientifico, descripcion, ruta_imagen, usuario_id, fecha_insercion, es_mamifero) VALUES
(1, 'León', 'Panthera leo', 'El león es conocido como el rey de la selva.', 'imagenes/imagenes/leon.jpg', 1, '2024-10-28 15:02:47', 1),
(3, 'Águila Calva', 'Haliaeetus leucocephalus', 'El águila calva es el símbolo nacional de los Estados Unidos.', 'imagenes/imagenes/aguila_calva.jpg', 3, '2024-10-28 15:02:47', 0),
(4, 'Oso Polar', 'Ursus maritimus', 'El oso polar vive en el Ártico y es un mamífero carnívoro.', 'imagenes/imagenes/oso_polar.jpg', 1, '2024-10-28 15:02:47', 1),
(5, 'Pingüino Emperador', 'Aptenodytes forsteri', 'El pingüino emperador habita en la Antártida y es ovíparo.', 'imagenes/imagenes/pinguino.jpg', 1, '2024-10-28 15:02:47', 0),
(6, 'Elefante Africano', 'Loxodonta africana', 'El elefante africano es el mamífero terrestre más grande.', 'imagenes/imagenes/elefante.jpg', 3, '2024-10-28 15:02:47', 1),
(8, 'Canguro Rojo', 'Macropus rufus', 'El canguro rojo es el marsupial más grande del mundo.', 'imagenes/imagenes/canguro.jpg', 7, '2024-10-28 15:02:47', 1),
(9, 'Pato Mallard', 'Anas platyrhynchos', 'El pato mallard es un ave acuática común en el hemisferio norte.', 'imagenes/imagenes/pato.jpg', 7, '2024-10-28 15:02:47', 0),
(10, 'Gorila de Montaña', 'Gorilla beringei beringei', 'El gorila de montaña es un primate mamífero que vive en África.', 'imagenes/imagenes/gorila.jpg', 7, '2024-10-28 15:02:47', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla usuarios
--

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre_usuario varchar(50) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY nombre_usuario (nombre_usuario),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla usuarios
--

INSERT INTO usuarios (id, nombre_usuario, email, password) VALUES
(1, 'luis', '1234@1234.com', '$2y$10$ouqONxD/UE.YV3twy/yVYudLM/PpdyeWWFDFbZ7sH1n3R/cEPTdhO'),
(7, '1234', '12@12.com', '$2y$10$ouqONxD/UE.YV3twy/yVYudLM/PpdyeWWFDFbZ7sH1n3R/cEPTdhO'),
(3, 'pepe', '123@123.com', '$2y$10$ouqONxD/UE.YV3twy/yVYudLM/PpdyeWWFDFbZ7sH1n3R/cEPTdhO'),
(4, 'admin', '1553@admin.com', '$2y$10$ouqONxD/UE.YV3twy/yVYudLM/PpdyeWWFDFbZ7sH1n3R/cEPTdhO'),
(0, 'anonymous', 'anonymous@example.com', '');



ALTER TABLE usuarios
ADD COLUMN token VARCHAR(255);

-- Agregar el campo 'nombre' (nombre real del usuario)
ALTER TABLE `usuarios`
ADD COLUMN `nombre` VARCHAR(100) NOT NULL AFTER `nombre_usuario`;

-- Agregar el campo 'apellido'
ALTER TABLE `usuarios`
ADD COLUMN `apellido` VARCHAR(100) NOT NULL AFTER `nombre`;

-- Agregar el campo 'avatar' para la imagen de perfil
ALTER TABLE `usuarios`
ADD COLUMN `avatar` VARCHAR(255) DEFAULT NULL AFTER `password`;

-- Asegurar que 'nombre_usuario' sea único
ALTER TABLE `usuarios`
ADD UNIQUE INDEX `idx_nombre_usuario` (`nombre_usuario`);

ALTER TABLE `usuarios`
ADD COLUMN `token_recuperacion` VARCHAR(64) DEFAULT NULL,
ADD COLUMN `expiracion_token` DATETIME DEFAULT NULL;


-- --------------------------------------------------------

-- 
-- Índices y claves foráneas para las tablas
--

-- Índices para la tabla animales

ALTER TABLE animales
  ADD KEY usuario_id (usuario_id);

-- Clave foránea para relacionar usuario_id en animales con id en usuarios
ALTER TABLE animales
  ADD CONSTRAINT animales_ibfk_1 FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE SET NULL;

-- AUTO_INCREMENT para las tablas
ALTER TABLE animales
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

ALTER TABLE usuarios
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;