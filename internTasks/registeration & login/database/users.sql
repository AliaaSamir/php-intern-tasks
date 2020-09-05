-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2020 at 08:03 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registeration`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_phone` varchar(80) NOT NULL,
  `user_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pass`, `user_phone`, `user_address`) VALUES
(3, 'Mohamed', 'mohamed@gmail.com', '$2y$10$JOn3wBpqvZukmF3WJNZvx.S71KBEUpELqJH3Im38xYpjfZSnuI/da', '123456789', 'cairo'),
(4, 'Ali', 'ali@yahoo.com', '$2y$10$I93W9Y7S7xc8.LcKcNOfH.U6rUJyCoI9UASDf.AkhTGlOzqL3q8RS', '123456789', 'Giza'),
(5, 'ahmed', 'ahmed@hotmail.com', '$2y$10$lI.p.gYgsUY5OF2ccT1I3.Og6CBPAndfzYZwRjC1doOHDS9ZnHIXS', '123456789', 'cairo'),
(6, 'samy', 'samy@gmail.com', '$2y$10$YVJelEHczad.iW1wrWefBOkGpUdT6KP4qofaMXtPTwAEbGYCn9Vme', '123456789', 'Cairo'),
(9, 'Maha', 'maha@yahoo.com', '$2y$10$NKgVLN/1Hq6exMiJl2J.h.6TE9lCgOGD/V.FqE3oeJUDT.yK4G.nC', '123456789', 'Giza'),
(10, 'Fatma', 'fatma@gmail.com', '$2y$10$QsJTjH.HYdiZ/UOqxbCpIeM4qQqLaitxqfcKE1PYGiIL0DxGx0qV.', '123456789', 'Cairo'),
(11, 'Ali Mohamed', 'alimohamed@gmail.com', '$2y$10$v5/8u1t18/2yrlMlhtLcvuf3m3KIhSBGh7txB89Z9F2wOQ2bnZwe.', '123456789', 'Cairo'),
(12, 'mohamed ahmed', 'mohamedahmed@gmail.com', '$2y$10$Ybgdz1uVnXaA80IdqeVuK.u5hLUkSmRQvkCs6mdfiniWkowanN4gy', '123456789', 'cairo'),
(13, 'Ali', 'alia_alaa@gamil.com', '$2y$10$U4DIinBZdoyP1xdCBPVKeOsyxsEZ.Tv0/JTN1zkmvN3LrnQTE/.Uq', '123456789', 'Giza');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
