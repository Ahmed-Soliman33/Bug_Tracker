-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 09:31 PM
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
-- Database: `bug_tracking_app`
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
(13, 'bug front ', 11, 'mobile', 'ssssssssssssss', 2, 'solved', 'high', '2025-05-07 17:35:49'),
(14, 'bug front ', 11, 'desktop', 'zzzzzzzzzzzzzzzzzzza', 3, 'solved', 'high', '2025-05-07 17:36:04'),
(15, 'aaaaaaaaaaaaaaaaaaaaaa', 4, 'web', 'aaaaaaaaaaaaaaaa', 1, 'solved', 'low', '2025-05-07 17:38:28'),
(16, 'bug front 555', 10, 'web', 'sssasasas', 2, 'solved', 'high', '2025-05-07 17:39:32');

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
(13, 1),
(16, 4);

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
(1, 'project  1', 'web', 'ask;jahslahlsl', '2025-05-06 16:55:48'),
(2, 'project  1', 'web', 'ask;jahslahlsl', '2025-05-06 16:56:26'),
(3, 'sasasas', 'web', 'sasasas', '2025-05-06 16:56:33'),
(4, 'project  5', 'mobile', 'sasasas', '2025-05-06 16:56:55'),
(5, 'sas', 'web', 'sass', '2025-05-06 17:48:44'),
(6, 'sas', 'web', 'sass', '2025-05-06 17:49:26'),
(7, 'sas', 'web', 'sass', '2025-05-06 17:50:08'),
(8, 'frontend', 'desktop', 'sasasasaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2025-05-06 17:58:39'),
(9, 'ahmed salah', 'mobile', 'asassssssssssssssssssss', '2025-05-06 18:32:05'),
(10, 'Bug Tracker Project', 'web', 'Bug Tracker ProjectBug Tracker ProjectBug Tracker ProjectBug Tracker ProjectBug Tracker ProjectBug Tracker ProjectBug Tracker ProjectBug Tracker ProjectBug Tracker Project', '2025-05-07 13:25:59'),
(11, 'Pro 2025', 'desktop', 'ggasgjkagkggggggggga', '2025-05-07 15:04:36');

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
(1, 'Ahmed Mostafa', 'mostafa@gmail.com', '2025-05-07'),
(2, 'Osama Ahmed', 'osama@gmail.com', '2025-05-07'),
(3, 'Ahmed Mostafa 21323', 'mostafasasas@gmail.com', '2025-05-07'),
(4, 'Ahmed Salah', 'salah@gmail.com', '2025-05-07');

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
(13, 'Ahmed Mostafa', 'mostafa@gmail.com', 'mostafa@gmail.com', 'staff', '2025-05-07 15:27:36'),
(17, 'Osama Ahmed', 'osama@gmail.com', 'osama@gmail.com', 'staff', '2025-05-07 15:34:45'),
(21, 'Ahmed Mostafa 21323', 'mostafasasas@gmail.com', 'mostafasasas@gmail.com', 'staff', '2025-05-07 17:18:24'),
(22, 'Ahmed Salah', 'salah@gmail.com', 'salah@gmail.com', 'staff', '2025-05-07 17:20:15');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
