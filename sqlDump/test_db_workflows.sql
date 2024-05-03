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
-- Table structure for table `workflows`
--

DROP TABLE IF EXISTS `workflows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `workflows` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aktion` varchar(255) DEFAULT NULL,
  `employee` varchar(255) DEFAULT NULL,
  `team_id` varchar(255) DEFAULT NULL,
  `addon` varchar(255) DEFAULT NULL,
  `main` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bearbeitungszeit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workflows`
--

LOCK TABLES `workflows` WRITE;
/*!40000 ALTER TABLE `workflows` DISABLE KEYS */;
INSERT INTO `workflows` VALUES (1,'Status setzen','4','923760','119',NULL,'2024-01-11 11:05:18','2024-01-11 11:05:18',NULL,NULL),(2,'Status prüfen','4','923760','120',NULL,'2024-01-11 11:05:27','2024-01-11 11:05:27',NULL,NULL),(3,NULL,'4','923760',NULL,'1','2024-01-11 11:05:49','2024-01-11 11:05:49','Test','12'),(4,'Packtisch','4','186035','Rechnung',NULL,'2024-01-18 19:16:35','2024-01-18 19:16:35',NULL,NULL),(5,'Posteingang prüfen','4','186035',NULL,NULL,'2024-01-18 19:16:47','2024-01-18 19:16:47',NULL,NULL),(6,'Status setzen','4','186035','126',NULL,'2024-01-18 19:16:52','2024-01-18 19:16:52',NULL,NULL),(7,NULL,'4','186035',NULL,'1','2024-01-18 19:16:58','2024-01-18 19:16:58','asdawd awd','123'),(8,'Status prüfen','4','446065','125',NULL,'2024-01-22 19:19:58','2024-01-22 19:19:58',NULL,NULL),(9,NULL,'4','446065',NULL,'1','2024-01-22 19:20:00','2024-01-22 19:20:00','meeting','2');
/*!40000 ALTER TABLE `workflows` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:34:43
