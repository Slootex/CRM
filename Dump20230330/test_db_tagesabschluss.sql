-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: test_db
-- ------------------------------------------------------
-- Server version	8.0.31

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
INSERT INTO `tagesabschluss` VALUES ('fensterpacktisch','Packetbänder','3','no',NULL,'2023-01-02 12:01:42','2023-01-02 12:01:42'),('fensterpacktisch','S-Kartoons','4','no',NULL,'2023-01-02 12:01:42','2023-01-02 12:01:42'),('fensterpacktisch','M-Kartoons','1','no',NULL,'2023-01-02 12:01:42','2023-01-02 12:01:42'),('fensterpacktisch','Packetbänder','5','no',NULL,'2023-01-04 17:33:55','2023-01-04 17:33:55'),('fensterpacktisch','M-Kartoons','4','no',NULL,'2023-01-04 17:33:55','2023-01-04 17:33:55'),('fensterpacktisch','S-Kartoons','1','no',NULL,'2023-01-04 17:33:55','2023-01-04 17:33:55'),('fensterpacktisch','Packetbänder','5','no',NULL,'2023-01-08 15:59:00','2023-01-08 15:59:00'),('fensterpacktisch','M-Kartoons','5','no',NULL,'2023-01-08 15:59:00','2023-01-08 15:59:00'),('fensterpacktisch','Packetbänder','5','no',NULL,'2023-01-08 15:59:14','2023-01-08 15:59:14'),('fensterpacktisch','M-Kartoons','5','no',NULL,'2023-01-08 15:59:14','2023-01-08 15:59:14'),('fensterpacktisch','Packetbänder','5','no',NULL,'2023-01-08 15:59:36','2023-01-08 15:59:36'),('fensterpacktisch','M-Kartoons','5','no',NULL,'2023-01-08 15:59:36','2023-01-08 15:59:36'),('fensterpacktisch','Packetbänder','5','no',NULL,'2023-01-08 16:00:09','2023-01-08 16:00:09'),('fensterpacktisch','M-Kartoons','5','no',NULL,'2023-01-08 16:00:09','2023-01-08 16:00:09'),('fensterpacktisch','Packetbänder','5','no',NULL,'2023-01-08 16:00:34','2023-01-08 16:00:34'),('fensterpacktisch','M-Kartoons','5','no',NULL,'2023-01-08 16:00:34','2023-01-08 16:00:34'),('fensterpacktisch','barcode','M-Kartoons','no',NULL,'2023-01-19 18:12:18','2023-01-19 18:12:18'),('fensterpacktisch','Packetbänder','3','no',NULL,'2023-01-19 18:12:18','2023-01-19 18:12:18'),('fensterpacktisch','M-Kartoons','3','no',NULL,'2023-01-19 18:12:18','2023-01-19 18:12:18'),('fensterpacktisch','XL-Kartoons','1','no',NULL,'2023-01-19 19:06:39','2023-01-19 19:06:39'),('fensterpacktisch','M-Kartoons','1','no',NULL,'2023-01-19 19:06:39','2023-01-19 19:06:39'),('fensterpacktisch','S-Kartoons','1','no',NULL,'2023-01-19 19:06:39','2023-01-19 19:06:39'),('fensterpacktisch','Packetbänder','3','no',NULL,'2023-01-20 08:41:54','2023-01-20 08:41:54'),('fensterpacktisch','M-Kartoons','3','no',NULL,'2023-01-20 08:41:54','2023-01-20 08:41:54'),('fensterpacktisch','Packetbänder','1','no',NULL,'2023-01-27 16:12:20','2023-01-27 16:12:20'),('fensterpacktisch','Packetbänder','1','no',NULL,'2023-01-27 16:12:56','2023-01-27 16:12:56'),('fensterpacktisch','Packetbänder','1','no',NULL,'2023-01-27 16:13:20','2023-01-27 16:13:20'),('fensterpacktisch','Packetbänder','1','no',NULL,'2023-01-27 16:13:51','2023-01-27 16:13:51'),('fensterpacktisch','Packetbänder','1','no',NULL,'2023-01-27 16:14:31','2023-01-27 16:14:31'),('fensterpacktisch','skip','1','yes',NULL,'2023-03-02 14:22:18','2023-03-02 14:22:18'),('fensterpacktisch','skip','1','yes',NULL,'2023-03-03 09:40:04','2023-03-03 09:40:04'),('fensterpacktisch','skip','1','yes',NULL,'2023-03-03 09:40:57','2023-03-03 09:40:57');
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

-- Dump completed on 2023-03-30 12:40:27
