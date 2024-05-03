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
-- Table structure for table `zuweisungen`
--

DROP TABLE IF EXISTS `zuweisungen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zuweisungen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `process_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `textid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zuweisungen`
--

LOCK TABLES `zuweisungen` WRITE;
/*!40000 ALTER TABLE `zuweisungen` DISABLE KEYS */;
INSERT INTO `zuweisungen` VALUES (95,'T9125','4','2024-02-11 07:12:12','2024-02-11 07:12:12','65c8653c8d274','2',NULL),(96,'T9125','3','2024-02-11 09:11:23','2024-02-11 09:11:23','65c8812b40bfd','2',NULL),(97,'T9125','8','2024-02-11 09:11:23','2024-02-11 09:11:23','65c8812b4c1de','2',NULL),(98,'T9125','4','2024-02-11 09:13:21','2024-02-11 09:13:21','65c881a1b4b9f','7',NULL),(99,'T9125','8','2024-02-11 09:13:21','2024-02-11 09:13:21','65c881a1be532','7',NULL),(100,'T9125','4','2024-02-11 09:13:38','2024-02-11 09:13:38',NULL,NULL,NULL),(101,'T9125','9','2024-02-11 09:13:38','2024-02-11 09:13:38',NULL,NULL,NULL),(102,'T9125','4','2024-02-11 09:13:54','2024-02-11 09:13:54',NULL,NULL,NULL),(103,'T9125','9','2024-02-11 09:13:54','2024-02-11 09:13:54',NULL,NULL,NULL),(104,'T9125','4','2024-02-11 09:14:05','2024-02-11 09:14:05',NULL,NULL,NULL),(105,'T9125','9','2024-02-11 09:14:05','2024-02-11 09:14:05',NULL,NULL,NULL),(106,'T9125','4','2024-02-11 09:14:45','2024-02-11 09:14:45',NULL,NULL,NULL),(107,'T9125','9','2024-02-11 09:14:45','2024-02-11 09:14:45',NULL,NULL,NULL),(108,'T9125','8','2024-02-11 09:15:09','2024-02-11 09:15:09',NULL,NULL,NULL),(109,'T9125','5','2024-02-11 09:16:05','2024-02-11 09:16:05',NULL,'4',NULL),(110,'T9125','8','2024-02-11 09:16:54','2024-02-11 09:16:54',NULL,'5',NULL),(111,'Z6710','4','2024-02-11 10:30:10','2024-02-11 10:30:10',NULL,'6',NULL),(112,'Z6710','10','2024-02-11 10:30:11','2024-02-11 10:30:11',NULL,'6',NULL),(113,'Z6710','4','2024-02-11 10:30:47','2024-02-11 10:30:47',NULL,'6',NULL),(114,'Z6710','10','2024-02-11 10:30:47','2024-02-11 10:30:47',NULL,'6',NULL),(115,'Z6710','4','2024-02-11 10:32:26','2024-02-11 10:32:26',NULL,'4',NULL),(116,'Z6710','11','2024-02-11 10:32:26','2024-02-11 10:32:26',NULL,'4',NULL),(117,'Z6710','9','2024-02-11 10:32:49','2024-02-11 10:32:49','65c894417b91f','4',NULL),(118,'Z6710','12','2024-02-11 10:32:49','2024-02-11 10:32:49','65c8944186bbb','4',NULL),(119,'Z6710','5','2024-02-11 10:33:59','2024-02-11 10:33:59','65c89487e8f01','4',NULL),(120,'Z6710','9','2024-02-11 10:34:00','2024-02-11 10:34:00','65c89488046f9','4',NULL),(121,'Z6710','4','2024-02-11 10:36:23','2024-02-11 10:36:23','65c895179465d','4',NULL),(122,'Z6710','9','2024-02-11 10:36:23','2024-02-11 10:36:23','65c89517a4a68','4',NULL),(123,'Z6710','5','2024-02-11 10:37:47','2024-02-11 10:37:47','65c8956b6c69c','4',NULL),(124,'Z6710','10','2024-02-11 10:37:47','2024-02-11 10:37:47','65c8956b7bfdf','4',NULL),(125,'Z6710','4','2024-02-11 10:38:13','2024-02-11 10:38:13',NULL,'4',NULL),(126,'Z6710','9','2024-02-11 10:38:13','2024-02-11 10:38:13',NULL,'4',NULL),(127,'Z6710','3','2024-02-11 10:39:40','2024-02-11 10:39:40','65c895dc13267','4',NULL),(128,'Z6710','10','2024-02-11 10:39:40','2024-02-11 10:39:40','65c895dc2ce08','4',NULL),(129,'T9125','4','2024-02-11 19:19:34','2024-02-11 19:20:30','65c90fb61d971','4',NULL),(130,'T9125','10','2024-02-11 19:19:34','2024-02-11 19:19:34','65c90fb627fb2','4',NULL),(131,'O3826','8','2024-02-19 08:49:51','2024-02-19 08:49:51','65d3081f0a371','5',NULL),(132,'O3826','10','2024-02-19 08:49:51','2024-02-19 08:49:51','65d3081f154d7','5',NULL),(133,'O3826','4','2024-02-19 08:51:05','2024-02-19 08:51:05',NULL,'4',NULL),(134,'O3826','9','2024-02-19 08:51:05','2024-02-19 08:51:05',NULL,'4',NULL),(135,'O3826','5','2024-02-19 08:51:48','2024-02-19 11:26:52','65d3089435540','4',1),(136,'O3826','9','2024-02-19 08:51:48','2024-02-19 11:27:05','65d308944083d','4',1),(137,'O3826','3','2024-02-19 08:52:30','2024-02-19 08:52:30','65d308be954c5','4',NULL),(138,'O3826','8','2024-02-19 08:52:30','2024-02-19 08:52:30','65d308bea2c1d','4',NULL),(139,'Z3190','3','2024-02-19 08:56:15','2024-02-19 08:56:15',NULL,'4',NULL),(140,'Z3190','8','2024-02-19 08:56:15','2024-02-19 08:56:15',NULL,'4',NULL);
/*!40000 ALTER TABLE `zuweisungen` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:22
