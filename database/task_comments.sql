-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 25, 2025 at 01:43 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flowtask`
--

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

CREATE TABLE `task_comments` (
  `id` int NOT NULL,
  `task_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment` text NOT NULL,
  `parent_comment_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_edited` tinyint(1) DEFAULT '0',
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task_comments`
--

INSERT INTO `task_comments` (`id`, `task_id`, `user_id`, `comment`, `parent_comment_id`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`, `is_edited`, `edited_at`) VALUES
(1, 55, 25, 'semangat ya ngerjainnya\r\n', NULL, '2025-10-01 08:27:46', '2025-10-01 08:27:46', 0, NULL, 0, NULL),
(2, 55, 28, 'oke kang', NULL, '2025-10-01 08:33:36', '2025-10-01 08:33:36', 0, NULL, 0, NULL),
(3, 55, 28, 'nih bos kelar', NULL, '2025-10-01 08:59:53', '2025-10-01 08:59:53', 0, NULL, 0, NULL),
(4, 55, 28, 'nih bos kelar', NULL, '2025-10-01 09:03:32', '2025-10-01 09:03:32', 0, NULL, 0, NULL),
(5, 55, 28, 'tes', NULL, '2025-10-01 09:14:09', '2025-10-01 09:14:09', 0, NULL, 0, NULL),
(6, 55, 28, 'yaa begitulah', 1, '2025-10-01 09:53:05', '2025-10-01 09:53:05', 0, NULL, 0, NULL),
(7, 55, 25, 'iya gitu', 6, '2025-10-01 10:35:18', '2025-10-01 10:35:18', 0, NULL, 0, NULL),
(8, 55, 25, 'hooh', 7, '2025-10-01 10:35:41', '2025-10-01 10:35:41', 0, NULL, 0, NULL),
(9, 55, 25, 'yaudah lah wir', 6, '2025-10-01 10:35:52', '2025-10-01 10:35:52', 0, NULL, 0, NULL),
(10, 56, 25, 'langsung kerjakan ya mase', NULL, '2025-10-01 10:42:15', '2025-10-01 10:42:15', 0, NULL, 0, NULL),
(11, 56, 25, 'start aja kalo sudah siap', 10, '2025-10-01 10:43:44', '2025-10-01 10:43:44', 0, NULL, 0, NULL),
(12, 56, 28, 'okokokok', 11, '2025-10-01 10:44:18', '2025-10-01 10:44:18', 0, NULL, 0, NULL),
(13, 55, 28, 'p', 8, '2025-10-01 10:44:39', '2025-10-01 10:44:39', 0, NULL, 0, NULL),
(14, 55, 28, 'p', 13, '2025-10-01 10:44:44', '2025-10-01 10:44:44', 0, NULL, 0, NULL),
(15, 56, 1, 'spiderman', 12, '2025-10-14 03:26:46', '2025-10-14 03:26:46', 0, NULL, 0, NULL),
(16, 56, 1, 'tes', NULL, '2025-10-14 03:47:55', '2025-10-14 03:47:55', 0, NULL, 0, NULL),
(17, 56, 1, 'cil', 12, '2025-10-14 03:55:23', '2025-10-14 03:55:23', 0, NULL, 0, NULL),
(18, 56, 1, 'tes', 17, '2025-10-14 03:55:38', '2025-10-14 03:55:38', 0, NULL, 0, NULL),
(19, 56, 25, 'tes', NULL, '2025-10-22 05:13:46', '2025-10-22 05:13:46', 0, NULL, 0, NULL),
(20, 58, 1, 'ataya', NULL, '2025-10-25 01:01:42', '2025-10-25 01:01:42', 0, NULL, 0, NULL),
(21, 58, 1, 'rehan77', 20, '2025-10-25 01:01:54', '2025-10-25 01:01:54', 0, NULL, 0, NULL),
(22, 60, 29, 'sernonoknye main laga laga😹', NULL, '2025-10-25 01:14:41', '2025-10-25 01:14:41', 0, NULL, 0, NULL),
(23, 60, 29, 'g', NULL, '2025-10-25 01:15:00', '2025-10-25 01:15:00', 0, NULL, 0, NULL),
(24, 60, 29, 'e', NULL, '2025-10-25 01:15:03', '2025-10-25 01:15:03', 0, NULL, 0, NULL),
(25, 60, 29, 'j', NULL, '2025-10-25 01:15:08', '2025-10-25 01:15:08', 0, NULL, 0, NULL),
(26, 60, 29, 'm', NULL, '2025-10-25 01:15:16', '2025-10-25 01:15:16', 0, NULL, 0, NULL),
(27, 60, 29, 'negro', NULL, '2025-10-25 01:18:55', '2025-10-25 01:18:55', 0, NULL, 0, NULL),
(28, 60, 29, 'hitam luwh', NULL, '2025-10-25 01:19:07', '2025-10-25 01:19:07', 0, NULL, 0, NULL),
(29, 60, 29, 'sambo', NULL, '2025-10-25 01:19:22', '2025-10-25 01:19:22', 0, NULL, 0, NULL),
(30, 60, 29, 'telaso', NULL, '2025-10-25 01:19:51', '2025-10-25 01:19:51', 0, NULL, 0, NULL),
(31, 60, 29, 'uygbk6ggggggggggggg6kttttttttttttttttttttttttttttttttttttttttttttt', NULL, '2025-10-25 01:21:08', '2025-10-25 01:21:08', 0, NULL, 0, NULL),
(32, 60, 1, 'tes', NULL, '2025-10-25 05:55:01', '2025-10-25 05:55:01', 0, NULL, 0, NULL),
(33, 60, 1, 'puki', NULL, '2025-10-25 06:05:20', '2025-10-25 06:05:20', 0, NULL, 0, NULL),
(34, 60, 1, 'pepek', NULL, '2025-10-25 06:05:25', '2025-10-25 06:05:25', 0, NULL, 0, NULL),
(35, 60, 1, 'tes', NULL, '2025-10-25 06:13:16', '2025-10-25 06:13:16', 0, NULL, 0, NULL),
(36, 60, 1, 'tes', NULL, '2025-10-25 11:04:03', '2025-10-25 11:04:03', 0, NULL, 0, NULL),
(37, 60, 1, 'tes', NULL, '2025-10-25 11:06:21', '2025-10-25 11:20:19', 1, '2025-10-25 11:20:19', 0, NULL),
(38, 60, 1, 'kenapa di apus woi', 37, '2025-10-25 11:21:37', '2025-10-25 11:21:37', 0, NULL, 0, NULL),
(39, 60, 1, 'halo mas bro ini codenya', NULL, '2025-10-25 11:48:47', '2025-10-25 11:48:47', 0, NULL, 0, NULL),
(40, 60, 1, 'a', NULL, '2025-10-25 11:48:56', '2025-10-25 11:48:56', 0, NULL, 0, NULL),
(41, 60, 1, 'as', NULL, '2025-10-25 11:49:08', '2025-10-25 11:49:08', 0, NULL, 0, NULL),
(42, 60, 1, 'tes', NULL, '2025-10-25 12:37:09', '2025-10-25 12:37:09', 0, NULL, 0, NULL),
(43, 60, 1, 's', NULL, '2025-10-25 12:37:12', '2025-10-25 12:37:12', 0, NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD CONSTRAINT `task_comments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_comments_ibfk_3` FOREIGN KEY (`parent_comment_id`) REFERENCES `task_comments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
