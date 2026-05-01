-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2024 at 07:00 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gmiu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mandatory`
--

CREATE TABLE `tbl_mandatory` (
  `id` bigint(20) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `file` text,
  `is_active` tinyint(1) DEFAULT '1',
  `is_delete` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated _at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_mandatory`
--

INSERT INTO `tbl_mandatory` (`id`, `name`, `file`, `is_active`, `is_delete`, `created_at`, `updated _at`) VALUES
(2, 'aaavbv', '2024-06-28-55-INTERCOMUPDATE.pdf', 1, 0, '2024-06-28 05:50:43', '2024-06-28 05:50:43'),
(3, 'Gyanmanjari Institute of Technology', '2024-06-28-83-jayesh.pdf', 1, 0, '2024-06-28 05:51:10', '2024-06-28 05:51:10'),
(5, 'Re-MSE Paper without CO(GENIUS)', '2024-06-28-41-Re-MSEPaperwithoutCO(GENIUS).pdf', 1, 0, '2024-06-28 05:52:33', '2024-06-28 05:52:33'),
(6, 'Re-MSE Paper without CO(GENIUS) Re-MSE Paper without CO(GENIUS)', '2024-06-28-82-OOP_WITH_CO_TDO.pdf', 1, 0, '2024-06-28 05:56:48', '2024-06-28 05:56:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_mandatory`
--
ALTER TABLE `tbl_mandatory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_mandatory`
--
ALTER TABLE `tbl_mandatory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
