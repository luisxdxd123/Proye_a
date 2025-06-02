-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2025 a las 03:29:07
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
-- Base de datos: `proye_a`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` enum('masculino','femenino','otro') NOT NULL,
  `genero_personalizado` varchar(50) DEFAULT NULL,
  `contacto` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol_user` enum('ciudadano','admin','departamentos') NOT NULL DEFAULT 'ciudadano',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `fecha_nacimiento`, `genero`, `genero_personalizado`, `contacto`, `contrasena`, `rol_user`, `fecha_registro`) VALUES
(5, 'admin', 'admin', '2025-05-01', 'masculino', NULL, 'admin@gmail.com', '123456', 'admin', '2025-05-29 17:34:53'),
(6, 'departamento1', 'departamento1', '2025-05-08', 'masculino', NULL, 'departamento1@gmail.com', '123456', 'departamentos', '2025-05-29 17:36:39'),
(7, 'Luis', 'Tellez', '2004-12-01', 'masculino', NULL, 'luis@gmail.com', '$2y$12$8YCAsOofPCLBxrZN.qdeZengkQQsnLv7R2N1KfY4A/9zMpT6SRn1.', 'ciudadano', '2025-05-29 17:45:28'),
(8, 'Shaila', 'Vite', '2000-10-10', 'otro', 'Binarie', 'shai@gmail.com', '$2y$12$0ux3lLY043n5kKosRkf.Nu.XfxG2CGIWzi3M7Fop5M.3ZmTTDTAMG', 'ciudadano', '2025-06-02 01:28:27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
