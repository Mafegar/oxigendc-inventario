-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2024 a las 18:23:10
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
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id_Articulo` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `detalles` varchar(50) NOT NULL,
  `tipo_producto` varchar(50) NOT NULL,
  `fecha_control` date DEFAULT NULL,
  `fecha_sig_control` date NOT NULL,
  `ubicacion` varchar(50) NOT NULL,
  `proveedor` varchar(100) NOT NULL,
  `unidades` int(11) NOT NULL,
  `forma_producto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id_Articulo`, `nombre`, `marca`, `modelo`, `detalles`, `tipo_producto`, `fecha_control`, `fecha_sig_control`, `ubicacion`, `proveedor`, `unidades`, `forma_producto`) VALUES
(1, 'Alicate prensa terminales', 'Genérico', 'N/A', '54254', 'Kit Maleta', '0000-00-00', '0000-00-00', 'Oxigen', 'Ferreteria Ubetense', 20, 'Activo'),
(2, 'Balanza electrónica con batería', 'Genérico', 'N/A', 'hasta 100KG PRATIKA 100', 'Equipo', '2024-03-19', '2024-05-10', 'Entregado en Obra', 'Ferreteria Ubetense', 4, 'Activo'),
(3, 'Cámara Termográfica', 'THT100', 'HT 1902', 'Completa profesional', 'Equipo', '2024-03-11', '2024-03-11', 'Oxigen', 'Ferreteria Ubetense', 0, 'Activo'),
(4, 'Cable extensible', 'Genérico', '50 m', '4T S/TAP TAYG 50MT 3G1,5 IP20', 'Herramienta', '0000-00-00', '0000-00-00', 'Oxigen', 'Ferreteria Ubetense', 2, 'Activo'),
(5, 'Cortafrios metal', 'Genérico', '250mm', 'N/A', 'Herramienta', '0000-00-00', '0000-00-00', 'Oxigen', 'Ferreteria Ubetense', 3, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id_Entrada` int(11) NOT NULL,
  `nombre_articulo` varchar(50) NOT NULL,
  `unidades` int(11) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id_Entrada`, `nombre_articulo`, `unidades`, `fecha_entrada`, `nombre_usuario`) VALUES
(1, 'Abocardador ensanchador', 1, '2024-03-12', 'amin'),
(2, 'Alicate prensa terminales', 10, '2024-03-12', 'amin'),
(3, 'Cámara Termográfica', 2, '2024-03-21', 'Marc'),
(4, 'Cinta métrica', 6, '2024-03-14', 'Marc'),
(5, 'Balanza electrónica con batería', 10, '2024-03-18', 'Marc'),
(6, 'Cámara Termográfica', 3, '2024-03-20', 'Jordi'),
(7, 'Balanza electrónica con batería', 5, '2024-03-20', 'Marc'),
(8, 'Balanza electrónica con batería', 5, '2024-03-20', 'Marc'),
(9, 'Balanza electrónica con batería', 2, '2024-03-20', 'Marc'),
(10, 'Cable extensible', 4, '2024-03-20', 'Marc'),
(11, 'Cable extensible', 1, '2024-03-21', 'Marc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id_Movimiento` int(11) NOT NULL,
  `tipo_movimiento` enum('Entrada','Salida') NOT NULL,
  `nombre_articulo` varchar(50) NOT NULL,
  `unidades` int(11) NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ubicacion` enum('Oxigen','Obra') NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id_Movimiento`, `tipo_movimiento`, `nombre_articulo`, `unidades`, `fecha_movimiento`, `ubicacion`, `nombre_usuario`) VALUES
(1, 'Entrada', 'Cinta métrica', 6, '2024-03-14', '', 'Marc'),
(2, 'Entrada', 'Alicate prensa terminales', 5, '2024-03-24', '', 'Marc'),
(3, 'Salida', 'Balanza electrónica con batería', 5, '2024-03-18', '', 'Marc'),
(4, 'Salida', 'Balanza electrónica con batería', 5, '2024-03-18', '', 'Marc'),
(5, 'Entrada', 'Balanza electrónica con batería', 10, '2024-03-18', '', 'Marc'),
(6, 'Salida', 'Cámara Termográfica', 3, '2024-03-20', '', 'Marc'),
(14, 'Entrada', 'Cable extensible', 1, '2024-03-21', 'Oxigen', 'Marc'),
(15, 'Salida', 'Cable extensible', 1, '2024-03-21', 'Oxigen', 'Marc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `id_Salida` int(11) NOT NULL,
  `nombre_articulo` varchar(50) NOT NULL,
  `unidades` int(11) NOT NULL,
  `fecha_salida` date NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `salidas`
--

INSERT INTO `salidas` (`id_Salida`, `nombre_articulo`, `unidades`, `fecha_salida`, `nombre_usuario`) VALUES
(1, 'Alicate prensa terminales', 10, '2024-03-12', 'amin'),
(2, 'Balanza electrónica con batería', 5, '2024-03-13', 'amin'),
(3, 'Alicate prensa terminales', 5, '2024-03-22', 'Marc'),
(4, 'Alicate prensa terminales', 5, '2024-03-24', 'Marc'),
(5, 'Balanza electrónica con batería', 5, '2024-03-18', 'Marc'),
(6, 'Balanza electrónica con batería', 5, '2024-03-18', 'Marc'),
(7, 'Cámara Termográfica', 3, '2024-03-20', 'Marc'),
(8, 'Balanza electrónica con batería', 6, '2024-03-20', 'Marc'),
(9, 'Balanza electrónica con batería', 1, '2024-03-20', 'Marc'),
(10, 'Balanza electrónica con batería', 1, '2024-03-20', 'Marc'),
(11, 'Cable extensible', 4, '2024-03-20', 'Marc'),
(15, 'Cámara Termográfica', 3, '2024-03-21', 'Marc'),
(16, 'Cable extensible', 1, '2024-03-21', 'Marc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_Usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `primer_apellido` varchar(100) NOT NULL,
  `segundo_apellido` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tipo_usuario` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_Usuario`, `nombre`, `primer_apellido`, `segundo_apellido`, `username`, `password`, `tipo_usuario`) VALUES
(1, 'Marc', 'Fernández', 'García', 'marc', '$2y$10$qBG3zPioymkRuYKStHtTT.yX6C82/VJn7hFf5bEMeUEWeJujmskL2', 1),
(2, 'Jordi', 'Torrella', 'López', 'jordi', '$2y$10$YkujEbkfojpjcyH0iOESvOkwGQ.tW9f.2GwUDs7UZ63nvlDqFfWdC', 0),
(3, 'Aroa', 'Blanca', 'Rodríguez ', 'aroa', '$2y$10$Qmhji194o/wiXXO/RxPK7.7NkS3bdOHxsGFnI5HofPAYExMc3rqoi', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id_Articulo`),
  ADD KEY `nombre_articulo` (`nombre`) USING BTREE;

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id_Entrada`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id_Movimiento`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id_Salida`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_Usuario`),
  ADD KEY `nombre_usuario` (`nombre`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id_Articulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id_Entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id_Movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id_Salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
