-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2025 a las 18:03:05
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
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `contacto_secundario` varchar(100) DEFAULT NULL,
  `ine` varchar(255) NOT NULL,
  `curp` varchar(255) NOT NULL,
  `comprobante_domicilio` varchar(255) NOT NULL,
  `documento_adicional` varchar(255) DEFAULT NULL,
  `imagen_adicional` varchar(255) DEFAULT NULL,
  `estado` enum('pendiente','en_proceso','completada','rechazada') NOT NULL DEFAULT 'pendiente',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `usuario_id`, `descripcion`, `contacto_secundario`, `ine`, `curp`, `comprobante_domicilio`, `documento_adicional`, `imagen_adicional`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 7, 'Mi calle esta loca', '7122488502', '1748835179_ine_Oracle 19C Backup 1.pdf', '1748835179_curp_ISOIEC 9075.pdf', '1748835179_comprobante_domicilio_ISOIEC 9075.pdf', 'documento_683d10820b1e2.pdf', 'imagen_683d10820b5e3.jpeg', 'completada', '2025-06-02 02:46:26', '2025-06-02 15:45:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_enviadas`
--

CREATE TABLE `solicitudes_enviadas` (
  `id` int(11) NOT NULL,
  `solicitud_id` int(11) NOT NULL,
  `departamento_id` int(11) NOT NULL,
  `enviado_por` int(11) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','en_revision','autorizada','rechazada') NOT NULL DEFAULT 'pendiente',
  `fecha_respuesta` timestamp NULL DEFAULT NULL,
  `respuesta_departamento` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes_enviadas`
--

INSERT INTO `solicitudes_enviadas` (`id`, `solicitud_id`, `departamento_id`, `enviado_por`, `observaciones`, `fecha_envio`, `estado`, `fecha_respuesta`, `respuesta_departamento`) VALUES
(1, 1, 6, 11, 'pa usted con mucho cariño', '2025-06-02 15:43:41', 'autorizada', '2025-06-02 15:45:04', 'pelfecto');

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
  `rol_user` enum('ciudadano','admin','departamentos','presidencia') NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `fecha_nacimiento`, `genero`, `genero_personalizado`, `contacto`, `contrasena`, `rol_user`, `fecha_registro`) VALUES
(5, 'admin', 'admin', '2025-05-01', 'masculino', NULL, 'admin@gmail.com', '123456', 'admin', '2025-05-29 17:34:53'),
(6, 'departamento1', 'departamento1', '2025-05-08', 'masculino', NULL, 'departamento1@gmail.com', '123456', 'departamentos', '2025-05-29 17:36:39'),
(7, 'Luis', 'Tellez', '2004-12-01', 'masculino', NULL, 'luis@gmail.com', '$2y$12$8YCAsOofPCLBxrZN.qdeZengkQQsnLv7R2N1KfY4A/9zMpT6SRn1.', 'ciudadano', '2025-05-29 17:45:28'),
(8, 'Shaila', 'Vite', '2000-10-10', 'otro', 'Binarie', 'shai@gmail.com', '$2y$12$0ux3lLY043n5kKosRkf.Nu.XfxG2CGIWzi3M7Fop5M.3ZmTTDTAMG', 'ciudadano', '2025-06-02 01:28:27'),
(9, 'Miku', 'Vite', '2025-06-20', 'otro', 'binarie', '1234567890', '$2y$12$XERNWl1igenHsnBKqTKvDuIzIFVUzB0Cxi5Msly5hXuT3ozWNa2v.', 'ciudadano', '2025-06-02 14:17:12'),
(11, 'Precidencia 1', 'MATEO', '2025-06-04', 'masculino', NULL, 'precidencia1@gmail.com', '$2y$12$z4hS/kT1ZuCtOAcFXle.Wu447STb57E3BwwzaRtPP3J7VYGEtPCaW', 'presidencia', '2025-06-02 15:08:32');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `solicitudes_enviadas`
--
ALTER TABLE `solicitudes_enviadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitud_id` (`solicitud_id`),
  ADD KEY `departamento_id` (`departamento_id`),
  ADD KEY `enviado_por` (`enviado_por`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `solicitudes_enviadas`
--
ALTER TABLE `solicitudes_enviadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `departamentos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitudes_enviadas`
--
ALTER TABLE `solicitudes_enviadas`
  ADD CONSTRAINT `solicitudes_enviadas_ibfk_1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitudes_enviadas_ibfk_2` FOREIGN KEY (`departamento_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitudes_enviadas_ibfk_3` FOREIGN KEY (`enviado_por`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
