-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2020 at 11:02 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(100) UNSIGNED NOT NULL,
  `user$id` int(100) UNSIGNED NOT NULL,
  `name` varchar(35) NOT NULL,
  `dueDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `user$id`, `name`, `dueDate`) VALUES
(1, 1, 'test', '2020-10-03'),
(3, 14, 'CS286 final', '2020-12-14'),
(9, 23, 'test', '2020-12-01'),
(11, 15, 'another project', '2024-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(100) UNSIGNED NOT NULL,
  `project$id` int(100) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `project$id`, `name`, `status`) VALUES
(1, 1, 'study chapter one', 'N'),
(2, 1, 'study chapter two', 'N'),
(6, 9, 'mop the ship', 'N'),
(7, 9, 'sweep the deck', 'N'),
(8, 9, 'wash the bannister', 'N'),
(11, 11, 'wash the dishes', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(150) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'testName', 'testpassword'),
(4, 'homework', '$2y$10$aE8ACfARThCZ6WJe9XVbL.IzYwcdYfjSrvsNluGdIPxBcPB.UnXvm'),
(14, 'test16', '$2y$10$.AR77kkzlB7dhf9BpS3P/On3Bkf2OvK8fpXV43bqdBeq5qN6zSeG6'),
(15, 'guest', '$2y$10$yyQq5MMRvjB0NDx4zlx7eequu.cK/LU2fwGLUOQPL8AUwSPT8CLd.'),
(16, 'jack', '$2y$10$P3Sad.NpgOjNK1bHDR139ub6eorSwvZRkLW/4bNMz8pUEwe5MeTp6'),
(18, 'testDrive', '$2y$10$jhQc5p14c3CK6xltU/8qX.sW1Qm13bLk9FUB0.z.S7Zq1Y4EsWuau'),
(20, 'efffff', '$2y$10$HHWZF6VGXMqgFXHXn.VX4Oa3eypNmfYArLc7nBZnzsbAw.PGn0dni'),
(21, 'ggggggg', '$2y$10$VN7rO4QR6hTGOq7mRoxlpO3ZdbziDPL2u0oFIyHvtLDyhw9bhA0kW'),
(22, 'ttttt', '$2y$10$Cc99IdZeRQIj3mhqiZP6Y.gq6Lnc2mN6lrgRuzaepnNoRUsqprHTC'),
(23, 'tyrant', '$2y$10$bvHoRtyvqiqpwOu.HU1Meutid4siQ9ldWrgXuzeexT2ySrEyons4q');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user$id` (`user$id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project$id` (`project$id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(150) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project` FOREIGN KEY (`user$id`) REFERENCES `users` (`id`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task` FOREIGN KEY (`project$id`) REFERENCES `project` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
