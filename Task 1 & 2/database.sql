-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 03:11 AM
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
-- Database: `sportradar_backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `match`
--

CREATE TABLE `match` (
  `Match_ID` int(11) NOT NULL,
  `Season` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Time_Venue_UTC` time NOT NULL,
  `Date_Venue` date NOT NULL,
  `Stadium` varchar(100) DEFAULT NULL,
  `Home_Team_ID_foreignkey` int(11) DEFAULT NULL,
  `Away_Team_ID_foreignkey` int(11) DEFAULT NULL,
  `Result_ID_foreignkey` int(11) DEFAULT NULL,
  `Stage_ID_foreignkey` varchar(50) DEFAULT NULL,
  `Origin_Competition_ID` varchar(50) DEFAULT NULL,
  `Origin_Competition_Name` varchar(100) DEFAULT NULL,
  `Sport` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `match`
--

INSERT INTO `match` (`Match_ID`, `Season`, `Status`, `Time_Venue_UTC`, `Date_Venue`, `Stadium`, `Home_Team_ID_foreignkey`, `Away_Team_ID_foreignkey`, `Result_ID_foreignkey`, `Stage_ID_foreignkey`, `Origin_Competition_ID`, `Origin_Competition_Name`, `Sport`) VALUES
(42, 2025, 'played', '00:00:00', '2024-11-03', NULL, 382, 383, NULL, 'f7a7309b-a491-11ef-9fa5-b07d64ea8bdd', 'afc-champions-league', 'AFC Champions League', 'football'),
(43, 2025, 'scheduled', '16:00:00', '2024-11-03', NULL, 384, 385, NULL, 'f7a7309b-a491-11ef-9fa5-b07d64ea8bdd', 'afc-champions-league', 'AFC Champions League', 'football'),
(44, 2025, 'scheduled', '15:25:00', '2024-11-04', NULL, 386, 387, NULL, 'f7a7309b-a491-11ef-9fa5-b07d64ea8bdd', 'afc-champions-league', 'AFC Champions League', 'football'),
(45, 2025, 'scheduled', '08:00:00', '2024-11-04', NULL, 388, 389, NULL, 'f7a7309b-a491-11ef-9fa5-b07d64ea8bdd', 'afc-champions-league', 'AFC Champions League', 'football'),
(46, 2025, 'scheduled', '02:02:00', '2025-01-01', NULL, 383, 387, NULL, 'f7a7309b-a491-11ef-9fa5-b07d64ea8bdd', NULL, NULL, 'Basketball'),
(47, 2025, 'scheduled', '22:22:00', '2222-02-02', NULL, 388, 384, NULL, 'f7a7309b-a491-11ef-9fa5-b07d64ea8bdd', NULL, NULL, 'Tenis'),
(48, 2025, 'scheduled', '11:01:00', '2025-11-11', NULL, 386, 386, NULL, 'f7a7309b-a491-11ef-9fa5-b07d64ea8bdd', NULL, NULL, 'Football'),
(49, 2025, 'scheduled', '22:02:00', '2025-02-11', NULL, 382, 385, NULL, 'f7a7309b-a491-11ef-9fa5-b07d64ea8bdd', NULL, NULL, 'Football');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `Result_ID` int(11) NOT NULL,
  `Home_Goals` int(11) DEFAULT NULL,
  `Away_Goals` int(11) DEFAULT NULL,
  `Winner` varchar(100) DEFAULT NULL,
  `Message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stage`
--

CREATE TABLE `stage` (
  `Stage_ID` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Ordering` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stage`
--

INSERT INTO `stage` (`Stage_ID`, `Name`, `Ordering`) VALUES
('f7a7309b-a491-11ef-9fa5-b07d64ea8bdd', 'ROUND OF 16', NULL),
('final-id', 'Final', NULL),
('half-final-id', 'Half Final', NULL),
('quarter-final-id', 'Quarter Final', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `Team_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Official_Name` varchar(100) DEFAULT NULL,
  `Slug` varchar(100) DEFAULT NULL,
  `Abbreviation` varchar(10) DEFAULT NULL,
  `Team_Country_Code` char(3) DEFAULT NULL,
  `Stage_Position` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`Team_ID`, `Name`, `Official_Name`, `Slug`, `Abbreviation`, `Team_Country_Code`, `Stage_Position`) VALUES
(382, 'Al Shabab', 'Al Shabab FC', 'al-shabab-fc', 'SHA', 'KSA', 'N/A'),
(383, 'Nasaf', 'FC Nasaf', 'fc-nasaf-qarshi', 'NAS', 'UZB', 'N/A'),
(384, 'Al Hilal', 'Al Hilal Saudi FC', 'al-hilal-saudi-fc', 'HIL', 'KSA', 'N/A'),
(385, 'Shabab Al Ahli', 'SHABAB AL AHLI DUBAI', 'shabab-al-ahli-club', 'SAH', 'UAE', 'N/A'),
(386, 'Al Duhail', 'AL DUHAIL SC', 'al-duhail-sc', 'DUH', 'QAT', 'N/A'),
(387, 'Al Rayyan', 'AL RAYYAN SC', 'al-rayyan-sc', 'RYN', 'QAT', 'N/A'),
(388, 'Al Faisaly', 'Al Faisaly FC', 'al-faisaly-fc', 'FAI', 'KSA', 'N/A'),
(389, 'Foolad', 'FOOLAD KHOUZESTAN FC', 'foolad-khuzestan-fc', 'FLD', 'IRN', 'N/A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `match`
--
ALTER TABLE `match`
  ADD PRIMARY KEY (`Match_ID`),
  ADD UNIQUE KEY `Date_Venue` (`Date_Venue`,`Time_Venue_UTC`,`Home_Team_ID_foreignkey`,`Away_Team_ID_foreignkey`),
  ADD UNIQUE KEY `Date_Venue_2` (`Date_Venue`,`Time_Venue_UTC`,`Stage_ID_foreignkey`),
  ADD KEY `Home_Team_ID_foreignkey` (`Home_Team_ID_foreignkey`),
  ADD KEY `Away_Team_ID_foreignkey` (`Away_Team_ID_foreignkey`),
  ADD KEY `Result_ID_foreignkey` (`Result_ID_foreignkey`),
  ADD KEY `Stage_ID_foreignkey` (`Stage_ID_foreignkey`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`Result_ID`);

--
-- Indexes for table `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`Stage_ID`),
  ADD UNIQUE KEY `Stage_ID` (`Stage_ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`Team_ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD UNIQUE KEY `Official_Name` (`Official_Name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `match`
--
ALTER TABLE `match`
  MODIFY `Match_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `Result_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `Team_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=646;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `match_ibfk_1` FOREIGN KEY (`Home_Team_ID_foreignkey`) REFERENCES `team` (`Team_ID`),
  ADD CONSTRAINT `match_ibfk_2` FOREIGN KEY (`Away_Team_ID_foreignkey`) REFERENCES `team` (`Team_ID`),
  ADD CONSTRAINT `match_ibfk_3` FOREIGN KEY (`Result_ID_foreignkey`) REFERENCES `result` (`Result_ID`),
  ADD CONSTRAINT `match_ibfk_4` FOREIGN KEY (`Stage_ID_foreignkey`) REFERENCES `stage` (`Stage_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
