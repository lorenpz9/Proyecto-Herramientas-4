-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2025 a las 21:09:16
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
-- Base de datos: `hotel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `correoelectronico` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `apellido`, `correoelectronico`, `contrasena`) VALUES
(1, 'adrian', 'aaa', 'adrian@hotmail.com', '$2y$10$20PS6GXLusRFXqsdXnVvJ.5ufghdGQ7v2K/HI5ylzlakZO//Q8Dme'),
(3, 'adrian', 'wies|', 'adrianwv@hotmail.com', 'neos1'),
(4, 'adrian', 'aas', 'adriana@hotmail.com', 'aaa'),
(6, 'jorge', 'aas', 'sasddf@hjf', 'ssa'),
(7, 'adrian', 'aas', 'hola@aasdsd', 'das'),
(8, 'assa', 'sasasa', 'sasddf@hjz', 'ss'),
(9, 'adrian', 'wies|', 'assd@ssasa', 'aa'),
(10, 'sda', 'aas', 'sasddf@hjfasa', 'asass'),
(11, 'asa', 'asas', 'adrian@hotmail.comss', 'saas'),
(12, 'assa', 'saas', 'ssddsasd@11', 'sasa'),
(13, 'adrianwv', 'wies|', 'adrian@hotmail.comssaa', 'sasda'),
(14, 'adrianwv', 'a', 'sasddf@hjfaa', 'sad'),
(15, 'adrian', 'a', 'adrian@hotmail.comssddddd', 'as'),
(16, 'adrian', 'aas', 'adrianwv@hotmail.comaaaddvcv', 'assa'),
(17, 'fabioel', 'aas', 'adrianwv@hotmail.comaaaddvcsasaasv', 'assa'),
(18, 'pato', 'asas', 'sasacxsccscccscs@haaa', 'sasasas'),
(19, 'sssass', 'asasa', 'asdas@hhhgg', 'jhh'),
(20, 'adrian', 'a', 'sasddf@hjfaad', 'sasd'),
(21, 'adrianwv', 'sdaa', 'dsad@bvfbgb', 'dsadasd'),
(22, 'jorge', 'sadas', 'sadsdsd@2221', 'aaa'),
(23, 'adrian', 'a', 'sasddf@hjfaaads', 'sd'),
(24, 'asdasd', 'sadsa', 'adrian@hotmail.comaasdasdas', 'ssaddas'),
(25, 'adrianwv', 'sdsa', 'sdasdasdsd@1dsffdsfdssdf', 'assa'),
(26, 'dsadasdasdsa', 'sdadsasdads', 'sasddf@hjfssa', 'asdasdsa'),
(27, 'adrianwv', 'dsds', 'dsadasda@11', 'aas'),
(28, 'adrianwv', 'sdasad', 'sasddf@hjfassa', 'saasdasd'),
(29, 'sdasdadsa', 'aas', 'adrian@hotmail.com32312', 'as'),
(30, 'dsasd', 'sddsdd', 'ddsdasdsa@211', 'assa'),
(31, 'saasdasd', 'saddsasda', 'adrian@hotmail.comsasadasf', 'sasad'),
(32, 'saxsda', 'asdsda', 'asdss@aasdsa', '123'),
(33, 'saddsasda', 'sdadas', 'sadsa@asdasdas', 'sadsasaddsa'),
(34, 'adrianwv', 'aas', 'asdsa@1232', 'asas'),
(35, 'asassa', 'sasasa', 'sadsdsd@2221aaa', 'sasaas'),
(36, 'adrianwv', 'a', 'adrianwv@hotmail.comasas', 'asasdads'),
(37, 'adrian', 'sasa', 'sasddf@hjfsasasa', 'saddsasda'),
(38, 'jorge', 'dads', 'adrian@hotmail.comaaadsc', 'dasdsad'),
(39, 'adrianwv', 'ghgvgvgvgv', 'adrian@hotmail.com234154', 'hjuyhguyh'),
(40, 'juancarlos', 'fctfytyf', 'adrian@hotmail.com556487', 'aaa'),
(41, 'Pancho', 'Cabrera', 'tuviejoen4@htomail.com', 'vivalasvegas'),
(42, 'Joaquin', 'Perez', 'mandos_123@gmail.com', 'vicecity'),
(43, 'Luis', 'Damian', 'manolito@hotmail.com', '12340'),
(44, 'admin', 'Morales', 'daniellitomaldito@gmail.com', '|123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correoelectronico` (`correoelectronico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
