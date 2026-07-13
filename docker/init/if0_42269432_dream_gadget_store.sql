-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql300.infinityfree.com
-- Generation Time: Jul 13, 2026 at 04:13 AM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42269432_dream_gadget_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(2, 'Personal Computing & Mobile'),
(4, 'Smart Home & Networking'),
(5, 'Office & Creator Equipment'),
(6, 'Power & Accessories'),
(7, 'Audio & Entertainment'),
(8, 'Car & Automotive Electronics'),
(9, 'Photography, Videography & Drones'),
(10, 'Wellness, Health & Grooming Tech'),
(11, 'Eco-Friendly & Outdoor Tech'),
(12, 'Component Level & DIY Electronics'),
(13, 'Gaming Gear & Esports Equipment'),
(14, 'Kitchen & Culinary Electronics');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Unread','Read') DEFAULT 'Unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_reply` text DEFAULT NULL,
  `reply_status` varchar(20) DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `full_name`, `email`, `subject`, `message`, `status`, `created_at`, `admin_reply`, `reply_status`) VALUES
(1, 'Cyrus S Reeves', 'cyrusreeves0@gmail.com', 'Inquiry about my order', 'Please, im finding it difficult to get my order, please help me out', 'Read', '2026-06-23 09:20:25', 'Ok we will do it immediately', 'Read'),
(2, 'Tongor Korden', 'tongor.kn@gmail.com', 'Inquiry about my order', 'I need my order please', 'Read', '2026-06-23 09:30:55', 'You will get it soon', 'Read'),
(3, 'Rachel Reeves', 'rachelreeves165@gmail.com', 'Inquiry about my order', 'When will i get my orders?', 'Read', '2026-06-23 09:42:51', 'Please dont worry, when a reach your destination, you will get it ', 'Read'),
(6, 'Tongor Korden', 'tongor.kn@gmail.com', 'Inquiry about my order', 'Hi', 'Read', '2026-06-23 12:09:10', 'How are you?', 'Read'),
(7, 'Tongor Korden', 'tongor.kn@gmail.com', 'Inquiry about my order', 'Hi', 'Read', '2026-06-23 12:10:13', 'how are you', 'Read'),
(8, 'Cyrus S Reeves', 'cyrusreeves0@gmail.com', 'Inquiry about my order', 'im waiting', 'Read', '2026-06-23 12:16:53', 'For what?', 'Read'),
(13, 'Cyrus S Reeves', 'cyrusreeves0@gmail.com', 'Inquiry about my order', 'We here', 'Read', '2026-06-23 12:26:02', 'Where?', 'Read'),
(14, 'Cyrus S Reeves', 'cyrusreeves0@gmail.com', 'Inquiry about my order', 'we here ', 'Read', '2026-06-23 12:32:38', 'I coming outside', 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 'Cyrus S Reeves', 'cyrusreeves0@gmail.com', '0792564032', 'Rwanda, Nyanza', '2026-06-23 15:30:57'),
(2, 'Cyrus S Reeves', 'cyrusreeves0@gmail.com', '0792564032', 'Rwanda, Nyanza', '2026-06-23 16:04:11'),
(3, 'Thomity Keita', 'timothykeita56@gmail.com', '0794131140', 'Rwanda', '2026-06-25 14:55:12'),
(4, 'Leo Henry', 'hleo52772@gmail.com', '0737652530', 'Monrovia Junction', '2026-06-25 16:44:22'),
(5, 'cephas m kpogbah', 'kpogbahcephas854@gmail.com', '0794041868', 'Nyanza district', '2026-07-03 07:11:21');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending',
  `user_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_phone` varchar(20) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_status` varchar(30) DEFAULT 'Pending Verification'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total_amount`, `order_status`, `order_date`, `status`, `user_id`, `payment_method`, `payment_phone`, `transaction_id`, `payment_status`) VALUES
(1, 1, '650000.00', 'Pending', '2026-06-23 15:30:57', 'Delivered', 1, 'MTN MoMo', '0792564032', 'MOMO123456', 'Paid'),
(2, 2, '550000.00', 'Pending', '2026-06-23 16:04:11', 'Pending', 1, 'MTN MoMo', '0792564032', 'TXN20260623180411809', 'Paid'),
(3, 3, '150000.00', 'Pending', '2026-06-25 14:55:12', 'Pending', 7, 'MTN MoMo', '0794131140', 'TXN20260625105512125', 'Paid'),
(4, 4, '450000.00', 'Pending', '2026-06-25 16:44:22', 'Delivered', 8, 'Airtel Money', '0737652530', 'TXN20260625124423756', 'Paid'),
(5, 5, '450000.00', 'Pending', '2026-07-03 07:11:21', 'Processing', 9, 'MTN MoMo', '0794041868', 'TXN20260703031121100', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(14, 1, 3, 1, '450000.00'),
(15, 1, 7, 2, '100000.00'),
(16, 2, 3, 1, '450000.00'),
(17, 2, 8, 2, '50000.00'),
(18, 3, 7, 1, '100000.00'),
(19, 3, 8, 1, '50000.00'),
(20, 4, 3, 1, '450000.00'),
(21, 5, 3, 1, '450000.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `description`, `price`, `image`, `stock`, `created_at`) VALUES
(1, 2, 'iPhone 15 Pro', 'Apple Smartphone', '1200000.00', 'iphone15 Pro.jpg', 10, '2026-06-22 11:07:05'),
(2, 2, 'Samsung Galaxy S25', 'Samsung Smartphone', '800000.00', 'samsungs25.jpg', 15, '2026-06-22 11:07:05'),
(3, 2, 'HP EliteBook', 'Business Laptop', '450000.00', 'hp_elitebook.jpg', 8, '2026-06-22 11:07:05'),
(4, 2, 'Dell XPS 15', 'Premium Laptop', '500000.00', 'dell_xps15.jpg', 5, '2026-06-22 11:07:05'),
(5, 2, 'Apple Watch Series 10', 'Smart Watch', '200000.00', 'apple_watch.jpg', 12, '2026-06-22 11:07:05'),
(6, 7, 'AirPods Pro', 'Wireless Earbuds', '75000.00', 'airpods_pro.jpg', 20, '2026-06-22 11:07:05'),
(7, 7, 'Wireless headphone', 'Premium headphone', '100000.00', 'wireless_headphone.jpg', 2, '2026-06-22 14:59:14'),
(8, 7, 'Wireless headphone', 'Premium headphone', '50000.00', 'wireless JBL_headphone.jpg', 1, '2026-06-22 15:02:51'),
(9, 14, 'Mika 6L Smart Pressure Cooker, SS MPC1106', 'The Mika 6L Smart Pressure Cooker is a versatile kitchen companion with 15 pre-programmed functions, including Cake, Biryani, Meat, Stew, Chicken, Bean, Lentil, Soup, Broth, Rice, Egg, Porridge, Steam, Slow Cook, and SautÃ©. Powered by 1000 Watts and operating at 220-240V, 50/60Hz, this cooker is designed for efficiency and safety.', '170000.00', 'pressure rice cooker.jpg', 50, '2026-07-01 07:25:26');

-- --------------------------------------------------------

--
-- Table structure for table `support_replies`
--

CREATE TABLE `support_replies` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `admin_reply` text NOT NULL,
  `status` varchar(20) DEFAULT 'Unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `created_at`) VALUES
(1, 'Cyrus S Reeves', 'cyrusreeves0@gmail.com', '$2y$10$3SPuqa27J.9eiEMU/BmVieaCnLkioJwstPokhPouEsMxs39iLBeo6', '2026-06-23 15:26:59'),
(2, 'Rachel Reeves', 'rachelreeves165@gmail.com', '$2y$10$9Y2lmJwWIQmPIDp64QxZEeitbPhXxzkjnnhwSqOREOUargKCQ0FGC', '2026-06-23 15:27:17'),
(3, 'Tongor Korden', 'tongor.kn@gmail.com', '$2y$10$qS3N2iVNXMq65AHHmZB8meV4Ra/dLCChGHARk4jzmAGwy/n0DXXfS', '2026-06-23 15:27:33'),
(4, 'Trent Anold', 'cyrusreeves13@gmail.com', '$2y$10$AsTsaA23QevxzFLFZDApf.W7Ty7P8cHHLFNzJW9OrwjA4vwT6kBqC', '2026-06-23 15:27:48'),
(5, 'Sam T. Chea', 'samchea132@gmail.com', '$2y$10$Rw2ZnzKNtcf9MAZe34z.uu1b5FLmgRoXUlbg/mkRBjZHBB8AEHaVe', '2026-06-23 15:28:26'),
(6, 'Sarah Doe', 'sarah1234@gmail.com', '$2y$10$wFrj2.gE6oRnO0JeJd346efD9.Z.a.5ZwA2CiIdCln4Pa2w6izlNu', '2026-06-23 17:02:35'),
(7, 'Thomity Keita', 'timothykeita56@gmail.com', '$2y$10$WEVn2WoIQ7aoWxjqqL9yxen13H2HhB/7W/ZB/t91QoAQdcmv3/UYW', '2026-06-25 14:53:38'),
(8, 'Leo Henry', 'hleo52772@gmail.com', '$2y$10$8FAupU8mTUIlPhuzFddFqOE1gkv1x3SZ8CFj4gn07qpMtAyRadIsS', '2026-06-25 16:38:55'),
(9, 'Cephas m Kpogbah', 'kpogbahcephas854@gmail.com', '$2y$10$now0w7xIEMrNyx7Cog3Fi.v90Eb0czV.N6NdxdZP.DgNchQBIe5Nu', '2026-07-03 07:08:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `support_replies`
--
ALTER TABLE `support_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `support_replies`
--
ALTER TABLE `support_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
