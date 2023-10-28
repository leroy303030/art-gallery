-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2023 at 03:58 AM
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
-- Database: `art_gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `employee_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `username`, `password`, `employee_number`) VALUES
(1, 'lyron987', 'lyron987', '1');

-- --------------------------------------------------------

--
-- Table structure for table `artworks`
--

CREATE TABLE `artworks` (
  `id` int(11) NOT NULL,
  `image_filename` varchar(255) NOT NULL,
  `painting_title` varchar(255) NOT NULL,
  `medium` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artworks`
--

INSERT INTO `artworks` (`id`, `image_filename`, `painting_title`, `medium`, `description`) VALUES
(1, 'uploads/2-removebg-preview.png', 'AKALA MO', 'LARGE', 'hahahhah'),
(2, 'uploads/new posert.PNG', 'AKALA MO', 'LARGE', 'fafafa');

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE `auctions` (
  `id` int(11) NOT NULL,
  `auction_title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bid_amount` decimal(10,0) NOT NULL,
  `bid_time` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bid_amount`
--

CREATE TABLE `bid_amount` (
  `id` int(11) NOT NULL,
  `admin_starting_bid` decimal(10,0) NOT NULL,
  `user_bid` decimal(10,0) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bid_amount`
--

INSERT INTO `bid_amount` (`id`, `admin_starting_bid`, `user_bid`, `email_address`, `created_at`, `user_id`) VALUES
(2, 100, 0, '', '2023-10-25 09:12:52', NULL),
(3, 100, 105, '', '2023-10-25 09:24:01', NULL),
(4, 100, 1001, '', '2023-10-25 18:08:59', NULL),
(5, 100, 2000, '', '2023-10-25 18:21:14', NULL),
(6, 100, 2001, '', '2023-10-25 18:37:20', NULL),
(7, 100, 3000, '', '2023-10-25 18:42:45', NULL),
(8, 100, 3001, '', '2023-10-25 18:47:31', NULL),
(9, 100, 5000, '', '2023-10-25 19:06:06', NULL),
(10, 100, 10000, 'cruzlyron777@gmail.com', '2023-10-26 16:12:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bid_details`
--

CREATE TABLE `bid_details` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `admin_starting_bid` decimal(10,0) NOT NULL,
  `user_bid` decimal(10,0) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `contactName` varchar(255) NOT NULL,
  `visitDate` date NOT NULL,
  `numVisitors` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `contactName`, `visitDate`, `numVisitors`) VALUES
(7, 'high', '2023-09-30', 2),
(8, 'high', '2023-09-30', 2),
(13, 'gaga', '2023-09-23', 20),
(14, 'gaga', '2023-09-23', 20),
(15, 'gaga', '2023-09-23', 20),
(17, 'haha', '2023-10-07', 99),
(19, 'lyron', '2023-09-28', 23),
(20, 'lyron', '2023-09-30', 3030),
(22, 'jea', '2023-09-27', 1997),
(23, 'jea', '2023-09-27', 1997),
(39, 'Lyron M. Cruz', '2023-09-30', 100),
(40, 'Lyron M. Cruz', '2023-09-30', 100),
(42, 'lyroniie', '2023-09-21', 100),
(43, 'lyroniie', '2023-09-20', 100),
(44, 'cruz', '2023-09-20', 120),
(45, 'lyron', '2023-09-22', 132323),
(46, 'lyron', '2023-09-23', 1),
(47, 'Christian Gonzales', '2023-09-22', 2),
(48, 'Joyce Hijastro', '2023-09-30', 3),
(49, 'Lyron M. Cruz', '2023-09-23', 12),
(50, 'Lyron M. Cruz', '2023-09-27', 1000),
(51, 'Lyron M. Cruz', '2023-10-21', 10),
(52, 'lyron', '2023-09-27', 21),
(53, 'haha', '2023-09-30', 9),
(54, '0987654321234567', '2023-10-01', 40),
(55, 'Lyron M. Cruz', '2023-10-04', 12);

-- --------------------------------------------------------

--
-- Table structure for table `exhibition`
--

CREATE TABLE `exhibition` (
  `id` int(11) NOT NULL,
  `image_filename` varchar(255) NOT NULL,
  `painting_title` varchar(255) NOT NULL,
  `medium` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exhibition`
--

INSERT INTO `exhibition` (`id`, `image_filename`, `painting_title`, `medium`, `description`) VALUES
(1, 'uploads/1.png', 'AKALA MO', 'LARGE', 'adsadsadasa'),
(2, 'uploads/2 - Copy.png', 'AKALA MO', 'LARGE', 'hhh'),
(3, 'uploads/2.png', 'AKALA MO', 'asdas', 'gagagag'),
(4, 'uploads/2-1.png', 'fasfasf', 'fasfs', 'fafasfas'),
(5, 'uploads/3.png', 'AKALA MO', 'dsadaas', 'dsadad'),
(6, 'uploads/Black Modern Smoke Textured Aesthetic Album Cover.png', 'afsafsaf', 'fsfddfd', 'fsfdf'),
(7, 'uploads/Black Modern Smoke Textured Aesthetic Album Cover.png', 'afsafsaf', 'fsfddfd', 'fsfdf'),
(8, 'uploads/new posert.PNG', 'da', 'DA', 'DS'),
(9, 'uploads/new poster.PNG', 'fsafsd', 'LARGE', 'sfafssa'),
(10, 'uploads/2-removebg-preview.png', 'gasasg', 'gasagsgs', 'gasggsagasga');

-- --------------------------------------------------------

--
-- Table structure for table `payment_proof`
--

CREATE TABLE `payment_proof` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `request_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_proof`
--

INSERT INTO `payment_proof` (`id`, `user_id`, `file_name`, `file_path`, `upload_date`, `request_id`) VALUES
(51, 3, '', 'proof_of_payment/361263396_593196796296829_7371615835882161062_n.jpg', '2023-10-24 17:36:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `photo_upload`
--

CREATE TABLE `photo_upload` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `photo_upload`
--

INSERT INTO `photo_upload` (`id`, `filename`, `description`, `created_at`) VALUES
(1, 'new posert.PNG', 'LAst bid', '2023-09-30 08:46:42'),
(2, '3.png', '', '2023-09-30 08:54:02'),
(3, '3.png', '', '2023-09-30 08:56:17'),
(4, 'Black Modern Smoke Textured Aesthetic Album Cover.png', '', '2023-09-30 09:00:36'),
(5, 'Black Modern Smoke Textured Aesthetic Album Cover.png', '', '2023-09-30 09:02:33'),
(6, 'Black Modern Smoke Textured Aesthetic Album Cover.png', '', '2023-09-30 09:03:30'),
(7, 'new posert.PNG', 'last bebonh', '2023-09-30 09:26:20'),
(8, 'new posert.PNG', 'last bebonh', '2023-09-30 09:33:10'),
(9, '3.png', 'last', '2023-09-30 09:45:46'),
(10, '1.png', 'The Band', '2023-10-01 13:44:38'),
(11, 'new posert.PNG', 'THE BOBO BAND', '2023-10-01 13:48:26'),
(12, '2-removebg-preview.png', 'ahahahahah', '2023-10-01 14:13:10'),
(13, '1695405025034.jpg', 'LLL', '2023-10-01 15:37:57'),
(14, 'new poster.PNG', '123', '2023-10-01 15:42:58'),
(15, '3.jpg', '123', '2023-10-03 14:14:00'),
(16, '3.jpg', '123', '2023-10-03 14:31:34'),
(17, '3.jpg', '120', '2023-10-03 14:36:26'),
(18, 'Logo.jpg', 'Letter head', '2023-10-03 14:46:54'),
(19, 'black-check-mark-icon-tick-symbol-in-black-color-illustration-for-web-mobile-and-concept-design-free-vector.jpg', 'Check like Ritemed', '2023-10-03 15:15:05'),
(20, '3-removebg-preview.png', 'ahahahahah', '2023-10-04 10:08:17'),
(21, 'black-check-mark-icon-tick-symbol-in-black-color-illustration-for-web-mobile-and-concept-design-free-vector-removebg-preview.png', '123', '2023-10-04 13:36:47'),
(22, 'IMG_7794.jpg', 'tin id', '2023-10-04 14:54:10'),
(23, '384518457_669231811841388_2571067053262784571_n.jpg', 'ahahahahah', '2023-10-04 15:04:46'),
(24, '20230923011602_IMG_7614.JPG', 'ahahahahah', '2023-10-05 05:05:03'),
(25, 'download.jfif', 'THE SONG OF FIRE AND GIN', '2023-10-21 07:55:01'),
(26, '361263396_593196796296829_7371615835882161062_n.jpg', 'RX', '2023-10-24 17:38:04');

-- --------------------------------------------------------

--
-- Table structure for table `qr_code`
--

CREATE TABLE `qr_code` (
  `id` int(11) NOT NULL,
  `photo_name` varchar(255) NOT NULL,
  `photo_description` text NOT NULL,
  `photo_file` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qr_code`
--

INSERT INTO `qr_code` (`id`, `photo_name`, `photo_description`, `photo_file`) VALUES
(1, '', '', 0x75706c6f6164732f646f776e6c6f61642e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `starting_bid`
--

CREATE TABLE `starting_bid` (
  `id` int(11) NOT NULL,
  `admin_starting_bid` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `starting_bid`
--

INSERT INTO `starting_bid` (`id`, `admin_starting_bid`, `created_at`) VALUES
(1, 100.00, '2023-10-24 18:42:29'),
(2, 100.00, '2023-10-25 09:09:18'),
(3, 100.00, '2023-10-25 09:10:47'),
(4, 100.00, '2023-10-25 09:11:22');

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

CREATE TABLE `timer` (
  `id` int(11) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timer`
--

INSERT INTO `timer` (`id`, `start_datetime`, `end_datetime`) VALUES
(31, '2023-10-03 02:28:00', '2023-10-03 02:29:00'),
(32, '2023-10-03 02:30:00', '2023-10-03 02:31:00'),
(33, '2023-10-03 02:36:00', '2023-10-03 02:37:00'),
(34, '2023-10-03 02:40:00', '2023-10-03 02:41:00'),
(35, '2023-10-03 02:43:00', '2023-10-03 02:45:00'),
(36, '2023-10-03 22:53:00', '2023-10-03 22:54:00'),
(37, '2023-10-03 23:17:00', '2023-10-03 23:25:00'),
(38, '2023-10-04 18:10:00', '2023-10-04 18:14:00'),
(39, '2023-10-04 21:39:00', '2023-10-04 13:39:00'),
(40, '2023-10-04 21:39:00', '2023-10-04 22:38:00'),
(41, '2023-10-05 13:07:00', '2023-10-05 14:07:00'),
(42, '2023-10-25 01:39:00', '2023-10-25 03:00:00'),
(43, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, '2023-10-25 01:39:00', '2023-10-25 03:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `permanent_address` varchar(255) NOT NULL,
  `request_status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `phone_number`, `first_name`, `middle_name`, `last_name`, `email_address`, `permanent_address`, `request_status`) VALUES
(1, 'ly123', '$2y$10$szcwSaODyhAL4sbj2ZoqseXRqXYJwbQes7BVzR0AlhfFRKMbhMhlm', '09984386734', 'ly', 'manlong', 'cruz', 'cruzlyron777@gmail.com', 'Bulakan', 'Pending'),
(2, 'lyron123', '$2y$10$9hS2h4uxePB9mlAFwnI.W.iRyaHbAot.P5Y9X0No/QOwV2DA1o7nS', '09984386734', 'jea', 'manlong', 'cruz', 'cruzlyron777@gmail.com', 'Bulakan', 'Pending'),
(3, 'lyron987', '$2y$10$GpBJflqIwpLZX.Ob4hGjpeGcGZyvaCxeSXImqUDBsUTeB9XBfr14m', '09984386734', 'jea', 'manlong', 'cruz', 'cruzlyron777@gmail.com', 'Bulakan', 'Pending'),
(4, '@injeolmi27', '$2y$10$BgbvtAPYH.f8E1s.0.qy3.BpQTIocPhRxOAkJkNNCZnr.7ONLfV2S', '09123456789', 'Whyer', 'Lee', 'Haha', 'a@gmail.com', 'Mars', 'Pending'),
(5, 'lyron12345', '$2y$10$i4VcZ08qpT.5TqH6YGALgO6Ekey7SwokUYtxE95UVF.vrwJ7jrAU.', '09984386734', 'ly', 'manlong', 'cruz', 'lyron.cruz.m@bulsu.edu.php', 'Bulakan', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `user_bid`
--

CREATE TABLE `user_bid` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bid_id` int(11) DEFAULT NULL,
  `user_bid_amount` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_requests`
--

CREATE TABLE `user_requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_date` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_requests`
--

INSERT INTO `user_requests` (`request_id`, `user_id`, `request_date`, `status`) VALUES
(38, 3, '2023-10-24 11:36:59', 'Approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_number` (`employee_number`);

--
-- Indexes for table `artworks`
--
ALTER TABLE `artworks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bid_amount`
--
ALTER TABLE `bid_amount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bid_user` (`user_id`);

--
-- Indexes for table `bid_details`
--
ALTER TABLE `bid_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username_fk` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exhibition`
--
ALTER TABLE `exhibition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_proof`
--
ALTER TABLE `payment_proof`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_fk` (`user_id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `photo_upload`
--
ALTER TABLE `photo_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qr_code`
--
ALTER TABLE `qr_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `starting_bid`
--
ALTER TABLE `starting_bid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timer`
--
ALTER TABLE `timer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `idx_username` (`username`);

--
-- Indexes for table `user_bid`
--
ALTER TABLE `user_bid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bid_id` (`bid_id`);

--
-- Indexes for table `user_requests`
--
ALTER TABLE `user_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `artworks`
--
ALTER TABLE `artworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bid_amount`
--
ALTER TABLE `bid_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bid_details`
--
ALTER TABLE `bid_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `exhibition`
--
ALTER TABLE `exhibition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_proof`
--
ALTER TABLE `payment_proof`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `photo_upload`
--
ALTER TABLE `photo_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `qr_code`
--
ALTER TABLE `qr_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `starting_bid`
--
ALTER TABLE `starting_bid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `timer`
--
ALTER TABLE `timer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_bid`
--
ALTER TABLE `user_bid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_requests`
--
ALTER TABLE `user_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bid_amount`
--
ALTER TABLE `bid_amount`
  ADD CONSTRAINT `fk_bid_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `bid_details`
--
ALTER TABLE `bid_details`
  ADD CONSTRAINT `username_fk` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_proof`
--
ALTER TABLE `payment_proof`
  ADD CONSTRAINT `payment_proof_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `payment_proof_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `user_requests` (`request_id`);

--
-- Constraints for table `user_bid`
--
ALTER TABLE `user_bid`
  ADD CONSTRAINT `user_bid_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_bid_ibfk_2` FOREIGN KEY (`bid_id`) REFERENCES `bid_amount` (`id`);

--
-- Constraints for table `user_requests`
--
ALTER TABLE `user_requests`
  ADD CONSTRAINT `user_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
