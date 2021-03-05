-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 04 Mar 2021, 11:40
-- Wersja serwera: 10.4.13-MariaDB
-- Wersja PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `rps`
--
DROP DATABASE IF EXISTS `rps`;
CREATE DATABASE IF NOT EXISTS `rps` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
USE `rps`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stats`
--

CREATE TABLE `stats` (
  `user_id` int(255) NOT NULL,
  `user_points` int(255) NOT NULL,
  `ai_points` int(255) NOT NULL,
  `level` varchar(45) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `stats`
--

INSERT INTO `stats` (`user_id`, `user_points`, `ai_points`, `level`) VALUES
(1, 4, 3, 'expert'),
(1, 0, 0, 'expert'),
(1, 4, 3, 'expert'),
(1, 2, 1, 'intermediate'),
(1, 11, 19, 'expert'),
(2, 1, 0, 'expert'),
(2, 6, 9, 'expert'),
(2, 1, 0, 'intermediate'),
(2, 3, 2, 'expert'),
(3, 4, 3, 'expert'),
(3, 2, 1, 'intermediate'),
(3, 11, 10, 'intermediate'),
(4, 32, 31, 'intermediate'),
(5, 13, 12, 'amateur'),
(5, 12, 11, 'expert'),
(6, 5, 4, 'expert'),
(6, 3, 2, 'intermediate'),
(6, 21, 20, 'amateur'),
(6, 0, 0, 'amateur'),
(6, 0, 0, 'amateur'),
(2, 2, 1, 'amateur'),
(2, 1, 0, 'intermediate'),
(2, 3, 7, 'expert'),
(2, 7, 6, 'expert'),
(7, 4, 6, 'expert'),
(7, 9, 8, 'amateur');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `username` varchar(45) COLLATE utf8mb4_polish_ci NOT NULL,
  `passwd` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `username`, `passwd`) VALUES
(1, 'STREANCh', '$2y$10$yABEXB6718OpKVNLgBNvt.afWoSqXJfjVrntTIssda2bKUc4bG9k2'),
(2, 'PEOnaTen', '$2y$10$BKy8HQSHXj8hrYwa5oFp4eVTA7t.iUX0/Im5CmLnnO08.Ojbontga'),
(3, 'IdenArVa', '$2y$10$ZzJSAHdLOFYB8H8NAsN1huE7IaPZdG0pWllQ50caiNsOOZXCYh1U2'),
(4, 'AftsWoNt', '$2y$10$51pTvEP3vA3AxwrUJ1hR2ejo3ZzBxWuWVZoNvQC6fU0qt5JVfhS12'),
(5, 'haHMEstE', '$2y$10$Yw/RnclDdZEa5.I9Q2Hji.G2KTplV9WAu1DuQjuHaZ96QSrZFhxoC'),
(6, 'Adrian', '$2y$10$y107FOG3Lc1qXOVhNFaELOkkgw7BxmfGwYDr4wyF04vnThRKpHDa.'),
(7, 'FaMETrinsETiON', '$2y$10$1Z2xq.SplCZZVJ6jWgmPoOoKG.rE0pR7aJzI8c6J8iR1fK1WHbwxi');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `stats`
--
ALTER TABLE `stats`
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `stats`
--
ALTER TABLE `stats`
  ADD CONSTRAINT `stats_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
