-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 28 Gru 2022, 02:59
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `listatodo`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zadaniadb`
--

CREATE TABLE `zadaniadb` (
  `numer` int(11) NOT NULL,
  `zadanie` mediumtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `data` date NOT NULL,
  `czas` time NOT NULL,
  `stan` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zadaniadb`
--

INSERT INTO `zadaniadb` (`numer`, `zadanie`, `data`, `czas`, `stan`) VALUES
(1, 'Napisz aplikację', '2022-12-31', '00:55:00', 1),
(2, 'Napisz skrypty', '2022-12-30', '23:57:00', 1),
(3, 'Ustaw wygląd strony', '2022-12-31', '00:57:00', 1),
(4, 'Utwórz bazę danych ', '2022-12-30', '15:58:00', 1),
(5, 'Wypełnij bazę danych rekordami z danymi', '2022-12-31', '22:58:00', 1),
(6, 'Nauka php laravel oraz programowania obiektowego w PHP', '2022-12-29', '23:59:00', 0),
(7, 'Zwrócenie wykonanego projektu aplikacji To-Do z wykorzystaniem funkcji CRUD', '2022-12-31', '12:02:00', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `zadaniadb`
--
ALTER TABLE `zadaniadb`
  ADD PRIMARY KEY (`numer`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `zadaniadb`
--
ALTER TABLE `zadaniadb`
  MODIFY `numer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
