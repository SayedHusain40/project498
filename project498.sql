-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 03:05 PM
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
-- Database: `project498`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `event_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `user_id`, `title`, `description`, `category`, `location`, `event_date`, `created_at`, `updated_at`) VALUES
(2, 6, 'first post', 'dwa', 'Academic', 'manama', '2024-11-25 15:54:00', '2024-11-25 09:53:12', '2024-11-25 09:53:12'),
(3, 3, 'first post', 'W', 'Academic', 'manama', '2024-11-30 16:15:00', '2024-11-28 10:15:37', '2024-11-28 10:15:37'),
(4, 5, 'first post', NULL, 'Career Development', 'manama', '2024-12-28 17:04:00', '2024-12-04 11:04:17', '2024-12-04 11:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `file_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `file_id`, `created_at`, `updated_at`) VALUES
(3, 3, 60, '2024-11-30 11:02:11', '2024-11-30 11:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('a@a.com|127.0.0.1', 'i:1;', 1728466637),
('a@a.com|127.0.0.1:timer', 'i:1728466637;', 1728466637),
('a@admin2.com|127.0.0.1', 'i:1;', 1728466622),
('a@admin2.com|127.0.0.1:timer', 'i:1728466622;', 1728466622),
('admin2@a.com|127.0.0.1', 'i:1;', 1726239197),
('admin2@a.com|127.0.0.1:timer', 'i:1726239197;', 1726239197),
('q@h.com|127.0.0.1', 'i:1;', 1732538232),
('q@h.com|127.0.0.1:timer', 'i:1732538232;', 1732538232),
('s@h.com|127.0.0.1', 'i:1;', 1733312966),
('s@h.com|127.0.0.1:timer', 'i:1733312966;', 1733312966),
('s@hotamil.com|127.0.0.1', 'i:1;', 1733312974),
('s@hotamil.com|127.0.0.1:timer', 'i:1733312974;', 1733312974),
('t@h.com|127.0.0.1', 'i:1;', 1732456092),
('t@h.com|127.0.0.1:timer', 'i:1732456092;', 1732456092);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `name`, `created_at`, `updated_at`) VALUES
(7, 'College of Information Technology', '2024-06-27 15:55:58', '2024-06-27 15:55:58'),
(9, 'College of Science', '2024-06-27 15:55:58', '2024-06-27 15:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `code`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 'Computer Programming I ', 'ITCS113', 25, NULL, NULL),
(2, 'Computer Programming II', 'ITCS 114', 25, NULL, NULL),
(3, 'Digital Logic', 'ITCE250', 24, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `college_id`, `created_at`, `updated_at`) VALUES
(24, 'Computer Engineering', 7, '2024-06-27 16:32:17', '2024-06-27 16:32:17'),
(25, 'Computer Science', 7, '2024-06-27 16:32:17', '2024-06-27 16:32:17'),
(26, 'Information Systems', 7, '2024-06-27 16:32:17', '2024-06-27 16:32:17'),
(30, 'Mathematics', 9, '2024-06-27 16:32:17', '2024-06-27 16:32:17'),
(31, 'Chemistry', 9, '2024-06-27 16:32:17', '2024-06-27 16:32:17'),
(32, 'Biology', 9, '2024-06-27 16:32:17', '2024-06-27 16:32:17'),
(33, 'Physics', 9, '2024-06-27 16:32:17', '2024-06-27 16:32:17');

-- --------------------------------------------------------

--
-- Table structure for table `expertise_user`
--

CREATE TABLE `expertise_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `expertise_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expertise_user`
--

INSERT INTO `expertise_user` (`id`, `user_id`, `expertise_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, NULL),
(2, 3, 2, NULL, NULL),
(3, 3, 3, NULL, NULL),
(4, 6, 1, NULL, NULL),
(5, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `rating`, `feedback`, `created_at`, `updated_at`) VALUES
(1, 5, 'yes it wokfs', '2024-12-04 09:57:00', '2024-12-04 09:57:00'),
(2, 1, 'hi', '2024-12-04 09:57:48', '2024-12-04 09:57:48'),
(3, 3, NULL, '2024-12-04 10:01:37', '2024-12-04 10:01:37'),
(4, 3, NULL, '2024-12-04 10:01:59', '2024-12-04 10:01:59'),
(5, 3, NULL, '2024-12-04 10:02:57', '2024-12-04 10:02:57'),
(6, 1, NULL, '2024-12-04 10:05:49', '2024-12-04 10:05:49'),
(7, 3, NULL, '2024-12-04 10:27:04', '2024-12-04 10:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `material_id`, `name`, `path`, `file_type`, `downloads`, `created_at`, `updated_at`) VALUES
(59, 93, 'Screenshot 2024-11-17 191601.png', 'public/files/1732799554_Screenshot 2024-11-17 191601.png', 'png', 1, '2024-11-28 10:12:34', '2024-12-01 08:33:20'),
(60, 94, 'Lab 1.pdf', 'public/files/1732975321_Lab 1.pdf', 'pdf', 1, '2024-11-30 11:02:01', '2024-11-30 11:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `file_user`
--

CREATE TABLE `file_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_user`
--

INSERT INTO `file_user` (`id`, `file_id`, `user_id`, `created_at`, `updated_at`) VALUES
(25, 60, 3, NULL, NULL),
(26, 59, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`id`, `user_id`, `material_id`, `created_at`, `updated_at`) VALUES
(3, 3, 93, '2024-11-28 10:47:17', '2024-11-28 10:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketplaces`
--

CREATE TABLE `marketplaces` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,3) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `condition` enum('new','used') NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketplaces`
--

INSERT INTO `marketplaces` (`id`, `user_id`, `title`, `description`, `price`, `category`, `condition`, `image_path`, `created_at`, `updated_at`) VALUES
(3, 3, 'first post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc at ultrices diam. In quis massa maximus, laoreet ante eget, pretium arcu. Donec a interdum mauris. Phasellus consectetur diam tincidunt mi hendrerit congue. Mauris lectus ex, iaculis ut purus in, sodales commodo velit. Donec vel odio turpis. Cras euismod eu mauris id vestibulum. Donec maximus auctor diam vitae tincidunt. Vestibulum tristique ipsum sed vestibulum elementum. Donec imperdiet ultrices augue, a ullamcorper tellus posuere eu. Morbi hendrerit ornare lectus vitae imperdiet. Duis ut nisi vel sem accumsan ultricies. Nunc mattis cursus ultrices. Praesent ut dui et odio consequat congue. Nam sit amet massa vitae orci rhoncus accumsan at vel libero.\n\nPraesent quis urna eget nulla euismod sagittis non quis purus. Cras sit amet congue ipsum. Fusce sollicitudin odio eu odio malesuada vehicula. Aenean suscipit lectus sed sollicitudin tincidunt. Maecenas id nisi nec eros interdum malesuada. Quisque scelerisque mi ac urna pretium scelerisque. Vivamus quis tortor ac nibh molestie porta non in nisl. Sed convallis mi ante, id consectetur diam rhoncus ut. Donec dictum ultricies volutpat. Vivamus odio neque, dictum in porta id, mollis quis purus. Sed sit amet euismod ipsum.\n\nSed molestie facilisis tristique. Sed pharetra, urna et eleifend ultricies, diam leo volutpat quam, sit amet luctus nibh massa et est. Ut egestas ligula vitae interdum varius. Aenean lectus mi, faucibus ut nunc a, fermentum efficitur ante. Aenean maximus, justo at porttitor laoreet, nisi enim condimentum mi, et feugiat purus orci in purus. Suspendisse nec faucibus neque. Phasellus ac semper sapien.\n\nPhasellus commodo lacus sed turpis ornare eleifend. Pellentesque lacinia, ligula ut tincidunt dapibus, erat quam molestie elit, sed egestas erat est sit amet erat. Donec fringilla interdum lorem, nec vestibulum justo euismod in. Vivamus interdum gravida elit, ac congue tortor finibus ut. Pellentesque gravida egestas iaculis. Etiam est sem, molestie ac laoreet nec, tristique et risus. Vivamus varius tempus diam eu blandit. Aenean imperdiet, massa vel mollis feugiat, dolor nulla ornare tortor, vitae pretium nisi libero ut quam. Suspendisse in porttitor erat. Donec eu nisl nibh. Phasellus auctor diam in massa tincidunt consequat. Nullam vulputate libero nec ligula interdum euismod.\n\nNunc malesuada tortor orci, placerat faucibus est finibus nec. Suspendisse fermentum ipsum libero, in laoreet leo luctus ut. Aliquam laoreet fringilla diam sit amet volutpat. Aenean et leo ut leo mattis laoreet. Suspendisse potenti. Ut suscipit, ex at malesuada egestas, tellus velit pharetra sapien, sit amet interdum augue dolor non ex. Etiam sed massa sit amet mi porta venenatis in a arcu. Nullam laoreet urna vitae posuere pulvinar. Suspendisse potenti. Phasellus sollicitudin tellus ut rhoncus laoreet. Mauris fermentum bibendum consequat. Nam feugiat dictum libero ac luctus. Pellentesque eget arcu gravida, lobortis sapien eget, mattis lectus.', NULL, 'electronics', 'used', NULL, '2024-11-28 10:23:52', '2024-11-28 10:23:52'),
(4, 5, 'f', NULL, NULL, 'books', 'new', NULL, '2024-12-04 10:56:53', '2024-12-04 10:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `material_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `title`, `description`, `user_id`, `course_id`, `material_type_id`, `file_count`, `created_at`, `updated_at`) VALUES
(93, 'first post', 'EWF32', 3, 3, 2, 1, '2024-11-28 10:12:34', '2024-11-28 10:12:34'),
(94, 'f', '123', 3, 3, 3, 1, '2024-11-30 11:02:01', '2024-11-30 11:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `material_reports`
--

CREATE TABLE `material_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_reports`
--

INSERT INTO `material_reports` (`id`, `material_id`, `user_id`, `reason`, `created_at`, `updated_at`) VALUES
(10, 93, 8, 'hhh', '2024-12-01 08:27:03', '2024-12-01 08:27:03');

-- --------------------------------------------------------

--
-- Table structure for table `material_types`
--

CREATE TABLE `material_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_types`
--

INSERT INTO `material_types` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'red', NULL, NULL),
(2, 'Homework ', 'green', NULL, NULL),
(3, 'Quiz', 'blue', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_06_12_082424_create_temporary_files_table', 2),
(6, '2024_06_21_150050_create_colleges_table', 2),
(7, '2024_06_26_071910_create_ideas_table', 2),
(12, '2024_06_20_104434_create_departments_table', 6),
(13, '2024_06_27_223553_create_courses_table', 7),
(17, '2024_07_01_230806_create_material_types_table', 8),
(18, '2024_06_12_082243_create_materials_table', 9),
(20, '2024_07_10_205219_create_bookmarks_table', 10),
(23, '2024_07_18_171745_create_follows_table', 11),
(27, '2024_06_26_073028_create_posts_table', 12),
(35, '2024_06_14_070520_create_files_table', 17),
(37, '2024_08_08_152859_create_file_user_table', 18),
(39, '2024_09_02_142031_create_user_sessions_table', 19),
(46, '2024_09_14_115729_create_material_reports_table', 21),
(52, '2024_10_14_194448_create_expertise_user_table', 24),
(58, '2024_10_17_173842_create_study_sessions_table', 27),
(61, '2024_10_18_072404_create_restaurants_table', 29),
(63, '2024_10_16_122011_create_marketplace_table', 30),
(64, '2024_10_31_073401_create_questions_table', 31),
(65, '2024_10_31_073551_create_replies_table', 31),
(69, '2024_11_03_061609_create_question_user_like_dislikes_table', 32),
(70, '2024_11_04_112414_create_reply_user_like_dislikes_table', 33),
(71, '2024_11_04_145412_create_report_questions_table', 34),
(72, '2024_11_04_145412_create_report_replies_table', 34),
(74, '2024_11_25_104302_create_announcements_table', 36),
(75, '0001_01_01_000000_create_users_table', 37),
(76, '2024_12_04_112316_create_feedback_table', 38);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `likes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `dislikes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `department_id`, `user_id`, `content`, `likes`, `dislikes`, `created_at`, `updated_at`) VALUES
(82, 24, 3, 'a', 0, 0, '2024-11-30 09:28:37', '2024-11-30 09:28:37'),
(83, 24, 3, 'a', 0, 0, '2024-11-30 10:06:32', '2024-11-30 10:06:32'),
(84, 24, 3, 'n', 0, 0, '2024-11-30 10:17:35', '2024-11-30 10:17:35'),
(85, 24, 3, 'q', 0, 0, '2024-11-30 10:27:23', '2024-11-30 10:27:23'),
(86, 24, 3, 'new', 1, 0, '2024-11-30 10:30:15', '2024-11-30 10:32:15'),
(87, 24, 3, 'now', 0, 0, '2024-11-30 10:33:01', '2024-11-30 10:33:01'),
(88, 24, 3, 'a', 0, 1, '2024-11-30 10:37:52', '2024-11-30 10:37:53'),
(89, 24, 3, 'q', 0, 0, '2024-12-01 08:24:10', '2024-12-01 08:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `question_user_like_dislike`
--

CREATE TABLE `question_user_like_dislike` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('like','dislike') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question_user_like_dislike`
--

INSERT INTO `question_user_like_dislike` (`id`, `question_id`, `user_id`, `type`, `created_at`, `updated_at`) VALUES
(47, 86, 3, 'like', '2024-11-30 10:32:15', '2024-11-30 10:32:15'),
(48, 88, 3, 'dislike', '2024-11-30 10:37:53', '2024-11-30 10:37:53');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `likes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `dislikes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `question_id`, `user_id`, `content`, `likes`, `dislikes`, `created_at`, `updated_at`) VALUES
(35, 85, 3, 'qq', 0, 0, '2024-11-30 10:28:03', '2024-11-30 10:28:03'),
(36, 87, 3, 'reply', 0, 0, '2024-11-30 10:35:04', '2024-11-30 10:35:04'),
(37, 87, 3, 'w', 0, 0, '2024-11-30 10:36:41', '2024-11-30 10:36:41'),
(38, 88, 3, 'w', 1, 0, '2024-11-30 10:37:58', '2024-11-30 10:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `reply_user_like_dislike`
--

CREATE TABLE `reply_user_like_dislike` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reply_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('like','dislike') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reply_user_like_dislike`
--

INSERT INTO `reply_user_like_dislike` (`id`, `reply_id`, `user_id`, `type`, `created_at`, `updated_at`) VALUES
(13, 38, 3, 'like', '2024-11-30 10:37:59', '2024-11-30 10:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `report_questions`
--

CREATE TABLE `report_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_questions`
--

INSERT INTO `report_questions` (`id`, `question_id`, `user_id`, `reason`, `created_at`, `updated_at`) VALUES
(77, 87, 3, 'yed', '2024-11-30 10:33:09', '2024-11-30 10:33:09');

-- --------------------------------------------------------

--
-- Table structure for table `report_replies`
--

CREATE TABLE `report_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reply_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_replies`
--

INSERT INTO `report_replies` (`id`, `reply_id`, `user_id`, `reason`, `created_at`, `updated_at`) VALUES
(6, 37, 3, 'w reply', '2024-11-30 10:36:50', '2024-11-30 10:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `menu_image` varchar(255) DEFAULT NULL,
  `operating_hours` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `user_id`, `description`, `menu_image`, `operating_hours`, `location`, `created_at`, `updated_at`) VALUES
(10, 'Ali99', 3, 'w6d6wd', NULL, '12am to 10 pm', 'ubuibui', '2024-11-28 10:07:37', '2024-11-28 10:07:37'),
(13, 'hwh9', 3, '123', 'menus/1732802632_Screenshot 2024-11-18 170745.png', '12am to 10 pm', 'manama', '2024-11-28 11:03:52', '2024-11-28 11:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('q61hRlQHUNmLmehkNakTvQ8KRY1kslBIifwecEWt', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZmhVbHVWU2psd1d3eTF4M1VlM0FXN09PcFBjUDRzN3BwVVFKRkkyaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mZWVkYmFjayI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mZWVkYmFjayI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1733321091);

-- --------------------------------------------------------

--
-- Table structure for table `study_sessions`
--

CREATE TABLE `study_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `topic` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `session_date` datetime NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `location` varchar(255) NOT NULL,
  `price_or_volunteer` enum('price','volunteer') NOT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `study_sessions`
--

INSERT INTO `study_sessions` (`id`, `topic`, `description`, `session_date`, `user_id`, `course_id`, `location`, `price_or_volunteer`, `price`, `created_at`, `updated_at`) VALUES
(23, 'qdwad2132', '132', '2024-11-30 16:06:00', 3, 1, 'manama', 'price', 12.90, '2024-11-28 10:07:17', '2024-11-28 10:07:17'),
(24, 'qdwad2132', NULL, '2024-12-27 17:00:00', 5, 1, 'manama', 'volunteer', NULL, '2024-12-04 11:00:17', '2024-12-04 11:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `temporary_files`
--

CREATE TABLE `temporary_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `folder` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `major_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `country_code` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `major_id`, `phone`, `country_code`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Ali', 'user', 25, '+97337355106', NULL, 'a@hotmail.com', NULL, '$2y$12$3dFe2bt9d7NCMYn6XmyRier6vWfbtKu5aeqN3d.Dge1kzDrP.j6KO', NULL, '2024-12-03 14:07:09', '2024-12-03 14:11:15'),
(3, 'Sayed', 'user', NULL, '+97337355012', NULL, 's@hotmail.com', NULL, '$2y$12$/W131TjuvNf8L//5tLzXjOnjWanRptzVLvdtll2WTdJLF7ZKRzccK', NULL, '2024-12-03 13:18:21', '2024-12-03 14:00:47'),
(5, 'l', 'user', NULL, NULL, NULL, 'b@hotmail.com', NULL, '$2y$12$tZWsvR.QxxIMZiwVStj40uTM6l2soLfsLKdr1yXssj6oqAPS4bHZm', NULL, '2024-12-04 08:55:09', '2024-12-04 08:55:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_user_id_foreign` (`user_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookmarks_user_id_foreign` (`user_id`),
  ADD KEY `bookmarks_file_id_foreign` (`file_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_department_id_foreign` (`department_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_college_id_foreign` (`college_id`);

--
-- Indexes for table `expertise_user`
--
ALTER TABLE `expertise_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expertise_user_user_id_foreign` (`user_id`),
  ADD KEY `expertise_user_expertise_id_foreign` (`expertise_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_material_id_foreign` (`material_id`);

--
-- Indexes for table `file_user`
--
ALTER TABLE `file_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_user_file_id_user_id_unique` (`file_id`,`user_id`),
  ADD KEY `file_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follows_user_id_foreign` (`user_id`),
  ADD KEY `follows_material_id_foreign` (`material_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketplaces`
--
ALTER TABLE `marketplaces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marketplaces_user_id_foreign` (`user_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materials_user_id_foreign` (`user_id`),
  ADD KEY `materials_course_id_foreign` (`course_id`),
  ADD KEY `materials_material_type_id_foreign` (`material_type_id`);

--
-- Indexes for table `material_reports`
--
ALTER TABLE `material_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_reports_material_id_foreign` (`material_id`),
  ADD KEY `material_reports_user_id_foreign` (`user_id`);

--
-- Indexes for table `material_types`
--
ALTER TABLE `material_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_department_id_foreign` (`department_id`),
  ADD KEY `questions_user_id_foreign` (`user_id`);

--
-- Indexes for table `question_user_like_dislike`
--
ALTER TABLE `question_user_like_dislike`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_user_like_dislike_question_id_foreign` (`question_id`),
  ADD KEY `question_user_like_dislike_user_id_foreign` (`user_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `replies_question_id_foreign` (`question_id`),
  ADD KEY `replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `reply_user_like_dislike`
--
ALTER TABLE `reply_user_like_dislike`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reply_user_like_dislike_reply_id_foreign` (`reply_id`),
  ADD KEY `reply_user_like_dislike_user_id_foreign` (`user_id`);

--
-- Indexes for table `report_questions`
--
ALTER TABLE `report_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_questions_question_id_foreign` (`question_id`),
  ADD KEY `report_questions_user_id_foreign` (`user_id`);

--
-- Indexes for table `report_replies`
--
ALTER TABLE `report_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_replies_reply_id_foreign` (`reply_id`),
  ADD KEY `report_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurants_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `study_sessions_user_id_foreign` (`user_id`),
  ADD KEY `study_sessions_course_id_foreign` (`course_id`);

--
-- Indexes for table `temporary_files`
--
ALTER TABLE `temporary_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_name_unique` (`name`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_major_id_foreign` (`major_id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_sessions_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `expertise_user`
--
ALTER TABLE `expertise_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `file_user`
--
ALTER TABLE `file_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marketplaces`
--
ALTER TABLE `marketplaces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `material_reports`
--
ALTER TABLE `material_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `material_types`
--
ALTER TABLE `material_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `question_user_like_dislike`
--
ALTER TABLE `question_user_like_dislike`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reply_user_like_dislike`
--
ALTER TABLE `reply_user_like_dislike`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `report_questions`
--
ALTER TABLE `report_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `report_replies`
--
ALTER TABLE `report_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `study_sessions`
--
ALTER TABLE `study_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `temporary_files`
--
ALTER TABLE `temporary_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expertise_user`
--
ALTER TABLE `expertise_user`
  ADD CONSTRAINT `expertise_user_expertise_id_foreign` FOREIGN KEY (`expertise_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expertise_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `file_user`
--
ALTER TABLE `file_user`
  ADD CONSTRAINT `file_user_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `file_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `marketplaces`
--
ALTER TABLE `marketplaces`
  ADD CONSTRAINT `marketplaces_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materials_material_type_id_foreign` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `materials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_reports`
--
ALTER TABLE `material_reports`
  ADD CONSTRAINT `material_reports_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_user_like_dislike`
--
ALTER TABLE `question_user_like_dislike`
  ADD CONSTRAINT `question_user_like_dislike_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_user_like_dislike_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reply_user_like_dislike`
--
ALTER TABLE `reply_user_like_dislike`
  ADD CONSTRAINT `reply_user_like_dislike_reply_id_foreign` FOREIGN KEY (`reply_id`) REFERENCES `replies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reply_user_like_dislike_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_questions`
--
ALTER TABLE `report_questions`
  ADD CONSTRAINT `report_questions_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_replies`
--
ALTER TABLE `report_replies`
  ADD CONSTRAINT `report_replies_reply_id_foreign` FOREIGN KEY (`reply_id`) REFERENCES `replies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `restaurants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD CONSTRAINT `study_sessions_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `study_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_major_id_foreign` FOREIGN KEY (`major_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
