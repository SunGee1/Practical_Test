-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2019 at 09:49 AM
-- Server version: 10.1.36-MariaDB
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
-- Database: `ordering`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `order_ref` int(11) NOT NULL,
  `product_ref` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`order_ref`, `product_ref`, `quantity`) VALUES
(107, 1, 9),
(107, 2, 9),
(107, 3, 9),
(107, 4, 9),
(107, 5, 9),
(107, 6, 9),
(105, 1, 1),
(105, 2, 3),
(105, 3, 3),
(105, 4, 3),
(105, 5, 3),
(110, 1, 1),
(110, 5, 1),
(108, 1, 1),
(108, 2, 2),
(108, 3, 2),
(108, 4, 2),
(108, 5, 3),
(108, 6, 2),
(111, 2, 3),
(111, 3, 3),
(111, 4, 3),
(111, 5, 4),
(113, 1, 1),
(112, 3, 1),
(112, 5, 4),
(112, 6, 5),
(109, 1, 1),
(109, 2, 1),
(109, 3, 1),
(109, 4, 2),
(109, 5, 4),
(106, 1, 1),
(106, 2, 2),
(106, 3, 1),
(106, 5, 1),
(104, 1, 2),
(104, 2, 2),
(104, 3, 1),
(104, 4, 1),
(104, 5, 1),
(104, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `cost` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `description`, `cost`) VALUES
(1, 'Apple', '1'),
(2, 'Banana', '2'),
(3, 'Pear', '1'),
(4, 'Strawberies', '3'),
(5, 'Pawpaw', '2'),
(6, 'Lichi', '4');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `label`) VALUES
(1, 'Placed'),
(2, 'Delivery in progress'),
(3, 'Delivered'),
(4, 'Canceled');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `firstname`, `surname`, `admin`) VALUES
(2, 'manson', '*A381F5C9853808F7CD89FA661A7024450C331514', 'ryan', 'van rooijen', 1),
(3, 'johndoe', '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19', 'John', 'Doe', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_order`
--

CREATE TABLE `user_order` (
  `id` int(11) NOT NULL,
  `user_ref` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `status_ref` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_order`
--

INSERT INTO `user_order` (`id`, `user_ref`, `order_date`, `order_update`, `status_ref`) VALUES
(104, 2, '2019-01-03 11:51:23', '2019-01-07 09:22:35', 4),
(105, 2, '2019-01-03 11:57:05', '2019-01-03 18:14:25', 1),
(106, 2, '2019-01-03 12:21:23', '2019-01-07 09:08:52', 1),
(107, 2, '2019-01-03 12:22:45', '2019-01-03 12:23:11', 1),
(108, 2, '2019-01-03 12:23:59', '2019-01-07 05:41:13', 1),
(109, 2, '2019-01-03 18:02:23', '2019-01-07 08:59:55', 1),
(110, 2, '2019-01-03 18:14:11', '2019-01-03 18:52:02', 1),
(111, 2, '2019-01-03 18:51:59', '2019-01-07 08:33:42', 1),
(112, 2, '2019-01-04 11:11:57', '2019-01-07 08:59:16', 1),
(113, 2, '2019-01-07 08:36:53', '0000-00-00 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_order`
--
ALTER TABLE `user_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
