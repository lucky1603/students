-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2019 at 01:44 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studenti`
--

-- --------------------------------------------------------

--
-- Table structure for table `kursevi`
--

CREATE TABLE `kursevi` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL COMMENT 'Referenca na tablu studenata',
  `predmet_id` int(11) NOT NULL COMMENT 'Referenca na tabelu  predmeta',
  `aktivnost` int(11) DEFAULT NULL COMMENT 'U poenima',
  `prisustvo` int(11) DEFAULT NULL COMMENT 'U poenima',
  `broj_casova` int(11) DEFAULT NULL COMMENT 'U danima',
  `samostalni_zadaci` int(11) DEFAULT NULL COMMENT 'Poeni',
  `kolokvijum_1_poeni` int(11) DEFAULT NULL COMMENT 'Poeni',
  `kolokvijum_2_poeni` int(11) DEFAULT NULL COMMENT 'Poeni',
  `kolokvijum_1_datum` date DEFAULT NULL COMMENT 'Datum prvog kolokvijuma',
  `kolokvijum_2_datum` date DEFAULT NULL COMMENT 'Datum drugog kolokvijuma',
  `pismeni_datum` date DEFAULT NULL COMMENT 'Datum pismenog dela ispita.',
  `pismeni_poeni` int(11) DEFAULT NULL COMMENT 'Broj poena na pismenom delu ispita.',
  `usmeni_datum` date DEFAULT NULL COMMENT 'Datum usmenog dela ispita.',
  `usmeni_poeni` int(11) DEFAULT NULL COMMENT 'Broj poena na usmenom delu ispital',
  `poeni_ukupno_do_usmenog` int(11) DEFAULT NULL COMMENT 'Ukupan broj poena.',
  `poeni_zbir` int(11) DEFAULT NULL COMMENT 'Ukupan zbir poena.',
  `ocena` int(11) DEFAULT NULL,
  `napomene` text,
  `skolska_godina` int(11) DEFAULT NULL,
  `datum_pocetka` date DEFAULT NULL,
  `datum_okoncanja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kursevi`
--

INSERT INTO `kursevi` (`id`, `student_id`, `predmet_id`, `aktivnost`, `prisustvo`, `broj_casova`, `samostalni_zadaci`, `kolokvijum_1_poeni`, `kolokvijum_2_poeni`, `kolokvijum_1_datum`, `kolokvijum_2_datum`, `pismeni_datum`, `pismeni_poeni`, `usmeni_datum`, `usmeni_poeni`, `poeni_ukupno_do_usmenog`, `poeni_zbir`, `ocena`, `napomene`, `skolska_godina`, `datum_pocetka`, `datum_okoncanja`) VALUES
(16, 25, 1, 0, 0, NULL, 0, 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', 0, NULL, 0, NULL, '', NULL, '2019-03-21', NULL),
(20, 13, 1, 0, 0, NULL, 0, 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', 0, NULL, 0, NULL, '', NULL, '2018-10-20', NULL),
(21, 13, 2, 0, 0, NULL, 0, 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', 0, NULL, 0, NULL, '', NULL, '2018-10-20', NULL),
(22, 24, 1, 0, 0, NULL, 0, 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', 0, NULL, 0, NULL, '', NULL, '2018-10-20', NULL),
(24, 8, 1, 0, 0, NULL, 0, 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', 0, NULL, 0, NULL, '', NULL, '2018-10-20', NULL),
(26, 8, 2, 0, 0, NULL, 0, 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', 0, NULL, 0, NULL, '', NULL, '2018-10-20', NULL),
(27, 25, 2, 0, 0, NULL, 0, 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', 0, NULL, 0, NULL, '', NULL, '2018-02-21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `predmeti`
--

CREATE TABLE `predmeti` (
  `id` int(11) NOT NULL,
  `sifra` varchar(10) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `opis` text NOT NULL,
  `fond_casova` int(11) NOT NULL DEFAULT '0',
  `profesor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `predmeti`
--

INSERT INTO `predmeti` (`id`, `sifra`, `ime`, `opis`, `fond_casova`, `profesor`) VALUES
(1, '0302.11', 'Osnovi taktike i gaÅ¡enja poÅ¾ara', 'Kratak opis', 123, 'Barbara Vidakovic'),
(2, '0303.11', 'Fizika', 'Osnove fizike', 150, 'Barbara Vidakovic');

-- --------------------------------------------------------

--
-- Table structure for table `rokovi`
--

CREATE TABLE `rokovi` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `DateEnding` date NOT NULL,
  `DateBeginning` date NOT NULL,
  `Year` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rokovi`
--

INSERT INTO `rokovi` (`Id`, `Name`, `Description`, `DateEnding`, `DateBeginning`, `Year`) VALUES
(1, 'Januarsko - Februarski', '', '2019-03-01', '2019-01-24', '2018/2019'),
(2, 'Aprilski', '', '2019-04-25', '2019-03-25', '2018/2019'),
(3, 'Junski', '', '2019-06-28', '2019-06-04', '2018/2019'),
(4, 'Septembarski', '', '2018-09-06', '2018-08-19', '2018/2019'),
(5, 'Oktobar 1', '', '2019-10-04', '2019-09-16', '2018/2019'),
(6, 'Oktobar II', '', '2019-11-27', '2019-10-27', '2018/2019');

-- --------------------------------------------------------

--
-- Table structure for table `studenti`
--

CREATE TABLE `studenti` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `broj_indeksa` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `firma` varchar(100) NOT NULL,
  `telefon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studenti`
--

INSERT INTO `studenti` (`id`, `ime`, `prezime`, `broj_indeksa`, `email`, `image`, `firma`, `telefon`) VALUES
(8, 'SiniÅ¡a', 'RistiÄ‡', '34234234', 'sinisa.ristic@gmail.com', '/img/studenti/mala jaza.jpg', '', ''),
(13, 'Jovan', 'JovanoviÄ‡', '2342341234', 'jovanjov@gmail.com', '/img/studenti/Patrick McCutcheon.jpg', '', ''),
(24, 'Leny', 'Krawitz', '123412341', 'leny@gmail.com', '/img/temp/Bert-Arjan Millenaar.png', '', ''),
(25, 'Petar', 'PetroviÄ‡', '32345-19', 'petar.petrovic@mail.rs', '/img/studenti/2.jpg', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kursevi`
--
ALTER TABLE `kursevi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_predmet_uk` (`student_id`,`predmet_id`),
  ADD KEY `predmet_id` (`predmet_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `predmeti`
--
ALTER TABLE `predmeti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sifra_uk` (`sifra`);

--
-- Indexes for table `rokovi`
--
ALTER TABLE `rokovi`
  ADD UNIQUE KEY `Id` (`Id`);

--
-- Indexes for table `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `br_indeksa_email_uk` (`broj_indeksa`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kursevi`
--
ALTER TABLE `kursevi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `predmeti`
--
ALTER TABLE `predmeti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rokovi`
--
ALTER TABLE `rokovi`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `studenti`
--
ALTER TABLE `studenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kursevi`
--
ALTER TABLE `kursevi`
  ADD CONSTRAINT `kursevi_fk_predmet` FOREIGN KEY (`predmet_id`) REFERENCES `predmeti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kursevi_fk_student` FOREIGN KEY (`student_id`) REFERENCES `studenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
