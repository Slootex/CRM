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
-- Table structure for table `zeiterfassung`
--

DROP TABLE IF EXISTS `zeiterfassung`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zeiterfassung` (
  `employee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zeiterfassung`
--

LOCK TABLES `zeiterfassung` WRITE;
/*!40000 ALTER TABLE `zeiterfassung` DISABLE KEYS */;
INSERT INTO `zeiterfassung` VALUES ('4','start',NULL,'2024-01-04 11:34:24','2024-01-04 11:34:24','Arbeit','','659697c082914'),('4','feierabend',NULL,'2024-01-04 11:34:27','2024-01-04 11:34:27','Arbeit','','659697c082914'),('4','start',NULL,'2024-01-04 20:45:45','2024-01-04 20:45:45','Arbeit','','659718f95953f'),('4','feierabend',NULL,'2024-01-04 20:45:52','2024-01-04 20:45:52','Arbeit','','659718f95953f'),('4','start',NULL,'2024-01-18 16:26:05','2024-01-18 16:26:05','Arbeit','','65a9511dca73d'),('4','feierabend',NULL,'2024-01-18 16:26:10','2024-01-18 16:26:10','Arbeit','','65a9511dca73d'),('4','start',NULL,'2024-01-27 20:28:38','2024-01-27 20:28:38','Arbeit','','65b5677681334'),('4','feierabend',NULL,'2024-01-27 20:28:40','2024-01-27 20:28:40','Arbeit','','65b5677681334'),('4','start',NULL,'2024-02-05 21:56:49','2024-02-05 21:56:49','Arbeit','','65c159a161198'),('4','feierabend',NULL,'2024-02-05 21:57:49','2024-02-05 21:57:49','Arbeit','','65c159a161198');
/*!40000 ALTER TABLE `zeiterfassung` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:34:41
