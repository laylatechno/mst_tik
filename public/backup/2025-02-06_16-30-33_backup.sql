-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: db_masterkit
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adjustment_details`
--

DROP TABLE IF EXISTS `adjustment_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustment_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `adjustment_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `adjustment_details_adjustment_id_foreign` (`adjustment_id`),
  KEY `adjustment_details_product_id_foreign` (`product_id`),
  CONSTRAINT `adjustment_details_adjustment_id_foreign` FOREIGN KEY (`adjustment_id`) REFERENCES `adjustments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `adjustment_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment_details`
--

LOCK TABLES `adjustment_details` WRITE;
/*!40000 ALTER TABLE `adjustment_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `adjustment_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adjustments`
--

DROP TABLE IF EXISTS `adjustments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `adjustment_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adjustment_date` date NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total` bigint DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `adjustments_document_number_unique` (`adjustment_number`) USING BTREE,
  KEY `adjustments_user_id_foreign` (`user_id`),
  CONSTRAINT `adjustments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustments`
--

LOCK TABLES `adjustments` WRITE;
/*!40000 ALTER TABLE `adjustments` DISABLE KEYS */;
/*!40000 ALTER TABLE `adjustments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('spatie.permission.cache','a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"d\";s:6:\"urutan\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:119:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"user-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:21;s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"user-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:22;s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"user-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:23;s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"user-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:24;s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:15:\"permission-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:13;s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:17:\"permission-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:14;s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:15:\"permission-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:15;s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:17:\"permission-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:16;s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:9:\"role-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:17;s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:11:\"role-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:18;s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:9:\"role-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:19;s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:11:\"role-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:20;s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:11:\"profil-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:33;s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:12:\"general-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:14:\"dashboard-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:2;s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"pengaturan-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:12;s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:14:\"menugroup-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:25;s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:16:\"menugroup-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:26;s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:14:\"menugroup-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:27;s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:16:\"menugroup-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:28;s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:11:\"master-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:3;s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:9:\"blog-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:4;s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:13:\"menuitem-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:29;s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:15:\"menuitem-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:30;s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:13:\"menuitem-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:31;s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:15:\"menuitem-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:32;s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:11:\"profil-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:34;s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:15:\"create-resource\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:40;s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:15:\"loghistori-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:46;s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:5:{s:1:\"a\";i:44;s:1:\"b\";s:20:\"loghistori-deleteall\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:46;s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:5:{s:1:\"a\";i:45;s:1:\"b\";s:12:\"advance-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:45;s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:5:{s:1:\"a\";i:46;s:1:\"b\";s:10:\"route-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:46;s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:5:{s:1:\"a\";i:47;s:1:\"b\";s:12:\"route-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:50;s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:5:{s:1:\"a\";i:48;s:1:\"b\";s:9:\"menu-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:50;s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:5:{s:1:\"a\";i:49;s:1:\"b\";s:19:\"permissionrole-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:50;s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:5:{s:1:\"a\";i:71;s:1:\"b\";s:9:\"unit-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:5:{s:1:\"a\";i:72;s:1:\"b\";s:11:\"unit-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:5:{s:1:\"a\";i:73;s:1:\"b\";s:9:\"unit-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:5:{s:1:\"a\";i:74;s:1:\"b\";s:11:\"unit-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:5:{s:1:\"a\";i:75;s:1:\"b\";s:13:\"category-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:5:{s:1:\"a\";i:76;s:1:\"b\";s:15:\"category-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:5:{s:1:\"a\";i:77;s:1:\"b\";s:13:\"category-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:5:{s:1:\"a\";i:78;s:1:\"b\";s:15:\"category-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:5:{s:1:\"a\";i:79;s:1:\"b\";s:12:\"product-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:5:{s:1:\"a\";i:80;s:1:\"b\";s:14:\"product-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:5:{s:1:\"a\";i:81;s:1:\"b\";s:12:\"product-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:5:{s:1:\"a\";i:82;s:1:\"b\";s:14:\"product-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:5:{s:1:\"a\";i:83;s:1:\"b\";s:13:\"supplier-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:5:{s:1:\"a\";i:84;s:1:\"b\";s:15:\"supplier-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:5:{s:1:\"a\";i:85;s:1:\"b\";s:13:\"supplier-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:5:{s:1:\"a\";i:86;s:1:\"b\";s:15:\"supplier-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:5:{s:1:\"a\";i:87;s:1:\"b\";s:13:\"purchase-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:5:{s:1:\"a\";i:88;s:1:\"b\";s:15:\"purchase-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:5:{s:1:\"a\";i:89;s:1:\"b\";s:13:\"purchase-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:5:{s:1:\"a\";i:90;s:1:\"b\";s:15:\"purchase-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:5:{s:1:\"a\";i:91;s:1:\"b\";s:9:\"cash-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:5:{s:1:\"a\";i:92;s:1:\"b\";s:9:\"cash-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:5:{s:1:\"a\";i:93;s:1:\"b\";s:11:\"cash-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:5:{s:1:\"a\";i:94;s:1:\"b\";s:11:\"cash-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:5:{s:1:\"a\";i:95;s:1:\"b\";s:13:\"transact-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:2;s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:5:{s:1:\"a\";i:96;s:1:\"b\";s:10:\"order-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:5:{s:1:\"a\";i:97;s:1:\"b\";s:12:\"order-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:5:{s:1:\"a\";i:98;s:1:\"b\";s:10:\"order-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:5:{s:1:\"a\";i:99;s:1:\"b\";s:12:\"order-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:5:{s:1:\"a\";i:100;s:1:\"b\";s:13:\"customer-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:5:{s:1:\"a\";i:101;s:1:\"b\";s:15:\"customer-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:5:{s:1:\"a\";i:102;s:1:\"b\";s:13:\"customer-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:5:{s:1:\"a\";i:103;s:1:\"b\";s:15:\"customer-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:5:{s:1:\"a\";i:104;s:1:\"b\";s:24:\"transactioncategory-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:5:{s:1:\"a\";i:105;s:1:\"b\";s:26:\"transactioncategory-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:5:{s:1:\"a\";i:106;s:1:\"b\";s:24:\"transactioncategory-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:5:{s:1:\"a\";i:107;s:1:\"b\";s:26:\"transactioncategory-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:5:{s:1:\"a\";i:108;s:1:\"b\";s:16:\"transaction-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:5:{s:1:\"a\";i:109;s:1:\"b\";s:18:\"transaction-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:5:{s:1:\"a\";i:110;s:1:\"b\";s:16:\"transaction-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:5:{s:1:\"a\";i:111;s:1:\"b\";s:18:\"transaction-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:5:{s:1:\"a\";i:112;s:1:\"b\";s:16:\"stockopname-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:5:{s:1:\"a\";i:113;s:1:\"b\";s:18:\"stockopname-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:5:{s:1:\"a\";i:114;s:1:\"b\";s:16:\"stockopname-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:5:{s:1:\"a\";i:115;s:1:\"b\";s:18:\"stockopname-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:5:{s:1:\"a\";i:116;s:1:\"b\";s:15:\"adjustment-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:5:{s:1:\"a\";i:117;s:1:\"b\";s:17:\"adjustment-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:5:{s:1:\"a\";i:118;s:1:\"b\";s:15:\"adjustment-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:5:{s:1:\"a\";i:119;s:1:\"b\";s:17:\"adjustment-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:5:{s:1:\"a\";i:120;s:1:\"b\";s:11:\"report-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:4;s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:5:{s:1:\"a\";i:121;s:1:\"b\";s:19:\"purchasereport-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:5:{s:1:\"a\";i:122;s:1:\"b\";s:16:\"orderreport-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:5:{s:1:\"a\";i:123;s:1:\"b\";s:18:\"productreport-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:5:{s:1:\"a\";i:124;s:1:\"b\";s:17:\"profitreport-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:5:{s:1:\"a\";i:125;s:1:\"b\";s:21:\"topproductreport-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:5:{s:1:\"a\";i:126;s:1:\"b\";s:11:\"slider-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:91;a:5:{s:1:\"a\";i:127;s:1:\"b\";s:13:\"slider-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:5:{s:1:\"a\";i:128;s:1:\"b\";s:11:\"slider-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:5:{s:1:\"a\";i:129;s:1:\"b\";s:13:\"slider-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:5:{s:1:\"a\";i:130;s:1:\"b\";s:14:\"testimony-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:5:{s:1:\"a\";i:131;s:1:\"b\";s:16:\"testimony-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:5:{s:1:\"a\";i:132;s:1:\"b\";s:14:\"testimony-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:5:{s:1:\"a\";i:133;s:1:\"b\";s:16:\"testimony-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:98;a:5:{s:1:\"a\";i:134;s:1:\"b\";s:11:\"depan-index\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:5:{s:1:\"a\";i:135;s:1:\"b\";s:12:\"gallery-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:5:{s:1:\"a\";i:136;s:1:\"b\";s:14:\"gallery-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:101;a:5:{s:1:\"a\";i:137;s:1:\"b\";s:12:\"gallery-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:102;a:5:{s:1:\"a\";i:138;s:1:\"b\";s:14:\"gallery-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:103;a:5:{s:1:\"a\";i:139;s:1:\"b\";s:9:\"team-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:104;a:5:{s:1:\"a\";i:140;s:1:\"b\";s:11:\"team-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:105;a:5:{s:1:\"a\";i:141;s:1:\"b\";s:9:\"team-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:106;a:5:{s:1:\"a\";i:142;s:1:\"b\";s:11:\"team-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:107;a:5:{s:1:\"a\";i:143;s:1:\"b\";s:12:\"service-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:108;a:5:{s:1:\"a\";i:144;s:1:\"b\";s:14:\"service-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:109;a:5:{s:1:\"a\";i:145;s:1:\"b\";s:12:\"service-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:110;a:5:{s:1:\"a\";i:146;s:1:\"b\";s:14:\"service-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:111;a:5:{s:1:\"a\";i:147;s:1:\"b\";s:18:\"productimages-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:112;a:5:{s:1:\"a\";i:148;s:1:\"b\";s:20:\"productimages-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:113;a:5:{s:1:\"a\";i:149;s:1:\"b\";s:18:\"productimages-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:114;a:5:{s:1:\"a\";i:150;s:1:\"b\";s:20:\"productimages-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:115;a:5:{s:1:\"a\";i:155;s:1:\"b\";s:19:\"backupdatabase-list\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:116;a:5:{s:1:\"a\";i:156;s:1:\"b\";s:21:\"backupdatabase-create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:117;a:5:{s:1:\"a\";i:157;s:1:\"b\";s:19:\"backupdatabase-edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:118;a:5:{s:1:\"a\";i:158;s:1:\"b\";s:21:\"backupdatabase-delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:8:\"Pengguna\";s:1:\"c\";s:3:\"web\";}}}',1738942085);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cash`
--

DROP TABLE IF EXISTS `cash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cash` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash`
--

LOCK TABLES `cash` WRITE;
/*!40000 ALTER TABLE `cash` DISABLE KEYS */;
INSERT INTO `cash` VALUES (1,'Kas Toko',-915300,'2024-11-24 07:27:30','2025-01-31 02:25:07'),(2,'Bank BSI',478200,'2024-11-24 07:27:43','2024-12-27 08:55:54');
/*!40000 ALTER TABLE `cash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Makanan','Kategori Makanan','PKL.png',NULL,'2024-11-22 23:53:12','2025-02-01 01:35:27'),(2,'Minuman','Kategori Minuman',NULL,NULL,'2024-11-22 23:53:24','2024-11-22 23:54:06'),(3,'Cemilan','Kategori Cemilan',NULL,NULL,'2024-11-22 23:53:35','2024-11-22 23:53:35'),(4,'Aksesoris',NULL,NULL,NULL,'2024-11-30 03:19:48','2024-11-30 03:19:48'),(5,'Alat Tulis Kantor','Alat Tulis Kantor Terlengkap',NULL,NULL,'2024-12-04 03:27:24','2024-12-04 03:27:24');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_categories`
--

DROP TABLE IF EXISTS `customer_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_categories`
--

LOCK TABLES `customer_categories` WRITE;
/*!40000 ALTER TABLE `customer_categories` DISABLE KEYS */;
INSERT INTO `customer_categories` VALUES (1,'Pengguna Umum','2024-11-23 10:09:59','2024-11-23 10:10:00'),(2,'Member','2024-11-23 10:10:22','2024-11-23 10:10:23');
/*!40000 ALTER TABLE `customer_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_category_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`),
  KEY `customers_customer_category_id_foreign` (`customer_category_id`),
  CONSTRAINT `customers_customer_category_id_foreign` FOREIGN KEY (`customer_category_id`) REFERENCES `customer_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Pelanggan Umum','pelanggan@gmail.com','0000000',1,'2024-11-28 03:48:29','2024-11-28 03:48:30'),(2,'Rudi Turmudzi','rudi@gmail.com','0000000',2,'2024-11-28 03:48:59','2024-11-28 03:48:59'),(3,'Maryam Layla Alfathunissa','alfathunissamaryamlayla@gmail.com','0000000',2,'2024-12-02 08:17:20','2024-12-02 08:33:16');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES (3,'Koperasi Satu',NULL,NULL,'20250204153509_Ruang_Inspirasi_Saung_Ojo.webp',NULL,'2025-02-04 08:35:10','2025-02-04 08:35:10');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_histories`
--

DROP TABLE IF EXISTS `log_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Tabel_Asal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ID_Entitas` bigint unsigned DEFAULT NULL,
  `Aksi` enum('Create','Read','Update','Delete') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Waktu` timestamp NULL DEFAULT NULL,
  `Pengguna` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Data_Lama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `Data_Baru` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1247 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_histories`
--

LOCK TABLES `log_histories` WRITE;
/*!40000 ALTER TABLE `log_histories` DISABLE KEYS */;
INSERT INTO `log_histories` VALUES (1227,'Permission',151,'Create','2025-02-06 07:09:44','1',NULL,'{\"name\":\"backup-list\",\"urutan\":null,\"guard_name\":\"web\",\"updated_at\":\"2025-02-06T14:09:44.000000Z\",\"created_at\":\"2025-02-06T14:09:44.000000Z\",\"id\":151}','2025-02-06 07:09:44','2025-02-06 07:09:44'),(1228,'Permission',152,'Create','2025-02-06 07:10:02','1',NULL,'{\"name\":\"backup-create\",\"urutan\":null,\"guard_name\":\"web\",\"updated_at\":\"2025-02-06T14:10:02.000000Z\",\"created_at\":\"2025-02-06T14:10:02.000000Z\",\"id\":152}','2025-02-06 07:10:02','2025-02-06 07:10:02'),(1229,'Permission',153,'Create','2025-02-06 07:10:15','1',NULL,'{\"name\":\"backup-edit\",\"urutan\":null,\"guard_name\":\"web\",\"updated_at\":\"2025-02-06T14:10:15.000000Z\",\"created_at\":\"2025-02-06T14:10:15.000000Z\",\"id\":153}','2025-02-06 07:10:15','2025-02-06 07:10:15'),(1230,'Permission',154,'Create','2025-02-06 07:10:25','1',NULL,'{\"name\":\"backup-delete\",\"urutan\":null,\"guard_name\":\"web\",\"updated_at\":\"2025-02-06T14:10:25.000000Z\",\"created_at\":\"2025-02-06T14:10:25.000000Z\",\"id\":154}','2025-02-06 07:10:25','2025-02-06 07:10:25'),(1231,'Role',1,'Update','2025-02-06 07:18:11','1','{\"name\":\"Admin\",\"permissions\":[\"user-list\",\"user-create\",\"user-edit\",\"user-delete\",\"permission-list\",\"permission-create\",\"permission-edit\",\"permission-delete\",\"role-list\",\"role-create\",\"role-edit\",\"role-delete\",\"profil-list\",\"general-list\",\"dashboard-list\",\"pengaturan-list\",\"menugroup-list\",\"menugroup-create\",\"menugroup-edit\",\"menugroup-delete\",\"master-list\",\"blog-list\",\"menuitem-list\",\"menuitem-create\",\"menuitem-edit\",\"menuitem-delete\",\"profil-edit\",\"create-resource\",\"loghistori-list\",\"loghistori-deleteall\",\"advance-list\",\"route-list\",\"route-create\",\"menu-list\",\"permissionrole-list\",\"unit-list\",\"unit-create\",\"unit-edit\",\"unit-delete\",\"category-list\",\"category-create\",\"category-edit\",\"category-delete\",\"product-list\",\"product-create\",\"product-edit\",\"product-delete\",\"supplier-list\",\"supplier-create\",\"supplier-edit\",\"supplier-delete\",\"purchase-list\",\"purchase-create\",\"purchase-edit\",\"purchase-delete\",\"cash-list\",\"cash-edit\",\"cash-create\",\"cash-delete\",\"transact-list\",\"order-list\",\"order-create\",\"order-edit\",\"order-delete\",\"customer-list\",\"customer-create\",\"customer-edit\",\"customer-delete\",\"transactioncategory-list\",\"transactioncategory-create\",\"transactioncategory-edit\",\"transactioncategory-delete\",\"transaction-list\",\"transaction-create\",\"transaction-edit\",\"transaction-delete\",\"stockopname-list\",\"stockopname-create\",\"stockopname-edit\",\"stockopname-delete\",\"adjustment-list\",\"adjustment-create\",\"adjustment-edit\",\"adjustment-delete\",\"report-list\",\"purchasereport-list\",\"orderreport-list\",\"productreport-list\",\"profitreport-list\",\"topproductreport-list\",\"slider-list\",\"slider-create\",\"slider-edit\",\"slider-delete\",\"testimony-list\",\"testimony-create\",\"testimony-edit\",\"testimony-delete\",\"depan-index\",\"gallery-list\",\"gallery-create\",\"gallery-edit\",\"gallery-delete\",\"team-list\",\"team-create\",\"team-edit\",\"team-delete\",\"service-list\",\"service-create\",\"service-edit\",\"service-delete\",\"productimages-list\",\"productimages-create\",\"productimages-edit\",\"productimages-delete\"]}','{\"name\":\"Admin\",\"permissions\":[\"user-list\",\"user-create\",\"user-edit\",\"user-delete\",\"permission-list\",\"permission-create\",\"permission-edit\",\"permission-delete\",\"role-list\",\"role-create\",\"role-edit\",\"role-delete\",\"profil-list\",\"general-list\",\"dashboard-list\",\"pengaturan-list\",\"menugroup-list\",\"menugroup-create\",\"menugroup-edit\",\"menugroup-delete\",\"master-list\",\"blog-list\",\"menuitem-list\",\"menuitem-create\",\"menuitem-edit\",\"menuitem-delete\",\"profil-edit\",\"create-resource\",\"loghistori-list\",\"loghistori-deleteall\",\"advance-list\",\"route-list\",\"route-create\",\"menu-list\",\"permissionrole-list\",\"unit-list\",\"unit-create\",\"unit-edit\",\"unit-delete\",\"category-list\",\"category-create\",\"category-edit\",\"category-delete\",\"product-list\",\"product-create\",\"product-edit\",\"product-delete\",\"supplier-list\",\"supplier-create\",\"supplier-edit\",\"supplier-delete\",\"purchase-list\",\"purchase-create\",\"purchase-edit\",\"purchase-delete\",\"cash-list\",\"cash-edit\",\"cash-create\",\"cash-delete\",\"transact-list\",\"order-list\",\"order-create\",\"order-edit\",\"order-delete\",\"customer-list\",\"customer-create\",\"customer-edit\",\"customer-delete\",\"transactioncategory-list\",\"transactioncategory-create\",\"transactioncategory-edit\",\"transactioncategory-delete\",\"transaction-list\",\"transaction-create\",\"transaction-edit\",\"transaction-delete\",\"stockopname-list\",\"stockopname-create\",\"stockopname-edit\",\"stockopname-delete\",\"adjustment-list\",\"adjustment-create\",\"adjustment-edit\",\"adjustment-delete\",\"report-list\",\"purchasereport-list\",\"orderreport-list\",\"productreport-list\",\"profitreport-list\",\"topproductreport-list\",\"slider-list\",\"slider-create\",\"slider-edit\",\"slider-delete\",\"testimony-list\",\"testimony-create\",\"testimony-edit\",\"testimony-delete\",\"depan-index\",\"gallery-list\",\"gallery-create\",\"gallery-edit\",\"gallery-delete\",\"team-list\",\"team-create\",\"team-edit\",\"team-delete\",\"service-list\",\"service-create\",\"service-edit\",\"service-delete\",\"productimages-list\",\"productimages-create\",\"productimages-edit\",\"productimages-delete\",\"backup-list\",\"backup-create\",\"backup-edit\",\"backup-delete\"]}','2025-02-06 07:18:11','2025-02-06 07:18:11'),(1232,'Menu Item',50,'Create','2025-02-06 07:19:07','1',NULL,'{\"name\":\"Back Up\",\"icon\":\"fas fa-database\",\"route\":\"backup.index\",\"permission_name\":\"backup-list\",\"status\":\"Aktif\",\"position\":\"1\",\"menu_group_id\":\"3\",\"parent_id\":null,\"updated_at\":\"2025-02-06T14:19:07.000000Z\",\"created_at\":\"2025-02-06T14:19:07.000000Z\",\"id\":50}','2025-02-06 07:19:07','2025-02-06 07:19:07'),(1233,'Role',1,'Update','2025-02-06 07:40:58','1','{\"name\":\"Admin\",\"permissions\":[\"user-list\",\"user-create\",\"user-edit\",\"user-delete\",\"permission-list\",\"permission-create\",\"permission-edit\",\"permission-delete\",\"role-list\",\"role-create\",\"role-edit\",\"role-delete\",\"profil-list\",\"general-list\",\"dashboard-list\",\"pengaturan-list\",\"menugroup-list\",\"menugroup-create\",\"menugroup-edit\",\"menugroup-delete\",\"master-list\",\"blog-list\",\"menuitem-list\",\"menuitem-create\",\"menuitem-edit\",\"menuitem-delete\",\"profil-edit\",\"create-resource\",\"loghistori-list\",\"loghistori-deleteall\",\"advance-list\",\"route-list\",\"route-create\",\"menu-list\",\"permissionrole-list\",\"unit-list\",\"unit-create\",\"unit-edit\",\"unit-delete\",\"category-list\",\"category-create\",\"category-edit\",\"category-delete\",\"product-list\",\"product-create\",\"product-edit\",\"product-delete\",\"supplier-list\",\"supplier-create\",\"supplier-edit\",\"supplier-delete\",\"purchase-list\",\"purchase-create\",\"purchase-edit\",\"purchase-delete\",\"cash-list\",\"cash-edit\",\"cash-create\",\"cash-delete\",\"transact-list\",\"order-list\",\"order-create\",\"order-edit\",\"order-delete\",\"customer-list\",\"customer-create\",\"customer-edit\",\"customer-delete\",\"transactioncategory-list\",\"transactioncategory-create\",\"transactioncategory-edit\",\"transactioncategory-delete\",\"transaction-list\",\"transaction-create\",\"transaction-edit\",\"transaction-delete\",\"stockopname-list\",\"stockopname-create\",\"stockopname-edit\",\"stockopname-delete\",\"adjustment-list\",\"adjustment-create\",\"adjustment-edit\",\"adjustment-delete\",\"report-list\",\"purchasereport-list\",\"orderreport-list\",\"productreport-list\",\"profitreport-list\",\"topproductreport-list\",\"slider-list\",\"slider-create\",\"slider-edit\",\"slider-delete\",\"testimony-list\",\"testimony-create\",\"testimony-edit\",\"testimony-delete\",\"depan-index\",\"gallery-list\",\"gallery-create\",\"gallery-edit\",\"gallery-delete\",\"team-list\",\"team-create\",\"team-edit\",\"team-delete\",\"service-list\",\"service-create\",\"service-edit\",\"service-delete\",\"productimages-list\",\"productimages-create\",\"productimages-edit\",\"productimages-delete\",\"backup-list\",\"backup-create\",\"backup-edit\",\"backup-delete\"]}','{\"name\":\"Admin\",\"permissions\":[\"user-list\",\"user-create\",\"user-edit\",\"user-delete\",\"permission-list\",\"permission-create\",\"permission-edit\",\"permission-delete\",\"role-list\",\"role-create\",\"role-edit\",\"role-delete\",\"profil-list\",\"general-list\",\"dashboard-list\",\"pengaturan-list\",\"menugroup-list\",\"menugroup-create\",\"menugroup-edit\",\"menugroup-delete\",\"master-list\",\"blog-list\",\"menuitem-list\",\"menuitem-create\",\"menuitem-edit\",\"menuitem-delete\",\"profil-edit\",\"create-resource\",\"loghistori-list\",\"loghistori-deleteall\",\"advance-list\",\"route-list\",\"route-create\",\"menu-list\",\"permissionrole-list\",\"unit-list\",\"unit-create\",\"unit-edit\",\"unit-delete\",\"category-list\",\"category-create\",\"category-edit\",\"category-delete\",\"product-list\",\"product-create\",\"product-edit\",\"product-delete\",\"supplier-list\",\"supplier-create\",\"supplier-edit\",\"supplier-delete\",\"purchase-list\",\"purchase-create\",\"purchase-edit\",\"purchase-delete\",\"cash-list\",\"cash-edit\",\"cash-create\",\"cash-delete\",\"transact-list\",\"order-list\",\"order-create\",\"order-edit\",\"order-delete\",\"customer-list\",\"customer-create\",\"customer-edit\",\"customer-delete\",\"transactioncategory-list\",\"transactioncategory-create\",\"transactioncategory-edit\",\"transactioncategory-delete\",\"transaction-list\",\"transaction-create\",\"transaction-edit\",\"transaction-delete\",\"stockopname-list\",\"stockopname-create\",\"stockopname-edit\",\"stockopname-delete\",\"adjustment-list\",\"adjustment-create\",\"adjustment-edit\",\"adjustment-delete\",\"report-list\",\"purchasereport-list\",\"orderreport-list\",\"productreport-list\",\"profitreport-list\",\"topproductreport-list\",\"slider-list\",\"slider-create\",\"slider-edit\",\"slider-delete\",\"testimony-list\",\"testimony-create\",\"testimony-edit\",\"testimony-delete\",\"depan-index\",\"gallery-list\",\"gallery-create\",\"gallery-edit\",\"gallery-delete\",\"team-list\",\"team-create\",\"team-edit\",\"team-delete\",\"service-list\",\"service-create\",\"service-edit\",\"service-delete\",\"productimages-list\",\"productimages-create\",\"productimages-edit\",\"productimages-delete\",\"backup-list\",\"backup-create\",\"backup-edit\",\"backup-delete\"]}','2025-02-06 07:40:58','2025-02-06 07:40:58'),(1234,'Menu Item',50,'Update','2025-02-06 07:43:03','1','{\"id\":50,\"name\":\"Back Up\",\"icon\":\"fas fa-database\",\"route\":\"backup.index\",\"status\":\"Aktif\",\"permission_name\":\"backup-list\",\"menu_group_id\":3,\"position\":1,\"parent_id\":null,\"created_at\":\"2025-02-06T14:19:07.000000Z\",\"updated_at\":\"2025-02-06T14:19:07.000000Z\"}','{\"id\":50,\"name\":\"Back Up\",\"icon\":\"fas fa-database\",\"route\":\"backup.index\",\"status\":\"Aktif\",\"permission_name\":\"backup-list\",\"menu_group_id\":\"3\",\"position\":\"1\",\"parent_id\":null,\"created_at\":\"2025-02-06T14:19:07.000000Z\",\"updated_at\":\"2025-02-06T14:19:07.000000Z\"}','2025-02-06 07:43:03','2025-02-06 07:43:03'),(1235,'Permission',151,'Delete','2025-02-06 07:49:56','1','{\"id\":151,\"name\":\"backup-list\",\"guard_name\":\"web\",\"urutan\":null,\"created_at\":\"2025-02-06T14:09:44.000000Z\",\"updated_at\":\"2025-02-06T14:09:44.000000Z\"}',NULL,'2025-02-06 07:49:56','2025-02-06 07:49:56'),(1236,'Menu Item',50,'Delete','2025-02-06 07:50:40','1','{\"id\":50,\"name\":\"Back Up\",\"icon\":\"fas fa-database\",\"route\":\"backup.index\",\"status\":\"Aktif\",\"permission_name\":\"backup-list\",\"menu_group_id\":3,\"position\":1,\"parent_id\":null,\"created_at\":\"2025-02-06T14:19:07.000000Z\",\"updated_at\":\"2025-02-06T14:19:07.000000Z\"}',NULL,'2025-02-06 07:50:40','2025-02-06 07:50:40'),(1237,'Permission',152,'Delete','2025-02-06 07:50:54','1','{\"id\":152,\"name\":\"backup-create\",\"guard_name\":\"web\",\"urutan\":null,\"created_at\":\"2025-02-06T14:10:02.000000Z\",\"updated_at\":\"2025-02-06T14:10:02.000000Z\"}',NULL,'2025-02-06 07:50:54','2025-02-06 07:50:54'),(1238,'Permission',153,'Delete','2025-02-06 07:51:01','1','{\"id\":153,\"name\":\"backup-edit\",\"guard_name\":\"web\",\"urutan\":null,\"created_at\":\"2025-02-06T14:10:15.000000Z\",\"updated_at\":\"2025-02-06T14:10:15.000000Z\"}',NULL,'2025-02-06 07:51:01','2025-02-06 07:51:01'),(1239,'Permission',154,'Delete','2025-02-06 07:51:08','1','{\"id\":154,\"name\":\"backup-delete\",\"guard_name\":\"web\",\"urutan\":null,\"created_at\":\"2025-02-06T14:10:25.000000Z\",\"updated_at\":\"2025-02-06T14:10:25.000000Z\"}',NULL,'2025-02-06 07:51:08','2025-02-06 07:51:08'),(1240,'Permission',155,'Create','2025-02-06 07:54:17','1',NULL,'{\"name\":\"backupdatabase-list\",\"urutan\":null,\"guard_name\":\"web\",\"updated_at\":\"2025-02-06T14:54:17.000000Z\",\"created_at\":\"2025-02-06T14:54:17.000000Z\",\"id\":155}','2025-02-06 07:54:17','2025-02-06 07:54:17'),(1241,'Role',1,'Update','2025-02-06 07:54:39','1','{\"name\":\"Admin\",\"permissions\":[\"user-list\",\"user-create\",\"user-edit\",\"user-delete\",\"permission-list\",\"permission-create\",\"permission-edit\",\"permission-delete\",\"role-list\",\"role-create\",\"role-edit\",\"role-delete\",\"profil-list\",\"general-list\",\"dashboard-list\",\"pengaturan-list\",\"menugroup-list\",\"menugroup-create\",\"menugroup-edit\",\"menugroup-delete\",\"master-list\",\"blog-list\",\"menuitem-list\",\"menuitem-create\",\"menuitem-edit\",\"menuitem-delete\",\"profil-edit\",\"create-resource\",\"loghistori-list\",\"loghistori-deleteall\",\"advance-list\",\"route-list\",\"route-create\",\"menu-list\",\"permissionrole-list\",\"unit-list\",\"unit-create\",\"unit-edit\",\"unit-delete\",\"category-list\",\"category-create\",\"category-edit\",\"category-delete\",\"product-list\",\"product-create\",\"product-edit\",\"product-delete\",\"supplier-list\",\"supplier-create\",\"supplier-edit\",\"supplier-delete\",\"purchase-list\",\"purchase-create\",\"purchase-edit\",\"purchase-delete\",\"cash-list\",\"cash-edit\",\"cash-create\",\"cash-delete\",\"transact-list\",\"order-list\",\"order-create\",\"order-edit\",\"order-delete\",\"customer-list\",\"customer-create\",\"customer-edit\",\"customer-delete\",\"transactioncategory-list\",\"transactioncategory-create\",\"transactioncategory-edit\",\"transactioncategory-delete\",\"transaction-list\",\"transaction-create\",\"transaction-edit\",\"transaction-delete\",\"stockopname-list\",\"stockopname-create\",\"stockopname-edit\",\"stockopname-delete\",\"adjustment-list\",\"adjustment-create\",\"adjustment-edit\",\"adjustment-delete\",\"report-list\",\"purchasereport-list\",\"orderreport-list\",\"productreport-list\",\"profitreport-list\",\"topproductreport-list\",\"slider-list\",\"slider-create\",\"slider-edit\",\"slider-delete\",\"testimony-list\",\"testimony-create\",\"testimony-edit\",\"testimony-delete\",\"depan-index\",\"gallery-list\",\"gallery-create\",\"gallery-edit\",\"gallery-delete\",\"team-list\",\"team-create\",\"team-edit\",\"team-delete\",\"service-list\",\"service-create\",\"service-edit\",\"service-delete\",\"productimages-list\",\"productimages-create\",\"productimages-edit\",\"productimages-delete\"]}','{\"name\":\"Admin\",\"permissions\":[\"user-list\",\"user-create\",\"user-edit\",\"user-delete\",\"permission-list\",\"permission-create\",\"permission-edit\",\"permission-delete\",\"role-list\",\"role-create\",\"role-edit\",\"role-delete\",\"profil-list\",\"general-list\",\"dashboard-list\",\"pengaturan-list\",\"menugroup-list\",\"menugroup-create\",\"menugroup-edit\",\"menugroup-delete\",\"master-list\",\"blog-list\",\"menuitem-list\",\"menuitem-create\",\"menuitem-edit\",\"menuitem-delete\",\"profil-edit\",\"create-resource\",\"loghistori-list\",\"loghistori-deleteall\",\"advance-list\",\"route-list\",\"route-create\",\"menu-list\",\"permissionrole-list\",\"unit-list\",\"unit-create\",\"unit-edit\",\"unit-delete\",\"category-list\",\"category-create\",\"category-edit\",\"category-delete\",\"product-list\",\"product-create\",\"product-edit\",\"product-delete\",\"supplier-list\",\"supplier-create\",\"supplier-edit\",\"supplier-delete\",\"purchase-list\",\"purchase-create\",\"purchase-edit\",\"purchase-delete\",\"cash-list\",\"cash-edit\",\"cash-create\",\"cash-delete\",\"transact-list\",\"order-list\",\"order-create\",\"order-edit\",\"order-delete\",\"customer-list\",\"customer-create\",\"customer-edit\",\"customer-delete\",\"transactioncategory-list\",\"transactioncategory-create\",\"transactioncategory-edit\",\"transactioncategory-delete\",\"transaction-list\",\"transaction-create\",\"transaction-edit\",\"transaction-delete\",\"stockopname-list\",\"stockopname-create\",\"stockopname-edit\",\"stockopname-delete\",\"adjustment-list\",\"adjustment-create\",\"adjustment-edit\",\"adjustment-delete\",\"report-list\",\"purchasereport-list\",\"orderreport-list\",\"productreport-list\",\"profitreport-list\",\"topproductreport-list\",\"slider-list\",\"slider-create\",\"slider-edit\",\"slider-delete\",\"testimony-list\",\"testimony-create\",\"testimony-edit\",\"testimony-delete\",\"depan-index\",\"gallery-list\",\"gallery-create\",\"gallery-edit\",\"gallery-delete\",\"team-list\",\"team-create\",\"team-edit\",\"team-delete\",\"service-list\",\"service-create\",\"service-edit\",\"service-delete\",\"productimages-list\",\"productimages-create\",\"productimages-edit\",\"productimages-delete\",\"backupdatabase-list\"]}','2025-02-06 07:54:39','2025-02-06 07:54:39'),(1242,'Menu Item',51,'Create','2025-02-06 07:56:13','1',NULL,'{\"name\":\"Back Up Database\",\"icon\":\"fas fa-database\",\"route\":\"backupdatabase.index\",\"permission_name\":\"backupdatabase-list\",\"status\":\"Aktif\",\"position\":\"1\",\"menu_group_id\":\"3\",\"parent_id\":null,\"updated_at\":\"2025-02-06T14:56:13.000000Z\",\"created_at\":\"2025-02-06T14:56:13.000000Z\",\"id\":51}','2025-02-06 07:56:13','2025-02-06 07:56:13'),(1243,'Permission',156,'Create','2025-02-06 08:27:10','1',NULL,'{\"name\":\"backupdatabase-create\",\"urutan\":null,\"guard_name\":\"web\",\"updated_at\":\"2025-02-06T15:27:10.000000Z\",\"created_at\":\"2025-02-06T15:27:10.000000Z\",\"id\":156}','2025-02-06 08:27:10','2025-02-06 08:27:10'),(1244,'Permission',157,'Create','2025-02-06 08:27:20','1',NULL,'{\"name\":\"backupdatabase-edit\",\"urutan\":null,\"guard_name\":\"web\",\"updated_at\":\"2025-02-06T15:27:19.000000Z\",\"created_at\":\"2025-02-06T15:27:19.000000Z\",\"id\":157}','2025-02-06 08:27:20','2025-02-06 08:27:20'),(1245,'Permission',158,'Create','2025-02-06 08:27:30','1',NULL,'{\"name\":\"backupdatabase-delete\",\"urutan\":null,\"guard_name\":\"web\",\"updated_at\":\"2025-02-06T15:27:30.000000Z\",\"created_at\":\"2025-02-06T15:27:30.000000Z\",\"id\":158}','2025-02-06 08:27:30','2025-02-06 08:27:30'),(1246,'Role',1,'Update','2025-02-06 08:28:06','1','{\"name\":\"Admin\",\"permissions\":[\"user-list\",\"user-create\",\"user-edit\",\"user-delete\",\"permission-list\",\"permission-create\",\"permission-edit\",\"permission-delete\",\"role-list\",\"role-create\",\"role-edit\",\"role-delete\",\"profil-list\",\"general-list\",\"dashboard-list\",\"pengaturan-list\",\"menugroup-list\",\"menugroup-create\",\"menugroup-edit\",\"menugroup-delete\",\"master-list\",\"blog-list\",\"menuitem-list\",\"menuitem-create\",\"menuitem-edit\",\"menuitem-delete\",\"profil-edit\",\"create-resource\",\"loghistori-list\",\"loghistori-deleteall\",\"advance-list\",\"route-list\",\"route-create\",\"menu-list\",\"permissionrole-list\",\"unit-list\",\"unit-create\",\"unit-edit\",\"unit-delete\",\"category-list\",\"category-create\",\"category-edit\",\"category-delete\",\"product-list\",\"product-create\",\"product-edit\",\"product-delete\",\"supplier-list\",\"supplier-create\",\"supplier-edit\",\"supplier-delete\",\"purchase-list\",\"purchase-create\",\"purchase-edit\",\"purchase-delete\",\"cash-list\",\"cash-edit\",\"cash-create\",\"cash-delete\",\"transact-list\",\"order-list\",\"order-create\",\"order-edit\",\"order-delete\",\"customer-list\",\"customer-create\",\"customer-edit\",\"customer-delete\",\"transactioncategory-list\",\"transactioncategory-create\",\"transactioncategory-edit\",\"transactioncategory-delete\",\"transaction-list\",\"transaction-create\",\"transaction-edit\",\"transaction-delete\",\"stockopname-list\",\"stockopname-create\",\"stockopname-edit\",\"stockopname-delete\",\"adjustment-list\",\"adjustment-create\",\"adjustment-edit\",\"adjustment-delete\",\"report-list\",\"purchasereport-list\",\"orderreport-list\",\"productreport-list\",\"profitreport-list\",\"topproductreport-list\",\"slider-list\",\"slider-create\",\"slider-edit\",\"slider-delete\",\"testimony-list\",\"testimony-create\",\"testimony-edit\",\"testimony-delete\",\"depan-index\",\"gallery-list\",\"gallery-create\",\"gallery-edit\",\"gallery-delete\",\"team-list\",\"team-create\",\"team-edit\",\"team-delete\",\"service-list\",\"service-create\",\"service-edit\",\"service-delete\",\"productimages-list\",\"productimages-create\",\"productimages-edit\",\"productimages-delete\",\"backupdatabase-list\"]}','{\"name\":\"Admin\",\"permissions\":[\"user-list\",\"user-create\",\"user-edit\",\"user-delete\",\"permission-list\",\"permission-create\",\"permission-edit\",\"permission-delete\",\"role-list\",\"role-create\",\"role-edit\",\"role-delete\",\"profil-list\",\"general-list\",\"dashboard-list\",\"pengaturan-list\",\"menugroup-list\",\"menugroup-create\",\"menugroup-edit\",\"menugroup-delete\",\"master-list\",\"blog-list\",\"menuitem-list\",\"menuitem-create\",\"menuitem-edit\",\"menuitem-delete\",\"profil-edit\",\"create-resource\",\"loghistori-list\",\"loghistori-deleteall\",\"advance-list\",\"route-list\",\"route-create\",\"menu-list\",\"permissionrole-list\",\"unit-list\",\"unit-create\",\"unit-edit\",\"unit-delete\",\"category-list\",\"category-create\",\"category-edit\",\"category-delete\",\"product-list\",\"product-create\",\"product-edit\",\"product-delete\",\"supplier-list\",\"supplier-create\",\"supplier-edit\",\"supplier-delete\",\"purchase-list\",\"purchase-create\",\"purchase-edit\",\"purchase-delete\",\"cash-list\",\"cash-edit\",\"cash-create\",\"cash-delete\",\"transact-list\",\"order-list\",\"order-create\",\"order-edit\",\"order-delete\",\"customer-list\",\"customer-create\",\"customer-edit\",\"customer-delete\",\"transactioncategory-list\",\"transactioncategory-create\",\"transactioncategory-edit\",\"transactioncategory-delete\",\"transaction-list\",\"transaction-create\",\"transaction-edit\",\"transaction-delete\",\"stockopname-list\",\"stockopname-create\",\"stockopname-edit\",\"stockopname-delete\",\"adjustment-list\",\"adjustment-create\",\"adjustment-edit\",\"adjustment-delete\",\"report-list\",\"purchasereport-list\",\"orderreport-list\",\"productreport-list\",\"profitreport-list\",\"topproductreport-list\",\"slider-list\",\"slider-create\",\"slider-edit\",\"slider-delete\",\"testimony-list\",\"testimony-create\",\"testimony-edit\",\"testimony-delete\",\"depan-index\",\"gallery-list\",\"gallery-create\",\"gallery-edit\",\"gallery-delete\",\"team-list\",\"team-create\",\"team-edit\",\"team-delete\",\"service-list\",\"service-create\",\"service-edit\",\"service-delete\",\"productimages-list\",\"productimages-create\",\"productimages-edit\",\"productimages-delete\",\"backupdatabase-list\",\"backupdatabase-create\",\"backupdatabase-edit\",\"backupdatabase-delete\"]}','2025-02-06 08:28:06','2025-02-06 08:28:06');
/*!40000 ALTER TABLE `log_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_groups`
--

DROP TABLE IF EXISTS `menu_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_groups`
--

LOCK TABLES `menu_groups` WRITE;
/*!40000 ALTER TABLE `menu_groups` DISABLE KEYS */;
INSERT INTO `menu_groups` VALUES (2,'General','Aktif','general-list',1,'2024-11-11 00:20:07','2024-12-28 01:14:38'),(3,'Setting','Aktif','pengaturan-list',6,'2024-11-11 00:20:07','2024-12-15 16:49:33'),(5,'Master','Aktif','master-list',2,'2024-11-11 02:56:39','2024-12-28 01:14:38'),(6,'Advance','Aktif','advance-list',5,'2024-11-12 03:25:33','2024-12-15 16:49:33'),(10,'Transaksi','Aktif','transaction-list',3,'2024-11-25 02:04:51','2024-11-25 02:07:19'),(11,'Laporan','Aktif','report-list',4,'2024-12-15 16:49:21','2024-12-15 20:22:07');
/*!40000 ALTER TABLE `menu_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_group_id` bigint unsigned NOT NULL,
  `position` int NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_group_id_foreign` (`menu_group_id`),
  KEY `menu_items_parent_id_foreign` (`parent_id`),
  CONSTRAINT `menu_items_menu_group_id_foreign` FOREIGN KEY (`menu_group_id`) REFERENCES `menu_groups` (`id`),
  CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (2,'Dashboard','fa fa-address-book','home','Aktif','dashboard-list',2,1,NULL,'2024-11-11 00:20:07','2025-02-06 03:56:00'),(3,'User','fa fa-address-book','users.index','Aktif','user-list',6,30,NULL,'2024-11-11 00:20:07','2025-01-27 02:41:26'),(4,'Role','ti ti-layout-grid','roles.index','Aktif','role-list',3,2,20,'2024-11-11 00:20:07','2024-11-15 04:50:24'),(5,'Permission','ti ti-menu','permissions.index','Aktif','permission-list',3,1,20,'2024-11-11 00:20:07','2024-11-15 04:50:24'),(6,'Menu Group','ti ti-package','menu_groups.index','Aktif','menugroup-list',3,7,19,'2024-11-11 07:48:06','2024-11-13 01:41:20'),(8,'Menu Item','ti ti-layout','menu_items.index','Aktif','menuitem-list',3,8,19,'2024-11-11 10:17:52','2024-11-13 01:41:47'),(13,'Profil','fa fa-university','profil.index','Aktif','profil-list',6,29,NULL,'2024-11-11 09:11:45','2025-01-27 02:41:12'),(14,'Modul','fa fa-book','resource.create','Aktif','create-resource',3,23,NULL,'2024-11-11 11:34:58','2025-02-03 01:10:14'),(15,'Log Histori','fa fa-history','log_histori.index','Aktif','loghistori-list',6,30,NULL,'2024-11-12 02:35:41','2024-12-25 06:34:17'),(18,'Generate Route','fa fa-truck','routes.index','Aktif','route-list',3,24,NULL,'2024-11-13 00:49:17','2025-02-03 01:10:14'),(19,'Menu','fa fa-bullseye','menu_items.index','Aktif','menu-list',3,21,NULL,'2024-11-13 01:40:48','2025-02-03 01:10:14'),(20,'Permission & Role','fa fa-server','permissions.index','Aktif','permissionrole-list',3,22,NULL,'2024-11-13 01:46:20','2025-02-03 01:10:14'),(23,'Produk','fa fa-cubes','products.index','Aktif','product-list',5,29,NULL,'2024-11-16 21:12:57','2025-02-03 01:10:14'),(27,'Satuan','ti ti-tag','units.index','Aktif','unit-list',5,3,23,'2024-11-22 22:55:52','2024-11-25 01:58:52'),(28,'Kategori Produk','ti ti-files','categories.index','Aktif','category-list',5,5,23,'2024-11-22 23:46:27','2024-11-25 01:58:36'),(29,'Supplier','fa fa-user-circle','suppliers.index','Aktif','supplier-list',5,25,NULL,'2024-11-23 21:11:56','2025-02-03 01:10:14'),(30,'Pembelian','fas fa-shopping-cart','purchases.index','Aktif','purchase-list',10,30,NULL,'2024-11-23 23:06:05','2025-01-27 02:41:35'),(31,'Kas','fa fa-gift','cash.index','Aktif','cash-list',6,30,NULL,'2024-11-25 01:35:22','2025-01-27 02:41:12'),(32,'Data Produk','ti ti-brand-blogger','products.index','Aktif','product-list',5,7,23,'2024-11-25 01:57:59','2024-11-25 01:59:07'),(33,'Penjualan','fas fa-cart-plus','orders.index','Aktif','order-list',10,30,NULL,'2024-11-26 22:46:26','2025-02-03 01:10:14'),(34,'Pelanggan','fa fa-user','customers.index','Aktif','customer-list',5,26,NULL,'2024-12-02 08:09:24','2025-02-03 01:10:14'),(35,'Kategori Transaksi','fa fa-adjust','transaction_categories.index','Aktif','transactioncategory-list',10,27,NULL,'2024-12-02 21:02:32','2025-02-03 01:10:14'),(36,'Transaksi','fas fa-database','transactions.index','Aktif','transaction-list',10,28,NULL,'2024-12-03 01:01:37','2025-02-03 01:10:14'),(37,'Stock Opname','fa fa-podcast','stock_opname.index','Aktif','stockopname-list',10,19,NULL,'2024-12-10 09:14:13','2025-02-03 01:10:14'),(38,'Adjustment','fa fa-battery-full','adjustments.index','Aktif','adjustment-list',10,20,NULL,'2024-12-12 03:42:04','2025-02-03 01:10:14'),(39,'Laporan Pembelian','fa fa-file','report.purchase_reports','Aktif','purchasereport-list',11,15,NULL,'2024-12-15 17:44:06','2025-02-03 01:10:13'),(40,'Laporan Penjualan','fa fa-file','report.order_reports','Aktif','orderreport-list',11,14,NULL,'2024-12-15 23:46:41','2025-02-03 01:10:13'),(41,'Laporan Produk','fa fa-file','report.product_reports','Aktif','productreport-list',11,16,NULL,'2024-12-17 09:28:05','2025-02-03 01:10:14'),(42,'Laporan Laba Rugi','fa fa-file','report.profit_reports','Aktif','profitreport-list',11,18,NULL,'2024-12-21 09:00:58','2025-02-03 01:10:14'),(43,'Laporan Produk Terlaris','fa fa-file','report.top_product_reports','Aktif','topproductreport-list',11,17,NULL,'2024-12-25 06:34:02','2025-02-03 01:10:14'),(44,'Slider','fa fa-file-image','sliders.index','Aktif','slider-list',5,6,46,'2025-01-11 00:16:47','2025-01-27 02:42:32'),(45,'Testimoni','fa fa-feather','testimonial.index','Aktif','testimony-list',5,7,46,'2025-01-15 00:23:51','2025-01-27 02:43:10'),(46,'Depan','fa fa-globe','products.index','Aktif','depan-index',5,13,NULL,'2025-01-27 02:39:54','2025-02-03 01:10:13'),(47,'Galeri','ti ti-user-circle','galleries.index','Aktif','gallery-list',5,1,46,'2025-02-01 07:30:25','2025-02-01 07:30:25'),(48,'Team','ti ti-user-circle','teams.index','Aktif','team-list',5,2,46,'2025-02-01 08:03:01','2025-02-01 08:03:01'),(49,'Layanan','ti ti-user-circle','services.index','Aktif','service-list',5,1,46,'2025-02-03 06:53:56','2025-02-03 06:53:56'),(51,'Back Up Database','fas fa-database','backupdatabase.index','Aktif','backupdatabase-list',3,1,NULL,'2025-02-06 07:56:13','2025-02-06 07:56:13');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (183,'2024_12_12_082259_create_adjusments_table',1),(184,'2024_12_12_090236_create_adjustment_details_table',2),(187,'2024_12_21_163651_create_profit_loss_table',3),(188,'2024_12_26_064737_create_galeries_table',4),(189,'2024_12_26_065536_create_galeries_table',5),(190,'2024_12_26_074010_create_sliders_table',6),(191,'2024_12_28_081940_create_shifts_table',7),(192,'2025_01_11_055203_create_sliders_table',8),(193,'2025_01_13_103545_create_testimonials_table',9),(194,'2025_01_27_170553_create_galleries_table',10),(195,'2025_02_01_145348_create_teams_table',11),(196,'2025_02_02_093656_create_car_table',12),(197,'2025_02_02_093958_create_cars_table',13),(198,'2025_02_03_134241_create_services_table',14),(199,'2025_02_04_074817_create_product_images_table',15);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',9);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `order_price` bigint NOT NULL DEFAULT '0',
  `total_price` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_date` date NOT NULL,
  `no_order` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `cash_id` bigint unsigned DEFAULT NULL,
  `total_cost_before` bigint NOT NULL DEFAULT '0',
  `percent_discount` bigint NOT NULL DEFAULT '0',
  `amount_discount` bigint NOT NULL DEFAULT '0',
  `input_payment` bigint NOT NULL DEFAULT '0',
  `return_payment` bigint DEFAULT NULL,
  `total_cost` bigint NOT NULL DEFAULT '0',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type_payment` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `cash_id` (`cash_id`),
  CONSTRAINT `cash` FOREIGN KEY (`cash_id`) REFERENCES `cash` (`id`) ON DELETE CASCADE,
  CONSTRAINT `customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` bigint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'user-list','web',21,'2024-11-11 06:38:20','2024-11-11 06:38:21'),(2,'user-create','web',22,'2024-11-11 06:38:37','2024-11-11 06:38:38'),(3,'user-edit','web',23,'2024-11-11 06:39:04','2024-11-11 06:39:05'),(4,'user-delete','web',24,'2024-11-11 06:42:16','2024-11-11 06:42:17'),(5,'permission-list','web',13,'2024-11-11 06:46:36','2024-11-11 06:46:37'),(6,'permission-create','web',14,'2024-11-11 06:46:37','2024-11-11 06:46:38'),(7,'permission-edit','web',15,'2024-11-11 06:46:39','2024-11-11 06:46:41'),(8,'permission-delete','web',16,'2024-11-11 06:46:42','2024-11-11 06:46:43'),(9,'role-list','web',17,'2024-11-11 06:47:56','2024-11-11 06:47:57'),(10,'role-create','web',18,'2024-11-11 06:47:58','2024-11-11 06:47:59'),(11,'role-edit','web',19,'2024-11-11 06:48:00','2024-11-11 06:48:00'),(12,'role-delete','web',20,'2024-11-11 06:48:01','2024-11-11 06:48:02'),(13,'profil-list','web',33,'2024-11-11 06:52:05','2024-11-11 09:23:24'),(14,'general-list','web',1,'2024-11-11 07:33:23','2024-11-11 08:38:32'),(15,'dashboard-list','web',2,'2024-11-11 00:34:33','2024-11-11 08:47:48'),(16,'pengaturan-list','web',12,'2024-11-11 00:40:26','2024-11-11 08:52:40'),(17,'menugroup-list','web',25,'2024-11-11 00:48:54','2024-11-11 01:42:31'),(18,'menugroup-create','web',26,'2024-11-11 01:41:58','2024-11-11 01:42:47'),(19,'menugroup-edit','web',27,'2024-11-11 01:42:07','2024-11-11 01:42:55'),(20,'menugroup-delete','web',28,'2024-11-11 01:42:15','2024-11-11 01:43:04'),(21,'master-list','web',3,'2024-11-11 02:33:19','2024-11-11 02:33:19'),(22,'blog-list','web',4,'2024-11-11 02:57:18','2024-11-11 02:57:18'),(23,'menuitem-list','web',29,'2024-11-11 03:14:49','2024-11-11 03:14:49'),(24,'menuitem-create','web',30,'2024-11-11 03:14:59','2024-11-11 03:14:59'),(25,'menuitem-edit','web',31,'2024-11-11 03:15:08','2024-11-11 03:15:08'),(26,'menuitem-delete','web',32,'2024-11-11 03:15:16','2024-11-11 03:15:16'),(34,'profil-edit','web',34,'2024-11-11 09:23:38','2024-11-11 09:23:38'),(35,'create-resource','web',40,'2024-11-11 11:33:44','2024-11-11 11:33:44'),(37,'loghistori-list','web',46,'2024-11-12 02:38:37','2024-11-12 02:38:37'),(44,'loghistori-deleteall','web',46,'2024-11-12 03:18:15','2024-11-12 03:18:15'),(45,'advance-list','web',45,'2024-11-12 03:24:59','2024-11-12 03:24:59'),(46,'route-list','web',46,'2024-11-13 00:47:06','2024-11-13 00:47:06'),(47,'route-create','web',50,'2024-11-13 00:52:45','2024-11-13 00:58:39'),(48,'menu-list','web',50,'2024-11-13 01:39:04','2024-11-13 01:39:16'),(49,'permissionrole-list','web',50,'2024-11-13 01:46:42','2024-11-13 01:46:42'),(71,'unit-list','web',NULL,'2024-11-22 22:54:17','2024-11-22 22:54:17'),(72,'unit-create','web',NULL,'2024-11-22 22:54:27','2024-11-22 22:54:27'),(73,'unit-edit','web',NULL,'2024-11-22 22:54:37','2024-11-22 22:54:37'),(74,'unit-delete','web',NULL,'2024-11-22 22:54:45','2024-11-22 22:54:45'),(75,'category-list','web',NULL,'2024-11-22 23:42:08','2024-11-22 23:42:08'),(76,'category-create','web',NULL,'2024-11-22 23:42:35','2024-11-22 23:42:35'),(77,'category-edit','web',NULL,'2024-11-22 23:43:07','2024-11-22 23:43:07'),(78,'category-delete','web',NULL,'2024-11-22 23:43:17','2024-11-22 23:43:17'),(79,'product-list','web',NULL,'2024-11-23 00:55:07','2024-11-23 00:55:07'),(80,'product-create','web',NULL,'2024-11-23 00:55:22','2024-11-23 00:55:22'),(81,'product-edit','web',NULL,'2024-11-23 00:55:33','2024-11-23 00:55:33'),(82,'product-delete','web',NULL,'2024-11-23 00:55:47','2024-11-23 00:55:47'),(83,'supplier-list','web',NULL,'2024-11-23 21:10:37','2024-11-23 21:10:37'),(84,'supplier-create','web',NULL,'2024-11-23 21:10:48','2024-11-23 21:10:48'),(85,'supplier-edit','web',NULL,'2024-11-23 21:10:56','2024-11-23 21:10:56'),(86,'supplier-delete','web',NULL,'2024-11-23 21:11:06','2024-11-23 21:11:06'),(87,'purchase-list','web',NULL,'2024-11-23 23:03:16','2024-11-23 23:03:16'),(88,'purchase-create','web',NULL,'2024-11-23 23:03:28','2024-11-23 23:03:28'),(89,'purchase-edit','web',NULL,'2024-11-23 23:04:04','2024-11-23 23:04:04'),(90,'purchase-delete','web',NULL,'2024-11-23 23:04:17','2024-11-23 23:04:17'),(91,'cash-list','web',NULL,'2024-11-25 01:32:02','2024-11-25 01:32:02'),(92,'cash-edit','web',NULL,'2024-11-25 01:32:13','2024-11-25 01:32:13'),(93,'cash-create','web',NULL,'2024-11-25 01:32:54','2024-11-25 01:32:54'),(94,'cash-delete','web',NULL,'2024-11-25 01:33:05','2024-11-25 01:33:05'),(95,'transact-list','web',2,'2024-11-25 02:04:24','2024-12-03 00:59:18'),(96,'order-list','web',NULL,'2024-11-26 22:29:38','2024-11-26 22:29:38'),(97,'order-create','web',NULL,'2024-11-26 22:29:50','2024-11-26 22:29:50'),(98,'order-edit','web',NULL,'2024-11-26 22:30:01','2024-11-26 22:30:01'),(99,'order-delete','web',NULL,'2024-11-26 22:30:11','2024-11-26 22:30:11'),(100,'customer-list','web',NULL,'2024-12-02 08:07:33','2024-12-02 08:07:33'),(101,'customer-create','web',NULL,'2024-12-02 08:07:44','2024-12-02 08:07:44'),(102,'customer-edit','web',NULL,'2024-12-02 08:07:53','2024-12-02 08:07:53'),(103,'customer-delete','web',NULL,'2024-12-02 08:08:07','2024-12-02 08:08:07'),(104,'transactioncategory-list','web',NULL,'2024-12-02 20:57:04','2024-12-02 20:57:04'),(105,'transactioncategory-create','web',NULL,'2024-12-02 20:57:36','2024-12-02 20:57:36'),(106,'transactioncategory-edit','web',NULL,'2024-12-02 20:57:49','2024-12-02 20:57:49'),(107,'transactioncategory-delete','web',NULL,'2024-12-02 20:58:03','2024-12-02 20:58:03'),(108,'transaction-list','web',NULL,'2024-12-03 00:59:42','2024-12-03 00:59:42'),(109,'transaction-create','web',NULL,'2024-12-03 00:59:55','2024-12-03 00:59:55'),(110,'transaction-edit','web',NULL,'2024-12-03 01:00:06','2024-12-03 01:00:06'),(111,'transaction-delete','web',NULL,'2024-12-03 01:00:18','2024-12-03 01:00:18'),(112,'stockopname-list','web',NULL,'2024-12-10 09:12:02','2024-12-10 09:12:02'),(113,'stockopname-create','web',NULL,'2024-12-10 09:12:14','2024-12-10 09:12:14'),(114,'stockopname-edit','web',NULL,'2024-12-10 09:12:28','2024-12-10 09:12:28'),(115,'stockopname-delete','web',NULL,'2024-12-10 09:12:39','2024-12-10 09:12:39'),(116,'adjustment-list','web',NULL,'2024-12-12 03:38:02','2024-12-12 03:38:02'),(117,'adjustment-create','web',NULL,'2024-12-12 03:38:24','2024-12-12 03:38:24'),(118,'adjustment-edit','web',NULL,'2024-12-12 03:38:39','2024-12-12 03:38:39'),(119,'adjustment-delete','web',NULL,'2024-12-12 03:38:50','2024-12-12 03:38:50'),(120,'report-list','web',4,'2024-12-15 16:48:27','2024-12-15 20:19:05'),(121,'purchasereport-list','web',NULL,'2024-12-15 17:42:48','2024-12-15 20:19:37'),(122,'orderreport-list','web',NULL,'2024-12-15 23:44:38','2024-12-15 23:44:38'),(123,'productreport-list','web',NULL,'2024-12-17 09:26:43','2024-12-17 09:26:43'),(124,'profitreport-list','web',NULL,'2024-12-21 08:59:19','2024-12-21 08:59:19'),(125,'topproductreport-list','web',NULL,'2024-12-25 06:28:13','2024-12-25 06:28:13'),(126,'slider-list','web',NULL,'2025-01-11 00:15:30','2025-01-11 00:15:30'),(127,'slider-create','web',NULL,'2025-01-11 00:18:34','2025-01-11 00:18:34'),(128,'slider-edit','web',NULL,'2025-01-11 00:18:47','2025-01-11 00:18:47'),(129,'slider-delete','web',NULL,'2025-01-11 00:18:57','2025-01-11 00:18:57'),(130,'testimony-list','web',NULL,'2025-01-15 00:15:46','2025-01-15 00:15:46'),(131,'testimony-create','web',NULL,'2025-01-15 00:16:44','2025-01-15 00:16:44'),(132,'testimony-edit','web',NULL,'2025-01-15 00:16:55','2025-01-15 00:16:55'),(133,'testimony-delete','web',NULL,'2025-01-15 00:17:07','2025-01-15 00:17:07'),(134,'depan-index','web',NULL,'2025-01-27 02:32:53','2025-01-27 02:32:53'),(135,'gallery-list','web',NULL,'2025-02-01 07:27:14','2025-02-01 07:27:14'),(136,'gallery-create','web',NULL,'2025-02-01 07:27:32','2025-02-01 07:27:32'),(137,'gallery-edit','web',NULL,'2025-02-01 07:27:43','2025-02-01 07:27:43'),(138,'gallery-delete','web',NULL,'2025-02-01 07:27:54','2025-02-01 07:27:54'),(139,'team-list','web',NULL,'2025-02-01 08:01:22','2025-02-01 08:01:22'),(140,'team-create','web',NULL,'2025-02-01 08:01:34','2025-02-01 08:01:34'),(141,'team-edit','web',NULL,'2025-02-01 08:01:44','2025-02-01 08:01:44'),(142,'team-delete','web',NULL,'2025-02-01 08:01:56','2025-02-01 08:01:56'),(143,'service-list','web',NULL,'2025-02-03 06:51:17','2025-02-03 06:51:17'),(144,'service-create','web',NULL,'2025-02-03 06:51:29','2025-02-03 06:51:29'),(145,'service-edit','web',NULL,'2025-02-03 06:51:58','2025-02-03 06:51:58'),(146,'service-delete','web',NULL,'2025-02-03 06:52:43','2025-02-03 06:52:43'),(147,'productimages-list','web',NULL,'2025-02-04 01:00:06','2025-02-04 01:00:06'),(148,'productimages-create','web',NULL,'2025-02-04 01:00:28','2025-02-04 01:00:28'),(149,'productimages-edit','web',NULL,'2025-02-04 01:00:43','2025-02-04 01:00:43'),(150,'productimages-delete','web',NULL,'2025-02-04 01:01:15','2025-02-04 01:01:15'),(155,'backupdatabase-list','web',NULL,'2025-02-06 07:54:17','2025-02-06 07:54:17'),(156,'backupdatabase-create','web',NULL,'2025-02-06 08:27:10','2025-02-06 08:27:10'),(157,'backupdatabase-edit','web',NULL,'2025-02-06 08:27:19','2025-02-06 08:27:19'),(158,'backupdatabase-delete','web',NULL,'2025-02-06 08:27:30','2025-02-06 08:27:30');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_prices`
--

DROP TABLE IF EXISTS `product_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `customer_category_id` bigint unsigned NOT NULL,
  `price` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_prices_product_id_foreign` (`product_id`),
  KEY `product_prices_customer_category_id_foreign` (`customer_category_id`),
  CONSTRAINT `product_prices_customer_category_id_foreign` FOREIGN KEY (`customer_category_id`) REFERENCES `customer_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_prices`
--

LOCK TABLES `product_prices` WRITE;
/*!40000 ALTER TABLE `product_prices` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code_product` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `purchase_price` bigint NOT NULL,
  `cost_price` bigint NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reminder` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_unit_id_foreign` (`unit_id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (33,NULL,NULL,'Produk Satu Ini','produk-satu-ini',1,5,NULL,80000,100000,10,'20250205164140_sdit1.webp',0,'2025-02-05 09:41:40','2025-02-05 09:44:22'),(34,NULL,NULL,'Produk Dua Ini','produk-dua-ini',1,1,NULL,70000,120000,10,'20250205164217_sdit2.webp',0,'2025-02-05 09:42:18','2025-02-05 09:44:35'),(35,NULL,NULL,'Produk Tiga Itu','produk-tiga-itu',1,2,NULL,80000,125000,10,'20250205164246_smpit1.webp',0,'2025-02-05 09:42:46','2025-02-05 09:44:48'),(36,NULL,NULL,'Produk Empat Itu','produk-empat-itu',1,3,NULL,75000,110000,10,'20250205164320_smpit2.webp',0,'2025-02-05 09:43:20','2025-02-05 09:45:00');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil`
--

DROP TABLE IF EXISTS `profil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profil` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_profil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_wa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `deskripsi_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `deskripsi_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_dark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme` enum('light','dark') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_color` enum('Blue_Theme','Aqua_Theme','Purple_Theme','Green_Theme','Cyan_Theme','Orange_Theme') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `boxed_layout` enum('true','false') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sidebar_type` enum('full','mini-sidebar') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_border` enum('true','false') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direction` enum('ltr','rtl') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `embed_youtube` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `embed_map` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_keyword` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil`
--

LOCK TABLES `profil` WRITE;
/*!40000 ALTER TABLE `profil` DISABLE KEYS */;
INSERT INTO `profil` VALUES (1,'Master Kit','MST',NULL,'Jl. Raya Cinta Kamu Belakang Pom Bensin Sinar Terang, Tanjungpura, Kec. Indihiang, Kota Tasikmalaya, Jawa Barat 46155','085320555394','6285320555394','masterkit@gmail.com','@masterkit','Master Kit','https://www.youtube.com/','www.ltpresent.com','Deskripsi 1','Deksripsi 2','Deskripsi 3','20250127064836_logo2.webp','20250127064412_logo.webp','20250127065250_fav.webp','20250127064412_Yellow_Simple_Rent_Car_Illustrated_Yard_Sign.webp','20250102235021_login-bg.webp','dark','Blue_Theme','false','full','false','ltr','Embed','Map','pos, kasir, aplikasi, toko online','Master Kit merupakan sistem terpadu pos, kasir, aplikasi, toko online dan lain-lain','2024-11-11 05:51:01','2025-02-06 03:36:12');
/*!40000 ALTER TABLE `profil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profit_loss`
--

DROP TABLE IF EXISTS `profit_loss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profit_loss` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cash_id` bigint unsigned NOT NULL,
  `transaction_id` bigint unsigned DEFAULT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `purchase_id` bigint unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `category` enum('kurang','tambah') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profit_loss_cash_id_foreign` (`cash_id`),
  KEY `profit_loss_transaction_id_foreign` (`transaction_id`),
  KEY `profit_loss_order_id_foreign` (`order_id`),
  KEY `profit_loss_purchase_id_foreign` (`purchase_id`),
  CONSTRAINT `profit_loss_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cash` (`id`) ON DELETE CASCADE,
  CONSTRAINT `profit_loss_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `profit_loss_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  CONSTRAINT `profit_loss_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profit_loss`
--

LOCK TABLES `profit_loss` WRITE;
/*!40000 ALTER TABLE `profit_loss` DISABLE KEYS */;
/*!40000 ALTER TABLE `profit_loss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_items`
--

DROP TABLE IF EXISTS `purchase_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `purchase_price` bigint NOT NULL,
  `total_price` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  KEY `purchase_items_product_id_foreign` (`product_id`),
  CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_items`
--

LOCK TABLES `purchase_items` WRITE;
/*!40000 ALTER TABLE `purchase_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_date` date NOT NULL,
  `no_purchase` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `cash_id` bigint unsigned DEFAULT NULL,
  `total_cost` bigint NOT NULL DEFAULT '0',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type_payment` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchases_supplier_id_foreign` (`supplier_id`),
  KEY `purchases_user_id_foreign` (`user_id`),
  KEY `cash_id` (`cash_id`),
  CONSTRAINT `purchases_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cash` (`id`),
  CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(34,1),(35,1),(37,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,1),(114,1),(115,1),(116,1),(117,1),(118,1),(119,1),(120,1),(121,1),(122,1),(123,1),(124,1),(125,1),(126,1),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(137,1),(138,1),(139,1),(140,1),(141,1),(142,1),(143,1),(144,1),(145,1),(146,1),(147,1),(148,1),(149,1),(150,1),(155,1),(156,1),(157,1),(158,1),(14,2),(15,2),(21,2),(22,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','web','2024-11-10 22:51:56','2024-11-10 22:51:56'),(2,'Pengguna','web','2024-11-11 08:13:23','2024-11-11 08:13:23');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routes`
--

LOCK TABLES `routes` WRITE;
/*!40000 ALTER TABLE `routes` DISABLE KEYS */;
INSERT INTO `routes` VALUES (1,'debugbar.openhandler','2025-02-06 08:24:19','2025-02-06 08:24:19'),(2,'debugbar.clockwork','2025-02-06 08:24:20','2025-02-06 08:24:20'),(3,'debugbar.assets.css','2025-02-06 08:24:20','2025-02-06 08:24:20'),(4,'debugbar.assets.js','2025-02-06 08:24:20','2025-02-06 08:24:20'),(5,'debugbar.cache.delete','2025-02-06 08:24:20','2025-02-06 08:24:20'),(6,'debugbar.queries.explain','2025-02-06 08:24:20','2025-02-06 08:24:20'),(7,'up','2025-02-06 08:24:20','2025-02-06 08:24:20'),(8,'login','2025-02-06 08:24:20','2025-02-06 08:24:20'),(9,'login','2025-02-06 08:24:21','2025-02-06 08:24:21'),(10,'logout','2025-02-06 08:24:21','2025-02-06 08:24:21'),(11,'register','2025-02-06 08:24:21','2025-02-06 08:24:21'),(12,'register','2025-02-06 08:24:21','2025-02-06 08:24:21'),(13,'password.request','2025-02-06 08:24:21','2025-02-06 08:24:21'),(14,'password.email','2025-02-06 08:24:21','2025-02-06 08:24:21'),(15,'password.reset','2025-02-06 08:24:21','2025-02-06 08:24:21'),(16,'password.update','2025-02-06 08:24:21','2025-02-06 08:24:21'),(17,'password.confirm','2025-02-06 08:24:21','2025-02-06 08:24:21'),(18,'password/confirm','2025-02-06 08:24:21','2025-02-06 08:24:21'),(19,'beranda','2025-02-06 08:24:21','2025-02-06 08:24:21'),(20,'katalog.katalog_detail','2025-02-06 08:24:21','2025-02-06 08:24:21'),(21,'testimoni','2025-02-06 08:24:21','2025-02-06 08:24:21'),(22,'katalog','2025-02-06 08:24:21','2025-02-06 08:24:21'),(23,'detail_katalog','2025-02-06 08:24:21','2025-02-06 08:24:21'),(24,'home','2025-02-06 08:24:21','2025-02-06 08:24:21'),(25,'services.index','2025-02-06 08:24:22','2025-02-06 08:24:22'),(26,'services.create','2025-02-06 08:24:22','2025-02-06 08:24:22'),(27,'services.store','2025-02-06 08:24:22','2025-02-06 08:24:22'),(28,'services.show','2025-02-06 08:24:22','2025-02-06 08:24:22'),(29,'services.edit','2025-02-06 08:24:22','2025-02-06 08:24:22'),(30,'services.update','2025-02-06 08:24:22','2025-02-06 08:24:22'),(31,'services.destroy','2025-02-06 08:24:22','2025-02-06 08:24:22'),(32,'teams.index','2025-02-06 08:24:22','2025-02-06 08:24:22'),(33,'teams.create','2025-02-06 08:24:22','2025-02-06 08:24:22'),(34,'teams.store','2025-02-06 08:24:22','2025-02-06 08:24:22'),(35,'teams.show','2025-02-06 08:24:22','2025-02-06 08:24:22'),(36,'teams.edit','2025-02-06 08:24:22','2025-02-06 08:24:22'),(37,'teams.update','2025-02-06 08:24:22','2025-02-06 08:24:22'),(38,'teams.destroy','2025-02-06 08:24:22','2025-02-06 08:24:22'),(39,'galleries.index','2025-02-06 08:24:22','2025-02-06 08:24:22'),(40,'galleries.create','2025-02-06 08:24:22','2025-02-06 08:24:22'),(41,'galleries.store','2025-02-06 08:24:22','2025-02-06 08:24:22'),(42,'galleries.show','2025-02-06 08:24:22','2025-02-06 08:24:22'),(43,'galleries.edit','2025-02-06 08:24:22','2025-02-06 08:24:22'),(44,'galleries.update','2025-02-06 08:24:22','2025-02-06 08:24:22'),(45,'galleries.destroy','2025-02-06 08:24:22','2025-02-06 08:24:22'),(46,'testimonial.index','2025-02-06 08:24:22','2025-02-06 08:24:22'),(47,'testimonial.create','2025-02-06 08:24:23','2025-02-06 08:24:23'),(48,'testimonial.store','2025-02-06 08:24:23','2025-02-06 08:24:23'),(49,'testimonial.show','2025-02-06 08:24:23','2025-02-06 08:24:23'),(50,'testimonial.edit','2025-02-06 08:24:23','2025-02-06 08:24:23'),(51,'testimonial.update','2025-02-06 08:24:23','2025-02-06 08:24:23'),(52,'testimonial.destroy','2025-02-06 08:24:23','2025-02-06 08:24:23'),(53,'sliders.index','2025-02-06 08:24:23','2025-02-06 08:24:23'),(54,'sliders.create','2025-02-06 08:24:23','2025-02-06 08:24:23'),(55,'sliders.store','2025-02-06 08:24:23','2025-02-06 08:24:23'),(56,'sliders.show','2025-02-06 08:24:23','2025-02-06 08:24:23'),(57,'sliders.edit','2025-02-06 08:24:23','2025-02-06 08:24:23'),(58,'sliders.update','2025-02-06 08:24:23','2025-02-06 08:24:23'),(59,'sliders.destroy','2025-02-06 08:24:23','2025-02-06 08:24:23'),(60,'tutorial-status','2025-02-06 08:24:23','2025-02-06 08:24:23'),(61,'set-tutorial-status','2025-02-06 08:24:23','2025-02-06 08:24:23'),(62,'adjustments.index','2025-02-06 08:24:23','2025-02-06 08:24:23'),(63,'adjustments.create','2025-02-06 08:24:23','2025-02-06 08:24:23'),(64,'adjustments.store','2025-02-06 08:24:23','2025-02-06 08:24:23'),(65,'adjustments.show','2025-02-06 08:24:23','2025-02-06 08:24:23'),(66,'adjustments.edit','2025-02-06 08:24:23','2025-02-06 08:24:23'),(67,'adjustments.update','2025-02-06 08:24:23','2025-02-06 08:24:23'),(68,'adjustments.destroy','2025-02-06 08:24:24','2025-02-06 08:24:24'),(69,'adjustments.print','2025-02-06 08:24:24','2025-02-06 08:24:24'),(70,'stock_opname.index','2025-02-06 08:24:24','2025-02-06 08:24:24'),(71,'stock_opname.create','2025-02-06 08:24:24','2025-02-06 08:24:24'),(72,'stock_opname.store','2025-02-06 08:24:24','2025-02-06 08:24:24'),(73,'stock_opname.show','2025-02-06 08:24:24','2025-02-06 08:24:24'),(74,'stock_opname.edit','2025-02-06 08:24:24','2025-02-06 08:24:24'),(75,'stock_opname.update','2025-02-06 08:24:24','2025-02-06 08:24:24'),(76,'stock_opname.destroy','2025-02-06 08:24:24','2025-02-06 08:24:24'),(77,'stock_opname.print','2025-02-06 08:24:24','2025-02-06 08:24:24'),(78,'report.purchase_reports','2025-02-06 08:24:24','2025-02-06 08:24:24'),(79,'report.purchase_reports.export','2025-02-06 08:24:24','2025-02-06 08:24:24'),(80,'report.purchase_reports.export_pdf','2025-02-06 08:24:24','2025-02-06 08:24:24'),(81,'report.purchase_reports.preview_pdf','2025-02-06 08:24:24','2025-02-06 08:24:24'),(82,'report.order_reports','2025-02-06 08:24:24','2025-02-06 08:24:24'),(83,'report.order_reports.export','2025-02-06 08:24:24','2025-02-06 08:24:24'),(84,'report.order_reports.export_pdf','2025-02-06 08:24:24','2025-02-06 08:24:24'),(85,'report.order_reports.preview_pdf','2025-02-06 08:24:24','2025-02-06 08:24:24'),(86,'report.product_reports','2025-02-06 08:24:24','2025-02-06 08:24:24'),(87,'report.product_reports.export','2025-02-06 08:24:24','2025-02-06 08:24:24'),(88,'report.product_reports.export_pdf','2025-02-06 08:24:24','2025-02-06 08:24:24'),(89,'report.product_reports.preview_pdf','2025-02-06 08:24:25','2025-02-06 08:24:25'),(90,'report.profit_reports','2025-02-06 08:24:25','2025-02-06 08:24:25'),(91,'report.profit_reports.export','2025-02-06 08:24:25','2025-02-06 08:24:25'),(92,'report.profit_reports.export_pdf','2025-02-06 08:24:25','2025-02-06 08:24:25'),(93,'report.profit_reports.preview_pdf','2025-02-06 08:24:25','2025-02-06 08:24:25'),(94,'report.top_product_reports','2025-02-06 08:24:25','2025-02-06 08:24:25'),(95,'report.top_product_reports.export','2025-02-06 08:24:25','2025-02-06 08:24:25'),(96,'report.top_product_reports.export_pdf','2025-02-06 08:24:25','2025-02-06 08:24:25'),(97,'report.top_product_reports.preview_pdf','2025-02-06 08:24:25','2025-02-06 08:24:25'),(98,'transactions.index','2025-02-06 08:24:25','2025-02-06 08:24:25'),(99,'transactions.create','2025-02-06 08:24:25','2025-02-06 08:24:25'),(100,'transactions.store','2025-02-06 08:24:25','2025-02-06 08:24:25'),(101,'transactions.show','2025-02-06 08:24:25','2025-02-06 08:24:25'),(102,'transactions.edit','2025-02-06 08:24:25','2025-02-06 08:24:25'),(103,'transactions.update','2025-02-06 08:24:25','2025-02-06 08:24:25'),(104,'transactions.destroy','2025-02-06 08:24:25','2025-02-06 08:24:25'),(105,'transaction_categories.index','2025-02-06 08:24:25','2025-02-06 08:24:25'),(106,'transaction_categories.create','2025-02-06 08:24:25','2025-02-06 08:24:25'),(107,'transaction_categories.store','2025-02-06 08:24:25','2025-02-06 08:24:25'),(108,'transaction_categories.show','2025-02-06 08:24:25','2025-02-06 08:24:25'),(109,'transaction_categories.edit','2025-02-06 08:24:25','2025-02-06 08:24:25'),(110,'transaction_categories.update','2025-02-06 08:24:25','2025-02-06 08:24:25'),(111,'transaction_categories.destroy','2025-02-06 08:24:26','2025-02-06 08:24:26'),(112,'cash.index','2025-02-06 08:24:26','2025-02-06 08:24:26'),(113,'cash.create','2025-02-06 08:24:26','2025-02-06 08:24:26'),(114,'cash.store','2025-02-06 08:24:26','2025-02-06 08:24:26'),(115,'cash.show','2025-02-06 08:24:26','2025-02-06 08:24:26'),(116,'cash.edit','2025-02-06 08:24:26','2025-02-06 08:24:26'),(117,'cash.update','2025-02-06 08:24:26','2025-02-06 08:24:26'),(118,'cash.destroy','2025-02-06 08:24:26','2025-02-06 08:24:26'),(119,'purchases.index','2025-02-06 08:24:26','2025-02-06 08:24:26'),(120,'purchases.create','2025-02-06 08:24:26','2025-02-06 08:24:26'),(121,'purchases.store','2025-02-06 08:24:26','2025-02-06 08:24:26'),(122,'purchases.show','2025-02-06 08:24:26','2025-02-06 08:24:26'),(123,'purchases.edit','2025-02-06 08:24:26','2025-02-06 08:24:26'),(124,'purchases.update','2025-02-06 08:24:26','2025-02-06 08:24:26'),(125,'purchases.destroy','2025-02-06 08:24:26','2025-02-06 08:24:26'),(126,'purchases.print_invoice','2025-02-06 08:24:26','2025-02-06 08:24:26'),(127,'suppliers.index','2025-02-06 08:24:26','2025-02-06 08:24:26'),(128,'suppliers.create','2025-02-06 08:24:26','2025-02-06 08:24:26'),(129,'suppliers.store','2025-02-06 08:24:26','2025-02-06 08:24:26'),(130,'suppliers.show','2025-02-06 08:24:26','2025-02-06 08:24:26'),(131,'suppliers.edit','2025-02-06 08:24:26','2025-02-06 08:24:26'),(132,'suppliers.update','2025-02-06 08:24:26','2025-02-06 08:24:26'),(133,'suppliers.destroy','2025-02-06 08:24:27','2025-02-06 08:24:27'),(134,'customers.index','2025-02-06 08:24:27','2025-02-06 08:24:27'),(135,'customers.create','2025-02-06 08:24:27','2025-02-06 08:24:27'),(136,'customers.store','2025-02-06 08:24:27','2025-02-06 08:24:27'),(137,'customers.show','2025-02-06 08:24:27','2025-02-06 08:24:27'),(138,'customers.edit','2025-02-06 08:24:27','2025-02-06 08:24:27'),(139,'customers.update','2025-02-06 08:24:27','2025-02-06 08:24:27'),(140,'customers.destroy','2025-02-06 08:24:27','2025-02-06 08:24:27'),(141,'orders.index','2025-02-06 08:24:27','2025-02-06 08:24:27'),(142,'orders.create','2025-02-06 08:24:27','2025-02-06 08:24:27'),(143,'orders.store','2025-02-06 08:24:27','2025-02-06 08:24:27'),(144,'orders.show','2025-02-06 08:24:27','2025-02-06 08:24:27'),(145,'orders.edit','2025-02-06 08:24:27','2025-02-06 08:24:27'),(146,'orders.update','2025-02-06 08:24:27','2025-02-06 08:24:27'),(147,'orders.destroy','2025-02-06 08:24:27','2025-02-06 08:24:27'),(148,'orders.print_invoice','2025-02-06 08:24:27','2025-02-06 08:24:27'),(149,'orders.print_struk','2025-02-06 08:24:27','2025-02-06 08:24:27'),(150,'units.index','2025-02-06 08:24:27','2025-02-06 08:24:27'),(151,'units.create','2025-02-06 08:24:27','2025-02-06 08:24:27'),(152,'units.store','2025-02-06 08:24:27','2025-02-06 08:24:27'),(153,'units.show','2025-02-06 08:24:28','2025-02-06 08:24:28'),(154,'units.edit','2025-02-06 08:24:28','2025-02-06 08:24:28'),(155,'units.update','2025-02-06 08:24:28','2025-02-06 08:24:28'),(156,'units.destroy','2025-02-06 08:24:28','2025-02-06 08:24:28'),(157,'products.index','2025-02-06 08:24:28','2025-02-06 08:24:28'),(158,'products.create','2025-02-06 08:24:28','2025-02-06 08:24:28'),(159,'products.store','2025-02-06 08:24:28','2025-02-06 08:24:28'),(160,'products.show','2025-02-06 08:24:28','2025-02-06 08:24:28'),(161,'products.edit','2025-02-06 08:24:28','2025-02-06 08:24:28'),(162,'products.update','2025-02-06 08:24:28','2025-02-06 08:24:28'),(163,'products.destroy','2025-02-06 08:24:28','2025-02-06 08:24:28'),(164,'get-product-price','2025-02-06 08:24:28','2025-02-06 08:24:28'),(165,'products.generate_barcode','2025-02-06 08:24:28','2025-02-06 08:24:28'),(166,'get-product-by-barcode','2025-02-06 08:24:28','2025-02-06 08:24:28'),(167,'products.images.index','2025-02-06 08:24:28','2025-02-06 08:24:28'),(168,'products.images.store','2025-02-06 08:24:28','2025-02-06 08:24:28'),(169,'products.images.destroy','2025-02-06 08:24:28','2025-02-06 08:24:28'),(170,'products.destroy-multiple','2025-02-06 08:24:28','2025-02-06 08:24:28'),(171,'categories.index','2025-02-06 08:24:28','2025-02-06 08:24:28'),(172,'categories.create','2025-02-06 08:24:28','2025-02-06 08:24:28'),(173,'categories.store','2025-02-06 08:24:28','2025-02-06 08:24:28'),(174,'categories.show','2025-02-06 08:24:28','2025-02-06 08:24:28'),(175,'categories.edit','2025-02-06 08:24:29','2025-02-06 08:24:29'),(176,'categories.update','2025-02-06 08:24:29','2025-02-06 08:24:29'),(177,'categories.destroy','2025-02-06 08:24:29','2025-02-06 08:24:29'),(178,'routes.index','2025-02-06 08:24:29','2025-02-06 08:24:29'),(179,'routes.create','2025-02-06 08:24:29','2025-02-06 08:24:29'),(180,'routes.store','2025-02-06 08:24:29','2025-02-06 08:24:29'),(181,'routes.show','2025-02-06 08:24:29','2025-02-06 08:24:29'),(182,'routes.edit','2025-02-06 08:24:29','2025-02-06 08:24:29'),(183,'routes.update','2025-02-06 08:24:29','2025-02-06 08:24:29'),(184,'routes.destroy','2025-02-06 08:24:29','2025-02-06 08:24:29'),(185,'routes.generate','2025-02-06 08:24:29','2025-02-06 08:24:29'),(186,'log_histori.index','2025-02-06 08:24:29','2025-02-06 08:24:29'),(187,'log_histori.create','2025-02-06 08:24:29','2025-02-06 08:24:29'),(188,'log_histori.store','2025-02-06 08:24:29','2025-02-06 08:24:29'),(189,'log_histori.show','2025-02-06 08:24:29','2025-02-06 08:24:29'),(190,'log_histori.edit','2025-02-06 08:24:29','2025-02-06 08:24:29'),(191,'log_histori.update','2025-02-06 08:24:29','2025-02-06 08:24:29'),(192,'log_histori.destroy','2025-02-06 08:24:29','2025-02-06 08:24:29'),(193,'log-histori.delete-all','2025-02-06 08:24:29','2025-02-06 08:24:29'),(194,'roles.index','2025-02-06 08:24:30','2025-02-06 08:24:30'),(195,'roles.create','2025-02-06 08:24:30','2025-02-06 08:24:30'),(196,'roles.store','2025-02-06 08:24:30','2025-02-06 08:24:30'),(197,'roles.show','2025-02-06 08:24:30','2025-02-06 08:24:30'),(198,'roles.edit','2025-02-06 08:24:30','2025-02-06 08:24:30'),(199,'roles.update','2025-02-06 08:24:30','2025-02-06 08:24:30'),(200,'roles.destroy','2025-02-06 08:24:30','2025-02-06 08:24:30'),(201,'users.index','2025-02-06 08:24:30','2025-02-06 08:24:30'),(202,'users.create','2025-02-06 08:24:30','2025-02-06 08:24:30'),(203,'users.store','2025-02-06 08:24:30','2025-02-06 08:24:30'),(204,'users.show','2025-02-06 08:24:30','2025-02-06 08:24:30'),(205,'users.edit','2025-02-06 08:24:30','2025-02-06 08:24:30'),(206,'users.update','2025-02-06 08:24:30','2025-02-06 08:24:30'),(207,'users.destroy','2025-02-06 08:24:30','2025-02-06 08:24:30'),(208,'permissions.index','2025-02-06 08:24:30','2025-02-06 08:24:30'),(209,'permissions.create','2025-02-06 08:24:30','2025-02-06 08:24:30'),(210,'permissions.store','2025-02-06 08:24:30','2025-02-06 08:24:30'),(211,'permissions.show','2025-02-06 08:24:30','2025-02-06 08:24:30'),(212,'permissions.edit','2025-02-06 08:24:30','2025-02-06 08:24:30'),(213,'permissions.update','2025-02-06 08:24:30','2025-02-06 08:24:30'),(214,'permissions.destroy','2025-02-06 08:24:31','2025-02-06 08:24:31'),(215,'profil.index','2025-02-06 08:24:31','2025-02-06 08:24:31'),(216,'profil.create','2025-02-06 08:24:31','2025-02-06 08:24:31'),(217,'profil.store','2025-02-06 08:24:31','2025-02-06 08:24:31'),(218,'profil.show','2025-02-06 08:24:31','2025-02-06 08:24:31'),(219,'profil.edit','2025-02-06 08:24:31','2025-02-06 08:24:31'),(220,'profil.update','2025-02-06 08:24:31','2025-02-06 08:24:31'),(221,'profil.destroy','2025-02-06 08:24:31','2025-02-06 08:24:31'),(222,'profil.update_setting','2025-02-06 08:24:31','2025-02-06 08:24:31'),(223,'menu_groups.index','2025-02-06 08:24:31','2025-02-06 08:24:31'),(224,'menu_groups.create','2025-02-06 08:24:31','2025-02-06 08:24:31'),(225,'menu_groups.store','2025-02-06 08:24:31','2025-02-06 08:24:31'),(226,'menu_groups.show','2025-02-06 08:24:31','2025-02-06 08:24:31'),(227,'menu_groups.edit','2025-02-06 08:24:31','2025-02-06 08:24:31'),(228,'menu_groups.update','2025-02-06 08:24:31','2025-02-06 08:24:31'),(229,'menu_groups.destroy','2025-02-06 08:24:31','2025-02-06 08:24:31'),(230,'menu_items.index','2025-02-06 08:24:31','2025-02-06 08:24:31'),(231,'menu_items.create','2025-02-06 08:24:31','2025-02-06 08:24:31'),(232,'menu_items.store','2025-02-06 08:24:31','2025-02-06 08:24:31'),(233,'menu_items.show','2025-02-06 08:24:31','2025-02-06 08:24:31'),(234,'menu_items.edit','2025-02-06 08:24:31','2025-02-06 08:24:31'),(235,'menu_items.update','2025-02-06 08:24:31','2025-02-06 08:24:31'),(236,'menu_items.destroy','2025-02-06 08:24:32','2025-02-06 08:24:32'),(237,'menu_items.update_positions','2025-02-06 08:24:32','2025-02-06 08:24:32'),(238,'menu_groups.update_positions','2025-02-06 08:24:32','2025-02-06 08:24:32'),(239,'resource.create','2025-02-06 08:24:32','2025-02-06 08:24:32'),(240,'resource.store','2025-02-06 08:24:32','2025-02-06 08:24:32'),(241,'backupdatabase.index','2025-02-06 08:24:32','2025-02-06 08:24:32'),(242,'backupdatabase.create','2025-02-06 08:24:32','2025-02-06 08:24:32'),(243,'backupdatabase.store','2025-02-06 08:24:32','2025-02-06 08:24:32'),(244,'backupdatabase.show','2025-02-06 08:24:32','2025-02-06 08:24:32'),(245,'backupdatabase.edit','2025-02-06 08:24:32','2025-02-06 08:24:32'),(246,'backupdatabase.update','2025-02-06 08:24:32','2025-02-06 08:24:32'),(247,'backupdatabase.destroy','2025-02-06 08:24:32','2025-02-06 08:24:32'),(248,'backup.manual','2025-02-06 08:24:32','2025-02-06 08:24:32'),(249,'backup.restore','2025-02-06 08:24:32','2025-02-06 08:24:32'),(250,'storage.local','2025-02-06 08:24:32','2025-02-06 08:24:32');
/*!40000 ALTER TABLE `routes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (2,'Pembuatan Aplikasi Website',NULL,NULL,'20250204022550_PKL_(1).webp',NULL,'2025-02-03 19:11:59','2025-02-03 19:25:50'),(3,'Pembuatan Aplikasi Dekstop',NULL,NULL,'20250204022605_PKL_(2).webp',NULL,'2025-02-03 19:19:07','2025-02-03 19:26:05'),(4,'Media Pembelajaran  Anak',NULL,NULL,'20250204023046_PKL_(3).webp',NULL,'2025-02-03 19:30:47','2025-02-03 19:31:14'),(5,'Reparasi Laptop, PC & Printer',NULL,NULL,'20250204024009_PKL_(4).webp',NULL,'2025-02-03 19:38:46','2025-02-03 19:40:10');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('cxnKPrCBSRWfzyW2aWiPFzW2iS0rqUsm2NFjxiQN',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWEpNcHBiVXR2akNaSW42UXQzNFRFQk9LMzhrb0VoUU5Ha05Oc2NZRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9tYXN0ZXJraXQudGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzM4ODI5MjU4O319',1738859425);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sliders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` VALUES (3,'Lorem Ipsum Slider 1','Lorem Ipsum Slider 1','20250127160215_6.webp','https://drive.google.com/file/d/13lofIH_M8FtOHFbDP2HXVw9UV4HwNhtp/preview',1,'2025-01-27 09:02:16','2025-01-27 09:02:16'),(4,'Lorem Ipsum Slider 2','Lorem Ipsum Slider 2','20250127160245_7.webp','https://drive.google.com/file/d/13lofIH_M8FtOHFbDP2HXVw9UV4HwNhtp/preview',2,'2025-01-27 09:02:45','2025-01-27 09:02:45'),(5,'Lorem Ipsum Slider 3','Lorem Ipsum Slider 3','20250127160308_8.webp','https://drive.google.com/file/d/13lofIH_M8FtOHFbDP2HXVw9UV4HwNhtp/preview',3,'2025-01-27 09:03:08','2025-01-27 09:03:08');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_opname`
--

DROP TABLE IF EXISTS `stock_opname`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_opname` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `opname_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `opname_date` date DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_opname_no_stock_opname_unique` (`opname_number`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_opname`
--

LOCK TABLES `stock_opname` WRITE;
/*!40000 ALTER TABLE `stock_opname` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_opname` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_opname_detail`
--

DROP TABLE IF EXISTS `stock_opname_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_opname_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stock_opname_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `system_stock` int NOT NULL DEFAULT '0',
  `physical_stock` int NOT NULL DEFAULT '0',
  `difference` int NOT NULL DEFAULT '0',
  `description_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_opname_detail_stock_opname_id_foreign` (`stock_opname_id`),
  KEY `stock_opname_detail_product_id_foreign` (`product_id`),
  CONSTRAINT `stock_opname_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_opname_detail_stock_opname_id_foreign` FOREIGN KEY (`stock_opname_id`) REFERENCES `stock_opname` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_opname_detail`
--

LOCK TABLES `stock_opname_detail` WRITE;
/*!40000 ALTER TABLE `stock_opname_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_opname_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Supplier Umum','supplierumum@gmail.com','085320555394','Perumahan CGM Sukarindik Kecamatan Bungursari. Blok C31. RT/RW 02/11. Kota Tasikmalaya\r\nJl. Tajur Indah','2024-11-23 21:34:09','2024-11-28 08:24:22'),(2,'CV. Prima rasa Abadi','pra@gmail.com','085320555333','Jl. Tajur Indah','2024-11-23 22:17:50','2024-11-23 22:17:50'),(3,'PT. Triguna','triguna@gmail.com',NULL,NULL,'2024-12-04 10:16:45','2024-12-04 10:16:45');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'Pcs','2024-11-22 23:03:07','2024-11-22 23:05:38'),(2,'Kg','2024-11-22 23:03:15','2024-11-22 23:03:15'),(3,'Gram','2024-11-22 23:03:22','2024-11-22 23:03:22'),(4,'Box','2024-11-22 23:03:29','2024-11-22 23:03:29'),(5,'Dus','2024-11-22 23:03:41','2024-11-22 23:03:41'),(6,'Karton','2024-11-22 23:03:49','2024-11-22 23:03:49'),(8,'Pack','2024-12-04 03:27:44','2024-12-04 03:27:44');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Muhammad Rafi Heryadi','muhammadrafiheryadi94@gmail.com',NULL,'$2y$12$vFfwv6GhKGvZlqH5FpMfCeBhdSb.DhQ/VyGIjetPRfzkMV/MiBF72','20241209003632_5.webp','vW09WZRHL5Hi42EF3pHPeZeoTyHWfSeeAaB27AcU5W2qoVF1It7H0619lDO4','2024-11-10 22:51:56','2024-12-08 17:36:32'),(9,'Maryam Layla Alfathunissa','alfathunissamaryamlayla@gmail.com',NULL,'$2y$12$dn8qiKAf1eIbZQA5yUMb.ORs6B38JLXCyXES3PGk.GU8jrZ1PxAz6','20241209004251_6.webp',NULL,'2024-12-08 17:42:52','2024-12-08 17:42:52');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-06 23:30:34
