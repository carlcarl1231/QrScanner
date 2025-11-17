-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2025 at 08:40 AM
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
-- Database: `scandb`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_scan`
--

CREATE TABLE `table_scan` (
  `ID` int(11) NOT NULL,
  `fName` varchar(250) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `mi` varchar(50) NOT NULL,
  `plateNumber` varchar(250) NOT NULL,
  `vehicleType` varchar(250) NOT NULL,
  `address` varchar(150) NOT NULL,
  `contactNumber` varchar(20) NOT NULL,
  `orcr` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `table_scan`
--

INSERT INTO `table_scan` (`ID`, `fName`, `lName`, `mi`, `plateNumber`, `vehicleType`, `address`, `contactNumber`, `orcr`) VALUES
(74, 'Carl Japheth', 'Gomeza', 'h', 'jjj 99', 'Car', 'Capitol East', '000000000', 0),
(75, 'Carl Japheth', 'Gomez', 'S', 'aga 1111', 'Car', 'Capitol East', '09947848985', 0),
(76, 'Vowhls', 'Ligma', 'S.', 'AKA 6253', 'Car', 'Capitol West', '09947848985', 0),
(77, 'Mike', 'Tyson', 'L.', 'KAS 7231', 'Car', 'Prk.2, Buayan, General Santos City ', '09972717237', 0),
(78, 'Mike', 'Tyson', 'S.', 'ASD 1231', 'Motorcycle', 'Prk.2, Buayan, General Santos City ', '09385623841', 0),
(79, 'Ryan Mico', 'Lapena', 'D', '1206212', 'Truck', 'Capitol East', '09947848985', 0),
(80, 'sample', 'sample', 'sample', 'sample', 'Car', 'Capitol East', '09947848985', 1),
(81, 'sample2', 'sample2', 'sample2', '1231', 'Car', 'asd', 'aasd', 0),
(82, 'sample3', 'sample3', 'sample3', 'sample3', 'Tricycle', 'sample3', 'sample3', 1),
(84, 'sample4', 'sample4', 'sample4', 'sample123', 'Car', 'sample', '1231231239', 1);

--
-- Triggers `table_scan`
--
DELIMITER $$
CREATE TRIGGER `create_user_after_scan` AFTER INSERT ON `table_scan` FOR EACH ROW INSERT INTO user_tb (username)
VALUES (LOWER(CONCAT(NEW.fname, ".", NEW.lname)))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `table_scan2`
--

CREATE TABLE `table_scan2` (
  `id2` int(11) NOT NULL,
  `timeIn` varchar(250) NOT NULL,
  `timeOut` varchar(250) NOT NULL,
  `logDate` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `IDIndex` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `table_scan2`
--

INSERT INTO `table_scan2` (`id2`, `timeIn`, `timeOut`, `logDate`, `status`, `IDIndex`) VALUES
(22, '13:13', '13:13', '2024-10-08', '1', 76),
(23, '13:13', '13:14', '2024-10-08', '1', 75),
(24, '13:14', '13:28', '2024-10-08', '1', 75),
(25, '13:28', '13:28', '2024-10-08', '1', 75),
(27, '19:22', '19:22', '2024-10-08', '1', 75),
(28, '19:22', '19:22', '2024-10-08', '1', 75),
(29, '19:22', '19:22', '2024-10-08', '1', 75),
(30, '19:29', '19:42', '2024-10-08', '1', 75),
(31, '19:30', '19:48', '2024-10-08', '1', 78),
(32, '19:46', '19:46', '2024-10-08', '1', 75),
(33, '19:46', '19:46', '2024-10-08', '1', 75),
(34, '08:36', '08:37', '2024-10-09', '1', 79),
(35, '08:19', '08:20', '2024-10-11', '1', 84),
(36, '08:24', '', '2024-10-11', '0', 84);

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_scan`
--
ALTER TABLE `table_scan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `table_scan2`
--
ALTER TABLE `table_scan2`
  ADD PRIMARY KEY (`id2`),
  ADD KEY `fk_ID` (`IDIndex`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_scan`
--
ALTER TABLE `table_scan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `table_scan2`
--
ALTER TABLE `table_scan2`
  MODIFY `id2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_scan2`
--
ALTER TABLE `table_scan2`
  ADD CONSTRAINT `fk_ID` FOREIGN KEY (`IDIndex`) REFERENCES `table_scan` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `table_scan2_ibfk_1` FOREIGN KEY (`IDIndex`) REFERENCES `table_scan` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
