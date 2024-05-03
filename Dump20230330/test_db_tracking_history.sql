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
-- Table structure for table `tracking_history`
--

DROP TABLE IF EXISTS `tracking_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tracking_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `process_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tracking_history`
--

LOCK TABLES `tracking_history` WRITE;
/*!40000 ALTER TABLE `tracking_history` DISABLE KEYS */;
INSERT INTO `tracking_history` VALUES (1,'16153','1ZA285F87990382535','Shipper created a label, UPS has not received the package yet. ','20230130',NULL,'2023-02-23 13:01:18','2023-02-23 13:01:18'),(2,'48592','1ZA285F87990386648','Shipper created a label, UPS has not received the package yet. ','20230202',NULL,'2023-02-23 13:01:19','2023-02-23 13:01:19'),(3,'13852','1ZA285F87998995154','Shipper created a label, UPS has not received the package yet. ','20230202',NULL,'2023-02-23 13:01:20','2023-02-23 13:01:20'),(4,'13852','1ZA285F87998705163','Shipper created a label, UPS has not received the package yet. ','20230202',NULL,'2023-02-23 13:01:20','2023-02-23 13:01:20'),(5,'18157','1ZA285F87991767850','Shipper created a label, UPS has not received the package yet. ','20230202',NULL,'2023-02-23 13:01:21','2023-02-23 13:01:21'),(6,'98691','1ZA285F87994559310','Shipper created a label, UPS has not received the package yet. ','20230203',NULL,'2023-02-23 13:01:22','2023-02-23 13:01:22'),(7,'95699','1ZA285F86897790843','Shipper created a label, UPS has not received the package yet. ','20230203',NULL,'2023-02-23 13:01:23','2023-02-23 13:01:23'),(8,'73131','1ZA285F86895242251','Shipper created a label, UPS has not received the package yet. ','20230203',NULL,'2023-02-23 13:01:24','2023-02-23 13:01:24'),(9,'13139','1ZA285F86890383359','Shipper created a label, UPS has not received the package yet. ','20230218',NULL,'2023-02-23 13:01:25','2023-02-23 13:01:25'),(10,'31829','1ZA285F8FX97713734','Shipper created a label, UPS has not received the package yet. ','20230220',NULL,'2023-02-23 13:01:27','2023-02-23 13:01:27'),(11,'93659','1ZA285F86895538549','Shipper created a label, UPS has not received the package yet. ','20230221',NULL,'2023-02-23 13:01:28','2023-02-23 13:01:28'),(12,'54949','1ZA285F86892815503','Shipper created a label, UPS has not received the package yet. ','20230223',NULL,'2023-02-23 13:01:29','2023-02-23 13:01:29'),(13,'16153','1ZA285F87990382535','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230130',NULL,'2023-02-24 09:01:04','2023-02-24 09:01:04'),(14,'48592','1ZA285F87990386648','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230202',NULL,'2023-02-24 09:01:05','2023-02-24 09:01:05'),(15,'13852','1ZA285F87998995154','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230202',NULL,'2023-02-24 09:01:06','2023-02-24 09:01:06'),(16,'13852','1ZA285F87998705163','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230202',NULL,'2023-02-24 09:01:07','2023-02-24 09:01:07'),(17,'18157','1ZA285F87991767850','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230202',NULL,'2023-02-24 09:01:08','2023-02-24 09:01:08'),(18,'98691','1ZA285F87994559310','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230203',NULL,'2023-02-24 09:01:09','2023-02-24 09:01:09'),(19,'95699','1ZA285F86897790843','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230203',NULL,'2023-02-24 09:01:10','2023-02-24 09:01:10'),(20,'73131','1ZA285F86895242251','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230203',NULL,'2023-02-24 09:01:11','2023-02-24 09:01:11'),(21,'13139','1ZA285F86890383359','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230218',NULL,'2023-02-24 09:01:12','2023-02-24 09:01:12'),(22,'31829','1ZA285F8FX97713734','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230220',NULL,'2023-02-24 09:01:13','2023-02-24 09:01:13'),(23,'93659','1ZA285F86895538549','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230221',NULL,'2023-02-24 09:01:14','2023-02-24 09:01:14'),(24,'54949','1ZA285F86892815503','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230223',NULL,'2023-02-24 09:01:15','2023-02-24 09:01:15'),(25,'18491','1ZA285F86895779057','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230223',NULL,'2023-02-24 09:01:16','2023-02-24 09:01:16'),(26,'37148','1ZA285F8689170129','apwdjwapojdapiowd','20230301',NULL,'2023-02-24 09:01:16','2023-02-24 09:01:16'),(27,'89645','1ZA285F86897166152','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230224',NULL,'2023-03-02 13:34:40','2023-03-02 13:34:40'),(28,'78141','1ZA285F86897136167','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230224',NULL,'2023-03-02 13:34:41','2023-03-02 13:34:41'),(29,'86211','1ZA285F86895306772','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230224',NULL,'2023-03-02 13:34:42','2023-03-02 13:34:42'),(30,'27572','1ZA285F86891632391','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230224',NULL,'2023-03-02 13:34:43','2023-03-02 13:34:43'),(31,'27572','1ZA285F86898713988','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230224',NULL,'2023-03-02 13:34:44','2023-03-02 13:34:44'),(32,'27572','1ZA285F86891128605','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230224',NULL,'2023-03-02 13:34:45','2023-03-02 13:34:45'),(33,'85137','1ZA285F86896553799','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230224',NULL,'2023-03-02 13:34:46','2023-03-02 13:34:46'),(34,'15421','1ZA285F86890792658','Stornierte Info erhalten ','20230228',NULL,'2023-03-02 13:34:47','2023-03-02 13:34:47'),(35,'15421','1ZA285F86890792658','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230227',NULL,'2023-03-02 13:34:47','2023-03-02 13:34:47'),(36,'37148','1ZA285F86899094137','Versender hat einen Aufkleber erstellt, UPS hat das Paket noch nicht erhalten. ','20230302',NULL,'2023-03-03 09:36:42','2023-03-03 09:36:42');
/*!40000 ALTER TABLE `tracking_history` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:46
