-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 09, 2025 at 08:48 PM
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
-- Database: `users_telemed`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `booking_date` datetime NOT NULL DEFAULT current_timestamp(),
  `dokter_id` int(11) DEFAULT NULL,
  `jam_booking` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_dokter`
--

CREATE TABLE `data_dokter` (
  `dokter_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `spesialis` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_dokter`
--

INSERT INTO `data_dokter` (`dokter_id`, `id`, `nama_dokter`, `spesialis`, `created_at`, `updated_at`) VALUES
(5, 4, 'Dr. Budi Santoso', 'Spesialis Kardiologi', '2025-01-09 19:32:52', '2025-01-09 19:34:36'),
(6, 24, 'Dr. Citra Lestar', 'Spesialis Penyakit Dalam', '2025-01-09 19:38:03', '2025-01-09 19:42:16'),
(7, 25, 'Dr. Lila Sekar', 'Dokter Umum', '2025-01-09 19:39:03', '2025-01-09 19:39:03'),
(8, 26, 'Dr. Mita Purnama', 'Dokter Umum', '2025-01-09 19:40:03', '2025-01-09 19:40:03'),
(9, 27, 'Dr. Oscar Pranata', 'Spesialis Gastroenterologi', '2025-01-09 19:41:23', '2025-01-09 19:41:23'),
(10, 28, 'Dr. Joko Pratama', 'Spesialis Penyakit Dalam', '2025-01-09 19:44:42', '2025-01-09 19:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `data_pasien`
--

CREATE TABLE `data_pasien` (
  `pasien_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `usia` int(11) NOT NULL,
  `keluhan_penyakit` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_dokter`
--

CREATE TABLE `jadwal_dokter` (
  `jadwal_dokter_id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `jadwal_konsultasi` date NOT NULL,
  `jam` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_dokter`
--

INSERT INTO `jadwal_dokter` (`jadwal_dokter_id`, `dokter_id`, `jadwal_konsultasi`, `jam`) VALUES
(7, 5, '2025-01-10', '00:00:00'),
(8, 5, '2025-12-26', '03:00:00'),
(9, 5, '2025-06-24', '04:00:00'),
(10, 6, '2025-01-27', '04:15:00'),
(11, 7, '2025-01-15', '03:08:00'),
(12, 8, '2025-01-06', '02:00:00'),
(13, 9, '2024-12-30', '04:00:00'),
(14, 10, '2025-01-07', '04:00:00'),
(15, 10, '2025-03-31', '03:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','doctor','patient') NOT NULL DEFAULT 'patient',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2024-12-27 04:05:47'),
(3, 'pasien1', '81da142e2b702c37dbb03d069bef156e', 'patient', '2024-12-27 12:55:50'),
(4, 'dokter1', '5db479bc6453dea4e990cadafd5cede8', 'doctor', '2024-12-27 13:23:21'),
(5, 'pasien2', 'b601ceaa524d491ab929f6943464dbac', 'patient', '2024-12-28 00:16:10'),
(6, 'pasien3', '3a13f50cf7bc2cece19355b9340e91e2', 'patient', '2024-12-28 03:40:06'),
(7, 'pasien4', '2f5c87001c060678317c5a9b853f7237', 'patient', '2024-12-28 09:58:11'),
(8, 'pasien5', 'bdd83d1c6c8fafb3b86e5b8ce9efa291', 'patient', '2024-12-28 11:06:55'),
(24, 'dokter2', '83ac5c3ef493ab7cdebd68dc1712ca89', 'doctor', '2025-01-09 19:37:32'),
(25, 'dokter3', 'c3df25b7b0f35874746bda741960fa85', 'doctor', '2025-01-09 19:38:41'),
(26, 'dokter4', '09d6d215991224c49ecdca4158437d8e', 'doctor', '2025-01-09 19:39:33'),
(27, 'dokter5', '63a6f03666f667bc34f928a4cf4af709', 'doctor', '2025-01-09 19:40:47'),
(28, 'dokter6', 'a51c2ccf58e1bff620549b9d5fde0956', 'doctor', '2025-01-09 19:43:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `data_dokter`
--
ALTER TABLE `data_dokter`
  ADD PRIMARY KEY (`dokter_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `data_pasien`
--
ALTER TABLE `data_pasien`
  ADD PRIMARY KEY (`pasien_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD PRIMARY KEY (`jadwal_dokter_id`),
  ADD KEY `fk_dokter_id` (`dokter_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `data_dokter`
--
ALTER TABLE `data_dokter`
  MODIFY `dokter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `data_pasien`
--
ALTER TABLE `data_pasien`
  MODIFY `pasien_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  MODIFY `jadwal_dokter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_dokter`
--
ALTER TABLE `data_dokter`
  ADD CONSTRAINT `data_dokter_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `data_pasien`
--
ALTER TABLE `data_pasien`
  ADD CONSTRAINT `data_pasien_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `fk_dokter_id` FOREIGN KEY (`dokter_id`) REFERENCES `data_dokter` (`dokter_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
