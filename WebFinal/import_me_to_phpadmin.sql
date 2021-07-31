-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 31, 2021 at 04:28 AM
-- Server version: 5.7.32
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `account`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_token`
--

CREATE TABLE `password_token` (
  `email` varchar(50) NOT NULL,
  `token` char(255) NOT NULL,
  `expired_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `password_token`
--

INSERT INTO `password_token` (`email`, `token`, `expired_time`) VALUES
('daudaihoc040501@gmail.com', '4d02b237011db65a82aeaf3b2683a713', 1627741364);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `email` varchar(50) NOT NULL,
  `fullname` text,
  `department_name` text,
  `tel` varchar(50) DEFAULT NULL,
  `user_password` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `fullname`, `department_name`, `tel`, `user_password`) VALUES
('519h0321@student.tdtu.edu.vn', 'nghia', 'it', '0945', '$2y$10$5YJ7yEtK0j/9I2Osh3JA7.RY/XTq1I/rSDHW2A.lml1B527hIKORq'),
('daudaihoc040501@gmail.com', 'nghia doan', 'it', '0123', '$2y$10$g86cb62.YcfLpRddSE6QZuCJ6SPZ.CiRbRUcsgi95oE7uKfiEFfh6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_token`
--
ALTER TABLE `password_token`
  ADD PRIMARY KEY (`email`,`token`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
