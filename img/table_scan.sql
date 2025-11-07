-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 06:34 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `table_scan`
--
ALTER TABLE `table_scan`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_scan`
--
ALTER TABLE `table_scan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
