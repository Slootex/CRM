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
-- Table structure for table `activitys`
--

DROP TABLE IF EXISTS `activitys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activitys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activitys`
--

LOCK TABLES `activitys` WRITE;
/*!40000 ALTER TABLE `activitys` DISABLE KEYS */;
INSERT INTO `activitys` VALUES (1,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:25','2024-01-15 16:46:25'),(2,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:27','2024-01-15 16:46:27'),(3,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:28','2024-01-15 16:46:28'),(4,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:29','2024-01-15 16:46:29'),(5,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:29','2024-01-15 16:46:29'),(6,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:29','2024-01-15 16:46:29'),(7,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:30','2024-01-15 16:46:30'),(8,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:30','2024-01-15 16:46:30'),(9,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:31','2024-01-15 16:46:31'),(10,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:31','2024-01-15 16:46:31'),(11,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:32','2024-01-15 16:46:32'),(12,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:32','2024-01-15 16:46:32'),(13,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:33','2024-01-15 16:46:33'),(14,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:33','2024-01-15 16:46:33'),(15,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:35','2024-01-15 16:46:35'),(16,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:35','2024-01-15 16:46:35'),(17,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:35','2024-01-15 16:46:35'),(18,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:36','2024-01-15 16:46:36'),(19,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:36','2024-01-15 16:46:36'),(20,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:37','2024-01-15 16:46:37'),(21,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:37','2024-01-15 16:46:37'),(22,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:38','2024-01-15 16:46:38'),(23,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:38','2024-01-15 16:46:38'),(24,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:39','2024-01-15 16:46:39'),(25,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:39','2024-01-15 16:46:39'),(26,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:39','2024-01-15 16:46:39'),(27,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:40','2024-01-15 16:46:40'),(28,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:40','2024-01-15 16:46:40'),(29,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:41','2024-01-15 16:46:41'),(30,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:41','2024-01-15 16:46:41'),(31,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:42','2024-01-15 16:46:42'),(32,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:42','2024-01-15 16:46:42'),(33,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:43','2024-01-15 16:46:43'),(34,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:43','2024-01-15 16:46:43'),(35,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:43','2024-01-15 16:46:43'),(36,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:44','2024-01-15 16:46:44'),(37,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:44','2024-01-15 16:46:44'),(38,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:46','2024-01-15 16:46:46'),(39,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:46','2024-01-15 16:46:46'),(40,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:47','2024-01-15 16:46:47'),(41,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:47','2024-01-15 16:46:47'),(42,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:47','2024-01-15 16:46:47'),(43,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:48','2024-01-15 16:46:48'),(44,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:48','2024-01-15 16:46:48'),(45,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:49','2024-01-15 16:46:49'),(46,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:49','2024-01-15 16:46:49'),(47,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:50','2024-01-15 16:46:50'),(48,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:50','2024-01-15 16:46:50'),(49,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:51','2024-01-15 16:46:51'),(50,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:51','2024-01-15 16:46:51'),(51,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:52','2024-01-15 16:46:52'),(52,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:52','2024-01-15 16:46:52'),(53,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:52','2024-01-15 16:46:52'),(54,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:53','2024-01-15 16:46:53'),(55,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:53','2024-01-15 16:46:53'),(56,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:54','2024-01-15 16:46:54'),(57,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:54','2024-01-15 16:46:54'),(58,'4','http://localhost:8000/crm/aktivit%C3%A4tsmonitor','127.0.0.1','Land Berlin, Berlin 10249','2024-01-15 16:46:55','2024-01-15 16:46:55');
/*!40000 ALTER TABLE `activitys` ENABLE KEYS */;
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
