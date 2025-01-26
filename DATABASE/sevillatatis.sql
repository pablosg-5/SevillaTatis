-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-01-2025 a las 23:07:26
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
-- Base de datos: `sevillatatis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(255) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `nombre_usuario`, `contrasena`) VALUES
(12346, 'admin', '$2y$10$gQ2lHlxYwI1HuVZbJ8OUu.yEe0eKpwYjMAYqLJK7zys0oz6IIyE2G');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `nombre_usuario` varchar(255) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `fecha_nacimiento`, `nombre_usuario`, `contrasena`) VALUES
(22, 'Pablo', 'Sanchez', '2001-01-12', 'psangom', '$2y$10$PdcXkvv4hSBGiUGjUW94T.u8zNX1JhKrtEuEdn2ht3rKX4CqjKybS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `experiencias`
--

CREATE TABLE `experiencias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `experiencias`
--

INSERT INTO `experiencias` (`id`, `nombre`, `descripcion`, `precio`, `imagen`) VALUES
(1, 'Betis Tour', 'This experience will take you through the facilities of Real Betis Balompié, allowing you to discover more about its history, achievements, and the daily life of the players. You will have the chance to visit part of the pitch where players and the coaching staff are during matches. Additionally, you will see the club', 17.25, '../img/campo_betis.jpg'),
(2, 'Beer Tasting by Bars', 'Sevilla, a city pulsating with joy and exquisite flavors, is a haven for beer enthusiasts. Embark on this journey through some of its most iconic and trendy bars, where you\"ll savor a diverse selection of artisanal and classic beers, paired with delectable tapas.', 34.95, '../img/cerveza.jpg'),
(3, 'Alcazar Tour', 'Discover the enchanting Alcázar of Seville on a guided tour! Explore centuries of history as we wander through stunning Moorish architecture, lush gardens, and opulent royal chambers. Our expert guide will share fascinating stories about the palace\"s past, from its Islamic origins to its role as a royal residence. Don\"t miss this opportunity to experience one of Spain\"s most iconic landmarks.', 14.49, '../img/alcazar.jpg'),
(4, 'Horse Tour', 'Enjoy a unique experience riding a horse through the most emblematic streets of Seville. Our guide will take you on a relaxing ride through the historic center, allowing you to admire the architecture and local life from a different perspective. You will enjoy the breeze and the scents of the city while riding through Plaza de España, Parque de María Luisa, and other places of interest. At the end of the tour, you can take pictures with your horse and take home an unforgettable memory.', 11.95, '../img/caballo.jpg'),
(5, 'Tour for the center', 'Immerse yourself in the beauty of Plaza de España and María Luisa Park, two of Seville\"s most iconic places. Our guide will tell you the history of these places and show you the most impressive architectural details. You will walk along the canals of Plaza de España, admire the tiles and sculptures, and enjoy the tranquility of the park. At the end of the tour, you can visit the Archaeological Museum and receive a map with recommendations for nearby restaurants.', 9.95, '../img/plaza_espana.jpg'),
(6, 'Triana Tour', 'Discover the charm of the Triana neighborhood, the cradle of flamenco and Seville\"s ceramics. You will walk through its narrow streets, visit the famous Triana Bridge and the Triana Market, where you can find local products and crafts. A flamenco guide will tell you stories and legends about this neighborhood full of tradition and teach you some of the basic steps of flamenco. At the end of the tour, you can enjoy a live flamenco show and receive a handcrafted souvenir from Triana.', 19.95, '../img/triana.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `created_at`) VALUES
(9, 22, 'You have successfully reserved the experience: Betis Tour', '2025-01-26 21:44:35'),
(10, 22, 'You have successfully reserved the experience: Tour for the center', '2025-01-26 21:47:30'),
(11, 22, 'You have successfully reserved the experience: Tour for the center', '2025-01-26 21:49:09'),
(12, 22, 'You have successfully reserved the experience: Triana Tour', '2025-01-26 21:49:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_cliente` int(11) NOT NULL,
  `id_anuncio` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_cliente`, `id_anuncio`, `cantidad`, `fecha`) VALUES
(22, 1, 3, '2025-01-31'),
(22, 5, 5, '2025-02-02'),
(22, 6, 2, '2025-02-02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `experiencias`
--
ALTER TABLE `experiencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_cliente`,`id_anuncio`),
  ADD KEY `id_anuncio` (`id_anuncio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12347;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `experiencias`
--
ALTER TABLE `experiencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_anuncio`) REFERENCES `experiencias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
