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
-- Table structure for table `phone_historys`
--

DROP TABLE IF EXISTS `phone_historys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phone_historys` (
  `process_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lead_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone_historys`
--

LOCK TABLES `phone_historys` WRITE;
/*!40000 ALTER TABLE `phone_historys` DISABLE KEYS */;
INSERT INTO `phone_historys` VALUES ('16945','awdaw dawd','1',NULL,'2022-10-24 12:10:17','2022-10-24 12:10:17',NULL),('57626','Lucas Gloede','1',NULL,'2022-11-03 06:16:35','2022-11-03 06:16:35',NULL),('95956','gh jgh','1',NULL,'2022-11-03 11:39:01','2022-11-03 11:39:01',NULL),('47331','awdaw dawd','1',NULL,'2022-11-07 11:06:23','2022-11-07 11:06:23',NULL),('51666','adwa awda','1',NULL,'2022-11-10 06:13:15','2022-11-10 06:13:15',NULL),('58577','awd awd','1',NULL,'2022-11-14 08:39:22','2022-11-14 08:39:22',NULL),('62173','awdawd awd','dummy123456#',NULL,'2022-12-09 09:38:34','2022-12-09 09:38:34',NULL),('62173','penis','dummy123456#',NULL,'2022-12-09 10:18:21','2022-12-09 10:18:21',NULL),('48824','Peter Wallson','dummy123456#',NULL,'2022-12-09 10:42:13','2022-12-09 10:42:13',NULL),('82779','cgfbjvh','dummy123456#',NULL,'2022-12-31 13:01:11','2022-12-31 13:01:11',NULL),('82779','awdawd','fensterpacktisch',NULL,'2023-01-05 07:24:48','2023-01-05 07:24:48',NULL),('61963','awd','fensterpacktisch',NULL,'2023-01-14 08:22:08','2023-01-14 08:22:08',NULL),('64293','nö','fensterpacktisch',NULL,'2023-01-18 14:42:39','2023-01-18 14:42:39',NULL),('64293','fdhfgh','fensterpacktisch',NULL,'2023-01-18 14:48:47','2023-01-18 14:48:47',NULL),('13112','awd','fensterpacktisch',NULL,'2023-01-26 08:33:35','2023-01-26 08:33:35',NULL),('75451','awd','fensterpacktisch',NULL,'2023-02-01 11:59:55','2023-02-01 11:59:55','fase ef a asf asef asef sef aef asef sef fase ef a asf asef asef sef aef asef sef fase ef a asf asef asef sef aef asef sef fase ef a asf asef asef sef aef asef sef fase ef a asf asef asef sef aef asef sef fase ef a asf asef asef sef aef asef sef fase ef a asf asef asef sef aef asef sef fase ef a asf asef asef sef aef asef sef fase ef a asf asef asef sef aef asef sef fase ef a asf asef asef sef aef asef sef'),('85945','sef','fensterpacktisch',NULL,'2023-02-02 09:29:41','2023-02-02 09:29:41','sefsefsefse fsef');
/*!40000 ALTER TABLE `phone_historys` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:47
