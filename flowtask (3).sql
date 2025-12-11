-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 11, 2025 at 03:53 AM
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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(50) NOT NULL,
  `entity_id` int NOT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-30 10:25:05'),
(2, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-30 10:27:13'),
(3, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-30 10:27:51'),
(4, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-30 10:28:05'),
(5, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-31 02:35:46'),
(6, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-31 11:24:17'),
(7, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-31 14:25:48'),
(8, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-31 14:25:51'),
(9, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-31 14:27:35'),
(10, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-31 14:27:50'),
(11, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-31 14:32:56'),
(12, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-31 14:32:59'),
(13, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 03:17:59'),
(14, 1, 'create_user', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 03:18:26'),
(15, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 03:20:07'),
(16, 17, 'login', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 03:20:12'),
(17, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 03:48:18'),
(18, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 03:48:20'),
(19, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 03:48:27'),
(20, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 04:44:05'),
(21, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 04:44:07'),
(22, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 04:44:28'),
(23, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 05:13:42'),
(24, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 05:13:44'),
(25, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 06:52:13'),
(26, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 08:47:07'),
(27, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 08:47:10'),
(28, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 08:48:08'),
(29, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 08:48:11'),
(30, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 08:48:28'),
(31, 17, 'update_profile', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 08:48:40'),
(32, 17, 'logout', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 11:31:38'),
(33, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 11:33:07'),
(34, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 11:33:23'),
(35, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 11:34:15'),
(36, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 12:38:07'),
(37, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 12:38:09'),
(38, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 13:19:40'),
(39, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 13:25:02'),
(40, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 13:25:06'),
(41, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-01 13:25:09'),
(42, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:31:31'),
(43, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:32:19'),
(44, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:32:34'),
(45, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:32:42'),
(46, 1, 'create_user', 'user', 18, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:35:49'),
(47, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:36:08'),
(48, 18, 'login', 'user', 18, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:36:18'),
(49, 18, 'create_project', 'project', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:42:13'),
(50, 18, 'create_project', 'project', 3, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:43:57'),
(51, 18, 'create_project', 'project', 4, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:44:04'),
(52, 18, 'update_profile', 'user', 18, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 06:48:21'),
(53, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 11:58:57'),
(54, 1, 'update_project', 'project', 4, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 12:21:35'),
(55, 1, 'delete_project', 'project', 4, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 12:24:02'),
(56, 1, 'delete_project', 'project', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 12:24:07'),
(57, 1, 'update_project', 'project', 3, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 12:24:36'),
(58, 1, 'update_project', 'project', 3, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 12:24:45'),
(59, 1, 'update_project', 'project', 3, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 12:34:33'),
(60, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 12:57:55'),
(61, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 13:44:45'),
(62, 1, 'login', 'user', 1, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-05 13:55:27'),
(63, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 02:24:24'),
(64, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:27:46'),
(65, 1, 'create_task', 'task', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:28:33'),
(66, 1, 'create_task', 'task', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:30:23'),
(67, 1, 'delete_task', 'task', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:37:02'),
(68, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 06:53:49'),
(69, 1, 'update_task_status', 'task', 2, '{\"status\": \"done\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:03:15'),
(70, 1, 'update_task', 'task', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:03:43'),
(71, 1, 'update_task_status', 'task', 2, '{\"status\": \"done\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:03:45'),
(72, 1, 'create_user', 'user', 19, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:04:36'),
(73, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:04:39'),
(74, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:05:06'),
(75, 1, 'update_user', 'user', 19, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:05:33'),
(76, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:05:36'),
(77, 19, 'login', 'user', 19, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:05:53'),
(78, 19, 'logout', 'user', 19, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:07:13'),
(79, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:07:21'),
(80, 1, 'update_user', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:07:39'),
(81, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:07:43'),
(82, 17, 'login', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:07:52'),
(83, 17, 'logout', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:08:33'),
(84, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:08:40'),
(85, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:20:00'),
(86, 19, 'login', 'user', 19, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:20:09'),
(87, 19, 'logout', 'user', 19, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:20:32'),
(88, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:20:40'),
(89, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:20:59'),
(90, 17, 'login', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:21:05'),
(91, 17, 'logout', 'user', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:21:22'),
(92, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:21:34'),
(93, 1, 'create_project', 'project', 5, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:22:09'),
(94, 1, 'create_task', 'task', 3, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:22:39'),
(95, 1, 'update_task_status', 'task', 3, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:22:44'),
(96, 1, 'update_task_status', 'task', 3, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:22:52'),
(97, 1, 'create_task', 'task', 4, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:35:06'),
(98, 1, 'update_task_status', 'task', 4, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:35:10'),
(99, 1, 'update_task', 'task', 3, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:35:25'),
(100, 1, 'update_task_status', 'task', 3, '{\"status\": \"done\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-12 07:35:27'),
(101, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-18 11:23:33'),
(102, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-18 11:40:27'),
(103, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-18 11:40:38'),
(104, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-18 11:57:58'),
(105, 1, 'login', 'user', 1, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-20 10:54:51'),
(106, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 11:34:53'),
(107, 1, 'create_user', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 11:35:52'),
(108, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 11:36:12'),
(109, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 11:36:22'),
(110, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 11:38:01'),
(111, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 11:38:23'),
(112, 1, 'create_user', 'user', 26, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 11:39:39'),
(113, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 11:40:05'),
(114, 26, 'login', 'user', 26, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 11:40:16'),
(115, 25, 'login', 'user', 25, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 05:47:08'),
(116, 25, 'update_profile', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:00:17'),
(117, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:28:59'),
(118, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:29:05'),
(119, 1, 'create_user', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:29:24'),
(120, 1, 'create_user', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:29:41'),
(121, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:29:45'),
(122, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:30:10'),
(123, 25, 'create_project', 'project', 16, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:35:18'),
(124, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:53:32'),
(125, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:54:10'),
(126, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 06:54:18'),
(127, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 07:06:15'),
(128, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 07:06:21'),
(129, 25, 'create_task', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:16:38'),
(130, 25, 'update_task', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:17:02'),
(131, 25, 'update_task_status', 'task', 55, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:17:06'),
(132, 25, 'update_task', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:17:56'),
(133, 25, 'update_task', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:18:43'),
(134, 25, 'update_task_status', 'task', 55, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:25:14'),
(135, 25, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:27:46'),
(136, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:33:08'),
(137, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:33:15'),
(138, 28, 'update_task', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:33:28'),
(139, 28, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:33:36'),
(140, 28, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 08:59:53'),
(141, 28, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:03:32'),
(142, 28, 'upload_attachment', 'task', 55, '{\"filename\": \"1759309412_0_WhatsApp_Image_2025-09-30_at_14.03.02_85fcb88c.jpg\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:03:32'),
(143, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:05:17'),
(144, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:10:33'),
(145, 28, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:14:09'),
(146, 28, 'upload_attachment', 'task', 55, '{\"filename\": \"1759310049_0_WhatsApp_Image_2025-09-30_at_12.05.45_9828bb2f.jpg\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:14:09'),
(147, 28, 'update_task_status', 'task', 55, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:18:43'),
(148, 28, 'update_task_status', 'task', 55, '{\"status\": \"done\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:34:54'),
(149, 28, 'update_profile', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:49:01'),
(150, 28, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:53:05'),
(151, 28, 'update_task', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:11:18'),
(152, 28, 'update_task', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:34:06'),
(153, 28, 'update_task', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:34:14'),
(154, 28, 'update_task', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:34:21'),
(155, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:34:43'),
(156, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:34:49'),
(157, 25, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:35:18'),
(158, 25, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:35:41'),
(159, 25, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:35:52'),
(160, 25, 'create_task', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:42:00'),
(161, 25, 'add_comment', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:42:15'),
(162, 25, 'add_comment', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:43:44'),
(163, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:43:52'),
(164, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:43:58'),
(165, 28, 'add_comment', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:44:18'),
(166, 28, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:44:39'),
(167, 28, 'add_comment', 'task', 55, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 10:44:44'),
(168, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-02 08:48:47'),
(169, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-02 08:59:36'),
(170, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-02 09:00:01'),
(171, 25, 'update_profile', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-02 09:29:49'),
(172, 25, 'update_profile', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-02 09:34:02'),
(173, 25, 'update_profile', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-02 09:34:29'),
(174, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 04:22:45'),
(175, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 02:50:45'),
(176, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 09:19:19'),
(177, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 09:43:09'),
(178, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 09:45:02'),
(179, 27, 'login', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 09:45:07'),
(180, 27, 'create_test_case', 'test_case', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 09:45:41'),
(181, 27, 'logout', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 09:52:04'),
(182, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 09:52:14'),
(183, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 09:52:26'),
(184, 27, 'login', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 09:52:32'),
(185, 27, 'update_profile', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 10:22:04'),
(186, 27, 'update_profile', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 10:22:28'),
(187, 1, 'login', 'user', 1, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:18:49'),
(188, 1, 'add_bug_comment', 'bug', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:20:14'),
(189, 1, 'add_bug_comment', 'bug', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:20:21'),
(190, 1, 'add_comment', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:26:46'),
(191, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:36:19'),
(192, 1, 'add_bug_comment', 'bug', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:38:46'),
(193, 1, 'add_bug_comment', 'bug', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:39:21'),
(194, 1, 'upload_bug_attachment', 'bug', 1, '{\"filename\": \"1760413161_0_1756549633_WhatsApp_Image_2025-08-21_at_13.28.45_3b730eec.jpg\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:39:21'),
(195, 1, 'add_comment', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:47:55'),
(196, 1, 'add_bug_comment', 'bug', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:51:24'),
(197, 1, 'upload_bug_attachment', 'bug', 1, '{\"filename\": \"1760413884_0_Nature_s_Essence__A_Minimalist_Ode_to_Beauty.jpg\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:51:24'),
(198, 1, 'add_comment', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:55:23'),
(199, 1, 'upload_attachment', 'task', 56, '{\"filename\": \"1760414123_0_52c64c72294407663e6f654f467bef53.ico\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:55:23'),
(200, 1, 'add_comment', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:55:38'),
(201, 1, 'upload_attachment', 'task', 56, '{\"filename\": \"1760414138_0_Nature_s_Essence__A_Minimalist_Ode_to_Beauty.jpg\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:55:38'),
(202, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 13:08:54'),
(203, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 13:13:20'),
(204, 27, 'login', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 13:13:26'),
(205, 27, 'logout', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 13:15:10'),
(206, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 13:15:24'),
(207, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-16 06:10:25'),
(208, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-16 06:10:41'),
(209, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-16 06:21:14'),
(210, 1, 'update_bug_status', 'bug', 1, '{\"status\": \"assigned\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-16 06:23:33'),
(211, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-16 06:30:24'),
(212, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-16 06:30:33'),
(213, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-16 11:45:31'),
(214, 1, 'login', 'user', 1, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-17 08:24:04'),
(215, 1, 'complete_project', 'project', 16, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-17 08:32:30'),
(216, 1, 'create_task', 'task', 57, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-17 08:33:39'),
(217, 1, 'reopen_project', 'project', 16, '{\"status\": \"completed\"}', '{\"reason\": \"maintenance\", \"status\": \"in_progress\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-17 08:38:22'),
(218, 1, 'reopen_project', 'project', 16, '{\"status\": \"completed\"}', '{\"reason\": \"maintenance\", \"status\": \"in_progress\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-17 08:38:29'),
(219, 1, 'complete_project', 'project', 16, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-17 08:46:34'),
(220, 1, 'update_task', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-17 08:46:48'),
(221, 1, 'update_task', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-17 08:47:01'),
(222, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-19 04:49:55'),
(223, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-19 04:50:10'),
(224, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-19 04:54:53'),
(225, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-19 04:59:27'),
(226, 1, 'create_project', 'project', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-19 05:21:26'),
(227, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-19 06:44:11'),
(228, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-19 07:51:46'),
(229, 27, 'login', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-20 11:52:22'),
(230, 27, 'create_test_case', 'test_case', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-20 12:04:16'),
(231, 27, 'update_profile', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-20 12:15:35'),
(232, 27, 'update_profile', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-20 12:16:38'),
(233, 27, 'update_profile', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-20 12:25:39'),
(234, 27, 'logout', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-20 12:26:20'),
(235, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-20 12:26:27'),
(236, 28, 'update_profile', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-20 12:26:48'),
(237, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-20 12:32:01'),
(238, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-20 12:32:11'),
(239, 1, 'login', 'user', 1, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 02:52:44'),
(240, 1, 'deactivate_user', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 02:54:03'),
(241, 1, 'activate_user', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 02:58:48'),
(242, 1, 'deactivate_user', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 02:58:54'),
(243, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 03:00:34'),
(244, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 03:06:22'),
(245, 1, 'create_task', 'task', 58, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 03:40:26'),
(246, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 07:07:31'),
(247, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 07:46:28'),
(248, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 07:46:31'),
(249, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 07:53:44'),
(250, 27, 'login', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 07:53:50'),
(251, 27, 'run_test_case', 'test_case', 2, NULL, '{\"status\": \"pass\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 08:03:59'),
(252, 27, 'run_test_case', 'test_case', 2, NULL, '{\"status\": \"pass\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-21 08:04:33'),
(253, 1, 'login', 'user', 1, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:33:05'),
(254, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:33:17'),
(255, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:33:22'),
(256, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:33:41');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(257, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:34:03'),
(258, 1, 'activate_user', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:34:19'),
(259, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:34:23'),
(260, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:34:40'),
(261, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:35:30'),
(262, 27, 'login', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:35:36'),
(263, 27, 'logout', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:35:49'),
(264, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 03:35:59'),
(265, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 04:09:49'),
(266, 25, 'update_project', 'project', 16, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 04:17:56'),
(267, 25, 'update_project', 'project', 16, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 04:18:06'),
(268, 25, 'reopen_project', 'project', 16, '{\"status\": \"completed\"}', '{\"reason\": \"maintenance\", \"status\": \"in_progress\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 04:46:28'),
(269, 25, 'report_bug', 'bug', 11, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 05:05:06'),
(270, 25, 'update_bug_status', 'bug', 11, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 05:05:19'),
(271, 25, 'add_comment', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 05:13:46'),
(272, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 05:15:18'),
(273, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 05:15:27'),
(274, 28, 'update_profile', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 05:23:24'),
(275, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 07:23:23'),
(276, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 07:23:28'),
(277, 1, 'create_project', 'project', 18, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 07:25:54'),
(278, 1, 'create_task', 'task', 59, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 07:26:48'),
(279, 1, 'update_task_status', 'task', 59, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 07:26:52'),
(280, 1, 'report_bug', 'bug', 12, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 07:27:26'),
(281, 1, 'delete_project', 'project', 18, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 07:41:07'),
(282, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 08:34:17'),
(283, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 08:34:30'),
(284, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 08:34:37'),
(285, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 08:40:21'),
(286, 1, 'login', 'user', 1, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 08:44:15'),
(287, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 08:47:52'),
(288, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 08:47:57'),
(289, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 08:48:13'),
(290, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:19:00'),
(291, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:19:06'),
(292, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:35:42'),
(293, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:35:48'),
(294, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:35:51'),
(295, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:36:03'),
(296, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:50:27'),
(297, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:50:46'),
(298, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:50:48'),
(299, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:50:53'),
(300, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:51:00'),
(301, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:52:06'),
(302, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:52:13'),
(303, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-22 09:52:20'),
(304, 25, 'login', 'user', 25, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 07:22:26'),
(305, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 07:28:03'),
(306, 27, 'login', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 07:28:09'),
(307, 27, 'logout', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 08:18:17'),
(308, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 08:18:22'),
(309, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 08:18:31'),
(310, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 11:18:36'),
(311, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 11:23:25'),
(312, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 11:23:33'),
(313, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 11:25:45'),
(314, 27, 'login', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 11:30:14'),
(315, 27, 'logout', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 11:43:24'),
(316, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 11:43:28'),
(317, 1, 'update_test_case', 'test_case', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 12:01:55'),
(318, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 12:59:28'),
(319, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 12:59:34'),
(320, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 13:06:17'),
(321, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-23 13:06:21'),
(322, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:01:25'),
(323, 1, 'add_comment', 'task', 58, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:01:42'),
(324, 1, 'add_comment', 'task', 58, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:01:54'),
(325, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:03:09'),
(326, 1, 'create_user', 'user', 29, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:07:59'),
(327, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:08:04'),
(328, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:08:58'),
(329, 1, 'update_user', 'user', 29, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:09:24'),
(330, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:09:29'),
(331, 29, 'login', 'user', 29, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:09:40'),
(332, 29, 'update_profile', 'user', 29, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:10:08'),
(333, 29, 'update_profile', 'user', 29, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:11:02'),
(334, 29, 'create_project', 'project', 19, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:12:45'),
(335, 29, 'create_task', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:13:44'),
(336, 29, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:14:41'),
(337, 29, 'upload_attachment', 'task', 60, '{\"filename\": \"1761354881_0_Screenshot_2025-10-25_080623.png\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:14:41'),
(338, 29, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:15:00'),
(339, 29, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:15:03'),
(340, 29, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:15:08'),
(341, 29, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:15:16'),
(342, 29, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:18:55'),
(343, 29, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:19:07'),
(344, 29, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:19:22'),
(345, 29, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:19:51'),
(346, 29, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 01:21:08'),
(347, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 05:50:19'),
(348, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 05:55:01'),
(349, 1, 'add_bug_comment', 'bug', 11, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 05:55:13'),
(350, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 06:05:20'),
(351, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 06:05:25'),
(352, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 06:13:16'),
(353, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 06:14:25'),
(354, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 06:14:30'),
(355, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 07:52:19'),
(356, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 10:54:53'),
(357, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 11:04:03'),
(358, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 11:06:21'),
(359, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Trae/1.100.3 Chrome/132.0.6834.210 Electron/34.5.1 Safari/537.36', '2025-10-25 11:17:33'),
(360, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 11:21:37'),
(361, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 11:48:47'),
(362, 1, 'upload_attachment', 'task', 60, '{\"filename\": \"1761392927_0_Screenshot_2025-03-07_151045.png\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 11:48:47'),
(363, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 11:48:56'),
(364, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 11:49:08'),
(365, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 12:37:09'),
(366, 1, 'upload_attachment', 'task', 60, '{\"filename\": \"1761395829_0_Screenshot_2025-03-02_113430.png\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 12:37:09'),
(367, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 12:37:12'),
(368, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 13:42:22'),
(369, 1, 'create_task', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:20:13'),
(370, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:20:35'),
(371, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:31:41'),
(372, 1, 'upload_attachment', 'task', 61, '{\"filename\": \"1761402701_0_Screenshot_2025-03-07_151045.png\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:31:41'),
(373, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:31:48'),
(374, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:31:50'),
(375, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:34:52'),
(376, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:35:01'),
(377, 1, 'upload_attachment', 'task', 61, '{\"filename\": \"1761402901_0_Screenshot_2025-03-02_113430.png\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:35:01'),
(378, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:35:07'),
(379, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:35:21'),
(380, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:42:26'),
(381, 1, 'upload_attachment', 'task', 61, '{\"filename\": \"1761403346_0_Screenshot_2025-03-01_113413.png\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:42:26'),
(382, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:43:14'),
(383, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:43:25'),
(384, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:45:50'),
(385, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:45:59'),
(386, 1, 'upload_attachment', 'task', 61, '{\"filename\": \"1761403559_0_Cuplikan_layar_2025-02-26_052527.png\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:45:59'),
(387, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:46:06'),
(388, 1, 'add_bug_comment', 'bug', 11, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:49:49'),
(389, 1, 'add_bug_comment', 'bug', 11, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:49:53'),
(390, 1, 'upload_bug_attachment', 'bug', 11, '{\"filename\": \"1761403793_0_Screenshot_2025-03-02_113430.png\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:49:53'),
(391, 1, 'add_bug_comment', 'bug', 11, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:49:54'),
(392, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 14:58:57'),
(393, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 15:02:02'),
(394, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 15:02:08'),
(395, 1, 'upload_attachment', 'task', 61, '{\"filename\": \"1761404528_0_Screenshot_2025-03-06_143940.png\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 15:02:08'),
(396, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-25 15:02:14'),
(397, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 02:06:01'),
(398, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 03:46:18'),
(399, 1, 'delete_comment', 'task', 61, '{\"comment_id\": \"62\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 04:04:54'),
(400, 1, 'delete_comment', 'task', 60, '{\"comment_id\": \"25\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 04:15:50'),
(401, 1, 'delete_bug_comment', 'bug', 11, '{\"comment_id\": \"6\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 04:16:13'),
(402, 1, 'restore_bug_comment', 'bug', 11, '{\"comment_id\": \"6\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 04:24:57'),
(403, 1, 'delete_bug_comment', 'bug', 11, '{\"comment_id\": \"8\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 04:25:03'),
(404, 1, 'restore_bug_comment', 'bug', 11, '{\"comment_id\": \"8\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 04:25:11'),
(405, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 04:39:07'),
(406, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 04:40:48'),
(407, 1, 'edit_bug_comment', 'bug', 11, '{\"comment_id\": \"9\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 06:35:50'),
(408, 1, 'add_comment', 'task', 60, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 06:36:18'),
(409, 1, 'edit_task_comment', 'task', 60, '{\"comment_id\": \"63\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 08:24:19'),
(410, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 14:15:17'),
(411, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 15:02:56'),
(412, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 15:03:05'),
(413, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 15:03:09'),
(414, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 15:08:29'),
(415, 1, 'update_profile', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 15:08:32'),
(416, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 06:41:52'),
(417, 1, 'update_test_case', 'test_case', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 06:56:42'),
(418, 1, 'update_test_case', 'test_case', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 06:56:53'),
(419, 1, 'create_test_suite', 'test_suite', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 07:20:16'),
(420, 1, 'run_test_suite', 'test_suite', 2, NULL, '{\"total\": 2, \"failed\": 1, \"passed\": 1, \"blocked\": 0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 08:03:01'),
(421, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 11:26:35'),
(422, 1, 'update_test_suite', 'test_suite', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 11:30:52'),
(423, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 12:24:27'),
(424, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 12:24:36'),
(425, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 12:35:38'),
(426, 27, 'login', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 12:35:47'),
(427, 27, 'logout', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 12:38:09'),
(428, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 12:38:12'),
(429, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 12:47:27'),
(430, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 06:13:33'),
(431, 1, 'restore_comment', 'task', 60, '{\"comment_id\": \"25\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 07:02:05'),
(432, 1, 'delete_bug_comment', 'bug', 1, '{\"comment_id\": \"4\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 07:02:20'),
(433, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 07:06:41'),
(434, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 07:06:53'),
(435, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 07:11:31'),
(436, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 07:11:39'),
(437, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 07:11:43'),
(438, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 07:11:48'),
(439, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 07:13:25'),
(440, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 07:13:39'),
(441, 25, 'create_test_suite', 'test_suite', 3, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 08:11:39'),
(442, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 08:32:37'),
(443, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 08:32:44'),
(444, 28, 'update_task', 'task', 56, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 08:46:41'),
(445, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 08:47:56'),
(446, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 08:48:06'),
(447, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 08:48:14'),
(448, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 08:48:26'),
(449, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 09:02:46'),
(450, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 09:02:51'),
(451, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 10:01:28'),
(452, 1, 'update_bug', 'bug', 11, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 11:42:44'),
(453, 1, 'update_bug', 'bug', 11, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 11:42:58'),
(454, 1, 'report_bug', 'bug', 13, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 12:00:36'),
(455, 1, 'update_bug_status', 'bug', 13, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 12:12:29'),
(456, 1, 'update_bug_status', 'bug', 13, '{\"status\": \"resolved\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 12:12:31'),
(457, 1, 'update_bug_status', 'bug', 11, '{\"status\": \"resolved\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 12:12:57'),
(458, 1, 'update_bug_status', 'bug', 1, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 12:17:10'),
(459, 1, 'update_bug_status', 'bug', 1, '{\"status\": \"resolved\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 12:17:13'),
(460, 1, 'report_bug', 'bug', 14, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 12:34:36'),
(461, 1, 'update_bug_status', 'bug', 14, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 12:34:41'),
(462, 1, 'update_bug_status', 'bug', 14, '{\"status\": \"resolved\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 12:34:44'),
(463, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 14:39:00'),
(464, 1, 'report_bug', 'bug', 15, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 14:50:55'),
(465, 1, 'update_bug', 'bug', 15, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 15:01:16'),
(466, 1, 'update_bug', 'bug', 15, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 15:01:32'),
(467, 1, 'update_bug', 'bug', 15, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 15:03:35'),
(468, 1, 'update_bug', 'bug', 15, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 15:12:15'),
(469, 1, 'update_bug', 'bug', 15, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 15:12:25'),
(470, 1, 'upload_bug_attachment', 'bug', 15, '{\"filename\": \"1761837767_0_WhatsApp_Image_2025-10-29_at_13.54.12_fa4e7fb1.jpg\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 15:22:47'),
(471, 1, 'update_bug', 'bug', 15, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 15:22:47'),
(472, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-31 03:17:34'),
(473, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-31 03:29:50'),
(474, 27, 'login', 'user', 27, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-31 03:29:58'),
(475, 27, 'upload_bug_attachment', 'bug', 11, '{\"filename\": \"1761881442_0_USECASE_ASLI_JURNAL.drawio__4_.png\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-31 03:30:42'),
(476, 27, 'update_bug', 'bug', 11, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-31 03:30:42'),
(477, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-01 01:26:14'),
(478, 1, 'add_comment', 'task', 61, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-01 01:26:47'),
(479, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-15 04:19:43'),
(480, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 00:20:52'),
(481, 1, 'delete_user', 'user', 29, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 00:30:14'),
(482, 1, 'delete_user', 'user', 29, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 00:30:19'),
(483, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 00:40:35'),
(484, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 01:40:54'),
(485, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 01:41:04'),
(486, 28, 'login', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 01:41:13'),
(487, 28, 'logout', 'user', 28, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 01:43:12'),
(488, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/17.5 Mobile/15A5370a Safari/602.1', '2025-11-29 01:43:31'),
(489, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 06:45:06'),
(490, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 06:46:12'),
(491, 25, 'create_project', 'project', 20, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 06:47:51'),
(492, 25, 'create_task', 'task', 62, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 06:49:24'),
(493, 25, 'update_task_status', 'task', 62, '{\"status\": \"in_progress\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 06:49:33'),
(494, 25, 'add_comment', 'task', 62, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 06:49:42'),
(495, 25, 'update_task_status', 'task', 62, '{\"status\": \"done\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 06:49:52'),
(496, 25, 'report_bug', 'bug', 16, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 06:51:25'),
(497, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-30 02:04:20'),
(498, 1, 'create_project', 'project', 21, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-30 02:05:26'),
(499, 1, 'create_task', 'task', 63, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-30 02:06:12'),
(500, 1, 'add_comment', 'task', 63, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-30 02:06:22'),
(501, 1, 'report_bug', 'bug', 17, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-30 02:07:27'),
(502, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-30 02:08:07'),
(503, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-01 11:38:27'),
(504, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-01 12:03:04'),
(505, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:48:49'),
(506, 1, 'logout', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:49:12'),
(507, 25, 'login', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:49:34'),
(508, 25, 'logout', 'user', 25, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:55:13'),
(509, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 02:12:44'),
(510, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:56:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(511, 1, 'update_user', 'user', 18, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:39:40'),
(512, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-05 01:12:47'),
(513, 1, 'login', 'user', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-05 03:29:26');

-- --------------------------------------------------------

--
-- Table structure for table `bugs`
--

CREATE TABLE `bugs` (
  `id` int NOT NULL,
  `project_id` int NOT NULL,
  `task_id` int DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `steps_to_reproduce` text,
  `expected_result` text,
  `actual_result` text,
  `category_id` int DEFAULT NULL,
  `severity` enum('critical','major','minor','trivial') NOT NULL DEFAULT 'minor',
  `priority` enum('urgent','high','medium','low') NOT NULL DEFAULT 'medium',
  `due_date` date DEFAULT NULL,
  `status` enum('new','assigned','in_progress','resolved','closed','rejected') NOT NULL DEFAULT 'new',
  `reported_by` int NOT NULL,
  `assigned_to` int DEFAULT NULL,
  `resolved_by` int DEFAULT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `os` varchar(100) DEFAULT NULL,
  `device` varchar(100) DEFAULT NULL,
  `environment` enum('development','staging','production') DEFAULT 'development',
  `resolution` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bugs`
--

INSERT INTO `bugs` (`id`, `project_id`, `task_id`, `title`, `description`, `steps_to_reproduce`, `expected_result`, `actual_result`, `category_id`, `severity`, `priority`, `due_date`, `status`, `reported_by`, `assigned_to`, `resolved_by`, `browser`, `os`, `device`, `environment`, `resolution`, `created_at`, `updated_at`, `resolved_at`, `tags`) VALUES
(1, 6, 14, 'Seed Bug for Seed Project 1', 'Autogenerated bug for demo data', NULL, NULL, NULL, 1, 'minor', 'medium', NULL, 'resolved', 1, 17, NULL, NULL, NULL, NULL, 'development', NULL, '2025-09-18 11:48:50', '2025-10-30 12:17:13', NULL, NULL),
(2, 7, 13, 'Seed Bug for Seed Project 2', 'Autogenerated bug for demo data', NULL, NULL, NULL, 1, 'minor', 'medium', NULL, 'new', 1, 17, NULL, NULL, NULL, NULL, 'development', NULL, '2025-09-18 11:48:50', '2025-09-18 11:48:50', NULL, NULL),
(3, 8, 12, 'Seed Bug for Seed Project 3', 'Autogenerated bug for demo data', NULL, NULL, NULL, 1, 'minor', 'medium', NULL, 'new', 1, 17, NULL, NULL, NULL, NULL, 'development', NULL, '2025-09-18 11:48:50', '2025-09-18 11:48:50', NULL, NULL),
(4, 9, 11, 'Seed Bug for Seed Project 4', 'Autogenerated bug for demo data', NULL, NULL, NULL, 1, 'minor', 'medium', NULL, 'new', 1, 17, NULL, NULL, NULL, NULL, 'development', NULL, '2025-09-18 11:48:50', '2025-09-18 11:48:50', NULL, NULL),
(5, 10, 10, 'Seed Bug for Seed Project 5', 'Autogenerated bug for demo data', NULL, NULL, NULL, 1, 'minor', 'medium', NULL, 'new', 1, 17, NULL, NULL, NULL, NULL, 'development', NULL, '2025-09-18 11:48:50', '2025-09-18 11:48:50', NULL, NULL),
(6, 11, 9, 'Seed Bug for Seed Project 6', 'Autogenerated bug for demo data', NULL, NULL, NULL, 1, 'minor', 'medium', NULL, 'new', 1, 17, NULL, NULL, NULL, NULL, 'development', NULL, '2025-09-18 11:48:50', '2025-09-18 11:48:50', NULL, NULL),
(7, 12, 8, 'Seed Bug for Seed Project 7', 'Autogenerated bug for demo data', NULL, NULL, NULL, 1, 'minor', 'medium', NULL, 'new', 1, 17, NULL, NULL, NULL, NULL, 'development', NULL, '2025-09-18 11:48:50', '2025-09-18 11:48:50', NULL, NULL),
(8, 13, 7, 'Seed Bug for Seed Project 8', 'Autogenerated bug for demo data', NULL, NULL, NULL, 1, 'minor', 'medium', NULL, 'new', 1, 17, NULL, NULL, NULL, NULL, 'development', NULL, '2025-09-18 11:48:50', '2025-09-18 11:48:50', NULL, NULL),
(9, 14, 6, 'Seed Bug for Seed Project 9', 'Autogenerated bug for demo data', NULL, NULL, NULL, 1, 'minor', 'medium', NULL, 'new', 1, 17, NULL, NULL, NULL, NULL, 'development', NULL, '2025-09-18 11:48:50', '2025-09-18 11:48:50', NULL, NULL),
(10, 15, 5, 'Seed Bug for Seed Project 10', 'Autogenerated bug for demo data', NULL, NULL, NULL, 1, 'minor', 'medium', NULL, 'new', 1, 17, NULL, NULL, NULL, NULL, 'development', NULL, '2025-09-18 11:48:50', '2025-09-18 11:48:50', NULL, NULL),
(11, 16, NULL, 'tes', 'tes', 'tes', 'tes', 'tes', 4, 'critical', 'urgent', '2025-11-01', 'resolved', 25, 28, NULL, 'tes', 'tes', NULL, 'production', NULL, '2025-10-22 05:05:06', '2025-10-31 03:30:42', NULL, ''),
(13, 5, NULL, 'tes gambar', 'tes gambar', 'tes gambar', 'tes gambar', 'tes gambar', 2, 'minor', 'medium', NULL, 'resolved', 1, 28, NULL, 'tes gambar', 'tes gambar', NULL, 'development', NULL, '2025-10-30 12:00:36', '2025-10-30 12:12:31', NULL, NULL),
(14, 5, NULL, 'tes', 'tes', 'tes', 'tes', 'tes', 3, 'major', 'medium', NULL, 'resolved', 1, 28, 1, 'tes', 'tes', NULL, 'development', NULL, '2025-10-30 12:34:36', '2025-10-30 12:34:44', NULL, NULL),
(15, 5, NULL, 'GAMBAR', 'GAMBAR', 'GAMBAR', 'GAMBAR', 'GAMBAR', 2, 'critical', 'high', '2025-11-02', 'assigned', 1, 28, NULL, 'GAMBAR', 'GAMBAR', NULL, 'development', NULL, '2025-10-30 14:50:55', '2025-10-30 15:01:16', NULL, NULL),
(16, 20, NULL, 'bug di login', 'bug di login', '1.login\r\n2.terjadi error', 'bisa login', 'error', 2, 'critical', 'high', NULL, 'assigned', 25, 28, NULL, 'chrome', 'windows 11', NULL, 'development', NULL, '2025-11-29 06:51:25', '2025-11-29 06:51:25', NULL, NULL),
(17, 21, NULL, 'bug saat login', 'bug saat login', '1.ketika ketik username dan password\r\n2. dan klik login gak bisa', 'bisa login', 'gak bisa login', 2, 'trivial', 'high', NULL, 'assigned', 1, 28, NULL, 'chrome', 'windows 10', NULL, 'development', NULL, '2025-11-30 02:07:27', '2025-11-30 02:07:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bug_attachments`
--

CREATE TABLE `bug_attachments` (
  `id` int NOT NULL,
  `bug_id` int NOT NULL,
  `comment_id` int DEFAULT NULL,
  `uploaded_by` int NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bug_attachments`
--

INSERT INTO `bug_attachments` (`id`, `bug_id`, `comment_id`, `uploaded_by`, `file_name`, `file_path`, `file_size`, `file_type`, `uploaded_at`) VALUES
(1, 1, NULL, 1, '1760413161_0_1756549633_WhatsApp_Image_2025-08-21_at_13.28.45_3b730eec.jpg', 'uploads/bugs/1760413161_0_1756549633_WhatsApp_Image_2025-08-21_at_13.28.45_3b730eec.jpg', 52004, 'image/jpeg', '2025-10-14 03:39:21'),
(2, 1, NULL, 1, '1760413884_0_Nature_s_Essence__A_Minimalist_Ode_to_Beauty.jpg', 'uploads/bugs/1760413884_0_Nature_s_Essence__A_Minimalist_Ode_to_Beauty.jpg', 39169, 'image/jpeg', '2025-10-14 03:51:24'),
(5, 11, 8, 1, '1761403793_0_Screenshot_2025-03-02_113430.png', 'uploads/bugs/1761403793_0_Screenshot_2025-03-02_113430.png', 22781, 'image/png', '2025-10-25 14:49:53'),
(6, 13, NULL, 1, '1761825636_0_978-1-4842-5540-7_CoverFigure.jpg', 'uploads/bugs/1761825636_0_978-1-4842-5540-7_CoverFigure.jpg', 366209, 'image/jpeg', '2025-10-30 12:00:36'),
(7, 14, NULL, 1, '1761827676_0_WhatsApp_Image_2025-10-29_at_13.54.12_fa4e7fb1.jpg', 'uploads/bugs/1761827676_0_WhatsApp_Image_2025-10-29_at_13.54.12_fa4e7fb1.jpg', 41719, 'image/jpeg', '2025-10-30 12:34:36'),
(9, 15, NULL, 1, '1761837767_0_WhatsApp_Image_2025-10-29_at_13.54.12_fa4e7fb1.jpg', 'uploads/bugs/1761837767_0_WhatsApp_Image_2025-10-29_at_13.54.12_fa4e7fb1.jpg', 41719, 'image/jpeg', '2025-10-30 15:22:47'),
(10, 11, NULL, 27, '1761881442_0_USECASE_ASLI_JURNAL.drawio__4_.png', 'uploads/bugs/1761881442_0_USECASE_ASLI_JURNAL.drawio__4_.png', 34809, 'image/png', '2025-10-31 03:30:42'),
(11, 16, NULL, 25, '1764399085_0_Cuplikan_layar_2025-02-26_052527.png', 'uploads/bugs/1764399085_0_Cuplikan_layar_2025-02-26_052527.png', 92053, 'image/png', '2025-11-29 06:51:25'),
(12, 17, NULL, 1, '1764468447_0_Cuplikan_layar_2025-02-26_052527.png', 'uploads/bugs/1764468447_0_Cuplikan_layar_2025-02-26_052527.png', 92053, 'image/png', '2025-11-30 02:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `bug_categories`
--

CREATE TABLE `bug_categories` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `color` varchar(7) DEFAULT '#6c757d',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bug_categories`
--

INSERT INTO `bug_categories` (`id`, `name`, `description`, `color`, `created_at`) VALUES
(1, 'UI', 'User Interface related bugs', '#007bff', '2025-08-30 10:01:13'),
(2, 'Backend', 'Server-side and API related bugs', '#28a745', '2025-08-30 10:01:13'),
(3, 'Database', 'Database and data integrity issues', '#ffc107', '2025-08-30 10:01:13'),
(4, 'Performance', 'Performance and optimization issues', '#fd7e14', '2025-08-30 10:01:13'),
(5, 'Security', 'Security vulnerabilities and issues', '#dc3545', '2025-08-30 10:01:13'),
(6, 'Integration', 'Third-party integration issues', '#6f42c1', '2025-08-30 10:01:13'),
(7, 'Compatibility', 'Browser/Device compatibility issues', '#17a2b8', '2025-08-30 10:01:13');

-- --------------------------------------------------------

--
-- Table structure for table `bug_comments`
--

CREATE TABLE `bug_comments` (
  `id` int NOT NULL,
  `bug_id` int NOT NULL,
  `user_id` int NOT NULL,
  `edited_by` int DEFAULT NULL,
  `comment` text NOT NULL,
  `original_comment` text,
  `parent_comment_id` int DEFAULT NULL,
  `is_internal` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `is_edited` tinyint(1) DEFAULT '0',
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bug_comments`
--

INSERT INTO `bug_comments` (`id`, `bug_id`, `user_id`, `edited_by`, `comment`, `original_comment`, `parent_comment_id`, `is_internal`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`, `deleted_by`, `is_edited`, `edited_at`) VALUES
(4, 1, 1, NULL, 'Testing file upload feature', NULL, NULL, 0, '2025-10-14 03:39:21', '2025-10-30 07:02:20', 1, '2025-10-30 07:02:20', 1, 0, NULL),
(6, 11, 1, NULL, 'tes', NULL, NULL, 0, '2025-10-25 05:55:13', '2025-10-26 04:24:57', 0, NULL, NULL, 0, NULL),
(7, 11, 1, NULL, 'tes', NULL, NULL, 0, '2025-10-25 14:49:49', '2025-10-25 14:49:49', 0, NULL, NULL, 0, NULL),
(8, 11, 1, NULL, 'tes', NULL, NULL, 0, '2025-10-25 14:49:53', '2025-10-26 04:25:11', 0, NULL, NULL, 0, NULL),
(9, 11, 1, 1, 'mantap', 's', NULL, 0, '2025-10-25 14:49:54', '2025-10-26 06:35:50', 0, NULL, NULL, 1, '2025-10-26 06:35:50');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `company_name`, `contact_person`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'ABC Corporation', 'Robert Johnson', 'robert@abc-corp.com', '+1234567890', '123 Business Street, City, State', '2025-08-30 10:19:37', '2025-08-30 10:19:37'),
(2, 'XYZ Technologies', 'Lisa Brown', 'lisa@xyz-tech.com', '+1234567891', '456 Tech Avenue, City, State', '2025-08-30 10:19:37', '2025-08-30 10:19:37'),
(3, 'Global Solutions', 'David Miller', 'david@globalsolutions.com', '+1234567892', '789 Solution Drive, City, State', '2025-08-30 10:19:37', '2025-08-30 10:19:37'),
(4, 'Seed Corp A', 'Alice Seed', 'alice@seed-a.com', '+628111111111', 'Jl. Seed A No.1, Jakarta', '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(5, 'Seed Corp B', 'Bob Seed', 'bob@seed-b.com', '+628122222222', 'Jl. Seed B No.2, Jakarta', '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(6, 'Seed Corp C', 'Cindy Seed', 'cindy@seed-c.com', '+628133333333', 'Jl. Seed C No.3, Jakarta', '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(7, 'Seed Corp D', 'Doni Seed', 'doni@seed-d.com', '+628144444444', 'Jl. Seed D No.4, Jakarta', '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(8, 'pt kapal api', 'pt kapal api', 'ptkapalapi@example.com', NULL, NULL, '2025-10-01 06:30:54', '2025-10-01 06:30:54'),
(9, 'tes', 'tes', 'tes@example.com', NULL, NULL, '2025-10-19 05:21:26', '2025-10-19 05:21:26'),
(10, 'tes delete', 'tes delete', 'tesdelete@example.com', NULL, NULL, '2025-10-22 07:25:54', '2025-10-22 07:25:54');

-- --------------------------------------------------------

--
-- Table structure for table `mentions`
--

CREATE TABLE `mentions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `mentioned_by` int NOT NULL,
  `entity_type` enum('task_comment','bug_comment') NOT NULL,
  `entity_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `type` enum('task','bug','comment','mention','project','system') NOT NULL,
  `reference_id` int DEFAULT NULL,
  `reference_type` enum('task','bug','project','comment') DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `client_id` int DEFAULT NULL,
  `project_manager_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('planning','in_progress','on_hold','completed','cancelled') NOT NULL DEFAULT 'planning',
  `priority` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
  `budget` decimal(15,2) DEFAULT NULL,
  `progress` decimal(5,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `client_id`, `project_manager_id`, `start_date`, `end_date`, `status`, `priority`, `budget`, `progress`, `created_at`, `updated_at`) VALUES
(3, 'website gamings', 'website gaming', NULL, 18, '2025-09-05', '2025-09-06', 'in_progress', 'critical', 3000000000.00, 50.00, '2025-09-05 06:43:57', '2025-10-21 03:40:26'),
(5, 'website umkm', 'tes', NULL, 18, '2025-09-12', '2025-09-13', 'planning', 'medium', NULL, 33.33, '2025-09-12 07:22:09', '2025-10-17 08:33:39'),
(6, 'Seed Project 1', 'Seeded project for testing 1', 1, 18, '2025-08-19', '2025-11-17', 'in_progress', 'high', 150000000.00, 25.00, '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(7, 'Seed Project 2', 'Seeded project for testing 2', 1, 18, '2025-08-19', '2025-11-17', 'in_progress', 'high', 150000000.00, 16.67, '2025-09-18 11:48:50', '2025-10-25 14:20:13'),
(8, 'Seed Project 3', 'Seeded project for testing 3', 1, 18, '2025-08-19', '2025-11-17', 'in_progress', 'high', 150000000.00, 25.00, '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(9, 'Seed Project 4', 'Seeded project for testing 4', 1, 18, '2025-08-19', '2025-11-17', 'in_progress', 'high', 150000000.00, 25.00, '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(10, 'Seed Project 5', 'Seeded project for testing 5', 1, 18, '2025-08-19', '2025-11-17', 'in_progress', 'high', 150000000.00, 25.00, '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(11, 'Seed Project 6', 'Seeded project for testing 6', 1, 18, '2025-08-19', '2025-11-17', 'in_progress', 'high', 150000000.00, 25.00, '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(12, 'Seed Project 7', 'Seeded project for testing 7', 1, 18, '2025-08-19', '2025-11-17', 'in_progress', 'high', 150000000.00, 25.00, '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(13, 'Seed Project 8', 'Seeded project for testing 8', 1, 18, '2025-08-19', '2025-11-17', 'in_progress', 'high', 150000000.00, 25.00, '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(14, 'Seed Project 9', 'Seeded project for testing 9', 1, 18, '2025-08-19', '2025-11-17', 'in_progress', 'high', 150000000.00, 25.00, '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(15, 'Seed Project 10', 'Seeded project for testing 10', 1, 18, '2025-08-19', '2025-11-17', 'in_progress', 'high', 150000000.00, 25.00, '2025-09-18 11:48:50', '2025-09-18 11:48:50'),
(16, 'website umkm', 'yaaa okelah', 8, 25, '2025-10-01', '2025-10-29', 'in_progress', 'medium', NULL, 100.00, '2025-10-01 06:35:18', '2025-10-30 08:46:41'),
(17, 'Mochammad Rasya', 'tes', 9, 1, '2025-10-23', '2025-10-08', 'planning', 'medium', NULL, 0.00, '2025-10-19 05:21:26', '2025-10-19 05:21:26'),
(19, 'rayhan yamaha', 'motor sangar', 8, 29, '2025-10-25', '2025-10-26', 'planning', 'medium', NULL, 0.00, '2025-10-25 01:12:44', '2025-10-25 01:12:44'),
(20, 'membuat website', 'membuat website menggunakan php', 8, 25, '2025-11-29', '2025-11-30', 'planning', 'medium', NULL, 0.00, '2025-11-29 06:47:51', '2025-11-29 06:47:51'),
(21, 'membuat website keren', 'membuat website keren', 8, 1, '2025-11-30', '2025-11-30', 'planning', 'medium', NULL, 0.00, '2025-11-30 02:05:26', '2025-11-30 02:05:26');

-- --------------------------------------------------------

--
-- Table structure for table `project_milestones`
--

CREATE TABLE `project_milestones` (
  `id` int NOT NULL,
  `project_id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `due_date` date NOT NULL,
  `status` enum('pending','completed','overdue') DEFAULT 'pending',
  `completion_percentage` decimal(5,2) DEFAULT '0.00',
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_teams`
--

CREATE TABLE `project_teams` (
  `id` int NOT NULL,
  `project_id` int NOT NULL,
  `user_id` int NOT NULL,
  `role_in_project` enum('project_manager','developer','qa_tester','designer','analyst') NOT NULL,
  `assigned_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project_teams`
--

INSERT INTO `project_teams` (`id`, `project_id`, `user_id`, `role_in_project`, `assigned_at`) VALUES
(1, 6, 18, 'project_manager', '2025-09-18 11:48:50'),
(2, 7, 18, 'project_manager', '2025-09-18 11:48:50'),
(3, 8, 18, 'project_manager', '2025-09-18 11:48:50'),
(4, 9, 18, 'project_manager', '2025-09-18 11:48:50'),
(5, 10, 18, 'project_manager', '2025-09-18 11:48:50'),
(6, 11, 18, 'project_manager', '2025-09-18 11:48:50'),
(7, 12, 18, 'project_manager', '2025-09-18 11:48:50'),
(8, 13, 18, 'project_manager', '2025-09-18 11:48:50'),
(9, 14, 18, 'project_manager', '2025-09-18 11:48:50'),
(10, 15, 18, 'project_manager', '2025-09-18 11:48:50'),
(16, 15, 17, 'developer', '2025-09-18 11:48:50'),
(17, 14, 17, 'developer', '2025-09-18 11:48:50'),
(18, 13, 17, 'developer', '2025-09-18 11:48:50'),
(19, 12, 17, 'developer', '2025-09-18 11:48:50'),
(20, 11, 17, 'developer', '2025-09-18 11:48:50'),
(21, 10, 17, 'developer', '2025-09-18 11:48:50'),
(22, 9, 17, 'developer', '2025-09-18 11:48:50'),
(23, 8, 17, 'developer', '2025-09-18 11:48:50'),
(24, 7, 17, 'developer', '2025-09-18 11:48:50'),
(25, 6, 17, 'developer', '2025-09-18 11:48:50'),
(26, 15, 21, 'developer', '2025-09-18 11:48:50'),
(27, 14, 21, 'developer', '2025-09-18 11:48:50'),
(28, 13, 21, 'developer', '2025-09-18 11:48:50'),
(29, 12, 21, 'developer', '2025-09-18 11:48:50'),
(30, 11, 21, 'developer', '2025-09-18 11:48:50'),
(31, 10, 21, 'developer', '2025-09-18 11:48:50'),
(32, 9, 21, 'developer', '2025-09-18 11:48:50'),
(33, 8, 21, 'developer', '2025-09-18 11:48:50'),
(34, 7, 21, 'developer', '2025-09-18 11:48:50'),
(35, 6, 21, 'developer', '2025-09-18 11:48:50'),
(47, 6, 19, 'qa_tester', '2025-09-18 11:48:50'),
(48, 7, 19, 'qa_tester', '2025-09-18 11:48:50'),
(49, 8, 19, 'qa_tester', '2025-09-18 11:48:50'),
(50, 9, 19, 'qa_tester', '2025-09-18 11:48:50'),
(51, 10, 19, 'qa_tester', '2025-09-18 11:48:50'),
(52, 11, 19, 'qa_tester', '2025-09-18 11:48:50'),
(53, 12, 19, 'qa_tester', '2025-09-18 11:48:50'),
(54, 13, 19, 'qa_tester', '2025-09-18 11:48:50'),
(55, 14, 19, 'qa_tester', '2025-09-18 11:48:50'),
(56, 15, 19, 'qa_tester', '2025-09-18 11:48:50'),
(60, 17, 1, 'project_manager', '2025-10-19 05:21:26'),
(61, 17, 17, 'developer', '2025-10-19 05:21:26'),
(65, 16, 28, 'developer', '2025-10-22 04:18:06'),
(66, 16, 25, 'project_manager', '2025-10-22 04:18:06'),
(67, 16, 27, 'qa_tester', '2025-10-22 04:18:06'),
(71, 19, 29, 'project_manager', '2025-10-25 01:12:44'),
(72, 19, 28, 'developer', '2025-10-25 01:12:44'),
(73, 19, 27, 'qa_tester', '2025-10-25 01:12:45'),
(74, 20, 25, 'project_manager', '2025-11-29 06:47:51'),
(75, 20, 28, 'developer', '2025-11-29 06:47:51'),
(76, 20, 19, 'qa_tester', '2025-11-29 06:47:51'),
(77, 20, 17, 'developer', '2025-11-29 06:47:51'),
(78, 21, 1, 'project_manager', '2025-11-30 02:05:26'),
(79, 21, 17, 'developer', '2025-11-30 02:05:26'),
(80, 21, 28, 'developer', '2025-11-30 02:05:26'),
(81, 21, 23, 'qa_tester', '2025-11-30 02:05:26');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `is_global` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `setting_key`, `setting_value`, `is_global`, `created_at`, `updated_at`) VALUES
(1, NULL, 'app_name', 'FlowTask', 1, '2025-08-30 10:01:13', '2025-08-30 10:01:13'),
(2, NULL, 'app_version', '1.0.0', 1, '2025-08-30 10:01:13', '2025-08-30 10:01:13'),
(3, NULL, 'timezone', 'Asia/Jakarta', 1, '2025-08-30 10:01:13', '2025-08-30 10:01:13'),
(4, NULL, 'date_format', 'Y-m-d', 1, '2025-08-30 10:01:13', '2025-08-30 10:01:13'),
(5, NULL, 'datetime_format', 'Y-m-d H:i:s', 1, '2025-08-30 10:01:13', '2025-08-30 10:01:13'),
(6, NULL, 'items_per_page', '20', 1, '2025-08-30 10:01:13', '2025-08-30 10:01:13'),
(7, NULL, 'theme', 'light', 1, '2025-08-30 10:01:13', '2025-08-30 10:01:13'),
(8, NULL, 'email_notifications', 'true', 1, '2025-08-30 10:01:13', '2025-08-30 10:01:13'),
(9, NULL, 'auto_assign_bugs', 'false', 1, '2025-08-30 10:01:13', '2025-08-30 10:01:13'),
(10, NULL, 'max_file_size', '10485760', 1, '2025-08-30 10:01:13', '2025-08-30 10:01:13');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `project_id` int NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text,
  `assigned_to` int DEFAULT NULL,
  `created_by` int NOT NULL,
  `reporter_id` int DEFAULT NULL,
  `status` enum('to_do','in_progress','done','cancelled') NOT NULL DEFAULT 'to_do',
  `priority` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
  `task_type` enum('feature','bug','improvement') DEFAULT 'feature',
  `tags` varchar(500) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `estimated_hours` decimal(5,2) DEFAULT NULL,
  `verification_notes` text,
  `verified_by` int DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `actual_hours` decimal(5,2) DEFAULT NULL,
  `progress` decimal(5,2) DEFAULT '0.00',
  `parent_task_id` int DEFAULT NULL,
  `visibility` enum('project','assigned_only') DEFAULT 'project',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `title`, `description`, `assigned_to`, `created_by`, `reporter_id`, `status`, `priority`, `task_type`, `tags`, `due_date`, `estimated_hours`, `verification_notes`, `verified_by`, `verified_at`, `actual_hours`, `progress`, `parent_task_id`, `visibility`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`, `deleted_by`) VALUES
(2, 3, 'tes', 'tes', 17, 1, 1, 'done', 'high', 'feature', NULL, '2025-09-07', 2.00, NULL, NULL, NULL, NULL, 4.00, NULL, 'project', '2025-09-07 05:30:23', '2025-10-01 08:05:06', 0, NULL, NULL),
(3, 5, 'membuat landing page', 'tes', 17, 1, 1, 'done', 'low', 'feature', NULL, '2025-09-12', 2.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-12 07:22:39', '2025-10-01 08:05:06', 0, NULL, NULL),
(4, 5, 'membuat landing page', 'tes', 17, 1, 1, 'in_progress', 'low', 'feature', NULL, '2025-09-13', 3.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-12 07:35:06', '2025-10-01 08:05:06', 0, NULL, NULL),
(5, 15, 'Setup module - 1', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'medium', 'feature', NULL, '2025-09-26', 9.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(6, 14, 'Setup module - 1', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'medium', 'feature', NULL, '2025-09-26', 9.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(7, 13, 'Setup module - 1', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'medium', 'feature', NULL, '2025-09-26', 9.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(8, 12, 'Setup module - 1', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'medium', 'feature', NULL, '2025-09-26', 9.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(9, 11, 'Setup module - 1', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'medium', 'feature', NULL, '2025-09-26', 9.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(10, 10, 'Setup module - 1', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'medium', 'feature', NULL, '2025-09-26', 9.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(11, 9, 'Setup module - 1', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'medium', 'feature', NULL, '2025-09-26', 9.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(12, 8, 'Setup module - 1', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'medium', 'feature', NULL, '2025-09-26', 9.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(13, 7, 'Setup module - 1', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'medium', 'feature', NULL, '2025-09-26', 9.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(14, 6, 'Setup module - 1', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'medium', 'feature', NULL, '2025-09-26', 9.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(15, 15, 'Setup module - 2', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'high', 'feature', NULL, '2025-09-27', 10.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(16, 14, 'Setup module - 2', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'high', 'feature', NULL, '2025-09-27', 10.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(17, 13, 'Setup module - 2', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'high', 'feature', NULL, '2025-09-27', 10.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(18, 12, 'Setup module - 2', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'high', 'feature', NULL, '2025-09-27', 10.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(19, 11, 'Setup module - 2', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'high', 'feature', NULL, '2025-09-27', 10.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(20, 10, 'Setup module - 2', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'high', 'feature', NULL, '2025-09-27', 10.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(21, 9, 'Setup module - 2', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'high', 'feature', NULL, '2025-09-27', 10.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(22, 8, 'Setup module - 2', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'high', 'feature', NULL, '2025-09-27', 10.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(23, 7, 'Setup module - 2', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'high', 'feature', NULL, '2025-09-27', 10.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(24, 6, 'Setup module - 2', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'high', 'feature', NULL, '2025-09-27', 10.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(25, 15, 'Setup module - 3', 'Autogenerated task for demo data', 17, 18, 18, 'done', 'critical', 'feature', NULL, '2025-09-28', 11.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(26, 14, 'Setup module - 3', 'Autogenerated task for demo data', 17, 18, 18, 'done', 'critical', 'feature', NULL, '2025-09-28', 11.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(27, 13, 'Setup module - 3', 'Autogenerated task for demo data', 17, 18, 18, 'done', 'critical', 'feature', NULL, '2025-09-28', 11.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(28, 12, 'Setup module - 3', 'Autogenerated task for demo data', 17, 18, 18, 'done', 'critical', 'feature', NULL, '2025-09-28', 11.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(29, 11, 'Setup module - 3', 'Autogenerated task for demo data', 17, 18, 18, 'done', 'critical', 'feature', NULL, '2025-09-28', 11.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(30, 10, 'Setup module - 3', 'Autogenerated task for demo data', 17, 18, 18, 'done', 'critical', 'feature', NULL, '2025-09-28', 11.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(31, 9, 'Setup module - 3', 'Autogenerated task for demo data', 17, 18, 18, 'done', 'critical', 'feature', NULL, '2025-09-28', 11.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(32, 8, 'Setup module - 3', 'Autogenerated task for demo data', 17, 18, 18, 'done', 'critical', 'feature', NULL, '2025-09-28', 11.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(33, 7, 'Setup module - 3', 'Autogenerated task for demo data', 17, 18, 18, 'done', 'critical', 'feature', NULL, '2025-09-28', 11.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(34, 6, 'Setup module - 3', 'Autogenerated task for demo data', 17, 18, 18, 'done', 'critical', 'feature', NULL, '2025-09-28', 11.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(35, 15, 'Setup module - 4', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'low', 'feature', NULL, '2025-09-29', 12.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(36, 14, 'Setup module - 4', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'low', 'feature', NULL, '2025-09-29', 12.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(37, 13, 'Setup module - 4', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'low', 'feature', NULL, '2025-09-29', 12.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(38, 12, 'Setup module - 4', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'low', 'feature', NULL, '2025-09-29', 12.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(39, 11, 'Setup module - 4', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'low', 'feature', NULL, '2025-09-29', 12.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(40, 10, 'Setup module - 4', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'low', 'feature', NULL, '2025-09-29', 12.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(41, 9, 'Setup module - 4', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'low', 'feature', NULL, '2025-09-29', 12.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(42, 8, 'Setup module - 4', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'low', 'feature', NULL, '2025-09-29', 12.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(43, 7, 'Setup module - 4', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'low', 'feature', NULL, '2025-09-29', 12.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(44, 6, 'Setup module - 4', 'Autogenerated task for demo data', 17, 18, 18, 'in_progress', 'low', 'feature', NULL, '2025-09-29', 12.00, NULL, NULL, NULL, NULL, 50.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(45, 15, 'Setup module - 5', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'medium', 'feature', NULL, '2025-09-30', 8.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(46, 14, 'Setup module - 5', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'medium', 'feature', NULL, '2025-09-30', 8.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(47, 13, 'Setup module - 5', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'medium', 'feature', NULL, '2025-09-30', 8.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(48, 12, 'Setup module - 5', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'medium', 'feature', NULL, '2025-09-30', 8.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(49, 11, 'Setup module - 5', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'medium', 'feature', NULL, '2025-09-30', 8.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(50, 10, 'Setup module - 5', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'medium', 'feature', NULL, '2025-09-30', 8.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(51, 9, 'Setup module - 5', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'medium', 'feature', NULL, '2025-09-30', 8.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(52, 8, 'Setup module - 5', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'medium', 'feature', NULL, '2025-09-30', 8.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(53, 7, 'Setup module - 5', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'medium', 'feature', NULL, '2025-09-30', 8.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(54, 6, 'Setup module - 5', 'Autogenerated task for demo data', 17, 18, 18, 'to_do', 'medium', 'feature', NULL, '2025-09-30', 8.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'project', '2025-09-18 11:48:50', '2025-10-01 08:05:06', 0, NULL, NULL),
(55, 16, 'ui', 'ui', 28, 25, 25, 'done', 'low', 'feature', 'frontend', '2025-10-02', 2.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-10-01 08:16:38', '2025-10-01 10:19:37', 0, NULL, NULL),
(56, 16, 'tolong sesuaikan lagi webnya', 'okee', 28, 25, 25, 'done', 'low', 'improvement', 'frontend', '2025-10-01', NULL, NULL, NULL, NULL, NULL, 100.00, NULL, 'assigned_only', '2025-10-01 10:42:00', '2025-10-30 08:46:41', 0, NULL, NULL),
(57, 5, 'tes', 'tes', 17, 1, 1, 'in_progress', 'medium', 'improvement', 'tes', '2025-10-17', 2.00, NULL, NULL, NULL, NULL, 0.00, 4, 'assigned_only', '2025-10-17 08:33:39', '2025-10-17 08:33:39', 0, NULL, NULL),
(58, 3, 'OII', 'TES', 28, 1, 1, 'in_progress', 'low', 'bug', 'TES', '2025-10-22', 2.00, NULL, NULL, NULL, NULL, 0.00, 12, 'assigned_only', '2025-10-21 03:40:26', '2025-10-21 03:40:26', 0, NULL, NULL),
(60, 19, 'bikin mesin rayhan yamaha', 'testing', 28, 29, 29, 'to_do', 'critical', 'feature', 'frontend', '2025-10-26', 4.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'assigned_only', '2025-10-25 01:13:44', '2025-10-25 01:13:44', 0, NULL, NULL),
(61, 7, 'tes', 'tes', 26, 1, 1, 'in_progress', 'low', 'bug', 'tes', '2025-10-25', 2.00, NULL, NULL, NULL, NULL, 0.00, 12, 'assigned_only', '2025-10-25 14:20:13', '2025-10-25 14:20:13', 0, NULL, NULL),
(62, 20, 'membuat landing page', 'membuat landing page', 28, 25, 25, 'done', 'medium', 'feature', 'frontend', '2025-11-30', 2.00, NULL, NULL, NULL, NULL, 100.00, NULL, 'project', '2025-11-29 06:49:24', '2025-11-29 06:49:52', 0, NULL, NULL),
(63, 21, 'coba buatkan landing pagenya ', 'coba buatkan landing pagenya ', 28, 1, 1, 'to_do', 'high', 'bug', 'frontend', '2025-11-30', 2.00, NULL, NULL, NULL, NULL, 0.00, NULL, 'assigned_only', '2025-11-30 02:06:12', '2025-11-30 02:06:12', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_attachments`
--

CREATE TABLE `task_attachments` (
  `id` int NOT NULL,
  `task_id` int NOT NULL,
  `comment_id` int DEFAULT NULL,
  `uploaded_by` int NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task_attachments`
--

INSERT INTO `task_attachments` (`id`, `task_id`, `comment_id`, `uploaded_by`, `file_name`, `file_path`, `file_size`, `file_type`, `uploaded_at`, `is_deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 55, NULL, 28, '1759309412_0_WhatsApp_Image_2025-09-30_at_14.03.02_85fcb88c.jpg', 'uploads/tasks/1759309412_0_WhatsApp_Image_2025-09-30_at_14.03.02_85fcb88c.jpg', 63578, 'image/jpeg', '2025-10-01 09:03:32', 0, NULL, NULL),
(2, 55, NULL, 28, '1759310049_0_WhatsApp_Image_2025-09-30_at_12.05.45_9828bb2f.jpg', 'uploads/tasks/1759310049_0_WhatsApp_Image_2025-09-30_at_12.05.45_9828bb2f.jpg', 64416, 'image/jpeg', '2025-10-01 09:14:09', 0, NULL, NULL),
(3, 56, NULL, 1, '1760414123_0_52c64c72294407663e6f654f467bef53.ico', 'uploads/tasks/1760414123_0_52c64c72294407663e6f654f467bef53.ico', 651545, 'image/x-icon', '2025-10-14 03:55:23', 0, NULL, NULL),
(4, 56, NULL, 1, '1760414138_0_Nature_s_Essence__A_Minimalist_Ode_to_Beauty.jpg', 'uploads/tasks/1760414138_0_Nature_s_Essence__A_Minimalist_Ode_to_Beauty.jpg', 39169, 'image/jpeg', '2025-10-14 03:55:38', 0, NULL, NULL),
(5, 60, NULL, 29, '1761354881_0_Screenshot_2025-10-25_080623.png', 'uploads/tasks/1761354881_0_Screenshot_2025-10-25_080623.png', 232613, 'image/png', '2025-10-25 01:14:41', 0, NULL, NULL),
(6, 60, NULL, 1, '1761392927_0_Screenshot_2025-03-07_151045.png', 'uploads/tasks/1761392927_0_Screenshot_2025-03-07_151045.png', 42732, 'image/png', '2025-10-25 11:48:47', 0, NULL, NULL),
(7, 60, NULL, 1, '1761395829_0_Screenshot_2025-03-02_113430.png', 'uploads/tasks/1761395829_0_Screenshot_2025-03-02_113430.png', 22781, 'image/png', '2025-10-25 12:37:09', 0, NULL, NULL),
(8, 61, NULL, 1, '1761402701_0_Screenshot_2025-03-07_151045.png', 'uploads/tasks/1761402701_0_Screenshot_2025-03-07_151045.png', 42732, 'image/png', '2025-10-25 14:31:41', 0, NULL, NULL),
(9, 61, NULL, 1, '1761402901_0_Screenshot_2025-03-02_113430.png', 'uploads/tasks/1761402901_0_Screenshot_2025-03-02_113430.png', 22781, 'image/png', '2025-10-25 14:35:01', 0, NULL, NULL),
(10, 61, NULL, 1, '1761403346_0_Screenshot_2025-03-01_113413.png', 'uploads/tasks/1761403346_0_Screenshot_2025-03-01_113413.png', 816473, 'image/png', '2025-10-25 14:42:26', 0, NULL, NULL),
(11, 61, NULL, 1, '1761403559_0_Cuplikan_layar_2025-02-26_052527.png', 'uploads/tasks/1761403559_0_Cuplikan_layar_2025-02-26_052527.png', 92053, 'image/png', '2025-10-25 14:45:59', 0, NULL, NULL),
(12, 61, NULL, 1, '1761404528_0_Screenshot_2025-03-06_143940.png', 'uploads/tasks/1761404528_0_Screenshot_2025-03-06_143940.png', 542718, 'image/png', '2025-10-25 15:02:08', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

CREATE TABLE `task_comments` (
  `id` int NOT NULL,
  `task_id` int NOT NULL,
  `user_id` int NOT NULL,
  `edited_by` int DEFAULT NULL,
  `comment` text NOT NULL,
  `original_comment` text,
  `parent_comment_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `is_edited` tinyint(1) DEFAULT '0',
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task_comments`
--

INSERT INTO `task_comments` (`id`, `task_id`, `user_id`, `edited_by`, `comment`, `original_comment`, `parent_comment_id`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`, `deleted_by`, `is_edited`, `edited_at`) VALUES
(1, 55, 25, NULL, 'semangat ya ngerjainnya\r\n', NULL, NULL, '2025-10-01 08:27:46', '2025-10-01 08:27:46', 0, NULL, NULL, 0, NULL),
(2, 55, 28, NULL, 'oke kang', NULL, NULL, '2025-10-01 08:33:36', '2025-10-01 08:33:36', 0, NULL, NULL, 0, NULL),
(3, 55, 28, NULL, 'nih bos kelar', NULL, NULL, '2025-10-01 08:59:53', '2025-10-01 08:59:53', 0, NULL, NULL, 0, NULL),
(4, 55, 28, NULL, 'nih bos kelar', NULL, NULL, '2025-10-01 09:03:32', '2025-10-01 09:03:32', 0, NULL, NULL, 0, NULL),
(5, 55, 28, NULL, 'tes', NULL, NULL, '2025-10-01 09:14:09', '2025-10-01 09:14:09', 0, NULL, NULL, 0, NULL),
(6, 55, 28, NULL, 'yaa begitulah', NULL, 1, '2025-10-01 09:53:05', '2025-10-01 09:53:05', 0, NULL, NULL, 0, NULL),
(7, 55, 25, NULL, 'iya gitu', NULL, 6, '2025-10-01 10:35:18', '2025-10-01 10:35:18', 0, NULL, NULL, 0, NULL),
(8, 55, 25, NULL, 'hooh', NULL, 7, '2025-10-01 10:35:41', '2025-10-01 10:35:41', 0, NULL, NULL, 0, NULL),
(9, 55, 25, NULL, 'yaudah lah wir', NULL, 6, '2025-10-01 10:35:52', '2025-10-01 10:35:52', 0, NULL, NULL, 0, NULL),
(10, 56, 25, NULL, 'langsung kerjakan ya mase', NULL, NULL, '2025-10-01 10:42:15', '2025-10-01 10:42:15', 0, NULL, NULL, 0, NULL),
(11, 56, 25, NULL, 'start aja kalo sudah siap', NULL, 10, '2025-10-01 10:43:44', '2025-10-01 10:43:44', 0, NULL, NULL, 0, NULL),
(12, 56, 28, NULL, 'okokokok', NULL, 11, '2025-10-01 10:44:18', '2025-10-01 10:44:18', 0, NULL, NULL, 0, NULL),
(13, 55, 28, NULL, 'p', NULL, 8, '2025-10-01 10:44:39', '2025-10-01 10:44:39', 0, NULL, NULL, 0, NULL),
(14, 55, 28, NULL, 'p', NULL, 13, '2025-10-01 10:44:44', '2025-10-01 10:44:44', 0, NULL, NULL, 0, NULL),
(15, 56, 1, NULL, 'spiderman', NULL, 12, '2025-10-14 03:26:46', '2025-10-14 03:26:46', 0, NULL, NULL, 0, NULL),
(16, 56, 1, NULL, 'tes', NULL, NULL, '2025-10-14 03:47:55', '2025-10-14 03:47:55', 0, NULL, NULL, 0, NULL),
(17, 56, 1, NULL, 'cil', NULL, 12, '2025-10-14 03:55:23', '2025-10-14 03:55:23', 0, NULL, NULL, 0, NULL),
(18, 56, 1, NULL, 'tes', NULL, 17, '2025-10-14 03:55:38', '2025-10-14 03:55:38', 0, NULL, NULL, 0, NULL),
(19, 56, 25, NULL, 'tes', NULL, NULL, '2025-10-22 05:13:46', '2025-10-22 05:13:46', 0, NULL, NULL, 0, NULL),
(20, 58, 1, NULL, 'ataya', NULL, NULL, '2025-10-25 01:01:42', '2025-10-25 01:01:42', 0, NULL, NULL, 0, NULL),
(21, 58, 1, NULL, 'rehan77', NULL, 20, '2025-10-25 01:01:54', '2025-10-25 01:01:54', 0, NULL, NULL, 0, NULL),
(22, 60, 29, NULL, 'sernonoknye main laga laga😹', NULL, NULL, '2025-10-25 01:14:41', '2025-10-25 01:14:41', 0, NULL, NULL, 0, NULL),
(23, 60, 29, NULL, 'g', NULL, NULL, '2025-10-25 01:15:00', '2025-10-25 01:15:00', 0, NULL, NULL, 0, NULL),
(24, 60, 29, NULL, 'e', NULL, NULL, '2025-10-25 01:15:03', '2025-10-25 01:15:03', 0, NULL, NULL, 0, NULL),
(25, 60, 29, NULL, 'j', NULL, NULL, '2025-10-25 01:15:08', '2025-10-30 07:02:05', 0, NULL, NULL, 0, NULL),
(26, 60, 29, NULL, 'm', NULL, NULL, '2025-10-25 01:15:16', '2025-10-25 01:15:16', 0, NULL, NULL, 0, NULL),
(27, 60, 29, NULL, 'negro', NULL, NULL, '2025-10-25 01:18:55', '2025-10-25 01:18:55', 0, NULL, NULL, 0, NULL),
(28, 60, 29, NULL, 'hitam luwh', NULL, NULL, '2025-10-25 01:19:07', '2025-10-25 01:19:07', 0, NULL, NULL, 0, NULL),
(29, 60, 29, NULL, 'sambo', NULL, NULL, '2025-10-25 01:19:22', '2025-10-25 01:19:22', 0, NULL, NULL, 0, NULL),
(30, 60, 29, NULL, 'telaso', NULL, NULL, '2025-10-25 01:19:51', '2025-10-25 01:19:51', 0, NULL, NULL, 0, NULL),
(31, 60, 29, NULL, 'uygbk6ggggggggggggg6kttttttttttttttttttttttttttttttttttttttttttttt', NULL, NULL, '2025-10-25 01:21:08', '2025-10-25 01:21:08', 0, NULL, NULL, 0, NULL),
(32, 60, 1, NULL, 'tes', NULL, NULL, '2025-10-25 05:55:01', '2025-10-25 05:55:01', 0, NULL, NULL, 0, NULL),
(33, 60, 1, NULL, 'puki', NULL, NULL, '2025-10-25 06:05:20', '2025-10-25 06:05:20', 0, NULL, NULL, 0, NULL),
(34, 60, 1, NULL, 'pepek', NULL, NULL, '2025-10-25 06:05:25', '2025-10-25 06:05:25', 0, NULL, NULL, 0, NULL),
(35, 60, 1, NULL, 'tes', NULL, NULL, '2025-10-25 06:13:16', '2025-10-25 06:13:16', 0, NULL, NULL, 0, NULL),
(36, 60, 1, NULL, 'tes', NULL, NULL, '2025-10-25 11:04:03', '2025-10-25 11:04:03', 0, NULL, NULL, 0, NULL),
(39, 60, 1, NULL, 'halo mas bro ini codenya', NULL, NULL, '2025-10-25 11:48:47', '2025-10-25 11:48:47', 0, NULL, NULL, 0, NULL),
(40, 60, 1, NULL, 'a', NULL, NULL, '2025-10-25 11:48:56', '2025-10-25 11:48:56', 0, NULL, NULL, 0, NULL),
(41, 60, 1, NULL, 'as', NULL, NULL, '2025-10-25 11:49:08', '2025-10-25 11:49:08', 0, NULL, NULL, 0, NULL),
(42, 60, 1, NULL, 'tes', NULL, NULL, '2025-10-25 12:37:09', '2025-10-25 12:37:09', 0, NULL, NULL, 0, NULL),
(44, 61, 1, NULL, 'tes', NULL, NULL, '2025-10-25 14:20:35', '2025-10-25 14:20:35', 0, NULL, NULL, 0, NULL),
(45, 61, 1, NULL, 'eee', NULL, NULL, '2025-10-25 14:31:41', '2025-10-25 14:31:41', 0, NULL, NULL, 0, NULL),
(46, 61, 1, NULL, 'e', NULL, NULL, '2025-10-25 14:31:48', '2025-10-25 14:31:48', 0, NULL, NULL, 0, NULL),
(47, 61, 1, NULL, 'e', NULL, NULL, '2025-10-25 14:31:50', '2025-10-25 14:31:50', 0, NULL, NULL, 0, NULL),
(48, 61, 1, NULL, 'tes', NULL, NULL, '2025-10-25 14:34:52', '2025-10-25 14:34:52', 0, NULL, NULL, 0, NULL),
(49, 61, 1, NULL, 'ini projek ku', NULL, NULL, '2025-10-25 14:35:01', '2025-10-25 14:35:01', 0, NULL, NULL, 0, NULL),
(50, 61, 1, NULL, 'tes', NULL, NULL, '2025-10-25 14:35:07', '2025-10-25 14:35:07', 0, NULL, NULL, 0, NULL),
(51, 61, 1, NULL, 'helo', NULL, NULL, '2025-10-25 14:35:21', '2025-10-25 14:35:21', 0, NULL, NULL, 0, NULL),
(52, 61, 1, NULL, 'halo', NULL, NULL, '2025-10-25 14:42:26', '2025-10-25 14:42:26', 0, NULL, NULL, 0, NULL),
(53, 61, 1, NULL, 'mantap', NULL, NULL, '2025-10-25 14:43:14', '2025-10-25 14:43:14', 0, NULL, NULL, 0, NULL),
(54, 61, 1, NULL, 'loh', NULL, 53, '2025-10-25 14:43:25', '2025-10-25 14:43:25', 0, NULL, NULL, 0, NULL),
(55, 61, 1, NULL, 'nah gini brok', NULL, NULL, '2025-10-25 14:45:49', '2025-10-25 14:45:49', 0, NULL, NULL, 0, NULL),
(56, 61, 1, NULL, 'ini gpu saya', NULL, NULL, '2025-10-25 14:45:58', '2025-10-25 14:45:58', 0, NULL, NULL, 0, NULL),
(57, 61, 1, NULL, 'sama itu meerknya', NULL, 56, '2025-10-25 14:46:06', '2025-10-25 14:46:06', 0, NULL, NULL, 0, NULL),
(58, 61, 1, NULL, 'tes', NULL, NULL, '2025-10-25 14:58:57', '2025-10-25 14:58:57', 0, NULL, NULL, 0, NULL),
(59, 61, 1, NULL, 'tes', NULL, NULL, '2025-10-25 15:02:02', '2025-10-25 15:02:02', 0, NULL, NULL, 0, NULL),
(60, 61, 1, NULL, 'sss', NULL, NULL, '2025-10-25 15:02:08', '2025-10-25 15:02:08', 0, NULL, NULL, 0, NULL),
(61, 61, 1, NULL, 's', NULL, NULL, '2025-10-25 15:02:14', '2025-10-25 15:02:14', 0, NULL, NULL, 0, NULL),
(62, 61, 1, NULL, 'heloe', NULL, NULL, '2025-10-26 03:46:18', '2025-10-26 04:04:54', 1, '2025-10-26 04:04:54', NULL, 0, NULL),
(63, 60, 1, 1, 'acumalakaa', 'acumalaka', NULL, '2025-10-26 06:36:18', '2025-10-26 08:24:19', 0, NULL, NULL, 1, '2025-10-26 08:24:19'),
(64, 61, 1, NULL, 'ajg', NULL, NULL, '2025-10-29 12:47:27', '2025-10-29 12:47:27', 0, NULL, NULL, 0, NULL),
(65, 61, 1, NULL, 'tes', NULL, NULL, '2025-11-01 01:26:47', '2025-11-01 01:26:47', 0, NULL, NULL, 0, NULL),
(66, 62, 25, NULL, 'tes', NULL, NULL, '2025-11-29 06:49:42', '2025-11-29 06:49:42', 0, NULL, NULL, 0, NULL),
(67, 63, 1, NULL, 'tolong dikerjakan', NULL, NULL, '2025-11-30 02:06:22', '2025-11-30 02:06:22', 0, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_cases`
--

CREATE TABLE `test_cases` (
  `id` int NOT NULL,
  `project_id` int NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text,
  `preconditions` text,
  `test_steps` text NOT NULL,
  `expected_result` text NOT NULL,
  `priority` enum('critical','high','medium','low') NOT NULL DEFAULT 'medium',
  `type` enum('functional','ui','performance','security','usability','compatibility') NOT NULL DEFAULT 'functional',
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `test_cases`
--

INSERT INTO `test_cases` (`id`, `project_id`, `title`, `description`, `preconditions`, `test_steps`, `expected_result`, `priority`, `type`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 16, 'tessss', 'tessss', 'tesss', 'tessss', 'tessssss', 'medium', 'security', 27, '2025-10-05 09:45:41', '2025-10-23 12:01:55'),
(2, 5, 'tesssss2e', 'tes\n\n[Jenis Test Kustom: asdasdaaasdasdasdsadsadsadddasdsad]', 'tes', 'tes\r\ns\r\ns\r\ns\r\ns\r\ns\r\ns\r\ns\r\ns\r\ns\r\ns\r\nss\r\ns\r\n', 's\r\na\r\ns\r\ns\r\nss\r\ns\r\ns\r\ns\r\n', 'high', 'functional', 27, '2025-10-20 12:04:16', '2025-10-29 06:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `test_executions`
--

CREATE TABLE `test_executions` (
  `id` int NOT NULL,
  `test_case_id` int NOT NULL,
  `test_suite_id` int DEFAULT NULL,
  `executed_by` int NOT NULL,
  `status` enum('pass','fail','blocked','not_executed') NOT NULL DEFAULT 'not_executed',
  `actual_result` text,
  `comments` text,
  `execution_time` decimal(8,2) DEFAULT NULL,
  `executed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `test_executions`
--

INSERT INTO `test_executions` (`id`, `test_case_id`, `test_suite_id`, `executed_by`, `status`, `actual_result`, `comments`, `execution_time`, `executed_at`) VALUES
(1, 2, NULL, 27, 'pass', NULL, 'tes', NULL, '2025-10-21 08:03:59'),
(2, 2, NULL, 27, 'pass', NULL, 'tes', NULL, '2025-10-21 08:04:33'),
(3, 1, NULL, 1, 'pass', NULL, '', NULL, '2025-10-29 08:03:01'),
(4, 2, NULL, 1, 'fail', NULL, '', NULL, '2025-10-29 08:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `test_suites`
--

CREATE TABLE `test_suites` (
  `id` int NOT NULL,
  `project_id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `type` enum('smoke','regression','functional','integration','system','acceptance','performance','security','ui','usability','compatibility') NOT NULL DEFAULT 'functional',
  `priority` enum('critical','high','medium','low') NOT NULL DEFAULT 'medium',
  `schedule` enum('manual','daily','weekly','release') NOT NULL DEFAULT 'manual',
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `test_suites`
--

INSERT INTO `test_suites` (`id`, `project_id`, `name`, `description`, `type`, `priority`, `schedule`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 5, 'tes', 'tes', 'security', 'medium', 'manual', 1, '2025-10-29 07:16:56', '2025-10-29 07:16:56'),
(2, 5, 'tes', 'tesadsdsddda', 'security', 'medium', 'manual', 1, '2025-10-29 07:20:16', '2025-10-29 11:30:52'),
(3, 16, 'kumpulan projek penting', 'kumpulan projek penting', 'performance', 'critical', 'daily', 25, '2025-10-30 08:11:39', '2025-10-30 08:11:39');

-- --------------------------------------------------------

--
-- Table structure for table `test_suite_cases`
--

CREATE TABLE `test_suite_cases` (
  `id` int NOT NULL,
  `test_suite_id` int NOT NULL,
  `test_case_id` int NOT NULL,
  `execution_order` int DEFAULT '1',
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `test_suite_cases`
--

INSERT INTO `test_suite_cases` (`id`, `test_suite_id`, `test_case_id`, `execution_order`, `added_at`) VALUES
(1, 2, 1, 1, '2025-10-29 07:20:16'),
(2, 2, 2, 1, '2025-10-29 07:20:16'),
(3, 3, 1, 1, '2025-10-30 08:11:39'),
(4, 3, 2, 1, '2025-10-30 08:11:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('super_admin','admin','project_manager','developer','qa_tester','client') NOT NULL DEFAULT 'developer',
  `profile_photo` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `language` enum('en','id') NOT NULL DEFAULT 'id' COMMENT 'User language preference: en=English, id=Indonesian',
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `email_verified` tinyint(1) DEFAULT '0',
  `last_login` timestamp NULL DEFAULT NULL,
  `username_last_changed` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role`, `profile_photo`, `phone`, `language`, `status`, `email_verified`, `last_login`, `username_last_changed`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@flowtask.com', '$2y$10$RAU/JfnuogZraGju1vTLA.8.BwUPk74d1M/B80OdGtoSxYk2YnMw.', 'System Administrator', 'super_admin', 'profiles/1761453648_hello-gifs--hi-gifs---funny-hello-gifs---get-the-best-gif-on-giphy.gif', '', 'id', 'active', 1, '2025-12-05 03:29:26', NULL, '2025-08-30 10:23:18', '2025-12-05 03:29:26'),
(17, 'keyzano', 'keyzano@gmail.com', '$2y$10$C0OaGESYgYpvBwbqTi87ce2xRke7z6ezyOU9MD4j0raLC9JvY8yLS', 'Keyzano Rasya', 'developer', 'profiles/1756716427_WhatsApp Image 2025-08-21 at 13.28.45_3b730eec.jpg', '089012389237', 'id', 'active', 0, '2025-09-12 07:21:05', NULL, '2025-09-01 03:18:26', '2025-10-19 05:25:03'),
(18, 'maliknigger', 'malik@gmail.com', '$2y$10$wPmPknjLk4k0luoHOuUBbespuk9UCTNX.ScQiY0ILUr4PnUUYKHE.', 'malikpei', 'project_manager', 'profiles/1757054901_images (6).jpeg', '0832763287', 'id', 'active', 0, '2025-09-05 06:36:18', NULL, '2025-09-05 06:35:49', '2025-12-03 05:39:40'),
(19, 'rasya10', 'rasya@gmail.com', '$2y$10$suDbh90z0.LYmO.Hi9lzwuWhvJfCrRqfngNnKkBKK0aQy0rG2EWgO', 'rasya', 'qa_tester', NULL, '', 'id', 'active', 0, '2025-09-12 07:20:09', NULL, '2025-09-12 07:04:36', '2025-10-19 05:25:03'),
(20, 'pm.seed1', 'pm.seed1@example.com', '$2y$10$RAU/JfnuogZraGju1vTLA.8.BwUPk74d1M/B80OdGtoSxYk2YnMw.', 'PM Seed 1', 'project_manager', NULL, '', 'id', 'active', 1, NULL, NULL, '2025-09-18 11:48:50', '2025-10-19 05:25:03'),
(21, 'dev.seed1', 'dev.seed1@example.com', '$2y$10$RAU/JfnuogZraGju1vTLA.8.BwUPk74d1M/B80OdGtoSxYk2YnMw.', 'Dev Seed 1', 'developer', NULL, '', 'id', 'active', 1, NULL, NULL, '2025-09-18 11:48:50', '2025-10-19 05:25:03'),
(22, 'dev.seed2', 'dev.seed2@example.com', '$2y$10$RAU/JfnuogZraGju1vTLA.8.BwUPk74d1M/B80OdGtoSxYk2YnMw.', 'Dev Seed 2', 'developer', NULL, '', 'id', 'active', 1, NULL, NULL, '2025-09-18 11:48:50', '2025-10-19 05:25:03'),
(23, 'qa.seed1', 'qa.seed1@example.com', '$2y$10$RAU/JfnuogZraGju1vTLA.8.BwUPk74d1M/B80OdGtoSxYk2YnMw.', 'QA Seed 1', 'qa_tester', NULL, '', 'id', 'active', 1, NULL, NULL, '2025-09-18 11:48:50', '2025-10-19 05:25:03'),
(24, 'client.seed1', 'client.seed1@example.com', '$2y$10$RAU/JfnuogZraGju1vTLA.8.BwUPk74d1M/B80OdGtoSxYk2YnMw.', 'Client Seed 1', 'client', NULL, '', 'id', 'active', 1, NULL, NULL, '2025-09-18 11:48:50', '2025-10-19 05:25:03'),
(25, 'ORANG PROJEK KEREN', 'projek@gmail.com', '$2y$10$Zl5CA.hoS2vkivCFAzq07.R2fZm1.aJgbfIzsNtkJZv81SlfxrHFK', 'orang projek', 'project_manager', 'profiles/1759298417_gundam-anime-8k-wallpaper-uhdpaper.com-724@3@a.jpg', '', 'id', 'active', 0, '2025-12-02 02:49:34', '2025-10-02 09:29:49', '2025-09-30 11:35:52', '2025-12-02 02:49:34'),
(26, 'apacoba', 'keyzondol@gmail.com', '$2y$10$5QEHwqDp8m5Kn0VM1EC3YOGfriuOghBHPlMxI5Kint62BPegtdp4m', 'apacoba', 'developer', NULL, '', 'id', 'active', 0, '2025-09-30 11:40:16', NULL, '2025-09-30 11:39:39', '2025-10-19 05:25:03'),
(27, 'rasya', 'qatester@gmail.com', '$2y$10$Apt/E8hzHt0ABpM2TZYBFO6a0fGQR2FCHZ//5MY3JOdhsJbpVnSWu', 'rasya', 'qa_tester', 'profiles/1760962598_hello-gifs--hi-gifs---funny-hello-gifs---get-the-best-gif-on-giphy.gif', '', 'id', 'active', 0, '2025-10-31 03:29:58', NULL, '2025-10-01 06:29:24', '2025-10-31 03:29:58'),
(28, 'Jago Koding', 'developer@gmail.com', '$2y$10$CC3DC29yqtMHWg2ftxBmh.Bpz5vkagG9BCX2BRpV3xBrMpRTn1O.2', 'developer', 'developer', 'profiles/1759312141_wallpaperflare.com_wallpaper (3).jpg', '', 'id', 'active', 0, '2025-11-29 01:41:13', '2025-10-22 05:23:24', '2025-10-01 06:29:41', '2025-11-29 01:41:13'),
(29, 'mainlagalaga', 'lagalaga@gmail.com', '$2y$10$i3DtBGSUnn5Ow8q6sGoRS.rSV5CKHh1k4Pm2kp4KNxtLVQ8RqsWgq', 'jom main', 'project_manager', 'profiles/1761354608_Screenshot 2025-10-25 080623.png', '0851246899', 'id', 'inactive', 0, '2025-10-25 01:09:40', NULL, '2025-10-25 01:07:59', '2025-11-29 00:30:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_user_created` (`user_id`,`created_at`),
  ADD KEY `idx_activity_logs_date` (`created_at`);

--
-- Indexes for table `bugs`
--
ALTER TABLE `bugs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `reported_by` (`reported_by`),
  ADD KEY `resolved_by` (`resolved_by`),
  ADD KEY `idx_bugs_project` (`project_id`),
  ADD KEY `idx_bugs_assigned` (`assigned_to`),
  ADD KEY `idx_bugs_status` (`status`),
  ADD KEY `idx_bugs_priority` (`priority`);

--
-- Indexes for table `bug_attachments`
--
ALTER TABLE `bug_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bug_id` (`bug_id`),
  ADD KEY `uploaded_by` (`uploaded_by`),
  ADD KEY `idx_comment_id` (`comment_id`);

--
-- Indexes for table `bug_categories`
--
ALTER TABLE `bug_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `bug_comments`
--
ALTER TABLE `bug_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bug_id` (`bug_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `idx_bug_comment_edited_by` (`edited_by`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mentions`
--
ALTER TABLE `mentions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `mentioned_by` (`mentioned_by`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notifications_user` (`user_id`),
  ADD KEY `idx_notifications_unread` (`user_id`,`is_read`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `idx_projects_status` (`status`),
  ADD KEY `idx_projects_pm` (`project_manager_id`);

--
-- Indexes for table `project_milestones`
--
ALTER TABLE `project_milestones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `project_teams`
--
ALTER TABLE `project_teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_project_user_role` (`project_id`,`user_id`,`role_in_project`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_setting` (`user_id`,`setting_key`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_tasks_project` (`project_id`),
  ADD KEY `idx_tasks_assigned` (`assigned_to`),
  ADD KEY `idx_tasks_status` (`status`),
  ADD KEY `fk_tasks_reporter_id` (`reporter_id`),
  ADD KEY `fk_tasks_parent_task_id` (`parent_task_id`),
  ADD KEY `fk_tasks_verified_by` (`verified_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `task_attachments`
--
ALTER TABLE `task_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `uploaded_by` (`uploaded_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `idx_comment_id` (`comment_id`);

--
-- Indexes for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `idx_task_comment_edited_by` (`edited_by`);

--
-- Indexes for table `test_cases`
--
ALTER TABLE `test_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `test_executions`
--
ALTER TABLE `test_executions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_case_id` (`test_case_id`),
  ADD KEY `test_suite_id` (`test_suite_id`),
  ADD KEY `executed_by` (`executed_by`);

--
-- Indexes for table `test_suites`
--
ALTER TABLE `test_suites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `test_suite_cases`
--
ALTER TABLE `test_suite_cases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_suite_case` (`test_suite_id`,`test_case_id`),
  ADD KEY `test_case_id` (`test_case_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_role` (`role`),
  ADD KEY `idx_users_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=514;

--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bug_attachments`
--
ALTER TABLE `bug_attachments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bug_categories`
--
ALTER TABLE `bug_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bug_comments`
--
ALTER TABLE `bug_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mentions`
--
ALTER TABLE `mentions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `project_milestones`
--
ALTER TABLE `project_milestones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_teams`
--
ALTER TABLE `project_teams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `task_attachments`
--
ALTER TABLE `task_attachments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `test_cases`
--
ALTER TABLE `test_cases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `test_executions`
--
ALTER TABLE `test_executions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test_suites`
--
ALTER TABLE `test_suites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test_suite_cases`
--
ALTER TABLE `test_suite_cases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bugs`
--
ALTER TABLE `bugs`
  ADD CONSTRAINT `bugs_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bugs_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bugs_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `bug_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bugs_ibfk_4` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `bugs_ibfk_5` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bugs_ibfk_6` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bug_attachments`
--
ALTER TABLE `bug_attachments`
  ADD CONSTRAINT `bug_attachments_ibfk_1` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bug_attachments_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bug_comments`
--
ALTER TABLE `bug_comments`
  ADD CONSTRAINT `bug_comments_ibfk_1` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bug_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bug_comments_ibfk_3` FOREIGN KEY (`parent_comment_id`) REFERENCES `bug_comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bug_comments_ibfk_4` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_bug_comment_edited_by` FOREIGN KEY (`edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `mentions`
--
ALTER TABLE `mentions`
  ADD CONSTRAINT `mentions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mentions_ibfk_2` FOREIGN KEY (`mentioned_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`project_manager_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `project_milestones`
--
ALTER TABLE `project_milestones`
  ADD CONSTRAINT `project_milestones_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_milestones_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `project_teams`
--
ALTER TABLE `project_teams`
  ADD CONSTRAINT `project_teams_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_teams_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_parent_task_id` FOREIGN KEY (`parent_task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tasks_reporter_id` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_tasks_verified_by` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `tasks_ibfk_4` FOREIGN KEY (`parent_task_id`) REFERENCES `tasks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_ibfk_5` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `task_attachments`
--
ALTER TABLE `task_attachments`
  ADD CONSTRAINT `task_attachments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_attachments_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_attachments_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD CONSTRAINT `fk_task_comment_edited_by` FOREIGN KEY (`edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `task_comments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_comments_ibfk_3` FOREIGN KEY (`parent_comment_id`) REFERENCES `task_comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_comments_ibfk_4` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `test_cases`
--
ALTER TABLE `test_cases`
  ADD CONSTRAINT `test_cases_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_cases_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `test_executions`
--
ALTER TABLE `test_executions`
  ADD CONSTRAINT `test_executions_ibfk_1` FOREIGN KEY (`test_case_id`) REFERENCES `test_cases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_executions_ibfk_2` FOREIGN KEY (`test_suite_id`) REFERENCES `test_suites` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `test_executions_ibfk_3` FOREIGN KEY (`executed_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `test_suites`
--
ALTER TABLE `test_suites`
  ADD CONSTRAINT `test_suites_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_suites_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `test_suite_cases`
--
ALTER TABLE `test_suite_cases`
  ADD CONSTRAINT `test_suite_cases_ibfk_1` FOREIGN KEY (`test_suite_id`) REFERENCES `test_suites` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_suite_cases_ibfk_2` FOREIGN KEY (`test_case_id`) REFERENCES `test_cases` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
