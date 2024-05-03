-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: test_db
-- ------------------------------------------------------
-- Server version	8.0.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tagesabschluss`
--

DROP TABLE IF EXISTS `tagesabschluss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tagesabschluss` (
  `employee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `skipped` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tagesabschluss`
--

LOCK TABLES `tagesabschluss` WRITE;
/*!40000 ALTER TABLE `tagesabschluss` DISABLE KEYS */;
INSERT INTO `tagesabschluss` VALUES ('4','skip','1','yes',NULL,'2024-01-24 11:43:40','2024-01-24 11:43:40'),('4','15','15','no',NULL,'2024-01-24 11:44:16','2024-01-24 11:44:16'),('4','16','15','no',NULL,'2024-01-24 11:44:16','2024-01-24 11:44:16'),('4','17','15','no',NULL,'2024-01-24 11:44:16','2024-01-24 11:44:16'),('4','18','15','no',NULL,'2024-01-24 11:44:17','2024-01-24 11:44:17'),('4','19','15','no',NULL,'2024-01-24 11:44:17','2024-01-24 11:44:17'),('4','20','15','no',NULL,'2024-01-24 11:44:17','2024-01-24 11:44:17'),('4','21','15','no',NULL,'2024-01-24 11:44:17','2024-01-24 11:44:17'),('4','22','15','no',NULL,'2024-01-24 11:44:18','2024-01-24 11:44:18'),('4','23','15','no',NULL,'2024-01-24 11:44:18','2024-01-24 11:44:18'),('4','24','15','no',NULL,'2024-01-24 11:44:18','2024-01-24 11:44:18'),('4','25','15','no',NULL,'2024-01-24 11:44:19','2024-01-24 11:44:19'),('4','26','15','no',NULL,'2024-01-24 11:44:19','2024-01-24 11:44:19'),('4','27','15','no',NULL,'2024-01-24 11:44:19','2024-01-24 11:44:19'),('4','28','15','no',NULL,'2024-01-24 11:44:19','2024-01-24 11:44:19'),('4','skip','1','yes',NULL,'2024-01-31 11:43:24','2024-01-31 11:43:24');
/*!40000 ALTER TABLE `tagesabschluss` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:23
