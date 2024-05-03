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
-- Table structure for table `user_workflows`
--

DROP TABLE IF EXISTS `user_workflows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_workflows` (
  `id` int NOT NULL AUTO_INCREMENT,
  `process_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `team_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `aktion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `addon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `checked` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=335 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_workflows`
--

LOCK TABLES `user_workflows` WRITE;
/*!40000 ALTER TABLE `user_workflows` DISABLE KEYS */;
INSERT INTO `user_workflows` VALUES (125,'G5810','57633','Status prüfen','15','2023-10-26 18:19:55','2023-10-26 18:19:55',NULL),(126,'G5810','57633','E-Mail senden','15','2023-10-26 18:19:55','2023-10-26 18:19:55',NULL),(127,'G5810','57633','Status prüfen','9','2023-10-26 18:19:55','2023-10-26 18:19:55',NULL),(128,'G5810','57633','Status setzen','15','2023-10-26 18:19:55','2023-10-26 18:19:55',NULL),(144,'N6057','15128','Verschieben','Auftrag-Archiv','2023-11-23 13:32:54','2023-11-23 13:35:09','1'),(153,'Q1282','37931','Status setzen',NULL,'2023-11-24 14:15:43','2023-11-29 19:40:35','1'),(154,'T5968','19472','Versandauftrag Techniker',NULL,'2023-11-24 16:42:02','2023-11-29 19:40:35','Error, Techniker & Gerät muss ausgewählt werden!'),(155,'T5968','19472','Status setzen','132','2023-11-24 16:42:02','2023-11-24 16:42:02',NULL),(159,'X6081','9421','Wareneingang prüfen',NULL,'2023-11-29 19:34:20','2023-11-29 19:34:20',NULL),(160,'X6081','9421','Status setzen','5','2023-11-29 19:34:20','2023-11-29 19:34:20',NULL),(164,'J7062','42440','Versandauftrag Kunde',NULL,'2023-11-29 19:37:20','2023-11-29 19:40:35','Error, Gerät muss ausgewählt werden!'),(266,'H4254','961917',NULL,NULL,'2023-12-07 11:56:38','2023-12-07 11:56:38',NULL),(267,'H4254','961917',NULL,NULL,'2023-12-07 11:57:04','2023-12-07 11:57:04',NULL),(268,'H4254','961917','Versandauftrag Kunde',NULL,'2023-12-07 12:02:18','2023-12-07 12:02:18',NULL),(269,'H4254','309311','Versandauftrag Kunde',NULL,'2023-12-07 12:02:22','2023-12-07 12:02:22',NULL),(270,'H4254','56829','Status prüfen','14','2023-12-07 12:02:25','2023-12-07 12:02:25',NULL),(271,'H4254','156250','Status prüfen','31','2023-12-07 12:02:45','2023-12-07 12:02:45',NULL),(272,'H4254','156250','Status setzen','132','2023-12-07 12:02:45','2023-12-07 12:02:45',NULL),(275,'N6424','30741','Versandauftrag Kunde',NULL,'2023-12-07 12:22:10','2023-12-07 12:22:10',NULL),(286,'B8173','90829','Versandauftrag Kunde',NULL,'2023-12-07 12:32:54','2023-12-07 12:33:03','Error, Gerät muss ausgewählt werden!'),(287,'B8173','961917','Versandauftrag Kunde',NULL,'2023-12-07 12:33:05','2023-12-07 12:33:08','Error, Gerät muss ausgewählt werden!'),(288,'B8173','961917','Versandauftrag Kunde',NULL,'2023-12-07 12:33:07','2023-12-07 12:33:08','Error, Gerät muss ausgewählt werden!'),(303,'Y2015','24643','Status prüfen','14','2023-12-11 16:54:14','2023-12-11 16:54:14',NULL),(304,'U9506','7326','Status prüfen','31','2023-12-12 02:16:55','2023-12-12 02:16:55',NULL),(306,'U9506','961917','Versandauftrag Kunde',NULL,'2023-12-12 02:41:35','2023-12-12 02:41:46','Error, Gerät muss ausgewählt werden!'),(311,'E5909','56829','Status prüfen','14','2023-12-12 02:46:29','2023-12-12 02:46:29',NULL),(312,'U4868','43259','Versandauftrag Kunde',NULL,'2023-12-12 12:54:57','2023-12-12 12:55:00','Error, Gerät muss ausgewählt werden!'),(314,'H6199','56829','Status prüfen','14','2023-12-12 12:57:13','2023-12-12 12:57:13',NULL),(315,'B5242','83051','Status prüfen','14','2023-12-12 13:42:50','2023-12-12 13:44:09','1'),(316,'Y2015','24643','Versandauftrag Techniker',NULL,'2023-12-13 13:01:45','2023-12-13 13:20:39','Error, Techniker & Gerät muss ausgewählt werden!'),(323,'E5313','79792','Status setzen','119','2024-01-17 14:19:53','2024-01-17 14:20:43','1'),(324,'E5313','79792','Status prüfen','120','2024-01-17 14:19:53','2024-01-17 14:19:53',NULL),(330,'J5058','79824','Status prüfen','125','2024-01-22 19:20:29','2024-01-22 19:25:58','1'),(331,'J5058','186035','Packtisch','Rechnung','2024-01-22 19:25:39','2024-01-22 19:25:39',NULL),(332,'J5058','186035','Posteingang prüfen',NULL,'2024-01-22 19:25:39','2024-01-22 19:25:39',NULL),(334,'J5058','79824','Versandauftrag Kunde',NULL,'2024-01-22 19:27:37','2024-01-22 19:27:37',NULL);
/*!40000 ALTER TABLE `user_workflows` ENABLE KEYS */;
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
