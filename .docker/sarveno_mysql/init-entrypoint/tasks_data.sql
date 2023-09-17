-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Host: sarveno_mysql
-- Generation Time: Sep 17, 2023 at 01:31 PM
-- Server version: 8.0.34
-- PHP Version: 8.0.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sarVenoDb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `isDone` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `isDone`, `created_at`) VALUES
(43, 'Get Uber Car', 1, '2023-09-16 11:53:28'),
(44, 'Go To SuperMarket', 1, '2023-09-16 11:53:53'),
(45, 'Rice  SASAS', 0, '2023-09-16 11:54:21'),
(46, 'Banana', 0, '2023-09-16 11:54:24'),
(47, 'Potato', 0, '2023-09-16 11:54:35'),
(48, 'Tomato', 0, '2023-09-16 11:54:40'),
(49, 'Bread fdfd', 0, '2023-09-16 11:54:50'),
(50, 'Lorem ipsomsdsadafdfsfsf', 0, '2023-09-16 11:55:34'),
(51, 'This is Test rg', 0, '2023-09-16 12:12:56'),
(52, 'this is changes ', 0, '2023-09-16 14:42:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_unique` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
