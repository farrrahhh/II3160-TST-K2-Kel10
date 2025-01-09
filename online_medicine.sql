-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 09, 2025 at 03:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_medicine`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` enum('pending','paid','shipped','completed','cancelled') DEFAULT 'pending',
  `shipping_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `status`, `shipping_address`) VALUES
(1, 1, 500000, 'pending', 'Jl. Merdeka No. 10, Jakarta'),
(2, 2, 120000, 'paid', 'Jl. Raya No. 5, Surabaya'),
(3, 1, 320000, 'shipped', 'Jl. Kebon Jeruk No. 12, Bandung'),
(4, 4, 150000, 'completed', 'Jl. Taman No. 8, Yogyakarta'),
(5, 20, 200000, 'cancelled', 'Jl. Sumber Alam No. 20, Bali'),
(6, 6, 250000, 'pending', 'Jl. Lautan No. 15, Makassar'),
(7, 7, 17000, 'paid', 'Jl. Angkasa No. 18, Medan'),
(8, 11, 55000, 'shipped', 'Jl. Bukit Indah No. 25, Palembang'),
(9, 9, 200000, 'completed', 'Jl. Raya No. 10, Malang'),
(10, 10, 22000, 'pending', 'Jl. Wira No. 30, Solo'),
(11, 22, 108000, 'pending', 'ITB'),
(12, 1, 120000, 'completed', '123 Main Street, City, Country'),
(13, 22, 0, 'pending', 'sdcd'),
(14, 22, 12000, 'pending', 'asdas');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` enum('processing','failed','success') DEFAULT 'processing',
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `status`, `amount`) VALUES
(1, 1, 'success', 500000),
(2, 2, 'success', 120000),
(3, 3, 'success', 320000),
(4, 4, 'success', 150000),
(5, 5, 'failed', 200000),
(6, 6, 'processing', 250000),
(7, 7, 'success', 17000),
(8, 8, 'success', 55000),
(9, 9, 'success', 200000),
(10, 10, 'processing', 22000),
(11, 11, 'processing', 108000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` enum('vitamin','supplement','medicine','ointment','other') DEFAULT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `disease` enum('Diabetes','Hypertension','Asthma','Heart Disease','Influenza','Diarrhea','Constipation','Migraine','Maag','Other') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `category`, `price`, `stock`, `is_active`, `disease`) VALUES
(1, 'Diabetes Support Capsule', 'Capsule for managing blood sugar levels.', 'medicine', 120000, 50, 1, 'Diabetes'),
(2, 'Hypertension Relief Supplement', 'A supplement to help control blood pressure.', 'supplement', 75000, 30, 1, 'Hypertension'),
(3, 'Asthma Inhaler', 'Inhaler for relieving asthma symptoms.', 'medicine', 150000, 25, 1, 'Asthma'),
(4, 'Heart Health Vitamin', 'Vitamin to support heart health.', 'vitamin', 95000, 40, 1, 'Heart Disease'),
(5, 'Flu Relief Ointment', 'Ointment for relieving flu-related symptoms.', 'ointment', 60000, 15, 1, 'Influenza'),
(6, 'Diarrhea Care Solution', 'Solution to manage diarrhea effectively.', 'medicine', 50000, 20, 1, 'Diarrhea'),
(7, 'Constipation Relief Powder', 'Powder to ease constipation.', 'other', 45000, 35, 1, 'Constipation'),
(8, 'Migraine Soothing Balm', 'A soothing balm for relieving migraines.', 'ointment', 70000, 20, 1, 'Migraine'),
(9, 'Maag Relief Capsule', 'Capsule for managing stomach acid and maag.', 'medicine', 55000, 25, 1, 'Maag'),
(10, 'General Wellness Supplement', 'Supplement for overall health and well-being.', 'supplement', 65000, 50, 1, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Alice Johnson', 'alice@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(2, 'Bob Smith', 'bob@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(3, 'Charlie Davis', 'charlie@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'admin'),
(4, 'David Lee', 'david@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(5, 'Eva White', 'eva@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'admin'),
(6, 'Frank Green', 'frank@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(7, 'Grace Black', 'grace@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(8, 'Henry Clark', 'henry@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'admin'),
(9, 'Isabel Moore', 'isabel@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(10, 'James Wilson', 'james@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(11, 'John Carter', 'john@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(12, 'Lily Evans', 'lily@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'admin'),
(13, 'Michael Brown', 'michael@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(14, 'Natalie White', 'natalie@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(15, 'Oliver King', 'oliver@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'admin'),
(16, 'Patricia Adams', 'patricia@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(17, 'Quinn Brooks', 'quinn@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(18, 'Robert White', 'robert@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'admin'),
(19, 'Sophia Green', 'sophia@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(20, 'Thomas Miller', 'thomas@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'customer'),
(22, 'farah', 'farah@example.com', '482c811da5d5b4bc6d497ffa98491e38', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
