-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2025 at 01:47 AM
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
-- Database: `evil_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `gender`, `age`, `email`, `password`, `profile_picture`) VALUES
(1, 'Bilal', 'Mahmood', 'Male', 22, 'bilal@gmail.com', '$2y$10$KOculBC4pHNnhRhFIsPWyuBGGeuKSFEGKX8cI4vpvYyVOzJRr2l66', 'uploads/profile_68336aacb99681.27723396.jpg'),
(2, 'Aasal', 'chuhan', 'Male', 19, 'aasaal@gmail.com', '$2y$10$SMc1IC/mkrwBaJ80hKmIkuwFt9Ckza7R96eH.4MyApGycP2iRIZH.', 'uploads/profile_68326e92c67c56.95622388.jpg'),
(3, 'salman', 'kukda', 'Male', 20, 'salman@gmail.com', '$2y$10$kz9cItWRUZb9GhhP0DgyI.lR6Vm/1ppMZ0vfuPtKgIEzidj1ky4Ai', 'uploads/profile_68336341abe763.11672958.jpg'),
(4, 'Ali', 'naime', 'Male', 22, 'ali@gmail.com', '$2y$10$DwYx9DFAIEcIZflRUYit5ODwoq1Sh0PJynYTrP4smPX5FxJVBUev6', 'uploads/profile_68336846938dc2.01710563.jpg'),
(5, 'abdullah', 'nadeem', 'Male', 21, 'abdullah@gmail.com', '$2y$10$rD7gTe.QyvO9w9ILNu2k2e3dlfwJHOkdEFurzVwnGlQnw3nhaMiV2', 'uploads/profile_68336ae8ac2ae6.92660080.jpg'),
(6, 'bilal', 'Mahmood', 'Male', 22, 'bilall@gmail.com', '$2y$10$JHleYOLj7ZZBTCY10cjGyuRq6ixt7S0ILoNEUTbWxPg67Nzhw8H3e', 'uploads/profile_68336bf92b1255.64838484.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
