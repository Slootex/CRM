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
-- Table structure for table `leads_archive_cars`
--

DROP TABLE IF EXISTS `leads_archive_cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leads_archive_cars` (
  `process_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `production_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_identification_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_power` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mileage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transmission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `broken_component` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_car` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_manufacturer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_partnumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_message_cache` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads_archive_cars`
--

LOCK TABLES `leads_archive_cars` WRITE;
/*!40000 ALTER TABLE `leads_archive_cars` DISABLE KEYS */;
INSERT INTO `leads_archive_cars` VALUES ('89941','123','123','123','123','123','123','circuit','petrol','0','yes',NULL,NULL,NULL,'123','123','123',NULL,'2022-10-28 05:46:38','2022-10-28 05:46:38'),('64346','1231','2312','3123','123','123123','123213','automatic','petrol','3','yes',NULL,NULL,NULL,'12312','123123','1231',NULL,'2022-10-28 05:53:34','2022-10-28 05:53:34'),('99536','BMW','BMW model','2016','129NJUD8D91D','210','46500','automatic','petrol','17','yes',NULL,NULL,NULL,'Der springt am anfang an dann geht nich mehr','BMWGeräte','912HdK82Hd',NULL,'2022-10-28 07:43:51','2022-10-28 07:43:51'),('39311','1231231','2312','3123','1231','23123','23123','automatic','petrol','2','yes',NULL,NULL,NULL,'31231','123123','123',NULL,'2022-10-28 10:51:07','2022-10-28 10:51:07'),('29126','BMW','BMWModell','2016',NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,'awdawdawdawd',NULL,NULL,NULL,'2022-11-01 10:57:01','2022-11-01 10:57:01'),('35138','BMW','BMWModell','2016',NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,'awdawdawdawd',NULL,NULL,NULL,'2022-11-01 11:01:26','2022-11-01 11:01:26'),('57626','BMW','BMWModell',NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-03 06:18:21','2022-11-03 06:18:21'),('34754','BMW',NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-03 08:23:48','2022-11-03 08:23:48'),('22824',NULL,NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-03 08:28:04','2022-11-03 08:28:04'),('93641',NULL,NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-04 08:55:17','2022-11-04 08:55:17'),('15579',NULL,NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-04 08:57:24','2022-11-04 08:57:24'),('68517',NULL,NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-07 06:25:37','2022-11-07 06:25:37'),('53331',NULL,NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-07 06:28:44','2022-11-07 06:28:44'),('47331',NULL,NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-07 11:16:30','2022-11-07 11:16:30'),('12529',NULL,NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-08 06:12:13','2022-11-08 06:12:13'),('61937',NULL,NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-08 06:44:20','2022-11-08 06:44:20'),('51666',NULL,NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-11 07:55:36','2022-11-11 07:55:36'),('35957',NULL,NULL,NULL,NULL,NULL,'0','circuit','petrol','0','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-14 11:19:26','2022-11-14 11:19:26'),('66216',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-23 06:25:44','2022-11-23 06:25:44'),('85928',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-11-23 14:16:34','2022-11-23 14:16:34'),('42998',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-12-26 23:09:05','2022-12-26 23:09:05'),('82779','sawdawd','123','123123',NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator',NULL,'awdaw',NULL,NULL,NULL,NULL,NULL,NULL,'2023-01-13 20:50:48','2023-01-13 20:50:48'),('28822',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-01-14 09:20:59','2023-01-14 09:20:59'),('56443',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-01-14 12:04:04','2023-01-14 12:04:04'),('55245','BMW','Model','123123',NULL,NULL,NULL,'circuit','petrol',NULL,NULL,NULL,NULL,NULL,NULL,'BMW','BUMERANG',NULL,'2023-01-18 18:59:12','2023-01-18 18:59:12'),('48464',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-01-19 08:42:22','2023-01-19 08:42:22'),('38392',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-01-20 10:55:22','2023-01-20 10:55:22');
/*!40000 ALTER TABLE `leads_archive_cars` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:35
