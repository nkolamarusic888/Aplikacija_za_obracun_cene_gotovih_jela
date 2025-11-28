-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2025 at 01:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restoran`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikal`
--

CREATE TABLE `artikal` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `jedinica_mere` enum('kg','g','l','ml','kom') NOT NULL,
  `cena` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikal`
--

INSERT INTO `artikal` (`id`, `naziv`, `jedinica_mere`, `cena`) VALUES
(1, 'Mleveno meso', 'kg', 1200.00),
(2, 'Pirinač', 'kg', 250.00),
(3, 'Kupus', 'kg', 100.00),
(4, 'Luk', 'kg', 150.00),
(5, 'Ulje', 'l', 300.00),
(6, 'So', 'kg', 50.00),
(7, 'Začini', 'g', 10.00),
(8, 'Krompir', 'kg', 80.00),
(9, 'Paradajz pire', 'kg', 200.00),
(10, 'Brašno', 'kg', 100.00),
(11, 'Putar', 'kg', 700.00),
(12, 'Kobasica', 'kg', 800.00),
(13, 'Pasulj', 'kg', 150.00),
(14, 'Šargarepa', 'kg', 90.00),
(15, 'Celer', 'kg', 120.00),
(16, 'Pavlaka', 'l', 350.00),
(17, 'Jogurt', 'l', 200.00),
(18, 'Sir', 'kg', 800.00),
(19, 'Paradajz', 'kg', 180.00),
(20, 'Krastavac', 'kg', 100.00),
(21, 'Beli luk', 'kg', 250.00),
(22, 'Kisela voda', 'l', 50.00),
(23, 'Mleko', 'l', 120.00),
(24, 'Pavlaka', 'l', 250.00),
(25, 'Paradajz', 'kg', 200.00),
(26, 'Mleko', 'l', 120.00),
(27, 'Šargarepa', 'kg', 100.00),
(28, 'Kecap', 'l', 300.00),
(29, 'Crni luk', 'kg', 150.00),
(30, 'Beli luk', 'kg', 180.00),
(31, 'Mlečni sir', 'kg', 800.00),
(32, 'Jaja', 'kom', 25.00),
(33, 'Šećer', 'kg', 80.00),
(34, 'Vanilin šećer', 'g', 10.00),
(35, 'Kakao', 'kg', 400.00),
(36, 'Maslac', 'kg', 900.00),
(37, 'Jogurt', 'l', 150.00),
(38, 'Majonez', 'l', 300.00),
(39, 'Krastavci', 'kg', 120.00),
(40, 'Paprika', 'kg', 130.00),
(41, 'Limun', 'kom', 50.00),
(42, 'Menta', 'g', 30.00),
(43, 'Med', 'kg', 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `jelo`
--

CREATE TABLE `jelo` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `opis` text DEFAULT NULL,
  `jedinica_mere` enum('porcija','kg','g','kom','l','ml') NOT NULL,
  `planirana_kolicina` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jelo`
--

INSERT INTO `jelo` (`id`, `naziv`, `opis`, `jedinica_mere`, `planirana_kolicina`) VALUES
(1, 'Pohovano meso', 'Ukusno meso', 'porcija', 400.00),
(2, 'Sarma', 'Ukusno meso', 'porcija', 500.00),
(3, 'Biftek', 'Ukusno meso', 'porcija', 500.00),
(5, 'Pohovano meso', 'Ukusno meso', 'porcija', 500.00),
(10, 'Pohovano meso', 'Ukusno meso', 'porcija', 500.00),
(11, 'Riba', 'Ukusno riba', 'porcija', 400.00),
(14, 'Paradazj pire', 'Ukusno riba', 'porcija', 400.00),
(17, 'Gulas', 'Tradicionalno jelo', 'porcija', 400.00),
(19, 'PIleci file', 'Ukusno', 'g', 400.00),
(20, 'Becka snicla', 'Veoma ukusno', 'g', 300.00),
(24, 'Musakaa', 'vdvd', 'kg', 1.00),
(26, 'Rostilj', 'Ukusno', 'kg', 1.00),
(28, 'Pasulj', '', 'g', 400.00),
(65, 'Mican', '', 'g', 0.23),
(66, 'Mican', '', 'g', 0.23),
(67, 'Mican', '', 'g', 0.23),
(68, 'Mican', '', 'g', 0.23),
(69, 'Mican', '', 'g', 0.23),
(70, 'Mican', '', 'g', 0.23),
(71, 'Mican', '', 'g', 0.23),
(72, 'Mican', '', 'g', 0.23),
(73, 'Mican', '', 'g', 0.23),
(74, 'Mican', '', 'g', 0.23),
(75, 'Mican', '', 'g', 0.23),
(76, 'Paradj pire', '', 'kom', 112.00),
(77, 'Paradj pire', '', 'kom', 112.00),
(78, 'Paradj pire', '', 'kom', 112.00),
(79, 'Pecen belo', '', 'g', 112.00),
(80, 'Pecen belo', '', 'g', 112.00),
(81, 'Pecen belo', '', 'g', 112.00),
(82, 'Prsuta', 'Ukusno predjelo', 'g', 300.00),
(83, 'Vino', 'Ukusno', 'l', 0.50),
(84, 'Pecena piletina', '', 'g', 200.00),
(85, 'Pasta sa sirom', 'Brzo i ukusno', 'porcija', 300.00),
(86, 'Pizza', 'Klasična margarita', 'porcija', 400.00),
(87, 'Piletina sa povrćem', 'Zdravo i ukusno', 'porcija', 500.00),
(88, 'Gulaš sa povrćem', 'Tradicionalno jelo', 'porcija', 400.00),
(89, 'Salata šopska', 'Osvežavajuća', 'porcija', 200.00),
(90, 'Musaka sa krompirom', 'Ukusna domaća musaka', 'porcija', 300.00),
(91, 'Riblja čorba', 'Lagano predjelo', 'l', 5.00),
(92, 'Palačinke', 'Slatko zadovoljstvo', 'kom', 10.00),
(93, 'Supa od povrća', 'Zdravo i toplo', 'l', 4.00),
(94, 'Burger', 'Popularno jelo', 'porcija', 400.00),
(95, 'Pasta Carbonara', 'Kremasta pasta sa slaninom i jajima', 'porcija', 400.00),
(96, 'Piletina sa povrćem', 'Zdravo jelo sa mešavinom povrća', 'porcija', 500.00),
(97, 'Musaka od patlidžana', 'Tradicionalna musaka sa patlidžanom', 'porcija', 400.00),
(98, 'Gulaš od govedine', 'Gust gulaš sa začinima', 'porcija', 500.00),
(99, 'Salata sa piletinom', 'Osvežavajuća salata sa grilovanom piletinom', 'porcija', 300.00),
(100, 'Riblja čorba', 'Ukusna čorba od ribe i povrća', 'porcija', 400.00),
(101, 'Palačinke sa čokoladom', 'Slatke palačinke za desert', 'kom', 2.00),
(102, 'Bečka šnicla', 'Klasična pohovana šnicla', 'porcija', 400.00),
(103, 'Pečeni krompir', 'Krompir pečen u rerni sa začinima', 'kg', 1.00),
(104, 'Pasta Bolognese', 'Pasta sa mesnim sosom', 'porcija', 400.00),
(105, 'Belo Vino', 'Belo je', 'l', 0.20),
(106, 'Belo Vino', 'Belo je', 'l', 0.20),
(107, 'Belo Vino', 'Belo je', 'l', 0.20),
(108, 'Belo Vino', 'Belo je', 'l', 0.20),
(109, 'Grilovano meso', '', 'porcija', 1.00),
(110, 'Biftek', 'Ukusan', 'g', 200.00),
(111, 'Rolovano belo', 'Veoma ukusno meso', 'g', 300.00),
(112, 'Domaci kajmak', 'Tradicionalno domaci', 'g', 300.00);

-- --------------------------------------------------------

--
-- Table structure for table `receptura`
--

CREATE TABLE `receptura` (
  `id` int(11) NOT NULL,
  `jelo_id` int(11) NOT NULL,
  `artikal_id` int(11) NOT NULL,
  `jedinica` enum('kg','g','l','ml','kom') NOT NULL,
  `kolicina` decimal(10,2) NOT NULL,
  `cena` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receptura`
--

INSERT INTO `receptura` (`id`, `jelo_id`, `artikal_id`, `jedinica`, `kolicina`, `cena`) VALUES
(1, 1, 2, 'kg', 0.50, 2000.00),
(2, 1, 3, 'kg', 1.00, 300.00),
(7, 3, 6, 'kg', 0.30, 234.00),
(12, 5, 12, 'g', 400.00, 0.30),
(13, 5, 8, 'kg', 0.40, 300.00),
(18, 10, 4, 'kg', 11.00, 11.00),
(19, 11, 12, 'kg', 1.00, 400.00),
(22, 14, 9, 'kg', 2.00, 400.00),
(24, 17, 1, 'kg', 0.60, 400.00),
(25, 17, 2, 'g', 800.00, 4.00),
(26, 17, 1, 'kg', 0.60, 400.00),
(27, 17, 2, 'g', 800.00, 4.00),
(33, 3, 7, 'kg', 0.40, 123.00),
(34, 3, 8, 'kg', 0.50, 100.00),
(40, 19, 12, 'kg', 1.04, 1266.00),
(43, 19, 12, 'kg', 0.10, 122.00),
(46, 20, 1, 'kg', 1.00, 214.00),
(49, 20, 6, 'kg', 1.00, 12.00),
(51, 26, 12, 'kg', 22.20, 500.00),
(54, 28, 2, 'g', 400.00, 2.00),
(57, 2, 10, 'kg', 12.00, 1.50),
(59, 26, 12, 'l', 12.00, 122.00),
(60, 17, 12, 'kg', 1.00, 123.00),
(61, 2, 12, 'kg', 1.00, 123.00),
(86, 82, 10, 'g', 120.00, 14.00),
(87, 82, 1, 'kg', 0.50, 300.00),
(88, 82, 5, 'l', 0.30, 180.00),
(89, 82, 1, 'kg', 0.50, 300.00),
(90, 82, 5, 'l', 0.30, 180.00),
(93, 2, 3, 'g', 320.00, 23.00),
(94, 82, 12, 'g', 123.00, 12.00),
(125, 85, 14, 'l', 0.20, 250.00),
(126, 85, 15, 'kg', 0.30, 200.00),
(127, 85, 9, 'kom', 2.00, 25.00),
(128, 85, 16, 'kg', 0.10, 150.00),
(129, 86, 1, 'kg', 0.40, 1200.00),
(130, 86, 17, 'kg', 0.30, 130.00),
(131, 86, 18, 'kg', 0.20, 180.00),
(132, 87, 19, 'kg', 0.50, 500.00),
(133, 87, 16, 'kg', 0.20, 150.00),
(134, 87, 14, 'l', 0.30, 250.00),
(135, 87, 10, 'kg', 0.40, 100.00),
(136, 88, 1, 'kg', 0.60, 1200.00),
(137, 88, 6, 'kg', 0.10, 50.00),
(138, 88, 7, 'g', 10.00, 10.00),
(139, 89, 11, 'kg', 0.30, 700.00),
(140, 89, 17, 'kg', 0.20, 130.00),
(141, 89, 16, 'kg', 0.10, 150.00),
(142, 1, 28, 'g', 200.00, 2.00),
(143, 1, 28, 'g', 200.00, 2.00),
(144, 1, 28, 'g', 200.00, 2.00),
(145, 20, 32, 'g', 300.00, 2.00),
(146, 111, 8, 'g', 400.00, 4.00),
(147, 86, 32, 'kom', 3.00, 20.00),
(148, 86, 32, 'kom', 3.00, 20.00),
(149, 86, 32, 'kom', 3.00, 20.00),
(150, 111, 28, 'kg', 0.20, 300.00),
(151, 111, 12, 'g', 400.00, 2.00),
(153, 112, 16, 'g', 50.00, 8.00),
(154, 112, 10, 'g', 200.00, 2.00),
(155, 112, 12, 'g', 200.00, 5.00),
(156, 112, 37, 'l', 0.50, 200.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikal`
--
ALTER TABLE `artikal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jelo`
--
ALTER TABLE `jelo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receptura`
--
ALTER TABLE `receptura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jelo_id` (`jelo_id`),
  ADD KEY `artikal_id` (`artikal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikal`
--
ALTER TABLE `artikal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `jelo`
--
ALTER TABLE `jelo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `receptura`
--
ALTER TABLE `receptura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `receptura`
--
ALTER TABLE `receptura`
  ADD CONSTRAINT `receptura_ibfk_1` FOREIGN KEY (`jelo_id`) REFERENCES `jelo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `receptura_ibfk_2` FOREIGN KEY (`artikal_id`) REFERENCES `artikal` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
