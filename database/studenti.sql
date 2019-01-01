-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 07, 2018 at 01:54 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

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
  `napomene` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kursevi`
--

INSERT INTO `kursevi` (`id`, `student_id`, `predmet_id`, `prisustvo`, `broj_casova`, `samostalni_zadaci`, `kolokvijum_1_poeni`, `kolokvijum_2_poeni`, `kolokvijum_1_datum`, `kolokvijum_2_datum`, `pismeni_datum`, `pismeni_poeni`, `usmeni_datum`, `usmeni_poeni`, `poeni_ukupno_do_usmenog`, `poeni_zbir`, `ocena`, `napomene`) VALUES
(1, 8, 1, 12, 110, 0, 56, 67, '2017-11-21', '2017-12-05', '0000-00-00', 0, '0000-00-00', NULL, 0, 0, 0, 'nisa specijalno'),
(2, 9, 1, 12, 33, NULL, 67, 89, '2017-11-22', '2017-12-14', '0000-00-00', 0, '0000-00-00', NULL, 0, 0, 0, NULL),
(3, 13, 1, 0, 0, NULL, 45, 77, '2017-11-23', '2017-12-21', '0000-00-00', 0, '0000-00-00', NULL, 0, 0, 0, NULL),
(4, 14, 1, 0, 0, NULL, 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', NULL, 0, 0, 0, NULL),
(5, 14, 2, 0, 0, NULL, 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', NULL, 0, 0, 0, NULL);

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
(1, '0302.11', 'Osnovi taktike i gasenja pozara.', 'Kratak opis', 123, 'Barbara Vidakovic'),
(2, '0303.11', 'Fizika', 'Osnove fizike', 150, 'Barbara Vidakovic');

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
(8, 'Sinisa', 'Ristic', '34234234', 'sinisa.ristic@gmail.com', '/img/studenti/mala jaza.jpg', '', ''),
(9, 'Barbara', 'Vidakovic', '3412341234', 'barbaravid@yahoo.co.uk', '/img/studenti/barbara.png', '', ''),
(13, 'Jovan', 'Jovanovic', '2342341234', 'jovanjov@gmail.com', '/img/studenti/Patrick McCutcheon.jpg', '', ''),
(14, 'Mira', 'Markovic', '2342141234', 'mmark@gmail.com', '/img/studenti/Nadja Spitzer.jpg', '', ''),
(16, 'sfasdf', 'asdfasdfa', '5234523452', 'mma@gmail.com', '/img/studenti/Viola Gauci.jpg', '', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `predmeti`
--
ALTER TABLE `predmeti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `studenti`
--
ALTER TABLE `studenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
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
