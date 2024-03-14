-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-03-2024 a las 18:31:26
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
(2, 'Abocardador ensanchador', 'FS', '275-FS', 'Ø1/8 - Ø3/4', '2', '0000-00-00', '0000-00-00', '1', 'Ferreteria Ubetense', 20, '1'),
(3, 'Alicate prensa terminales', 'Genérico', 'N/A', '54254', 'Herramienta', '0000-00-00', '0000-00-00', 'Entregado en Obra', 'Ferreteria Ubetense', 20, 'Activo'),
(4, 'Balanza electrónica con batería', 'Genérico', 'N/A', 'hasta 100KG PRATIKA 100', 'Equipo', '0000-00-00', '0000-00-00', 'Oxigen', 'Ferreteria Ubetense', 5, 'Passivo'),
(5, 'Cámara Termográfica', 'THT100', 'HT 1902', 'Completa profesional', 'Equipo', '2024-03-11', '2024-03-11', 'Oxigen', 'Ferreteria Ubetense', 3, 'Activo'),
(6, 'Cinta métrica', 'Genérico', '5 m', '25MM 5M', 'Herramienta', '0000-00-00', '0000-00-00', 'Oxigen', 'Ferreteria Ubetense', 9, 'Passivo');

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
(4, 'Cinta métrica', 6, '2024-03-14', 'Marc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id_Movimiento` int(11) NOT NULL,
  `tipo_movimiento` enum('entrada','salida') NOT NULL,
  `nombre_articulo` varchar(50) NOT NULL,
  `unidades` int(11) NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id_Movimiento`, `tipo_movimiento`, `nombre_articulo`, `unidades`, `fecha_movimiento`, `nombre_usuario`) VALUES
(1, 'entrada', 'Cinta métrica', 6, '2024-03-14', 'Marc'),
(2, 'entrada', 'Alicate prensa terminales', 5, '2024-03-24', 'Marc');

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
(4, 'Alicate prensa terminales', 5, '2024-03-24', 'Marc');

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
  `tipo_usuario` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_Usuario`, `nombre`, `primer_apellido`, `segundo_apellido`, `username`, `password`, `tipo_usuario`) VALUES
(1, 'Marc', 'Fernández', 'García', 'marc', '$2y$10$qBG3zPioymkRuYKStHtTT.yX6C82/VJn7hFf5bEMeUEWeJujmskL2', 1),
(2, 'Jordi', 'Torrella', 'López', 'jordi', '$2y$10$F4R9n.qYHYnxXpoY3M2LCO0c6BWbXhF4/xx.n3K4VxRKHCufwUqR.', 0);

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
  MODIFY `id_Articulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id_Entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id_Movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id_Salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
