-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2025 at 04:25 PM
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
-- Database: `webshoes`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pid` int(60) NOT NULL,
  `pgname` varchar(60) NOT NULL,
  `pname` varchar(60) NOT NULL,
  `pimage` blob NOT NULL,
  `cost` int(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pid`, `pgname`, `pname`, `pimage`, `cost`) VALUES
(2, 'Women Sneakers', 'Nike', 0x775f736e65616b6572332e6a7067, 1190),
(3, 'Men Sneakers', 'Nike', 0x6d656e5f736e65616b6572322e6a7067, 5000),
(4, 'Men Sneakers', 'ab', 0x6d656e5f736e65616b6572312e6a7067, 2000),
(5, 'Men Sneakers', 'xyz', 0x6d656e5f736e65616b6572352e6a7067, 5000),
(6, 'Women Sneakers', 'painted', 0x775f736e65616b6572322e6a7067, 900),
(7, 'Women Sneakers', 'jkm', 0x775f736e65616b6572352e6a7067, 2500),
(8, 'Men Walking Shoes', 'sdf', 0x6d5f77616c6b696e675f73686f6573352e6a7067, 1500),
(9, 'Men Walking Shoes', 'wer', 0x6d5f77616c6b696e675f73686f6573332e6a7067, 2100),
(10, 'Men Walking Shoes', 'gsr', 0x6d5f77616c6b696e675f73686f6573342e6a7067, 2000),
(14, 'WOMEN SANDAL', 'wood', 0x775f73616e64616c322e6a7067, 700),
(15, 'WOMEN SANDAL', 'heels', 0x775f73616e64616c362e6a7067, 1000),
(16, 'WOMEN SANDAL', 'adf', 0x775f73616e64616c332e6a7067, 600),
(17, 'Children Clog', 'crocs', 0x62616279626f795f636c6f67322e6a7067, 490),
(18, 'Children Clog', 'girly', 0x626162796769726c5f636c6f67362e6a7067, 500),
(19, 'Children Clog', 'boo', 0x626162796769726c5f636c6f67352e6a7067, 460),
(20, 'Children Walking Shoes', 'zxc', 0x626162795f73616e64616c312e6a7067, 300),
(21, 'Children Walking Shoes', 'butter', 0x626162795f73686f65732e6a7067, 450),
(22, 'Children Walking Shoes', 'digital', 0x626162795f77616c6b696e675f73686f6573342e6a7067, 550),
(23, 'Cricket Shoes', 'dfg', 0x637269636b65745f73686f6573312e6a7067, 2000),
(24, 'Cricket Shoes', 'Nike', 0x637269636b65745f73686f6573352e6a7067, 3200),
(25, 'Cricket Shoes', 'sde', 0x637269636b65745f73686f6573342e6a7067, 4210),
(26, 'Football Shoes', 'Puma', 0x666f6f7462616c6c312e6a7067, 3000),
(27, 'Football Shoes', 'csd', 0x666f6f7462616c6c352e6a7067, 1350),
(28, 'Football Shoes', 'Nike', 0x666f6f7462616c6c322e6a7067, 8000),
(29, 'Boys School Shoes', 'sew', 0x627363686f6f6c352e6a7067, 600),
(30, 'Boys School Shoes', 'bhy', 0x627363686f6f6c362e6a7067, 590),
(31, 'Boys School Shoes', 'bbf', 0x627363686f6f6c332e6a7067, 400),
(32, 'Girls School Shoes', 'nhu', 0x677363686f6f6c332e6a7067, 500),
(33, 'Girls School Shoes', 'xse', 0x677363686f6f6c322e6a7067, 450),
(34, 'Girls School Shoes', 'vdr', 0x677363686f6f6c312e6a7067, 670);

-- --------------------------------------------------------


--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `username`, `email`, `password`, `created_at`) 

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group`
--

CREATE TABLE `tbl_group` (
  `gid` int(60) NOT NULL,
  `pgname` varchar(60) NOT NULL,
  `status` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_group`
--

INSERT INTO `tbl_group` (`gid`, `pgname`, `status`) VALUES
(1, 'Women Sneakers', 'ACTIVE'),
(2, 'Men Sneakers', 'ACTIVE'),
(3, 'Men Walking Shoes', 'ACTIVE'),
(4, 'WOMEN SANDAL', 'ACTIVE'),
(5, 'Children Clog', 'ACTIVE'),
(6, 'Children Walking Shoes', 'ACTIVE'),
(7, 'Cricket Shoes', 'ACTIVE'),
(8, 'Football Shoes', 'ACTIVE'),
(9, 'Boys School Shoes', 'ACTIVE'),
(10, 'Girls School Shoes', 'ACTIVE');

-- --------------------------------------------------------
--
-- Table structure for table orders
-- 

CREATE TABLE orders (
id int(11) NOT NULL AUTO_INCREMENT,
customer_name varchar(255) NOT NULL,
customer_phone varchar(20) NOT NULL,
customer_email varchar(255) NOT NULL,
customer_address text NOT NULL,
payment_mode varchar(50) NOT NULL,
total_amount decimal(10,2) NOT NULL,
created_at timestamp NOT NULL DEFAULT current_timestamp(),
PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- -- Table structure for table order_items
--

CREATE TABLE order_items (
id int(11) NOT NULL AUTO_INCREMENT,
order_id int(11) NOT NULL,
product_name varchar(255) NOT NULL,
quantity int(11) NOT NULL,
price decimal(10,2) NOT NULL,
PRIMARY KEY (id),
KEY order_id (order_id),
FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `AdminEmail` varchar(100) NOT NULL,
  `loginid` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`id`, `FullName`, `AdminEmail`, `loginid`, `Password`, `created_at`) VALUES
(1, 'Admin', 'admin06@gmail.com', 'admin', '12345', '2025-02-03 12:49:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_group`
--
ALTER TABLE `tbl_group`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_group`
--
ALTER TABLE `tbl_group`
  MODIFY `gid` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
