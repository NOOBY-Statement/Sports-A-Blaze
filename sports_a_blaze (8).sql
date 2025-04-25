-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 11:54 AM
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
-- Database: `sports_a_blaze`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipment_items`
--

CREATE TABLE `equipment_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_src` varchar(255) NOT NULL,
  `stocks` int(11) NOT NULL,
  `availability` tinyint(1) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment_items`
--

INSERT INTO `equipment_items` (`id`, `name`, `image_src`, `stocks`, `availability`, `category`) VALUES
(1, 'Basketball Ball', 'bball.png', 0, 0, 'Basketball'),
(3, 'Racket', 'racket.png', 9, 1, 'Badminton'),
(4, 'Shuttlecock', 'shuttlecock.png', 44, 1, 'Badminton'),
(20, 'Basketball Court', 'bball-court.jpg', 2, 1, 'Courts'),
(21, 'Jersey Shirt', 'jersey.png', 3, 1, 'Basketball'),
(24, 'Volleyball Ball', 'vball.png', 5, 1, 'Volleyball'),
(25, 'Basketball Knee Pad', 'kneepad2.png', 6, 1, 'Basketball'),
(26, 'Socks', 'socks.png', 6, 1, 'Basketball'),
(27, 'Wrist Band', 'wristband.png', 9, 1, 'Badminton'),
(28, 'Visor Hat', 'visorhat.png', 3, 1, 'Badminton'),
(29, 'Volleyball Knee Pad', 'knee-pad.png', 11, 1, 'Volleyball'),
(30, 'Elbow Pad', 'elbowpad.png', 4, 1, 'Volleyball'),
(31, 'Badminton Court', 'b-court.jpg', 2, 1, 'Courts'),
(34, 'Volleyball Court', 'vball_court.jpg', 2, 1, 'Courts');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reserve_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contactNumber` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `equipment` varchar(255) DEFAULT NULL,
  `pickupDate` date DEFAULT NULL,
  `returnDate` date DEFAULT NULL,
  `startTime` time DEFAULT NULL,
  `endTime` time DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reserve_id`, `user_id`, `name`, `contactNumber`, `email`, `address`, `equipment`, `pickupDate`, `returnDate`, `startTime`, `endTime`, `status`) VALUES
(1, 21, 'Harold Legaspi', 947483647, 'haroldlegaspi@gmail.com', '193 Alapan 1-B Imus, Cavite', 'Basketball Ball', '2024-07-01', '2024-07-01', '14:00:00', '15:00:00', 'Completed'),
(5, 21, 'Harold Legaspi', 947483647, 'haroldlegaspi@gmail.com', '193 Alapan 1-B Imus, Cavite', 'Jersey Shirt', '2024-07-30', '2024-07-30', '18:26:00', '19:25:00', 'Completed'),
(13, 6, 'Jeon Wonwoo', 987456314, 'jeonwonwoo1@gmail.com', '143 Mabuhay St. Alapan 1-A Imus, Cavite', 'Shuttlecock', '2024-07-25', '2024-07-25', '10:00:00', '11:00:00', 'Completed'),
(20, 8, 'Soleil Cervantes', 987246812, 'soleilcervantes@gmail.com', '890 Bacoor, Cavite', 'Racket', '2024-07-30', '2024-07-30', '16:20:00', '17:37:00', 'Ongoing'),
(21, 13, 'Jandrick Mercadejas', 947483647, 'jandrickmercadejas@gmail.com', '234 Costa Leona Dasmarinas, Cavite', 'Elbow Pad', '2024-07-31', '2024-07-31', '15:43:00', '16:54:00', 'Ongoing'),
(22, 21, 'Harold Legaspi', 947483647, 'haroldlegaspi@gmail.com', '193 Alapan 1-B Imus, Cavite', 'Badminton Court', '2024-07-28', '2024-07-28', '10:00:00', '16:00:00', 'Ongoing'),
(23, 8, 'Soleil Cervantes', 987246812, 'soleilcervantes@gmail.com', '890 Bacoor, Cavite', 'Racket', '2024-07-30', '2024-07-30', '10:25:00', '14:00:00', 'Ongoing'),
(26, 8, 'Soleil Cervantes', 987246812, 'soleilcervantes@gmail.com', '890 Bacoor, Cavite', 'Volleyball Ball', '2024-07-30', '2024-07-30', '13:00:00', '13:30:00', 'Ongoing'),
(31, 8, 'Soleil Cervantes', 987246812, 'soleilcervantes@gmail.com', '890 Bacoor, Cavite', 'Basketball Knee Pad', '2024-07-21', '2024-07-21', '14:30:00', '16:20:00', 'Ongoing'),
(46, 8, 'Soleil Cervantes', 987246812, 'soleilcervantes@gmail.com', '890 Bacoor, Cavite', 'Basketball Court', '2024-07-23', '2024-07-23', '13:45:00', '14:55:00', 'Cancelled'),
(51, 21, 'Harold Legaspi', 947483647, 'haroldlegaspi@gmail.com', '193 Alapan 1-B Imus, Cavite', 'Jersey Shirt', '2024-07-30', '2024-07-30', '14:30:00', '16:00:00', 'Ongoing'),
(52, 21, 'Harold Legaspi', 947483648, 'haroldlegaspi@gmail.com', '193 Alapan 1-B Imus, Cavite', 'Shuttlecock', '2024-07-21', '2024-07-21', '13:40:00', '15:43:00', 'Ongoing'),
(53, 13, 'Jandrick Mercadejas', 947483647, 'jandrickmercadejas@gmail.com', '234 Costa Leona Dasmarinas, Cavite', 'Visor Hat', '2024-07-24', '2024-07-24', '15:23:00', '17:29:00', 'Ongoing');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contactNumber` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` varchar(50) NOT NULL DEFAULT 'user',
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contactNumber`, `address`, `password`, `userType`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(6, 'Jeon Wonwoo', 'jeonwonwoo1@gmail.com', 987456314, '143 Mabuhay St. Alapan 1-A Imus, Cavite', '$2y$10$bhHbE4CA.j89O63Pi2oSBe2T136OqF.lM6VkFZB0ckj9F2CHICANi', 'user', NULL, NULL),
(7, 'Shaira Legaspi', 'shairalegaspi9@gmail.com', 925647896, '185 Alapan 1-B Imus, Cavite', '$2y$10$dApMzBBtYSN8keZEpBN8NOV2NVKu1o85N6x9jD1H39q6GpPm4.MFq', 'admin', '79cd8633368608e5e866c6a1cfa8299f361435b24cf4bc9c7b8a983d5b54e542', '2024-07-03 22:21:44'),
(8, 'Soleil Cervantes', 'soleilcervantes@gmail.com', 987246812, '890 Bacoor, Cavite', '$2y$10$YyFfelgXwYuvRV6XA6NVcOnW/zjJ4ZJBapsbotawqOOSoC39FsTgW', 'user', NULL, NULL),
(11, 'Lei Legaspi', 'alyssaleilegaspi@gmail.com', 925467895, '245 Mambog 2 Bacoor, Cavite', '$2y$10$bwKAOdComkz6SJAd42L0/uTYhniQltfG55GAuk/FF5RtBeEofJlBW', 'user', NULL, NULL),
(12, 'Mheladel Defensor', 'mheladeldefensor@gmail.com', 924567891, '214 Dahlia St. Malagasang 2-F Imus, Cavite', '$2y$10$UjQ4IcTZySUbB826uEWhyuogp1w2cI8fJ//FamVmTjd2Qmjs5pQ.e', 'user', NULL, NULL),
(13, 'Jandrick Mercadejas', 'jandrickmercadejas@gmail.com', 947483647, '234 Costa Leona Dasmarinas, Cavite', '$2y$10$hMRZrCnMiV7xMy2Ekx.yTO1WikWaGDNAHzlyYXmOt3UN78pdolI3.', 'user', NULL, NULL),
(20, 'Patrick Benito', 'patrickbenito@gmail.com', 957861458, '111 ACM Phase 1 Alapan 1-A Imus, Cavite', '$2y$10$zlP9bT4kbkRH3VGqV.E7BOokvuGEDpNEg9fgjKmTAoWwa9DwA.Pv2', 'user', NULL, NULL),
(21, 'Harold Legaspi', 'haroldlegaspi@gmail.com', 947483648, '193 Alapan 1-B Imus, Cavite', '$2y$10$7q1WpBz4TzO9ilbK1XeK3OQ/1zBY1r86EiYSQZrlJSQyO6CYkWy1W', 'user', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipment_items`
--
ALTER TABLE `equipment_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reserve_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipment_items`
--
ALTER TABLE `equipment_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reserve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
