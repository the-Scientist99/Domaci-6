-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2021 at 02:44 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nekretnina_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `foto_nekretnine`
--

CREATE TABLE `foto_nekretnine` (
  `id` int(11) NOT NULL,
  `fotografija` varchar(255) NOT NULL DEFAULT './uploads/no-photo.png',
  `nekretnina_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foto_nekretnine`
--

INSERT INTO `foto_nekretnine` (`id`, `fotografija`, `nekretnina_id`) VALUES
(10, './uploads/6032937f1920f.jpg', 7),
(11, './uploads/6032937f1c2b8.png', 7),
(12, './uploads/60329e42a46a3.jpg', 8),
(13, './uploads/60329e42a63ee.jpg', 8),
(14, './uploads/60329e938b183.png', 9),
(16, './uploads/60329ed79172f.png', 11),
(17, './uploads/60329ef3d67d5.png', 12),
(20, './uploads/603576db64abf.jpeg', 15),
(22, './uploads/60357fb164b56.jpg', 18);

-- --------------------------------------------------------

--
-- Table structure for table `grad`
--

CREATE TABLE `grad` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grad`
--

INSERT INTO `grad` (`id`, `naziv`) VALUES
(1, 'Podgorica'),
(2, 'Nikšić'),
(3, 'Pljevlja'),
(4, 'Bijelo Polje'),
(5, 'Cetinje'),
(6, 'Bar'),
(7, 'Herceg Novi'),
(8, 'Berane'),
(9, 'Budva'),
(10, 'Ulcinj'),
(11, 'Tivat'),
(12, 'Rožaje'),
(13, 'Kotor'),
(14, 'Danilovgrad'),
(15, 'Mojkovac'),
(16, 'Plav'),
(17, 'Kolašin'),
(18, 'Žabljak'),
(19, 'Plužine'),
(20, 'Andrijevica'),
(21, 'Šavnik');

-- --------------------------------------------------------

--
-- Table structure for table `nekretnina`
--

CREATE TABLE `nekretnina` (
  `id` int(11) NOT NULL,
  `grad_id` int(11) NOT NULL,
  `tip_oglasa_id` int(11) NOT NULL,
  `tip_nekretnine_id` int(11) NOT NULL,
  `povrsina` int(11) NOT NULL,
  `cijena` int(11) NOT NULL,
  `god_izgradnje` date DEFAULT NULL,
  `opis` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'dostupno',
  `dat_prodaje` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nekretnina`
--

INSERT INTO `nekretnina` (`id`, `grad_id`, `tip_oglasa_id`, `tip_nekretnine_id`, `povrsina`, `cijena`, `god_izgradnje`, `opis`, `status`, `dat_prodaje`) VALUES
(7, 12, 3, 3, 59, 88, '1980-12-28', 'Accusamus fugit des', 'dostupno', NULL),
(8, 8, 3, 2, 96, 72, '2006-03-24', 'Voluptatem vitae pro', 'dostupno', NULL),
(9, 7, 3, 3, 59, 52, '2017-03-21', 'Voluptas est quos vo', 'prodato', '2021-02-10'),
(11, 13, 2, 2, 72, 51, '1996-12-05', 'Sunt omnis neque omn', 'prodato', '2021-02-10'),
(12, 13, 1, 2, 8, 8, '2006-08-18', 'Et fugiat aut sapien', 'dostupno', NULL),
(15, 11, 3, 2, 69, 55, '2004-01-06', 'Reprehenderit et vo', 'dostupno', NULL),
(17, 6, 2, 1, 97, 80, '2019-01-05', 'Voluptas quod incidi', 'dostupno', NULL),
(18, 13, 3, 2, 34, 62, '1977-12-06', 'Vel in irure quia ar', 'dostupno', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tip_nekretnine`
--

CREATE TABLE `tip_nekretnine` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tip_nekretnine`
--

INSERT INTO `tip_nekretnine` (`id`, `naziv`) VALUES
(1, 'stan'),
(2, 'kuća'),
(3, 'garaža'),
(4, 'poslovni prostor');

-- --------------------------------------------------------

--
-- Table structure for table `tip_oglasa`
--

CREATE TABLE `tip_oglasa` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tip_oglasa`
--

INSERT INTO `tip_oglasa` (`id`, `naziv`) VALUES
(1, 'prodaja'),
(2, 'iznajmljivanje'),
(3, 'kompenzacija');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foto_nekretnine`
--
ALTER TABLE `foto_nekretnine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foto_nekretnine_nekretnina` (`nekretnina_id`);

--
-- Indexes for table `grad`
--
ALTER TABLE `grad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nekretnina`
--
ALTER TABLE `nekretnina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nekretnina_grad` (`grad_id`),
  ADD KEY `fk_nekretnina_tip_nekretnine` (`tip_nekretnine_id`),
  ADD KEY `fk_nekretnina_tip_oglasa` (`tip_oglasa_id`);

--
-- Indexes for table `tip_nekretnine`
--
ALTER TABLE `tip_nekretnine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tip_oglasa`
--
ALTER TABLE `tip_oglasa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foto_nekretnine`
--
ALTER TABLE `foto_nekretnine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `grad`
--
ALTER TABLE `grad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `nekretnina`
--
ALTER TABLE `nekretnina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tip_nekretnine`
--
ALTER TABLE `tip_nekretnine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tip_oglasa`
--
ALTER TABLE `tip_oglasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `foto_nekretnine`
--
ALTER TABLE `foto_nekretnine`
  ADD CONSTRAINT `fk_foto_nekretnine_nekretnina` FOREIGN KEY (`nekretnina_id`) REFERENCES `nekretnina` (`id`);

--
-- Constraints for table `nekretnina`
--
ALTER TABLE `nekretnina`
  ADD CONSTRAINT `fk_nekretnina_tip_nekretnine` FOREIGN KEY (`tip_nekretnine_id`) REFERENCES `tip_nekretnine` (`id`),
  ADD CONSTRAINT `fk_nekretnina_tip_oglasa` FOREIGN KEY (`tip_oglasa_id`) REFERENCES `tip_oglasa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
