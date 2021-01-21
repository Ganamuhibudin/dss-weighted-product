# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.13-MariaDB)
# Database: dss
# Generation Time: 2021-01-21 02:54:16 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table criterias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `criterias`;

CREATE TABLE `criterias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atribut` enum('keuntungan','biaya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `criterias_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `criterias` WRITE;
/*!40000 ALTER TABLE `criterias` DISABLE KEYS */;

INSERT INTO `criterias` (`id`, `code`, `name`, `atribut`, `weight`, `created_at`, `updated_at`)
VALUES
	(1,'K1','Jumlah Invoice','keuntungan',4,NULL,'2020-11-29 06:38:08'),
	(4,'K2','Lama Berlangganan','keuntungan',3,'2020-11-29 06:38:59','2020-11-29 06:38:59'),
	(5,'K3','Kelancaran Pembayaran','keuntungan',3,'2020-11-29 06:41:04','2020-11-29 06:41:04'),
	(6,'K4','Jenis Pelanggan','keuntungan',2,'2020-11-29 06:41:25','2020-11-29 06:41:25');

/*!40000 ALTER TABLE `criterias` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customer_values
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer_values`;

CREATE TABLE `customer_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `customer_values` WRITE;
/*!40000 ALTER TABLE `customer_values` DISABLE KEYS */;

INSERT INTO `customer_values` (`id`, `customer_id`, `criteria_id`, `value`, `created_at`, `updated_at`)
VALUES
	(1,1,1,3,NULL,'2020-11-30 07:14:26'),
	(2,1,4,3,NULL,'2020-11-30 07:14:26'),
	(3,1,5,4,NULL,'2020-11-30 07:14:26'),
	(4,1,6,4,NULL,'2020-11-30 07:14:26'),
	(5,3,1,3,NULL,NULL),
	(6,3,4,2,NULL,NULL),
	(7,3,5,2,NULL,NULL),
	(8,3,6,4,NULL,NULL),
	(9,4,1,4,NULL,NULL),
	(10,4,4,3,NULL,NULL),
	(11,4,5,2,NULL,NULL),
	(12,4,6,4,NULL,NULL),
	(13,5,1,4,NULL,NULL),
	(14,5,4,3,NULL,NULL),
	(15,5,5,4,NULL,NULL),
	(16,5,6,4,NULL,NULL),
	(17,6,1,3,NULL,NULL),
	(18,6,4,3,NULL,NULL),
	(19,6,5,2,NULL,NULL),
	(20,6,6,4,NULL,NULL);

/*!40000 ALTER TABLE `customer_values` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;

INSERT INTO `customers` (`id`, `code`, `name`, `address`, `phone`, `created_at`, `updated_at`)
VALUES
	(1,'A1','PT ANUGRAH CITRA','Jl Rasuna Said','021333444',NULL,'2020-11-09 06:44:59'),
	(3,'A2','PT ADIPERKASA','Jl Mitra Sunter Boulevard','081233444555','2020-11-15 12:14:49','2020-11-15 12:14:49'),
	(4,'A3','PT INABATA','Jl Mitra Sunter Boulevard','081233444555',NULL,NULL),
	(5,'A4','PT KISCO INDONESIA','Jl Mitra Sunter Boulevard','081233444555',NULL,NULL),
	(6,'A5','PT SINAR BINTANG','Jl Mitra Sunter Boulevard','081233444555',NULL,NULL);

/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2019_08_19_000000_create_failed_jobs_table',1),
	(4,'2020_11_08_100729_create_customers_table',2),
	(6,'2020_11_15_121950_create_criterias_table',3),
	(7,'2020_11_29_064517_create_customer_values_table',4);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Administrator','admin@admin.com',NULL,'$2y$10$kqlx86zmQd/IJhAXTXgVxuyIp4QPfAKQfvGhItdymz0i9Iyx2u8e2','WWA9CUL7OPRklrMr5ZmSTk9VAdHSmFFJlCnOIUtBoNzLZVclaTAJVSY3nC47','2020-11-05 14:32:35','2020-11-05 14:32:35');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
