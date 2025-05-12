-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 12:52 AM
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
-- Database: `bug_tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bugs`
--

CREATE TABLE `bugs` (
  `id` int(11) NOT NULL,
  `bug_name` varchar(120) NOT NULL,
  `project_id` int(11) NOT NULL,
  `category` text NOT NULL,
  `details` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `status` enum('waiting','in_progress','solved') DEFAULT 'waiting',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bugs`
--

INSERT INTO `bugs` (`id`, `bug_name`, `project_id`, `category`, `details`, `assigned_to`, `status`, `priority`, `created_at`) VALUES
(79, 'backend bug salah', 20, 'desktop', 'asasass', 16, 'solved', 'high', '2025-05-12 23:28:19'),
(81, 'backend bug tarek', 22, 'mobile', 'asasas', NULL, 'solved', 'high', '2025-05-12 23:56:23');

-- --------------------------------------------------------

--
-- Table structure for table `bug_customer`
--

CREATE TABLE `bug_customer` (
  `bug_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bug_staff`
--

CREATE TABLE `bug_staff` (
  `bug_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bug_staff`
--

INSERT INTO `bug_staff` (`bug_id`, `staff_id`) VALUES
(79, 16),
(81, 19);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `customer_email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `customer_created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_email`, `customer_created_at`) VALUES
(1, 'احمد عبدالرحمن', 'ahmed@505', '2025-05-09'),
(2, 'Ahmed Elfares', 'ahmed23@500', '2025-05-09'),
(3, 'thabet', 'thabet@500', '2025-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `bug_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` datetime NOT NULL,
  `recipient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `bug_id`, `sender_id`, `message`, `sent_at`, `recipient_id`) VALUES
(30, 79, 42, 'عامل ايه ي رياسة ', '2025-05-12 22:29:33', 11),
(31, 79, 11, 'كويس يعلق', '2025-05-12 22:30:04', 42);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_title` varchar(300) NOT NULL,
  `project_type` enum('web','mobile','desktop') NOT NULL,
  `project_description` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_title`, `project_type`, `project_description`, `created_at`) VALUES
(20, 'project  5', 'mobile', 'qwqwqwqw', '2025-05-12 23:25:21'),
(21, 'project  4', 'desktop', 'sdsdadad', '2025-05-12 23:25:30'),
(22, 'front end dev', 'desktop', 'asasasas', '2025-05-12 23:53:10');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `staff_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `staff_created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `staff_email`, `staff_created_at`) VALUES
(15, 'Ahmed Mostafa', 'ahmed@gmail.com', '2025-05-10'),
(16, 'Ahmed Salah', 'salah@gmail.com', '2025-05-12'),
(18, 'SASA', 'sasa@gmail.com', '2025-05-12'),
(19, 'Tarek ', 'tarek@gmail.com', '2025-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` enum('customer','admin','staff') NOT NULL DEFAULT 'customer',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(11, 'ali', 'ali@500', '123', 'admin', '2025-05-05 23:19:28'),
(38, 'احمد عبدالرحمن', 'ahmed@505', '123', 'customer', '2025-05-09 16:02:25'),
(39, 'Ahmed Elfares', 'ahmed23@500', '123', 'customer', '2025-05-09 17:42:18'),
(41, 'Ahmed Mostafa', 'ahmed@gmail.com', 'ahmed@gmail.com', 'staff', '2025-05-10 14:31:27'),
(42, 'Ahmed Salah', 'salah@gmail.com', 'salah@gmail.com', 'staff', '2025-05-12 23:25:47'),
(44, 'SASA', 'sasa@gmail.com', 'sasa@gmail.com', 'staff', '2025-05-12 23:26:07'),
(45, 'Tarek ', 'tarek@gmail.com', 'tarek@gmail.com', 'staff', '2025-05-12 23:54:03'),
(46, 'thabet', 'thabet@500', '123', 'customer', '2025-05-12 23:58:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bugs`
--
ALTER TABLE `bugs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_project_id` (`project_id`),
  ADD KEY `bugs_ibfk_2` (`assigned_to`);

--
-- Indexes for table `bug_customer`
--
ALTER TABLE `bug_customer`
  ADD KEY `bug_id` (`bug_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `bug_staff`
--
ALTER TABLE `bug_staff`
  ADD PRIMARY KEY (`bug_id`,`staff_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bug_id` (`bug_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bugs`
--
ALTER TABLE `bugs`
  ADD CONSTRAINT `bugs_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `bugs_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `bug_customer`
--
ALTER TABLE `bug_customer`
  ADD CONSTRAINT `bug_customer_ibfk_1` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`id`),
  ADD CONSTRAINT `bug_customer_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `bug_staff`
--
ALTER TABLE `bug_staff`
  ADD CONSTRAINT `bug_staff_ibfk_1` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bug_staff_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
