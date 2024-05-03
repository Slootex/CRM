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
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'default','{\"uuid\":\"8d783831-e461-45b3-a561-5e83579cc4b2\",\"displayName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\saveTrackingnumber\\\":2:{s:2:\\\"id\\\";s:3:\\\"123\\\";s:10:\\\"connection\\\";s:8:\\\"database\\\";}\"},\"telescope_uuid\":\"9b33050b-0bdc-4ac9-ae4b-5791a6954a66\"}',0,NULL,1706434302,1706434302),(2,'default','{\"uuid\":\"760a1edb-cb7b-4211-a9c6-e2d3c97d31dd\",\"displayName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\saveTrackingnumber\\\":2:{s:2:\\\"id\\\";s:3:\\\"123\\\";s:10:\\\"connection\\\";s:8:\\\"database\\\";}\"},\"telescope_uuid\":\"9b33062c-f001-4e3f-834f-10fa7e0a0bd5\"}',0,NULL,1706434492,1706434492),(3,'default','{\"uuid\":\"f307f35e-7618-454b-a8a7-ea12bd283421\",\"displayName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\saveTrackingnumber\\\":2:{s:2:\\\"id\\\";s:4:\\\"1234\\\";s:10:\\\"connection\\\";s:8:\\\"database\\\";}\"},\"telescope_uuid\":\"9b330776-c75f-421c-b6d7-b918bd0c91eb\"}',0,NULL,1706434708,1706434708),(4,'default','{\"uuid\":\"6160e083-17f9-4467-b541-896f65c035cc\",\"displayName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\saveTrackingnumber\\\":2:{s:2:\\\"id\\\";s:3:\\\"123\\\";s:10:\\\"connection\\\";s:8:\\\"database\\\";}\"},\"telescope_uuid\":\"9b3307ef-9770-4e0f-ad05-de0afce7ccd9\"}',0,NULL,1706434787,1706434787),(5,'default','{\"uuid\":\"d6d4cbc3-dc33-43ca-9882-db1e04172814\",\"displayName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\saveTrackingnumber\\\":2:{s:2:\\\"id\\\";s:18:\\\"1ZA285F86890880133\\\";s:10:\\\"connection\\\";s:8:\\\"database\\\";}\"},\"telescope_uuid\":\"9b332903-8795-495b-9aea-29f1169cb250\"}',0,NULL,1706440337,1706440337),(6,'default','{\"uuid\":\"fb99cea2-2e5d-4804-9c2d-ef76992e613a\",\"displayName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\saveTrackingnumber\\\":2:{s:2:\\\"id\\\";s:18:\\\"1ZA285F86897350578\\\";s:10:\\\"connection\\\";s:8:\\\"database\\\";}\"},\"telescope_uuid\":\"9b332ef0-3059-40a3-a719-6d55cd06795b\"}',0,NULL,1706441331,1706441331),(7,'default','{\"uuid\":\"d75ca50c-8b46-405f-9ba0-0eb6d5515fdc\",\"displayName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\saveTrackingnumber\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\saveTrackingnumber\\\":2:{s:2:\\\"id\\\";s:18:\\\"1ZA285F80494068777\\\";s:10:\\\"connection\\\";s:8:\\\"database\\\";}\"},\"telescope_uuid\":\"9b332fda-0a71-41ec-867e-a7b460d3b118\"}',0,NULL,1706441484,1706441484);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:19
