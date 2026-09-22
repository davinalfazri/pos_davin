-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.8.8-MariaDB - MariaDB Server
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for pos_sahal
CREATE DATABASE IF NOT EXISTS `pos_sahal` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `pos_sahal`;

-- Dumping structure for table pos_sahal.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.cache: ~0 rows (approximately)

-- Dumping structure for table pos_sahal.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.cache_locks: ~0 rows (approximately)

-- Dumping structure for table pos_sahal.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table pos_sahal.item_penjualan
CREATE TABLE IF NOT EXISTS `item_penjualan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint(20) unsigned NOT NULL,
  `produk_id` bigint(20) unsigned NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_penjualan_penjualan_id_foreign` (`penjualan_id`),
  KEY `item_penjualan_produk_id_foreign` (`produk_id`),
  CONSTRAINT `item_penjualan_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`id`),
  CONSTRAINT `item_penjualan_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.item_penjualan: ~18 rows (approximately)
INSERT INTO `item_penjualan` (`id`, `penjualan_id`, `produk_id`, `kuantitas`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, 10000, 10000, '2026-08-09 20:52:27', '2026-08-09 20:52:27'),
	(2, 1, 2, 1, 5000, 5000, '2026-08-09 20:52:29', '2026-08-09 20:52:29'),
	(3, 2, 1, 14, 10000, 140000, '2026-08-09 23:26:29', '2026-08-09 23:26:36'),
	(4, 3, 1, 1, 10000, 10000, '2026-08-11 23:49:43', '2026-08-11 23:49:43'),
	(6, 3, 2, 1, 5000, 5000, '2026-08-11 23:53:15', '2026-08-11 23:53:15'),
	(7, 4, 1, 1, 10000, 10000, '2026-08-12 00:14:26', '2026-08-12 00:14:26'),
	(8, 4, 2, 1, 5000, 5000, '2026-08-12 00:14:28', '2026-08-12 00:14:28'),
	(9, 5, 1, 2, 10000, 20000, '2026-08-12 00:21:21', '2026-08-12 00:47:49'),
	(10, 5, 2, 1, 5000, 5000, '2026-08-12 00:21:23', '2026-08-12 00:21:23'),
	(11, 6, 2, 1, 5000, 5000, '2026-08-12 00:48:16', '2026-08-12 00:48:16'),
	(12, 7, 1, 1, 10000, 10000, '2026-08-12 00:49:07', '2026-08-12 00:49:07'),
	(13, 7, 2, 1, 5000, 5000, '2026-08-12 00:49:12', '2026-08-12 00:49:12'),
	(14, 4, 3, 1, 5000000, 5000000, '2026-08-18 21:14:22', '2026-08-18 21:14:22'),
	(15, 8, 3, 1, 5000000, 5000000, '2026-08-18 21:21:16', '2026-08-18 21:21:16'),
	(16, 9, 3, 1, 5000000, 5000000, '2026-08-18 21:55:17', '2026-08-18 21:55:17'),
	(17, 10, 3, 1, 5000000, 5000000, '2026-08-27 19:41:31', '2026-08-27 19:41:31'),
	(18, 10, 1, 1, 10000, 10000, '2026-08-27 19:51:08', '2026-08-27 19:51:08'),
	(19, 10, 2, 1, 5000, 5000, '2026-08-27 19:51:15', '2026-08-27 19:51:15');

-- Dumping structure for table pos_sahal.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.jobs: ~0 rows (approximately)

-- Dumping structure for table pos_sahal.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.job_batches: ~0 rows (approximately)

-- Dumping structure for table pos_sahal.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.migrations: ~7 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_roles_table', 1),
	(2, '0001_01_01_000000_create_users_table', 1),
	(3, '0001_01_01_000001_create_cache_table', 1),
	(4, '0001_01_01_000002_create_jobs_table', 1),
	(5, '2026_01_19_014814_create_produk_table', 1),
	(6, '2026_01_19_015701_create_penjualan_table', 1),
	(7, '2026_01_19_020509_create_item_penjualan_table', 1);

-- Dumping structure for table pos_sahal.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table pos_sahal.penjualan
CREATE TABLE IF NOT EXISTS `penjualan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `total_pembayaran` int(11) NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL,
  `status` enum('OPEN','COMPLETED') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penjualan_user_id_foreign` (`user_id`),
  CONSTRAINT `penjualan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.penjualan: ~10 rows (approximately)
INSERT INTO `penjualan` (`id`, `user_id`, `total_pembayaran`, `metode_pembayaran`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 15000, 'QRIS', 'COMPLETED', '2026-08-09 20:52:23', '2026-08-09 20:52:58'),
	(2, 1, 140000, 'QRIS', 'COMPLETED', '2026-08-09 23:26:13', '2026-08-09 23:26:53'),
	(3, 1, 15000, 'CASH', 'COMPLETED', '2026-08-11 23:49:33', '2026-08-11 23:53:24'),
	(4, 1, 5015000, 'CASH', 'COMPLETED', '2026-08-12 00:14:22', '2026-08-18 21:14:37'),
	(5, 2, 25000, 'CASH', 'COMPLETED', '2026-08-12 00:21:18', '2026-08-12 00:48:00'),
	(6, 2, 5000, 'QRIS', 'COMPLETED', '2026-08-12 00:48:12', '2026-08-12 00:48:23'),
	(7, 3, 15000, 'CASH', 'COMPLETED', '2026-08-12 00:49:04', '2026-08-12 00:49:21'),
	(8, 1, 5000000, 'CASH', 'COMPLETED', '2026-08-18 21:21:13', '2026-08-18 21:26:05'),
	(9, 2, 5000000, 'CASH', 'COMPLETED', '2026-08-18 21:52:13', '2026-08-18 21:55:27'),
	(10, 2, 5015000, 'QRIS', 'COMPLETED', '2026-08-27 19:41:27', '2026-08-27 19:51:26');

-- Dumping structure for table pos_sahal.produk
CREATE TABLE IF NOT EXISTS `produk` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produk_user_id_foreign` (`user_id`),
  KEY `produk_nama_index` (`nama`),
  CONSTRAINT `produk_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.produk: ~4 rows (approximately)
INSERT INTO `produk` (`id`, `user_id`, `foto`, `nama`, `harga_beli`, `harga_jual`, `stok`, `created_at`, `updated_at`) VALUES
	(1, 1, 'products/BFHc2QyT9L3PeksV7cKYTVKld7MnaTLTrwLVTLPr.jpg', 'cheetos', 5000, 10000, 9, '2026-08-09 20:51:45', '2026-08-27 19:51:08'),
	(2, 1, 'products/QVQFWhscYAHgOxM4Bf4rUj5rsc9dcHzRTCE9wGJk.png', 'teh pucuk', 3000, 5000, 9, '2026-08-09 20:52:15', '2026-08-27 19:51:15'),
	(3, 1, 'products/mDopahMBHEzQd8f4VpN34FynNda3mnq1eSfV6ToG.png', 'axio', 3000000, 5000000, 6, '2026-08-18 19:54:06', '2026-08-27 19:41:31');

-- Dumping structure for table pos_sahal.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.roles: ~2 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '2026-08-09 20:25:39', '2026-08-09 20:25:39'),
	(2, 'kasir', '2026-08-09 20:25:39', '2026-08-09 20:25:39');

-- Dumping structure for table pos_sahal.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.sessions: ~0 rows (approximately)

-- Dumping structure for table pos_sahal.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  FULLTEXT KEY `users_name_email_fulltext` (`name`,`email`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_sahal.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Haji Hall', 'hajihalll@gmail.com', NULL, '$2y$12$qAO12u4qYQu.98gSONz1ruFhbVG4KCvXQpEl2rYP/l1AOl2BvXhsq', NULL, '2026-08-09 20:25:41', '2026-08-09 20:25:41'),
	(2, 2, 'kasir', 'kasir@gmail.com', NULL, '$2y$12$bXkpEXQTN/TSJGgWi9mZQuuI2cXCAhZveAnccSSz3Gw7w/FZS1Jue', NULL, '2026-08-09 20:25:41', '2026-08-11 22:33:13'),
	(3, 1, 'bunga', 'bungaarum@gmail.com', NULL, '$2y$12$dFJdnAOXQLlBJXEnBqjxu.xtgWHfOBmhKT6X1sVYMKLskosHurf6u', NULL, '2026-08-11 22:09:52', '2026-08-12 00:20:35'),
	(4, 2, 'kasirtoko', 'kasirtoko@gmail.com', NULL, '$2y$12$vzIMACABbAVjlWp1jjItt.OR4YimK1t1YEZ86xzCYCIIoplcIdFf6', NULL, '2026-08-18 19:13:28', '2026-08-18 19:16:02');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
