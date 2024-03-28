-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-03-2024 a las 13:24:55
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
  `prinCategoria_ident` varchar(50) NOT NULL,
  `subCategoria_ident` varchar(50) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `detalles` varchar(50) NOT NULL,
  `tipo_producto` varchar(50) NOT NULL,
  `fecha_control` date DEFAULT NULL,
  `fecha_sig_control` date DEFAULT NULL,
  `ubicacion` varchar(50) NOT NULL,
  `proveedor` varchar(100) NOT NULL,
  `unidades` int(11) NOT NULL,
  `forma_producto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id_Articulo`, `prinCategoria_ident`, `subCategoria_ident`, `nombre`, `marca`, `modelo`, `detalles`, `tipo_producto`, `fecha_control`, `fecha_sig_control`, `ubicacion`, `proveedor`, `unidades`, `forma_producto`) VALUES
(1, '0', '', 'Alicate prensa terminales', 'Genérico', 'N/A', '54254', 'Kit Maleta', NULL, NULL, 'Oxigen', 'Ferreteria Ubetense', 17, 'Activo'),
(2, '0', '', 'Balanza electrónica con batería', 'Genérico', 'N/A', 'hasta 100KG PRATIKA 100', 'Equipo', '2024-03-19', '2024-05-10', 'Entregado en Obra', 'Ferreteria Ubetense', 3, 'Activo'),
(3, '0', '', 'Cámara Termográfica', 'THT100', 'HT 1902', 'Completa profesional', 'Equipo', '2024-03-11', '2024-03-11', 'Oxigen', 'Ferreteria Ubetense', 2, 'Activo'),
(5, '0', '', 'Cortafrios metal', 'Genérico', '250mm', 'N/A', 'Herramienta', NULL, NULL, 'Oxigen', 'Ferreteria Ubetense', 7, 'Activo'),
(9, '0', '', 'Juego coronas bimetálicas', 'Genérico', '8 pzas', '8PZ 16-67MM', 'Kit Maleta', NULL, NULL, 'Oxigen', 'Ferreteria Ubetense', 10, 'Activo'),
(10, '0', '', 'Compresor', 'Cevik', '24L', 'PRO 2HP', 'Equipo', '2024-03-26', '2024-04-26', 'Oxigen', 'Ferreteria Ubetense', 3, 'Activo'),
(11, 'CAB', 'CAB-1001', 'Cable extensible', 'Genérico', '25 m', '4T S/TAP TAYG 25MT 3G1,5 IP20', 'Herramienta', NULL, NULL, 'Oxigen', 'Ferreteria Ubetense', 8, 'Activo'),
(12, 'MRT', 'MRT-2001', 'Martillo bola', 'M-FIBRA', '450 gr', 'N/A', 'Herramienta', NULL, NULL, 'Oxigen', 'Ferreteria Ubetense', 10, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `num_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `num_codigo`) VALUES
(1, 'cable', 1001),
(2, 'martillo', 2001),
(3, 'llave', 3000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id_Entrada` int(11) NOT NULL,
  `prinCategoria_ident` varchar(50) NOT NULL,
  `subCategoria_ident` varchar(50) NOT NULL,
  `nombre_articulo` varchar(50) NOT NULL,
  `unidades` int(11) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `id_Articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id_Entrada`, `prinCategoria_ident`, `subCategoria_ident`, `nombre_articulo`, `unidades`, `fecha_entrada`, `nombre_usuario`, `id_Articulo`) VALUES
(1, '', '', 'Abocardador ensanchador', 1, '2024-03-12', 'amin', 0),
(2, '', '', 'Alicate prensa terminales', 10, '2024-03-12', 'amin', 0),
(3, '', '', 'Cámara Termográfica', 2, '2024-03-21', 'Marc', 0),
(4, '', '', 'Cinta métrica', 6, '2024-03-14', 'Marc', 0),
(5, '', '', 'Balanza electrónica con batería', 10, '2024-03-18', 'Marc', 0),
(6, '', '', 'Cámara Termográfica', 3, '2024-03-20', 'Jordi', 0),
(7, '', '', 'Balanza electrónica con batería', 5, '2024-03-20', 'Marc', 0),
(8, '', '', 'Balanza electrónica con batería', 5, '2024-03-20', 'Marc', 0),
(9, '', '', 'Balanza electrónica con batería', 2, '2024-03-20', 'Marc', 0),
(10, '', '', 'Cable extensible', 4, '2024-03-20', 'Marc', 0),
(11, '', '', 'Cable extensible', 1, '2024-03-28', 'Marc', 0),
(12, 'MRT', 'MRT-2001', 'Martillo bola', 2, '2024-03-28', 'Marc', 0),
(13, 'CAB', 'CAB-1001', 'Cable extensible', 1, '2024-03-28', 'Marc', 0),
(14, 'CAB', 'CAB-1001', 'Cable extensible', 2, '2024-03-28', 'Marc', 0),
(15, 'MRT', 'MRT-2001', 'Martillo bola', 2, '2024-03-28', 'Marc', 0),
(16, 'MRT', 'MRT-2001', 'Martillo bola', 1, '2024-03-28', 'Marc', 0),
(17, 'MRT', 'MRT-2001', 'Martillo bola', 2, '2024-01-31', 'Marc', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id_Movimiento` int(11) NOT NULL,
  `tipo_movimiento` enum('Entrada','Salida') NOT NULL,
  `prinCategoria_ident` varchar(50) NOT NULL,
  `subCategoria_ident` varchar(50) NOT NULL,
  `nombre_articulo` varchar(50) NOT NULL,
  `unidades` int(11) NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ubicacion` enum('Oxigen','Obra') NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id_Movimiento`, `tipo_movimiento`, `prinCategoria_ident`, `subCategoria_ident`, `nombre_articulo`, `unidades`, `fecha_movimiento`, `ubicacion`, `nombre_usuario`) VALUES
(1, 'Entrada', '', '', 'Cinta métrica', 6, '2024-03-14', '', 'Marc'),
(2, 'Entrada', '', '', 'Alicate prensa terminales', 5, '2024-03-24', '', 'Marc'),
(3, 'Salida', '', '', 'Balanza electrónica con batería', 5, '2024-03-18', '', 'Marc'),
(4, 'Salida', '', '', 'Balanza electrónica con batería', 5, '2024-03-18', '', 'Marc'),
(5, 'Entrada', '', '', 'Balanza electrónica con batería', 10, '2024-03-18', '', 'Marc'),
(6, 'Salida', '', '', 'Cámara Termográfica', 3, '2024-03-20', '', 'Marc'),
(7, 'Entrada', '', '', 'Cable extensible', 1, '2024-03-21', 'Oxigen', 'Marc'),
(8, 'Entrada', '', '', 'Cable extensible', 1, '2024-03-28', 'Oxigen', 'Marc'),
(10, 'Entrada', 'CAB', 'CAB-1001', 'Cable extensible', 2, '2024-03-28', 'Oxigen', 'Marc'),
(11, 'Salida', 'CAB', 'CAB-1001', 'Cable extensible', 2, '2024-03-28', 'Obra', 'Marc'),
(12, 'Entrada', 'MRT', 'MRT-2001', 'Martillo bola', 2, '2024-03-28', 'Oxigen', 'Marc'),
(13, 'Salida', 'MRT', 'MRT-2001', 'Martillo bola', 2, '2024-03-28', 'Obra', 'Marc'),
(14, 'Entrada', 'MRT', 'MRT-2001', 'Martillo bola', 1, '2024-03-28', 'Oxigen', 'Marc'),
(15, 'Entrada', 'MRT', 'MRT-2001', 'Martillo bola', 2, '2024-01-31', 'Oxigen', 'Marc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `id_Salida` int(11) NOT NULL,
  `prinCategoria_ident` varchar(50) NOT NULL,
  `subCategoria_ident` varchar(50) NOT NULL,
  `nombre_articulo` varchar(50) NOT NULL,
  `unidades` int(11) NOT NULL,
  `fecha_salida` date NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `salidas`
--

INSERT INTO `salidas` (`id_Salida`, `prinCategoria_ident`, `subCategoria_ident`, `nombre_articulo`, `unidades`, `fecha_salida`, `nombre_usuario`) VALUES
(1, '', '', 'Alicate prensa terminales', 10, '2024-03-12', 'amin'),
(2, '', '', 'Balanza electrónica con batería', 5, '2024-03-13', 'amin'),
(3, '', '', 'Alicate prensa terminales', 5, '2024-03-22', 'Marc'),
(4, '', '', 'Alicate prensa terminales', 5, '2024-03-24', 'Marc'),
(5, '', '', 'Balanza electrónica con batería', 5, '2024-03-18', 'Marc'),
(6, '', '', 'Balanza electrónica con batería', 5, '2024-03-18', 'Marc'),
(7, '', '', 'Cámara Termográfica', 3, '2024-03-20', 'Marc'),
(8, '', '', 'Balanza electrónica con batería', 6, '2024-03-20', 'Marc'),
(9, '', '', 'Balanza electrónica con batería', 1, '2024-03-20', 'Marc'),
(10, '', '', 'Balanza electrónica con batería', 1, '2024-03-20', 'Marc'),
(11, '', '', 'Cable extensible', 4, '2024-03-20', 'Marc'),
(15, '', '', 'Cámara Termográfica', 3, '2024-03-21', 'Marc'),
(16, '', '', 'Cable extensible', 1, '2024-03-21', 'Marc'),
(19, 'CAB', 'CAB-1001', 'Cable extensible', 2, '2024-03-28', 'Marc'),
(20, 'MRT', 'MRT-2001', 'Martillo bola', 2, '2024-03-28', 'Marc');

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
  ADD KEY `nombre_articulo` (`nombre`) USING BTREE,
  ADD KEY `prinCategoria_ident` (`prinCategoria_ident`),
  ADD KEY `subCategoria_ident` (`subCategoria_ident`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

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
  MODIFY `id_Articulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id_Entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id_Movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id_Salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
