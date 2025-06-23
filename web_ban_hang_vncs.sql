-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 23, 2025 at 07:19 AM
-- Server version: 8.0.37
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_ban_hang_vncs`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `telephone_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `telephone_id`, `content`, `created_at`, `updated_at`) VALUES
(7, 1, 6, 'a', '2025-06-22 21:19:24', '2025-06-22 21:19:24'),
(8, 1, 6, 'd', '2025-06-22 21:19:27', '2025-06-22 21:19:27'),
(9, 1, 6, 'uy', '2025-06-22 21:19:32', '2025-06-22 21:19:32'),
(10, 1, 6, 'j', '2025-06-22 21:19:37', '2025-06-22 21:19:37'),
(11, 2, 6, 'dfff', '2025-06-22 21:20:43', '2025-06-22 21:20:43'),
(12, 2, 6, '<script>alert(1)</script>', '2025-06-22 21:21:01', '2025-06-22 21:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2025_06_21_044906_add_balance_to_users_table', 1),
(7, '2025_06_21_044909_add_balance_to_users_table', 1),
(8, '2025_06_21_050630_create_telephones_table', 1),
(9, '2025_06_21_050631_create_shopping_carts_table', 1),
(10, '2025_06_21_110311_add_description_to_telephones_table', 2),
(11, '2025_06_23_035545_create_comments_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_carts`
--

CREATE TABLE `shopping_carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `telephone_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `status` enum('pending','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shopping_carts`
--

INSERT INTO `shopping_carts` (`id`, `user_id`, `telephone_id`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 33, 'paid', '2025-06-21 03:11:39', '2025-06-21 03:37:28'),
(2, 1, 2, 1, 'paid', '2025-06-21 03:11:51', '2025-06-21 03:37:28'),
(3, 1, 3, 3, 'paid', '2025-06-21 03:40:01', '2025-06-21 08:38:07'),
(4, 1, 6, 1, 'paid', '2025-06-21 03:40:10', '2025-06-21 08:38:07'),
(5, 1, 2, 1, 'paid', '2025-06-21 03:40:51', '2025-06-21 08:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `telephones`
--

CREATE TABLE `telephones` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `number` int NOT NULL DEFAULT '0',
  `brandId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `telephones`
--

INSERT INTO `telephones` (`id`, `name`, `price`, `number`, `brandId`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Galaxy S10', 120000.00, 100, '1', 'telephones/wAwXrDL9DZaOAYX9ludJAQ3sqGnLkVnztqi5vDME.png', '{{system(\'dir\')}}', '2025-06-20 23:36:51', '2025-06-21 19:52:24'),
(2, 'Iphone 16', 100000.00, 97, '3', 'telephones/AHeRZAR1bifoKZjk1sA8zyYQHiUFgKPIMgZvnX0j.png', NULL, '2025-06-20 23:37:21', '2025-06-21 19:51:33'),
(3, 'Xiaomi S20', 124400.00, 12, '3', 'products/Rc6DfQYPJkT6zcK52tM3qG8ugSzXU5B5RJjrfqcm.jpg', NULL, '2025-06-20 23:37:55', '2025-06-21 20:14:39'),
(4, 'Oppo A93', 210000.00, 11, '4', 'products/lAYneW7DTmCkKR5e6bg0xsQqkBMonlAvW7F3qZo8.jpg', NULL, '2025-06-20 23:38:26', '2025-06-20 23:38:26'),
(5, 'Galaxy note2', 190000.00, 122, '1', 'products/klbyJ4bKztYmc3mc1cGZqg6xjp4EUd0xC77cg1Zj.jpg', NULL, '2025-06-20 23:39:25', '2025-06-20 23:39:25'),
(6, 'Oppo e12', 119999.00, 123, '4', 'products/vZlLkFZeCtCDpJ4br8t4jZmjs3YXstUAVqZ6GB3j.jpg', NULL, '2025-06-20 23:39:49', '2025-06-20 23:39:49'),
(7, 'Iphone 20', 220000.00, 1, '2', 'products/joSNnr6QyGUT0mT3jbSiaPqSrlDlJqKb1unWa5YO.jpg', 'ggg', '2025-06-21 09:19:38', '2025-06-21 09:19:38'),
(8, 'aaa', 12.00, 12, '1', 'products/0Q5VhSUTaKQEdORgWXUc6nYrpZLLWe5Ux7XZFArr.jpg', NULL, '2025-06-21 19:29:51', '2025-06-21 19:29:51'),
(9, 'aaa', 12.00, 12, '1', 'products/WCMQZqfVAfCc4ZZwxta9S1pxhFmENvBsSlw78jgd.jpg', NULL, '2025-06-21 19:45:42', '2025-06-21 19:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT '100000000.00',
  `role` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `balance`, `role`) VALUES
(1, 'binh', 'op3477662@gmail.com', NULL, '$2y$12$DXkWjJOwggDNJexnUjnv9ejTtYyKEtPbZQqzYOtRnfl1YaKaqaCce', NULL, '2025-06-20 22:09:51', '2025-06-21 08:38:07', 95201601.00, 0),
(2, 'trinhtrang', 'trangchunghaha15@gmail.com', NULL, '$2y$12$NZg6f1.u.FZojlUgoG3/UO4fffVGN8lN14CW8DUwwvebLnKonIE5S', '8264zNVrYGTY7fWEJcq57H7PCMY7s0Rwb1gGRbuiWEl1Sh9dedm1BiVw3seQ', '2025-06-20 23:33:06', '2025-06-20 23:33:06', 100000000.00, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_telephone_id_foreign` (`telephone_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopping_carts_user_id_foreign` (`user_id`),
  ADD KEY `shopping_carts_telephone_id_foreign` (`telephone_id`);

--
-- Indexes for table `telephones`
--
ALTER TABLE `telephones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `telephones`
--
ALTER TABLE `telephones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_telephone_id_foreign` FOREIGN KEY (`telephone_id`) REFERENCES `telephones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  ADD CONSTRAINT `shopping_carts_telephone_id_foreign` FOREIGN KEY (`telephone_id`) REFERENCES `telephones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shopping_carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
