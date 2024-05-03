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
  `seconds` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minutes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hours` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `info` text COLLATE utf8mb4_unicode_ci,
  `main_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`main_id`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zeiterfassung`
--

LOCK TABLES `zeiterfassung` WRITE;
/*!40000 ALTER TABLE `zeiterfassung` DISABLE KEYS */;
INSERT INTO `zeiterfassung` VALUES ('1','start',NULL,'2023-03-12 07:47:00','2023-03-20 08:12:35',NULL,NULL,NULL,'64180fad07157','Urlaub',NULL,218),('1','feierabend',NULL,'2023-03-12 14:47:00','2023-03-20 08:12:35',NULL,NULL,NULL,'64180fad07157','Urlaub',NULL,219),('1','start',NULL,'2023-03-12 01:04:00','2023-03-20 08:12:35',NULL,NULL,NULL,'64180fbf86de2','Urlaub',NULL,220),('1','feierabend',NULL,'2023-03-12 03:48:00','2023-03-20 08:12:35',NULL,NULL,NULL,'64180fbf86de2','Urlaub',NULL,221),('1','start',NULL,'2023-03-12 04:48:00','2023-03-20 08:12:35',NULL,NULL,NULL,'64180fca8be9a','Urlaub',NULL,222),('1','feierabend',NULL,'2023-03-12 05:48:00','2023-03-20 08:12:35',NULL,NULL,NULL,'64180fca8be9a','Urlaub',NULL,223),('1','start',NULL,'2023-03-15 08:12:00','2023-03-20 08:13:48',NULL,NULL,NULL,'641815bca9e8f','Arbeit',NULL,224),('1','start',NULL,'2023-03-21 07:51:00','2023-03-21 07:51:37',NULL,NULL,NULL,'64196209e968a','Arbeit',NULL,225),('1','start',NULL,'2023-03-18 08:05:00','2023-03-21 08:05:37',NULL,NULL,NULL,'64196551a3395','Arbeit','123123213',226),('1','feierabend',NULL,'2023-03-18 08:12:00','2023-03-21 08:05:53',NULL,NULL,NULL,'64196551a3395','Arbeit','',227),('1','start',NULL,'2023-03-02 08:05:00','2023-03-21 08:06:07',NULL,NULL,NULL,'6419656f90558','Arbeit','3123123',228);
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

-- Dump completed on 2023-03-30 12:40:36
