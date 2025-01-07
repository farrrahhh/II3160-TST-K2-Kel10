-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 06, 2025 at 01:43 PM
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

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `patient_id`, `booking_date`, `dokter_id`, `jam_booking`) VALUES
(20, 8, '0000-00-00 00:00:00', 3, '12:00:00'),
(21, 8, '0000-00-00 00:00:00', 2, '06:00:00'),
(22, 7, '0000-00-00 00:00:00', 3, '12:00:00');

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
(2, 4, 'Dr. Dre', 'Hati', '2024-12-28 07:38:12', '2024-12-28 11:17:43'),
(3, 9, 'Farah Imba', 'Artifical Neural Network', '2025-01-03 13:15:57', '2025-01-03 13:15:57');

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

--
-- Dumping data for table `data_pasien`
--

INSERT INTO `data_pasien` (`pasien_id`, `id`, `nama`, `usia`, `keluhan_penyakit`) VALUES
(1, 3, 'Clement Nathanael Lim', 19, 'a'),
(2, 5, 'Sugeng', 35, 'Puyeng gak ada duit :D'),
(3, 6, 'TESTING', 28, 'sakit pala'),
(4, 7, 'clem', 20, 'g'),
(5, 8, 'clementtt', 18, 'aaaa'),
(6, 10, 'Clement', 21, 'Cupu AI'),
(7, 8, 'clement', 200, 'aaaaaaaa');

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
(2, 2, '2024-12-30', '06:00:00'),
(3, 2, '2024-12-30', '08:00:00'),
(4, 2, '2024-12-30', '09:00:00'),
(5, 3, '2025-01-11', '12:00:00');

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
(9, 'farah', '9b0f4d720720fd55436ac7f07ac8a840', 'doctor', '2025-01-03 13:15:24'),
(10, 'clement', '236e92bcf7c04d8d7ff3f798b537823f', 'patient', '2025-01-03 13:17:21');

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `data_dokter`
--
ALTER TABLE `data_dokter`
  MODIFY `dokter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `data_pasien`
--
ALTER TABLE `data_pasien`
  MODIFY `pasien_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  MODIFY `jadwal_dokter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
