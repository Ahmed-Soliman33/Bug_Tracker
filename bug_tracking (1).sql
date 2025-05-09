-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2025 at 02:57 PM
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
(43, 'vvsd', 15, 'web', 'sv', 11, 'waiting', 'medium', '2025-05-09 00:33:16'),
(45, ' ccccc', 15, 'web', ' cxxx', 11, 'in_progress', 'medium', '2025-05-09 00:33:56'),
(46, 'axs', 15, 'web', 'ead', 12, 'waiting', 'medium', '2025-05-09 00:36:20'),
(47, 'dsds', 16, 'web', 'dd', 11, 'waiting', 'high', '2025-05-09 00:36:36'),
(48, 'تلاو', 15, 'web', 'ةةةةةة', 11, 'waiting', 'low', '2025-05-09 01:15:45'),
(49, 'df', 15, 'web', 'dfs', 12, 'waiting', 'medium', '2025-05-09 01:41:19'),
(50, 'vvsd', 15, 'web', 'ccccc', 11, 'waiting', 'medium', '2025-05-09 01:41:45'),
(51, 'axs', 15, 'web', 'dddddd', 11, 'waiting', 'medium', '2025-05-09 01:42:35'),
(52, 'sdfv', 16, 'mobile', 'fff', 12, 'waiting', 'medium', '2025-05-09 15:25:27');

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
(43, 11),
(45, 11),
(46, 12),
(47, 11),
(48, 11),
(49, 12),
(50, 11),
(51, 11),
(52, 12);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_user`
--

CREATE TABLE `chat_user` (
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(15, 'project  1', 'mobile', '363', '2025-05-08 23:11:43'),
(16, 'project  5', 'mobile', '363+', '2025-05-08 23:11:52');

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
(11, 'Ahmed Mostafa', 'ahmed@gmail.com', '2025-05-08'),
(12, 'Ahmed Salah', 'salah@gmail.com', '2025-05-08');

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
(12, 'احمد عبدالرحمن', 'ahmed12@gmail.com', '123', 'customer', '2025-05-06 01:05:47'),
(23, 'Soliman', 'soliman@500', '123', 'customer', '2025-05-08 14:51:35'),
(25, 'احمد عبدالرحمن', 'soliman3@500', '123', 'customer', '2025-05-08 14:57:34'),
(33, 'Ahmed Mostafa', 'ahmed@gmail.com', 'ahmed@gmail.com', 'staff', '2025-05-08 20:57:36'),
(34, 'Ahmed Salah', 'salah@gmail.com', 'salah@gmail.com', 'staff', '2025-05-08 20:57:41'),
(36, 'Ahmed salah', 'ali@50000', '123', 'customer', '2025-05-09 15:55:47');

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
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_user`
--
ALTER TABLE `chat_user`
  ADD PRIMARY KEY (`chat_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
-- Constraints for table `chat_user`
--
ALTER TABLE `chat_user`
  ADD CONSTRAINT `chat_user_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
