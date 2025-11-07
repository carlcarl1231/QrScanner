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
-- Table structure for table `table_scan2`
--

CREATE TABLE `table_scan2` (
  `id2` int(11) NOT NULL,
  `timeIn` varchar(250) NOT NULL,
  `timeOut` varchar(250) NOT NULL,
  `logDate` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `IDIndex` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_scan2`
--
ALTER TABLE `table_scan2`
  ADD PRIMARY KEY (`id2`),
  ADD KEY `fk_ID` (`IDIndex`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_scan2`
--
ALTER TABLE `table_scan2`
  MODIFY `id2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_scan2`
--
ALTER TABLE `table_scan2`
  ADD CONSTRAINT `fk_ID` FOREIGN KEY (`IDIndex`) REFERENCES `table_scan` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `table_scan2_ibfk_1` FOREIGN KEY (`IDIndex`) REFERENCES `table_scan` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
