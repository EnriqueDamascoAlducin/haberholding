-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-12-2019 a las 05:16:33
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `haberholding`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_movimientos_equipo`
--

CREATE TABLE `bitacora_movimientos_equipo` (
  `id` int(11) NOT NULL,
  `movimiento` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `comentario` varchar(65) COLLATE utf8_spanish_ci NOT NULL,
  `registro` date NOT NULL,
  `estatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificaciones`
--

CREATE TABLE `clasificaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes`
--

CREATE TABLE `componentes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `clasificacion` int(11) NOT NULL,
  `descripcion` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `registro` date NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_max_garantia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_depto` int(11) NOT NULL COMMENT 'ID departamento',
  `nombre_depto` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre',
  `registro_depto` datetime DEFAULT current_timestamp() COMMENT 'Registro',
  `status_depto` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_depto`, `nombre_depto`, `registro_depto`, `status_depto`) VALUES
(1, 'Sistemas', '2019-11-19 22:37:43', 1),
(2, 'Contabilidad', '2019-11-19 23:00:39', 1),
(3, 'Marketing', '2019-11-19 23:07:42', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `id_modelo` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `registro` date NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_max_garantia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos_componente`
--

CREATE TABLE `equipos_componente` (
  `id` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `id_clasificacion` int(11) NOT NULL,
  `id_componente` int(11) NOT NULL,
  `registro` date NOT NULL,
  `estatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `id_marca` int(11) NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL COMMENT 'ID Modulo',
  `nombre_modulo` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre',
  `ruta_modulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ruta',
  `icono_modulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Icono',
  `registro_modulo` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de Registro',
  `status_modulo` int(11) NOT NULL DEFAULT 1 COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `nombre_modulo`, `ruta_modulo`, `icono_modulo`, `registro_modulo`, `status_modulo`) VALUES
(1, 'Usuarios', '/usuarios', 'fas fa-child', '2019-11-21 23:11:03', 1),
(2, 'Equipos', '/equipos', 'fas fa-desktop', '2019-11-21 23:54:28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_modulos`
--

CREATE TABLE `permisos_modulos` (
  `id_permiso` int(11) NOT NULL COMMENT 'ID permiso',
  `nombre_permiso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre',
  `modulo_permiso` int(11) DEFAULT NULL COMMENT 'Módulo',
  `register_permiso` datetime DEFAULT current_timestamp() COMMENT 'Fecha de registro',
  `status_permiso` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos_modulos`
--

INSERT INTO `permisos_modulos` (`id_permiso`, `nombre_permiso`, `modulo_permiso`, `register_permiso`, `status_permiso`) VALUES
(1, 'AGREGAR', 1, '2019-11-21 23:29:24', 1),
(2, 'EDITAR', 1, '2019-11-21 23:29:39', 1),
(3, 'EQUIPOS', 1, '2019-11-21 23:29:39', 1),
(4, 'AGREGAR', 2, '2019-11-21 23:54:57', 1),
(5, 'PERMISOS', 1, '2019-12-18 23:03:51', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_usuarios`
--

CREATE TABLE `permisos_usuarios` (
  `id_pu` int(11) NOT NULL COMMENT 'ID permiso con usuario',
  `permiso_pu` int(11) DEFAULT NULL COMMENT 'Permiso',
  `usuario_pu` int(11) DEFAULT NULL COMMENT 'Usuario',
  `registro_pu` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de Registro',
  `status_pu` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos_usuarios`
--

INSERT INTO `permisos_usuarios` (`id_pu`, `permiso_pu`, `usuario_pu`, `registro_pu`, `status_pu`) VALUES
(1, 1, 1, '2019-11-21 23:37:26', 1),
(2, 2, 1, '2019-11-21 23:37:26', 1),
(3, 3, 1, '2019-11-21 23:37:26', 1),
(5, 4, 1, '2019-11-21 23:58:45', 1),
(6, 5, 1, '2019-12-18 23:04:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `id_puesto` int(11) NOT NULL COMMENT 'ID puesto',
  `nombre_puesto` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre',
  `iddepto_puesto` int(11) NOT NULL COMMENT 'Departamento',
  `registro_puesto` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Registro',
  `status_puesto` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `puestos`
--

INSERT INTO `puestos` (`id_puesto`, `nombre_puesto`, `iddepto_puesto`, `registro_puesto`, `status_puesto`) VALUES
(1, 'Desarrollador', 1, '2019-11-19 22:54:50', 1),
(2, 'Contador', 2, '2019-11-19 23:01:09', 1),
(3, 'Soporte', 1, '2019-11-19 23:01:09', 1),
(4, 'Auxiliar', 2, '2019-11-19 23:01:09', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submodulos`
--

CREATE TABLE `submodulos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `modulo` int(11) DEFAULT NULL,
  `icono` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ruta` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `registro` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usu` int(11) NOT NULL COMMENT 'Id empleado',
  `nombre_usu` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre',
  `apellidop_usu` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Apellido Paterno',
  `apellidom_usu` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Apellido Materno',
  `sexo_usu` tinyint(4) NOT NULL COMMENT 'Sexo',
  `correo_usu` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Correo',
  `noempleado_usu` int(11) DEFAULT NULL COMMENT 'Número de Empleado',
  `depto_usu` int(11) DEFAULT NULL COMMENT 'Departamento',
  `puesto_usu` int(11) DEFAULT NULL COMMENT 'Puesto',
  `extension_usu` smallint(6) DEFAULT NULL COMMENT 'Extensión',
  `contrasena_usu` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Contraseña',
  `ingreso_usu` date DEFAULT NULL COMMENT 'Fecha de Ingreso',
  `registro_usu` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de Registro',
  `status_usu` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla Usuarios';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usu`, `nombre_usu`, `apellidop_usu`, `apellidom_usu`, `sexo_usu`, `correo_usu`, `noempleado_usu`, `depto_usu`, `puesto_usu`, `extension_usu`, `contrasena_usu`, `ingreso_usu`, `registro_usu`, `status_usu`) VALUES
(1, 'Enrique', 'Damasco', 'Alducin', 1, 'enriquealducin@outlook.com', 1, 1, 1, 111, '202cb962ac59075b964b07152d234b70', '2019-11-20', '2019-11-20 23:28:01', 1),
(2, 'Carolina', 'Velez', 'López', 2, 'cvelez_jc@hotmail.com', 8000876, 1, 1, 55, '202cb962ac59075b964b07152d234b70', '1992-05-27', '2019-12-08 21:18:35', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_equipo`
--

CREATE TABLE `usuarios_equipo` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `registro` date NOT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora_movimientos_equipo`
--
ALTER TABLE `bitacora_movimientos_equipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clasificaciones`
--
ALTER TABLE `clasificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_depto`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equipos_componente`
--
ALTER TABLE `equipos_componente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `permisos_modulos`
--
ALTER TABLE `permisos_modulos`
  ADD PRIMARY KEY (`id_permiso`),
  ADD KEY `fk_permisos_modulos` (`modulo_permiso`);

--
-- Indices de la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  ADD PRIMARY KEY (`id_pu`),
  ADD KEY `fk_pu_usuarios` (`usuario_pu`),
  ADD KEY `fk_pu_permisos` (`permiso_pu`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id_puesto`),
  ADD KEY `FK_puestoDepto` (`iddepto_puesto`);

--
-- Indices de la tabla `submodulos`
--
ALTER TABLE `submodulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modulo` (`modulo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usu`);

--
-- Indices de la tabla `usuarios_equipo`
--
ALTER TABLE `usuarios_equipo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_depto` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID departamento', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Modulo', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permisos_modulos`
--
ALTER TABLE `permisos_modulos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID permiso', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  MODIFY `id_pu` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID permiso con usuario', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id_puesto` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID puesto', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `submodulos`
--
ALTER TABLE `submodulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id empleado', AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `permisos_modulos`
--
ALTER TABLE `permisos_modulos`
  ADD CONSTRAINT `fk_permisos_modulos` FOREIGN KEY (`modulo_permiso`) REFERENCES `modulos` (`id_modulo`);

--
-- Filtros para la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  ADD CONSTRAINT `fk_pu_permisos` FOREIGN KEY (`permiso_pu`) REFERENCES `permisos_modulos` (`id_permiso`),
  ADD CONSTRAINT `fk_pu_usuarios` FOREIGN KEY (`usuario_pu`) REFERENCES `usuarios` (`id_usu`);

--
-- Filtros para la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD CONSTRAINT `FK_puestoDepto` FOREIGN KEY (`iddepto_puesto`) REFERENCES `departamentos` (`id_depto`);

--
-- Filtros para la tabla `submodulos`
--
ALTER TABLE `submodulos`
  ADD CONSTRAINT `submodulos_ibfk_1` FOREIGN KEY (`modulo`) REFERENCES `modulos` (`id_modulo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
