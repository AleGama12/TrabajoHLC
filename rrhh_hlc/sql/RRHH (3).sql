-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 28-11-2024 a las 09:17:45
-- Versión del servidor: 8.0.40
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `RRHH`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Candidatos`
--

CREATE TABLE `Candidatos` (
  `id_candidato` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `experiencia` int NOT NULL,
  `contacto` int NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Candidatos`
--

INSERT INTO `Candidatos` (`id_candidato`, `nombre`, `experiencia`, `contacto`, `direccion`) VALUES
(5, 'alejandro', 12, 62584935, 'arona'),
(8, 'andres', 6, 543546, 'españa'),
(9, 'sancho', 10, 4565675, 'valladolid'),
(10, 'jaime', 1, 5657543, 'los angeles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Empresas`
--

CREATE TABLE `Empresas` (
  `id_empresa` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `sector` varchar(100) NOT NULL,
  `ubicacion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` text NOT NULL,
  `telefono` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Postulaciones`
--

CREATE TABLE `Postulaciones` (
  `id_postulacion` int NOT NULL,
  `id_candidato` int NOT NULL,
  `id_vacante` int NOT NULL,
  `fecha_postulación` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vacantes`
--

CREATE TABLE `Vacantes` (
  `id_vacante` int NOT NULL,
  `puesto` varchar(100) NOT NULL,
  `requisitos` text NOT NULL,
  `salario` int NOT NULL,
  `tipo_contrato` varchar(100) NOT NULL,
  `id_empresa` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Candidatos`
--
ALTER TABLE `Candidatos`
  ADD PRIMARY KEY (`id_candidato`);

--
-- Indices de la tabla `Empresas`
--
ALTER TABLE `Empresas`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `Postulaciones`
--
ALTER TABLE `Postulaciones`
  ADD PRIMARY KEY (`id_postulacion`),
  ADD KEY `FK_candidatos` (`id_candidato`),
  ADD KEY `FK_vacantes` (`id_vacante`);

--
-- Indices de la tabla `Vacantes`
--
ALTER TABLE `Vacantes`
  ADD PRIMARY KEY (`id_vacante`),
  ADD KEY `FK_empresa` (`id_empresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Candidatos`
--
ALTER TABLE `Candidatos`
  MODIFY `id_candidato` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `Empresas`
--
ALTER TABLE `Empresas`
  MODIFY `id_empresa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Postulaciones`
--
ALTER TABLE `Postulaciones`
  MODIFY `id_postulacion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Vacantes`
--
ALTER TABLE `Vacantes`
  MODIFY `id_vacante` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Postulaciones`
--
ALTER TABLE `Postulaciones`
  ADD CONSTRAINT `FK_candidatos` FOREIGN KEY (`id_candidato`) REFERENCES `Candidatos` (`id_candidato`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_vacantes` FOREIGN KEY (`id_vacante`) REFERENCES `Vacantes` (`id_vacante`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Vacantes`
--
ALTER TABLE `Vacantes`
  ADD CONSTRAINT `FK_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `Empresas` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
