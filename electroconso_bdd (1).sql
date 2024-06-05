-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-electroconso.alwaysdata.net
-- Generation Time: Jun 05, 2024 at 10:15 PM
-- Server version: 10.6.17-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electroconso_bdd`
--

-- --------------------------------------------------------

--
-- Table structure for table `consommation`
--

CREATE TABLE `consommation` (
  `Id_Consommation` int(11) NOT NULL,
  `Id_Prise` int(11) NOT NULL,
  `W` double DEFAULT NULL,
  `dateW` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `Id_Fournisseur` int(11) NOT NULL,
  `Fnom` varchar(50) DEFAULT NULL,
  `TarifElect` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fournisseur`
--

INSERT INTO `fournisseur` (`Id_Fournisseur`, `Fnom`, `TarifElect`) VALUES
(1, 'EDF', 0.15),
(2, 'Engie', 0.14),
(3, 'Total Direct Energie', 0.13),
(4, 'Eni', 0.16),
(5, 'Vattenfall', 0.12),
(6, 'Planète OUI', 0.11),
(7, 'EkWateur', 0.17),
(8, 'ilek', 0.18);

-- --------------------------------------------------------

--
-- Table structure for table `prise`
--

CREATE TABLE `prise` (
  `Id_Prise` int(11) NOT NULL,
  `NomP` varchar(50) DEFAULT NULL,
  `CodeConnexion` varchar(50) DEFAULT NULL,
  `Id_Utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `prise`
--

INSERT INTO `prise` (`Id_Prise`, `NomP`, `CodeConnexion`, `Id_Utilisateur`) VALUES
(1, 'Cuisine', '123', 3),
(2, 'Salon', '123', 3),
(3, 'Chambre', '1234567890', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tarifer`
--

CREATE TABLE `tarifer` (
  `Id_Fournisseur` int(11) NOT NULL,
  `dateE` date NOT NULL,
  `tarif` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `Id_Utilisateur` int(11) NOT NULL,
  `UNom` varchar(50) DEFAULT NULL,
  `UPrenom` varchar(50) DEFAULT NULL,
  `UMail` varchar(50) DEFAULT NULL,
  `UTel` int(11) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `Id_Fournisseur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`Id_Utilisateur`, `UNom`, `UPrenom`, `UMail`, `UTel`, `mdp`, `Id_Fournisseur`) VALUES
(3, 'Iulian', 'Ionita', 'ionita.iulian215@gmail.com', 648772014, '$2y$10$/0QRJqZsDiNO5JzhXoCny.V7lwGh/qpuV9kWodRf2HHUTsYD30fAW', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consommation`
--
ALTER TABLE `consommation`
  ADD PRIMARY KEY (`Id_Consommation`),
  ADD UNIQUE KEY `Id_Prise` (`Id_Prise`,`Id_Consommation`);

--
-- Indexes for table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`Id_Fournisseur`);

--
-- Indexes for table `prise`
--
ALTER TABLE `prise`
  ADD PRIMARY KEY (`Id_Prise`),
  ADD KEY `Id_Utilisateur` (`Id_Utilisateur`);

--
-- Indexes for table `tarifer`
--
ALTER TABLE `tarifer`
  ADD PRIMARY KEY (`Id_Fournisseur`,`dateE`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`Id_Utilisateur`),
  ADD KEY `Id_Fournisseur` (`Id_Fournisseur`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consommation`
--
ALTER TABLE `consommation`
  MODIFY `Id_Consommation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `Id_Fournisseur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prise`
--
ALTER TABLE `prise`
  MODIFY `Id_Prise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `Id_Utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consommation`
--
ALTER TABLE `consommation`
  ADD CONSTRAINT `consommation_ibfk_1` FOREIGN KEY (`Id_Prise`) REFERENCES `prise` (`Id_Prise`);

--
-- Constraints for table `prise`
--
ALTER TABLE `prise`
  ADD CONSTRAINT `prise_ibfk_1` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `utilisateur` (`Id_Utilisateur`);

--
-- Constraints for table `tarifer`
--
ALTER TABLE `tarifer`
  ADD CONSTRAINT `tarifer_ibfk_1` FOREIGN KEY (`Id_Fournisseur`) REFERENCES `fournisseur` (`Id_Fournisseur`);

--
-- Constraints for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`Id_Fournisseur`) REFERENCES `fournisseur` (`Id_Fournisseur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
