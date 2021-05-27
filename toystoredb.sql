-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 27, 2021 at 04:50 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toystoreDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(70) DEFAULT NULL,
  `tel_number` varchar(12) DEFAULT NULL,
  `birth_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Provider`
--

CREATE TABLE `Provider` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(70) NOT NULL,
  `tel_number` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Toy`
--

CREATE TABLE `Toy` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `minAge` int(11) DEFAULT NULL,
  `maxAge` int(11) DEFAULT NULL,
  `id_Provider` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Toy`
--

INSERT INTO `Toy` (`id`, `name`, `type`, `price`, `minAge`, `maxAge`, `id_Provider`) VALUES
(1, 'ball', 'plastic', 25.7, 3, 18, NULL),
(3, 'car', 'mechanic', 33.3, 5, 18, NULL),
(4, 'doll', 'plastic', 15.5, 1, 16, NULL),
(6, 'gun', 'plastic', 30.5, 10, 18, NULL),
(7, 'train', 'mechanic', 98, 5, 12, NULL),
(11, 'toy3', 'electronic', 18.55, 5, 13, NULL),
(32, 'toy 5', 'electronic', 13.33, 8, 15, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `toy_photos`
--

CREATE TABLE `toy_photos` (
  `nom_Photo` varchar(50) NOT NULL,
  `id_Toy` int(11) NOT NULL,
  `data` blob NOT NULL,
  `photo_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(70) NOT NULL,
  `role` varchar(20) NOT NULL CHECK (`role` in ('Admin','Customer'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `login`, `password`, `role`) VALUES
(1, 'Admin', 'Admin', 'Admin'),
(2, 'Customer', 'Customer', 'Customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Provider`
--
ALTER TABLE `Provider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Toy`
--
ALTER TABLE `Toy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Provider` (`id_Provider`);

--
-- Indexes for table `toy_photos`
--
ALTER TABLE `toy_photos`
  ADD PRIMARY KEY (`nom_Photo`,`id_Toy`),
  ADD KEY `fk_toyPhotos_toy` (`id_Toy`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Provider`
--
ALTER TABLE `Provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Toy`
--
ALTER TABLE `Toy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Toy`
--
ALTER TABLE `Toy`
  ADD CONSTRAINT `fk_toy_provider` FOREIGN KEY (`id_Provider`) REFERENCES `Provider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `toy_photos`
--
ALTER TABLE `toy_photos`
  ADD CONSTRAINT `fk_toyPhotos_toy` FOREIGN KEY (`id_Toy`) REFERENCES `Toy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;