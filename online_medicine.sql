-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 29, 2024 at 05:41 PM
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
(12, 1, 120000, 'completed', '123 Main Street, City, Country');

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

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 10, 50000),
(2, 2, 10, 6, 20000),
(3, 3, 4, 20, 15000),
(4, 3, 10, 1, 20000),
(5, 4, 13, 4, 25000),
(7, 5, 19, 4, 50000),
(8, 6, 7, 10, 25000),
(9, 7, 9, 1, 17000),
(10, 8, 10, 1, 20000),
(11, 8, 11, 1, 35000),
(12, 9, 12, 1, 180000),
(13, 9, 10, 1, 20000),
(14, 10, 18, 1, 22000),
(15, 11, 1, 2, 100000),
(16, 11, 3, 1, 8000),
(17, 12, 11, 2, 70000),
(18, 12, 19, 1, 50000);

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
(1, 1, 'processing', 500000),
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
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `category`, `price`, `stock`, `is_active`) VALUES
(1, 'Vitamin C 1000mg', 'Vitamin C supplement to support immune system', 'vitamin', 50000, 198, 1),
(2, 'Omega-3 Fish Oil', 'Fish oil rich in Omega-3 for heart health', 'supplement', 150000, 120, 1),
(3, 'Paracetamol 500mg', 'Pain reliever and fever reducer', 'medicine', 8000, 499, 1),
(4, 'Antiseptic Ointment', 'Ointment for minor cuts and burns', 'ointment', 15000, 100, 1),
(5, 'Herbal Tea', 'Calming herbal tea for relaxation', 'other', 10000, 150, 1),
(6, 'Multivitamin A-Z', 'Complete daily multivitamin supplement', 'vitamin', 30000, 250, 1),
(7, 'Calcium Tablets', 'Calcium supplement for stronger bones', 'supplement', 25000, 180, 1),
(8, 'Ibuprofen 400mg', 'Pain reliever for inflammation and fever', 'medicine', 12000, 400, 1),
(9, 'Aloe Vera Gel', 'Natural aloe vera gel for skin hydration', 'ointment', 17000, 90, 1),
(10, 'Lavender Essential Oil', 'Relaxing lavender oil for aromatherapy', 'other', 20000, 110, 1),
(11, 'Vitamin D 1000 IU', 'Vitamin D supplement for bone health', 'vitamin', 35000, 218, 1),
(12, 'Fish Collagen Peptides', 'Collagen supplement for skin elasticity', 'supplement', 180000, 130, 1),
(13, 'Amoxicillin 500mg', 'Antibiotic for bacterial infections', 'medicine', 25000, 250, 1),
(14, 'Neosporin Ointment', 'Antibiotic ointment for cuts and scrapes', 'ointment', 18000, 200, 1),
(15, 'Green Tea Extract', 'Natural antioxidant supplement', 'other', 9000, 300, 1),
(16, 'Magnesium Supplement', 'Magnesium supplement for muscle and nerve function', 'supplement', 40000, 160, 1),
(17, 'Ginger Tea', 'Herbal ginger tea for digestion and nausea relief', 'other', 15000, 180, 1),
(18, 'Echinacea Supplement', 'Herbal supplement for immune system support', 'supplement', 22000, 210, 1),
(19, 'Probiotic Capsules', 'Probiotic supplement for gut health', 'supplement', 50000, 149, 1);

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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
