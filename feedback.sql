-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Loomise aeg: Mai 28, 2025 kell 04:44 PL
-- Serveri versioon: 10.4.32-MariaDB
-- PHP versioon: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Andmebaas: `homework`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) UNSIGNED NOT NULL,
  `added` datetime NOT NULL DEFAULT current_timestamp(),
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `feedback`
--

INSERT INTO `feedback` (`id`, `added`, `name`, `email`, `message`) VALUES
(4, '2025-05-23 12:59:13', 'Oinas Olen', 'oinas@oinas.com', 'Mulle see leht väga meeldib.'),
(5, '2025-05-23 13:05:59', 'Kusti Kukk', 'kukekusti@gmail.com', 'Mulle see leht ei meeldi!'),
(6, '2025-05-27 16:31:41', 'Lammas', 'lammas@hot.ee', 'Tere! Mina olen lammas.'),
(9, '2025-05-27 16:57:51', 'Mari Karus', 'karusmari@mail.ee', 'Palun võtme minuga ühendust!');

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
