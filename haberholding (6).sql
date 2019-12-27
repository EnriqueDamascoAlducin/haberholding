-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2019 a las 21:44:50
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
  `estatus` tinyint(4) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `id_movimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificaciones`
--

CREATE TABLE `clasificaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 Software/2Hardware',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clasificaciones`
--

INSERT INTO `clasificaciones` (`id`, `nombre`, `tipo`, `status`, `registro`) VALUES
(1, 'S.O.', 1, 1, '2019-12-27 09:08:32'),
(2, 'Antivirus', 1, 1, '2019-12-27 09:08:32'),
(3, 'Tarjeta Madre', 2, 1, '2019-12-27 09:11:53'),
(4, 'Office', 1, 1, '2019-12-27 09:22:20'),
(5, 'Mouse', 2, 1, '2019-12-27 09:39:06'),
(6, 'Teclado', 2, 1, '2019-12-27 09:39:06'),
(7, 'ALL IN ONE', 2, 1, '2019-12-27 12:17:34'),
(8, 'GABINETE', 2, 1, '2019-12-27 12:17:45'),
(9, 'LAPTOP', 2, 1, '2019-12-27 12:18:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes`
--

CREATE TABLE `componentes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `id_clasificacion` int(11) NOT NULL,
  `descripcion` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_max_garantia` date DEFAULT NULL,
  `id_marca` int(11) NOT NULL,
  `id_modelo` int(11) NOT NULL,
  `registro` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `componentes`
--

INSERT INTO `componentes` (`id`, `nombre`, `id_clasificacion`, `descripcion`, `fecha_max_garantia`, `id_marca`, `id_modelo`, `registro`, `status`) VALUES
(1, 'fz1550', 5, 'Mouse Inalambrico color negro', '2019-12-12', 1, 7, '0000-00-00 00:00:00', 1),
(2, 'dsadsa', 6, 'jajaajaj', '2019-12-06', 2, 6, '2019-12-27 11:00:56', 0),
(3, 'dsadsa', 8, 'dsadsa', '2019-12-21', 2, 6, '2019-12-27 14:44:29', 1);

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
(3, 'Marketing', '2019-11-19 23:07:42', 0),
(4, 'Ventas', '2019-12-27 01:38:04', 0),
(5, 'sa', '2019-12-27 02:25:26', 0),
(6, 'dsadas', '2019-12-27 02:25:56', 0),
(7, 'dsadsa', '2019-12-27 02:26:37', 0),
(8, 'fddf', '2019-12-27 02:27:19', 0),
(9, 'a', '2019-12-27 02:29:04', 0),
(10, 'das', '2019-12-27 02:35:07', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `serie` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clasificacion` int(11) NOT NULL,
  `id_modelo` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `fecha_max_garantia` date DEFAULT NULL,
  `comentarios` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `registro` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `serie`, `clasificacion`, `id_modelo`, `id_marca`, `fecha_max_garantia`, `comentarios`, `registro`, `status`) VALUES
(1, '0078', 8, 7, 1, '2019-12-27', 'core i 7  funcionando bien', '2019-12-27 12:43:07', 1),
(2, 'dsadsa', 8, 4, 1, NULL, 'dsadsa', '2019-12-27 13:03:04', 0),
(3, 'dsa', 5, 6, 2, NULL, 'dsadsa', '2019-12-27 13:04:31', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos_componente`
--

CREATE TABLE `equipos_componente` (
  `id` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `id_componente` int(11) NOT NULL,
  `registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `equipos_componente`
--

INSERT INTO `equipos_componente` (`id`, `id_equipo`, `id_componente`, `registro`, `status`) VALUES
(2, 1, 1, '2019-12-27 20:15:19', 0),
(3, 1, 1, '2019-12-27 20:26:49', 1),
(4, 3, 1, '2019-12-27 20:27:06', 1),
(5, 1, 1, '2019-12-27 20:33:43', 0),
(6, 1, 3, '2019-12-27 20:44:35', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos_software`
--

CREATE TABLE `equipos_software` (
  `id` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `id_componente` int(11) NOT NULL,
  `registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `equipos_software`
--

INSERT INTO `equipos_software` (`id`, `id_equipo`, `id_componente`, `registro`, `status`) VALUES
(9, 1, 1, '2019-12-27 20:35:00', 1),
(16, 1, 3, '2019-12-27 20:42:05', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `status`, `registro`) VALUES
(1, 'DELL', 1, '2019-12-27 09:33:28'),
(2, 'ASUS', 1, '2019-12-27 09:33:28'),
(3, 'HP-', 0, '2019-12-27 11:30:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `id_marca` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `nombre`, `id_marca`, `status`, `registro`) VALUES
(4, 'Inspiron 15', 1, 1, '2019-12-27 00:00:00'),
(5, 'Inspiron 13', 1, 1, '0000-00-00 00:00:00'),
(6, 'Rog', 2, 1, '2019-12-27 00:00:00'),
(7, 'KM636', 1, 1, '2019-12-27 09:40:52'),
(8, 'ssadd', 1, 0, '2019-12-27 11:43:52');

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
-- Estructura de tabla para la tabla `permisos_submodulos`
--

CREATE TABLE `permisos_submodulos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idsubmodulo` int(11) NOT NULL,
  `registro` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos_submodulos`
--

INSERT INTO `permisos_submodulos` (`id`, `nombre`, `idsubmodulo`, `registro`, `status`) VALUES
(1, 'AGREGAR', 1, '2019-12-26 22:17:03', 1),
(2, 'EDITAR', 1, '2019-12-26 22:17:03', 1),
(3, 'ELIMINAR', 1, '2019-12-26 22:17:03', 1),
(4, 'EQUIPOS', 1, '2019-12-26 22:17:03', 1),
(5, 'PERMISOS', 1, '2019-12-26 22:17:03', 1),
(6, 'AGREGAR', 2, '2019-12-26 23:56:51', 1),
(7, 'EDITAR', 2, '2019-12-27 01:41:40', 1),
(8, 'ELIMINAR', 2, '2019-12-27 01:48:11', 1),
(9, 'PUESTOS', 2, '2019-12-27 01:51:21', 1),
(10, 'AGREGAR', 5, '2019-12-27 09:03:53', 1),
(11, 'EDITAR', 5, '2019-12-27 09:03:53', 1),
(12, 'ELIMINAR', 5, '2019-12-27 09:03:53', 1),
(13, 'AGREGAR', 4, '2019-12-27 09:28:10', 1),
(14, 'EDITAR', 4, '2019-12-27 09:28:10', 1),
(15, 'ELIMINAR', 4, '2019-12-27 09:28:10', 1),
(16, 'AGREGAR', 10, '2019-12-27 11:13:32', 1),
(17, 'EDITAR', 10, '2019-12-27 11:13:32', 1),
(18, 'ELIMINAR', 10, '2019-12-27 11:13:32', 1),
(19, 'MODELOS', 10, '2019-12-27 11:13:32', 1),
(23, 'AGREGAR', 3, '2019-12-27 11:50:20', 1),
(24, 'EDITAR', 3, '2019-12-27 11:50:20', 1),
(25, 'ELIMINAR', 3, '2019-12-27 11:50:20', 1),
(26, 'AGREGAR', 12, '2019-12-27 13:10:29', 1),
(27, 'EDITAR', 12, '2019-12-27 13:10:29', 1),
(28, 'ELIMINAR', 12, '2019-12-27 13:10:29', 1),
(29, 'COMPONENTES', 3, '2019-12-27 13:56:08', 1),
(30, 'SOFTWARE', 3, '2019-12-27 13:56:08', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_submodulos_usuarios`
--

CREATE TABLE `permisos_submodulos_usuarios` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL,
  `registro` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos_submodulos_usuarios`
--

INSERT INTO `permisos_submodulos_usuarios` (`id`, `idusuario`, `idpermiso`, `registro`, `status`) VALUES
(8, 1, 2, '2019-12-27 00:02:11', 1),
(11, 1, 5, '2019-12-27 00:28:11', 1),
(12, 1, 1, '2019-12-27 01:18:18', 1),
(13, 1, 3, '2019-12-27 01:18:29', 1),
(14, 1, 4, '2019-12-27 01:18:29', 1),
(15, 1, 6, '2019-12-27 01:20:56', 1),
(16, 1, 7, '2019-12-27 01:41:50', 1),
(17, 1, 8, '2019-12-27 01:48:19', 1),
(18, 1, 9, '2019-12-27 01:51:31', 1),
(19, 1, 10, '2019-12-27 09:04:03', 1),
(20, 1, 11, '2019-12-27 09:04:03', 1),
(21, 1, 12, '2019-12-27 09:04:03', 1),
(22, 1, 13, '2019-12-27 09:28:22', 1),
(23, 1, 14, '2019-12-27 09:28:22', 1),
(24, 1, 15, '2019-12-27 09:28:22', 1),
(25, 1, 16, '2019-12-27 11:14:05', 1),
(26, 1, 17, '2019-12-27 11:14:05', 1),
(27, 1, 18, '2019-12-27 11:14:05', 1),
(28, 1, 19, '2019-12-27 11:14:05', 1),
(29, 1, 23, '2019-12-27 11:51:19', 1),
(30, 1, 24, '2019-12-27 11:51:19', 1),
(31, 1, 25, '2019-12-27 11:51:19', 1),
(32, 1, 26, '2019-12-27 13:11:31', 1),
(33, 1, 27, '2019-12-27 13:11:31', 1),
(34, 1, 28, '2019-12-27 13:11:31', 1),
(35, 1, 29, '2019-12-27 13:56:18', 1),
(36, 1, 30, '2019-12-27 13:56:18', 1);

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
(2, 'Contador', 2, '2019-11-19 23:01:09', 0),
(3, 'Soporte', 1, '2019-11-19 23:01:09', 0),
(4, 'Auxiliar', 2, '2019-11-19 23:01:09', 0),
(5, 'Redes', 1, '2019-12-27 02:41:00', 0),
(6, 'Soporte', 1, '2019-12-27 02:48:53', 1),
(7, 'Redes1', 1, '2019-12-27 08:55:21', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `software`
--

CREATE TABLE `software` (
  `id` int(11) NOT NULL,
  `nombre` varchar(35) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_clasificacion` int(11) DEFAULT NULL,
  `fecha_max_licencia` date DEFAULT NULL,
  `version` varchar(35) COLLATE utf8_spanish_ci DEFAULT NULL,
  `registro` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `software`
--

INSERT INTO `software` (`id`, `nombre`, `id_clasificacion`, `fecha_max_licencia`, `version`, `registro`, `status`) VALUES
(1, 'Windows 7', 1, '2019-12-31', 'PRO', '2019-12-27 13:29:24', 1),
(2, 'Ac', 4, NULL, 'free', '2019-12-27 13:52:58', 0),
(3, 'Avast2', 4, '2019-12-07', 'Free2', '2019-12-27 13:53:19', 1);

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

--
-- Volcado de datos para la tabla `submodulos`
--

INSERT INTO `submodulos` (`id`, `nombre`, `modulo`, `icono`, `ruta`, `registro`, `status`) VALUES
(1, 'Registro', 1, 'fa fa-user-plus', '/registro/', '2019-12-26 21:53:44', 1),
(2, 'Departamentos', 1, 'fa fa-asterisk', '/departamentos/', '2019-12-26 21:59:42', 1),
(3, 'Registro', 2, 'fa fa-laptop', '/registro/', '2019-12-26 22:01:02', 1),
(4, 'Componentes', 2, 'fa fa-print', '/componentes/', '2019-12-26 22:02:36', 1),
(5, 'Clasificaciones', 2, 'fa fa-sitemap', '/clasificaciones/', '2019-12-26 22:03:49', 1),
(10, 'Marcas', 2, 'fa fa-copyright', '/marcas/', '2019-12-26 22:07:59', 1),
(12, 'Software', 2, 'fa fa-code', '/software/', '2019-12-26 22:11:44', 1);

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
  `status_usu` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Status',
  `departamento` varchar(35) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla Usuarios';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usu`, `nombre_usu`, `apellidop_usu`, `apellidom_usu`, `sexo_usu`, `correo_usu`, `noempleado_usu`, `depto_usu`, `puesto_usu`, `extension_usu`, `contrasena_usu`, `ingreso_usu`, `registro_usu`, `status_usu`, `departamento`) VALUES
(1, 'Enrique', 'Damasco', 'Alducin', 1, 'enriquealducin@outlook.com', 1, 1, 1, 111, '202cb962ac59075b964b07152d234b70', '2019-11-20', '2019-11-20 23:28:01', 1, ''),
(2, 'Carolina', 'Velez', 'López', 2, 'cvelez_jc@hotmail.com', 2, 1, 1, 55, '202cb962ac59075b964b07152d234b70', '1992-05-27', '2019-12-08 21:18:35', 1, '');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_marca` (`id_marca`),
  ADD KEY `FK_id_modelo` (`id_modelo`),
  ADD KEY `FK_idclasificacion_componente` (`id_clasificacion`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_depto`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_marca_equipo` (`id_marca`),
  ADD KEY `FK_id_modelo_equipo` (`id_modelo`),
  ADD KEY `FK_id_clasificacion_equipo` (`clasificacion`);

--
-- Indices de la tabla `equipos_componente`
--
ALTER TABLE `equipos_componente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_componente_equipo` (`id_equipo`),
  ADD KEY `FK_componente_equipo_equipo` (`id_componente`);

--
-- Indices de la tabla `equipos_software`
--
ALTER TABLE `equipos_software`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_marca_modelo` (`id_marca`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `permisos_submodulos`
--
ALTER TABLE `permisos_submodulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_submodulo_permiso` (`idsubmodulo`);

--
-- Indices de la tabla `permisos_submodulos_usuarios`
--
ALTER TABLE `permisos_submodulos_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_permiso` (`idusuario`),
  ADD KEY `FK_permiso_usuario` (`idpermiso`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id_puesto`),
  ADD KEY `FK_puestoDepto` (`iddepto_puesto`);

--
-- Indices de la tabla `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_idclas_software` (`id_clasificacion`);

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
-- AUTO_INCREMENT de la tabla `clasificaciones`
--
ALTER TABLE `clasificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `componentes`
--
ALTER TABLE `componentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_depto` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID departamento', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `equipos_componente`
--
ALTER TABLE `equipos_componente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `equipos_software`
--
ALTER TABLE `equipos_software`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Modulo', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permisos_submodulos`
--
ALTER TABLE `permisos_submodulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `permisos_submodulos_usuarios`
--
ALTER TABLE `permisos_submodulos_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id_puesto` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID puesto', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `software`
--
ALTER TABLE `software`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `submodulos`
--
ALTER TABLE `submodulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id empleado', AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD CONSTRAINT `FK_id_marca` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`),
  ADD CONSTRAINT `FK_id_modelo` FOREIGN KEY (`id_modelo`) REFERENCES `modelos` (`id`),
  ADD CONSTRAINT `FK_idclasificacion_componente` FOREIGN KEY (`id_clasificacion`) REFERENCES `clasificaciones` (`id`);

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `FK_id_clasificacion_equipo` FOREIGN KEY (`clasificacion`) REFERENCES `clasificaciones` (`id`),
  ADD CONSTRAINT `FK_id_marca_equipo` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`),
  ADD CONSTRAINT `FK_id_modelo_equipo` FOREIGN KEY (`id_modelo`) REFERENCES `modelos` (`id`);

--
-- Filtros para la tabla `equipos_componente`
--
ALTER TABLE `equipos_componente`
  ADD CONSTRAINT `FK_componente_equipo` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id`),
  ADD CONSTRAINT `FK_componente_equipo_equipo` FOREIGN KEY (`id_componente`) REFERENCES `componentes` (`id`);

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `FK_id_marca_modelo` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`);

--
-- Filtros para la tabla `permisos_submodulos`
--
ALTER TABLE `permisos_submodulos`
  ADD CONSTRAINT `FK_submodulo_permiso` FOREIGN KEY (`idsubmodulo`) REFERENCES `submodulos` (`id`);

--
-- Filtros para la tabla `permisos_submodulos_usuarios`
--
ALTER TABLE `permisos_submodulos_usuarios`
  ADD CONSTRAINT `FK_permiso_usuario` FOREIGN KEY (`idpermiso`) REFERENCES `permisos_submodulos` (`id`),
  ADD CONSTRAINT `fk_usuario_permiso` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id_usu`);

--
-- Filtros para la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD CONSTRAINT `FK_puestoDepto` FOREIGN KEY (`iddepto_puesto`) REFERENCES `departamentos` (`id_depto`);

--
-- Filtros para la tabla `software`
--
ALTER TABLE `software`
  ADD CONSTRAINT `FK_idclas_software` FOREIGN KEY (`id_clasificacion`) REFERENCES `clasificaciones` (`id`);

--
-- Filtros para la tabla `submodulos`
--
ALTER TABLE `submodulos`
  ADD CONSTRAINT `submodulos_ibfk_1` FOREIGN KEY (`modulo`) REFERENCES `modulos` (`id_modulo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
