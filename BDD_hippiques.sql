-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2025 at 01:59 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hippiques`
--

-- --------------------------------------------------------

--
-- Table structure for table `cheval`
--

CREATE TABLE `cheval` (
  `IFCE` int NOT NULL,
  `nom_cheval` varchar(50) DEFAULT NULL,
  `dateNaissance_cheval` date DEFAULT NULL,
  `race_cheval` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id_course` int NOT NULL,
  `date_course` datetime DEFAULT NULL,
  `id_hippodrome` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipe`
--

CREATE TABLE `equipe` (
  `id_equipe` int NOT NULL,
  `matricule_jockey` int NOT NULL,
  `IFCE` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hippodrome`
--

CREATE TABLE `hippodrome` (
  `id_hippodrome` int NOT NULL,
  `localisation_hippodrome` varchar(255) DEFAULT NULL,
  `capacite_hippodrome` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jockey`
--

CREATE TABLE `jockey` (
  `matricule_jockey` int NOT NULL,
  `nom_jockey` varchar(50) DEFAULT NULL,
  `dateNaissance_jockey` date DEFAULT NULL,
  `genre_jockey` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participe`
--

CREATE TABLE `participe` (
  `id_course` int NOT NULL,
  `id_equipe` int NOT NULL,
  `num_dossard` int DEFAULT NULL,
  `temps` smallint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_User` int NOT NULL,
  `identifiant` varchar(50) DEFAULT NULL,
  `mdp` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_User`, `identifiant`, `mdp`, `type`) VALUES
(5, 'admin', 'test', 1),
(6, 'gest', 'test', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cheval`
--
ALTER TABLE `cheval`
  ADD PRIMARY KEY (`IFCE`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id_course`),
  ADD KEY `id_hippodrome` (`id_hippodrome`);

--
-- Indexes for table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id_equipe`),
  ADD KEY `matricule_jockey` (`matricule_jockey`),
  ADD KEY `IFCE` (`IFCE`);

--
-- Indexes for table `hippodrome`
--
ALTER TABLE `hippodrome`
  ADD PRIMARY KEY (`id_hippodrome`);

--
-- Indexes for table `jockey`
--
ALTER TABLE `jockey`
  ADD PRIMARY KEY (`matricule_jockey`);

--
-- Indexes for table `participe`
--
ALTER TABLE `participe`
  ADD PRIMARY KEY (`id_course`,`id_equipe`),
  ADD KEY `id_equipe` (`id_equipe`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_User`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id_course` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id_equipe` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hippodrome`
--
ALTER TABLE `hippodrome`
  MODIFY `id_hippodrome` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_User` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`id_hippodrome`) REFERENCES `hippodrome` (`id_hippodrome`);

--
-- Constraints for table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `equipe_ibfk_1` FOREIGN KEY (`matricule_jockey`) REFERENCES `jockey` (`matricule_jockey`),
  ADD CONSTRAINT `equipe_ibfk_2` FOREIGN KEY (`IFCE`) REFERENCES `cheval` (`IFCE`);

--
-- Constraints for table `participe`
--
ALTER TABLE `participe`
  ADD CONSTRAINT `participe_ibfk_1` FOREIGN KEY (`id_course`) REFERENCES `course` (`id_course`),
  ADD CONSTRAINT `participe_ibfk_2` FOREIGN KEY (`id_equipe`) REFERENCES `equipe` (`id_equipe`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;