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
-- Table structure for table `intern_history`
--

DROP TABLE IF EXISTS `intern_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `intern_history` (
  `process_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `component_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_count` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auftrag_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auftrag_info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shelfeid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `intern_history`
--

LOCK TABLES `intern_history` WRITE;
/*!40000 ALTER TABLE `intern_history` DISABLE KEYS */;
INSERT INTO `intern_history` VALUES ('U4868',NULL,NULL,NULL,'U4868-55-ORG-1','Fotoauftrag',NULL,NULL,'2024-01-05 08:36:28','2024-01-05 08:36:28','4',NULL),('1998','1998','1998','1998','138','Beschriftungsauftrag',NULL,NULL,'2024-01-05 13:54:19','2024-01-05 13:54:19','4',NULL),('8540','8540','8540','8540','140','Beschriftungsauftrag',NULL,NULL,'2024-01-22 19:16:17','2024-01-22 19:16:17','4',NULL),('J5058',NULL,NULL,NULL,'J5058-66-ORG-4','Fotoauftrag',NULL,NULL,'2024-01-22 20:00:54','2024-01-22 20:00:54','4',NULL),('9317','9317','9317','9317','142','Beschriftungsauftrag',NULL,NULL,'2024-01-23 11:12:40','2024-01-23 11:12:40','4',NULL),('1330','1330','1330','1330','143','Beschriftungsauftrag',NULL,NULL,'2024-01-23 11:17:35','2024-01-23 11:17:35','4',NULL),('5546','5546','5546','5546','144','Beschriftungsauftrag',NULL,NULL,'2024-01-23 11:21:26','2024-01-23 11:21:26','4',NULL),('4954','4954','4954','4954','145','Beschriftungsauftrag',NULL,NULL,'2024-01-23 11:27:54','2024-01-23 11:27:54','4',NULL),('J5058',NULL,NULL,NULL,'J5058-28-ORG-5','Fotoauftrag',NULL,NULL,'2024-01-23 20:02:48','2024-01-23 20:02:48','4','1A10'),('3566','3566','3566','3566','153','Beschriftungsauftrag','wadawd',NULL,'2024-01-24 13:29:06','2024-01-24 13:29:06','4','2A3'),('7305','7305','7305','7305','154','Beschriftungsauftrag',NULL,NULL,'2024-01-24 13:35:13','2024-01-24 13:35:13','4','2A4'),('X5517',NULL,NULL,NULL,'X5517-84-ORG-1','Fotoauftrag',NULL,NULL,'2024-01-24 14:22:21','2024-01-24 14:22:21','4','2A5'),('X5517',NULL,NULL,NULL,'X5517-84-ORG-1','Fotoauftrag',NULL,NULL,'2024-01-24 14:26:06','2024-01-24 14:26:06','4','2A5'),('X5517','82','ORG','5','X5517-82-ORG-5','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-26 21:49:54','2024-01-26 21:49:54','4','2B5'),('X5517','14','ORG','4','X5517-14-ORG-4','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 07:48:57','2024-01-27 07:48:57','4','2B6'),('X5517','82','ORG','5','X5517-82-ORG-5','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 07:49:14','2024-01-27 07:49:14','4','2B7'),('L9995','78','ORG','3','L9995-78-ORG-3','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 09:53:30','2024-01-27 09:53:30','4','2B10'),('L9995','87','ORG','4','L9995-87-ORG-4','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 10:05:50','2024-01-27 10:05:50','4','2B11'),('L9995','78','ORG','3','L9995-78-ORG-3','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 10:06:41','2024-01-27 10:06:41','4','2B11'),('L9995','87','ORG','4','L9995-87-ORG-4','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 10:07:13','2024-01-27 10:07:13','4','3A1'),('L9995','78','ORG','3','L9995-78-ORG-3','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 10:12:09','2024-01-27 10:12:09','4','3A1'),('J9248','19','ORG','1','J9248-19-ORG-1','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 10:24:15','2024-01-27 10:24:15','4','3A2'),('J9248','19','ORG','1','J9248-19-ORG-1','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 10:29:51','2024-01-27 10:29:51','4','3A2'),('J9248','19','ORG','1','J9248-19-ORG-1','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 10:55:12','2024-01-27 10:55:12','4','3A2'),('J9248','26','ORG','2','J9248-26-ORG-2','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 12:35:17','2024-01-27 12:35:17','4','3A6'),('X5517','14','ORG','4','X5517-14-ORG-4','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 12:56:17','2024-01-27 12:56:17','4','3A7'),('X5517','14','ORG','4','X5517-14-ORG-4','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!',NULL,'2024-01-27 13:04:15','2024-01-27 13:04:15','4','3A8'),('J4410','29','ORG','2','J4410-29-ORG-2','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!, Packet mit Sendungsnummer: 1ZA285F86897392014',NULL,'2024-01-31 12:03:17','2024-01-31 12:03:17','4','0A5'),('T9125','56','ORG','1','T9125-56-ORG-1','Einlagerungsauftrag','Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!, Packet mit Sendungsnummer: 1ZA285F80496096797',NULL,'2024-02-04 12:13:56','2024-02-04 12:13:56','4','0B6'),('T9125',NULL,NULL,NULL,NULL,'Abholauftrag',NULL,NULL,'2024-02-04 15:59:10','2024-02-04 15:59:10','4',NULL),('T9125',NULL,NULL,NULL,NULL,'Abholauftrag',NULL,NULL,'2024-02-06 21:38:10','2024-02-06 21:38:10','4',NULL);
/*!40000 ALTER TABLE `intern_history` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:24
