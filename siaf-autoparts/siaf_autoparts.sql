-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 30, 2026 at 01:03 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siaf_autoparts`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `name`, `created_at`) VALUES
(1, 'admin', '$2y$10$sklUIUBVebW7I6zavqzkV.Oa8X5qsXmG/xyXjJ7vPbBuf1z75/rka', 'Administrator', '2026-04-28 08:17:34');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `status` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `sort_order`, `status`, `created_at`) VALUES
(1, 'Control & Speedometer Cables', 'control-cables', 'Clutch cables, accelerator wires, brake cables', NULL, 0, 1, '2026-04-28 08:17:34'),
(2, 'Automotive Bearings', 'automotive-bearings', 'High-precision bearings for two wheelers', NULL, 1, 1, '2026-04-28 08:17:34'),
(3, 'Automotive Indicators', 'automotive-indicators', 'Side blinkers and indicator assemblies', NULL, 2, 1, '2026-04-28 08:17:34'),
(4, 'Spark & Two Wheeler Plugs', 'spark-plugs', 'Spark plugs for optimal ignition', NULL, 3, 1, '2026-04-28 08:17:34'),
(5, 'Chain Sprocket & Timing Kits', 'chain-sprocket', 'Chain drive components and timing kits', NULL, 4, 1, '2026-04-28 08:17:34'),
(6, 'Drum Rubber & Disc Caliper', 'brake-system', 'Braking system components', NULL, 5, 1, '2026-04-28 08:17:34'),
(7, 'Head Light Assembly', 'head-light', 'Complete headlight solutions', NULL, 6, 1, '2026-04-28 08:17:34'),
(8, 'Gear & Kick Shaft', 'gear-shaft', 'Transmission components', NULL, 7, 1, '2026-04-28 08:17:34');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('unread','read','replied') COLLATE utf8mb4_unicode_ci DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `product`, `message`, `status`, `created_at`) VALUES
(1, 'Hasan', 'admin1@gmail.com', '9999999999', 'Accelerator Wire', 'How many price of this product', 'replied', '2026-04-30 11:41:49'),
(2, 'Elite', 'hzakariya437@gmail.com', '9999999999', 'Accelerator Wire', 'fftg4', 'replied', '2026-04-30 11:43:45'),
(3, 'aa', 'Aadil@gmail.com', '98989899898', 'Accelerator Wire', 'ffds', 'replied', '2026-04-30 11:44:20');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `specifications` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(12,2) DEFAULT '0.00',
  `status` tinyint DEFAULT '1',
  `featured` tinyint DEFAULT '0',
  `views` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `specifications`, `image`, `gallery`, `price`, `status`, `featured`, `views`, `created_at`, `updated_at`) VALUES
(1, 1, 'Clutch Cable Splendor Plus', 'clutch-cable-splendor-plus', 'wire and durable outer casing.', 'Material: Steel + PVC, Length: Standard OEM, Compatible: Hero Splendor Plus', NULL, NULL, 600.00, 1, 1, 0, '2026-04-28 08:17:34', '2026-04-30 07:05:11'),
(2, 1, 'Accelerator Wire', 'accelerator-wire', 'Smooth accelerator wire for all major two-wheeler brands. Ensures quick throttle response.', 'Material: Stainless Steel, Length: Customizable, Compatible: Universal', NULL, NULL, 350.00, 1, 1, 1, '2026-04-28 08:17:34', '2026-04-30 11:31:59'),
(3, 1, 'Two Wheeler Brake Cable', 'two-wheeler-brake-cable', 'Reliable brake cable with superior braking performance. Tested for durability.', 'Material: Galvanized Steel, Length: Standard, Compatible: All Bikes', NULL, NULL, 280.00, 1, 0, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(4, 2, 'Bonetex Two Wheeler Bearing', 'bonetex-two-wheeler-bearing', 'High-precision ball bearing designed for smooth wheel rotation and long life.', 'Type: Ball Bearing, Material: Chrome Steel, Sealed: Yes', NULL, NULL, 180.00, 1, 1, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(5, 2, 'Two Wheeler Ball Bearing', 'two-wheeler-ball-bearing', 'Premium quality ball bearing for front and rear wheel applications.', 'Type: Deep Groove Ball Bearing, Size: Multiple', NULL, NULL, 220.00, 1, 0, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(6, 3, 'Plastic Two Wheeler Indicator', 'plastic-two-wheeler-indicator', 'Bright and durable side blinker for enhanced visibility and safety.', 'Material: ABS Plastic, Bulb Type: 12V, Color: Amber', NULL, NULL, 150.00, 1, 1, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(7, 3, 'Side Blinker Assembly', 'side-blinker-assembly', 'Complete indicator assembly with housing, bulb, and wiring.', 'Material: ABS + Glass, Voltage: 12V, Warranty: 6 Months', NULL, NULL, 320.00, 1, 0, 1, '2026-04-28 08:17:34', '2026-04-28 12:41:16'),
(8, 4, 'Two Wheeler Spark Plug', 'two-wheeler-spark-plug', 'Premium spark plug for optimal ignition and fuel efficiency.', 'Type: Resistor, Thread: M14, Heat Range: Standard', NULL, NULL, 120.00, 1, 1, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(9, 4, 'High Performance Spark Plug', 'high-performance-spark-plug', 'Racing grade spark plug for maximum power output.', 'Type: Iridium, Electrode: Fine Wire, Life: 30000km', NULL, NULL, 350.00, 1, 0, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(10, 5, 'Automobile Chain Sprocket Kit', 'automobile-chain-sprocket-kit', 'Complete chain and sprocket kit for reliable power transmission.', 'Chain Size: 428H, Sprocket Teeth: 14T/42T, Material: Steel', NULL, NULL, 850.00, 1, 1, 1, '2026-04-28 08:17:34', '2026-04-30 12:10:02'),
(11, 5, 'Timing Chain Kit', 'timing-chain-kit', 'Complete timing chain kit with tensioner and guides.', 'Links: 100, Material: Alloy Steel, Includes: Tensioner', NULL, NULL, 1200.00, 1, 0, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(12, 6, 'Two Wheeler Drum Rubber', 'two-wheeler-drum-rubber', 'High-quality drum brake rubber for effective braking.', 'Material: NBR Rubber, Size: Standard OEM, Heat Resistant: Yes', NULL, NULL, 180.00, 1, 1, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(13, 6, 'Disc Caliper Assembly', 'disc-caliper-assembly', 'Complete disc brake caliper assembly with pads.', 'Material: Aluminum, Piston: Single, Includes: Brake Pads', NULL, NULL, 1800.00, 1, 0, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(14, 7, 'Head Light Assy CD Deluxe', 'head-light-assy-cd-deluxe', 'Complete headlight assembly for Hero CD Deluxe.', 'Wattage: 35/35W, Housing: ABS, Lens: Glass', NULL, NULL, 650.00, 1, 1, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(15, 7, 'Motorcycle Head Light', 'motorcycle-head-light', 'Universal motorcycle headlight with bright halogen bulb.', 'Wattage: 60/55W, Bulb: H4, Housing: Metal', NULL, NULL, 950.00, 1, 0, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(16, 8, 'Bonetex Gear Shaft', 'bonetex-gear-shaft', 'Durable gear shaft for smooth transmission operation.', 'Material: Alloy Steel, Hardened: Yes, OEM Quality', NULL, NULL, 1200.00, 1, 1, 0, '2026-04-28 08:17:34', '2026-04-28 08:17:34'),
(18, 8, 'Ruubber', 'ruubber', 'check', 'Nothing', 'ruubber.jpg', NULL, 15.00, 1, 1, 2, '2026-04-30 09:18:32', '2026-04-30 11:10:49');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE IF NOT EXISTS `visitors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visit_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ip_date` (`ip_address`,`visit_date`),
  KEY `idx_session` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `ip_address`, `user_agent`, `session_id`, `page_url`, `visit_date`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '', '/siaf-autoparts/index.php', '2026-04-30 11:29:14'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '', '/siaf-autoparts/', '2026-04-30 11:31:40'),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '', '/siaf-autoparts/products.php', '2026-04-30 11:31:46'),
(4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '', '/siaf-autoparts/product.php?slug=accelerator-wire', '2026-04-30 11:31:59'),
(5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '', '/siaf-autoparts/contact.php?product=Accelerator+Wire', '2026-04-30 11:32:04'),
(6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '', '/siaf-autoparts/company-profile.php', '2026-04-30 11:49:28'),
(7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '', '/siaf-autoparts/contact.php', '2026-04-30 11:49:32'),
(8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '', '/siaf-autoparts/product.php?slug=automobile-chain-sprocket-kit', '2026-04-30 12:10:02');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
