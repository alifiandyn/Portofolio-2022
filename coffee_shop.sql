-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2021 at 09:15 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_order`
--

CREATE TABLE `detail_order` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `status_order` int(1) NOT NULL DEFAULT 0 COMMENT 'New/Done',
  `done_task` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_order`
--

INSERT INTO `detail_order` (`id`, `id_order`, `id_product`, `qty`, `price`, `status_order`, `done_task`) VALUES
(19, 1, 3, 1, 20000, 1, '2021-07-01 17:49:02'),
(20, 1, 2, 5, 60000, 1, '2021-07-01 18:38:43'),
(21, 1, 1, 5, 75000, 0, NULL),
(22, 2, 4, 10, 220000, 0, NULL),
(23, 2, 5, 1, 80000, 0, NULL),
(24, 2, 6, 10, 70000, 0, NULL),
(25, 3, 15, 1, 200000, 0, NULL),
(26, 3, 12, 5, 100000, 0, NULL),
(27, 3, 11, 5, 750000, 0, NULL),
(28, 4, 6, 5, 35000, 0, NULL),
(29, 4, 15, 10, 2000000, 0, NULL),
(30, 4, 3, 10, 200000, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name_product` varchar(32) NOT NULL,
  `description` varchar(128) NOT NULL,
  `img` varchar(255) NOT NULL,
  `price` bigint(20) NOT NULL,
  `category_product` int(1) NOT NULL COMMENT 'food/beverage',
  `status_product` int(1) NOT NULL COMMENT 'active/not active',
  `stock` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name_product`, `description`, `img`, `price`, `category_product`, `status_product`, `stock`, `date_created`) VALUES
(1, 'Cappucino', 'Capuccino bukan sembarang capuccino bukan pula seperti capcin di abang abang okee..', 'cappucino1.jpg', 15000, 1, 1, 10, '2021-04-19 19:01:07'),
(2, 'Kopi Susu', 'Susu murni yang diperah dari sapi Afrika dengan rasa yg sedikit asam berpadu dengan kopi khas dari kami', 'kopi_susu.jpg', 12000, 1, 1, 10, '2021-04-19 19:01:07'),
(3, 'French Fries', 'Irisan kentang yang tebal ditambah saos keju dan sambal yang menambah kenikmatan ketika dimakan dan cocok untuk sharing .', 'kentang.jpg', 20000, 2, 1, 15, '2021-04-19 19:02:44'),
(4, 'Sosis', 'Sosis Sapi pilihan yang dipilih dari sapi peternakan Kongo dengan daging yang juicy.', 'sosis.jpg', 22000, 2, 1, 10, '2021-04-19 19:02:44'),
(5, 'Blackforest', 'Kue yang sudah cukup familiar dengan cita rasa coklat yang tidak terlalu manis dan dengan porsi yang pas tentunya.', 'blackfores1.jpg', 80000, 2, 1, 3, '2021-04-19 19:03:58'),
(6, 'Donat', 'mulai dari donal coklat , strawberry , caramel , dan donat gula gula ada disini', 'donat.jpg', 7000, 2, 1, 50, '2021-04-19 19:03:58'),
(11, 'Tom yum Siddiq', 'Masakan asli jawa', 'TomYum.jpg', 150000, 2, 1, 0, '2021-05-25 18:49:14'),
(12, 'Roti Bakar Mama Afif', 'Resep Sifa', 'WhatsApp Image 2021-05-25 at 23.24.16.jpeg', 20000, 2, 1, 0, '2021-05-25 18:47:08'),
(15, 'Pizza', 'Makanan Khas Italy', 'WhatsApp Image 2021-05-26 at 16.43.17.jpeg', 200000, 1, 1, 0, '2021-05-26 10:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE `product_order` (
  `id` int(11) NOT NULL,
  `customer` varchar(32) NOT NULL,
  `total_price` bigint(20) NOT NULL,
  `status_order` int(11) NOT NULL,
  `date_order` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_order`
--

INSERT INTO `product_order` (`id`, `customer`, `total_price`, `status_order`, `date_order`) VALUES
(1, 'Nurul Nazua', 155000, 1, '2021-07-01 17:47:35'),
(2, 'Afif Sifa Hanifa', 370000, 1, '2021-07-01 17:48:04'),
(3, 'Muhammad Fahmi Siddiq', 1050000, 1, '2021-07-01 17:48:24'),
(4, 'Alifiandy Nugraha', 2235000, 1, '2021-07-01 17:48:40');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `status`, `date_created`) VALUES
(1, 'alifiandyn', '$2y$10$K1ljWfVWyKLRw/HvK0eK9uWOeNeRr1Wwz6QlfGP3bcKGERLvz9hIO', 0, '2021-05-24 15:59:18'),
(2, 'afifnazua', '$2y$10$X/wcYhrCNrmnnrIK6.KN2OYpZMrh/xaMwCaQdnmnLVqZZex6HvgXK', 0, '2021-05-25 18:26:32'),
(3, 'zulfahmi', '$2y$10$w/BYOGg/OIfRZLR2nZVAVO.rM5xqr/EWd9ObpaEO.tIC9AJWEQWtO', 0, '2021-05-26 09:27:20'),
(4, 'admin', '$2y$10$tMtsLG7l2trFML6pxvlqjecAsAuVeoLzvl7Kp0oeLQcocm8vH6via', 0, '2021-05-26 10:03:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_order`
--
ALTER TABLE `detail_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_order`
--
ALTER TABLE `detail_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_order`
--
ALTER TABLE `product_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
