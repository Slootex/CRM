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
-- Table structure for table `component_names`
--

DROP TABLE IF EXISTS `component_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `component_names` (
  `id` int unsigned NOT NULL DEFAULT '0',
  `company_id` int unsigned NOT NULL,
  `name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `component_names`
--

LOCK TABLES `component_names` WRITE;
/*!40000 ALTER TABLE `component_names` DISABLE KEYS */;
INSERT INTO `component_names` VALUES (1,1,'Unbekanntes-Steuergerät'),(2,1,'Xenon-Steuergerät'),(3,1,'Luftmengenmesser'),(4,1,'Lenkungsteuergerät'),(5,1,'Klimasteuergerät-Klimaanlage'),(6,1,'Verdeck-Steuergerät'),(7,1,'Navigationsgerät'),(8,1,'Pumpensteuergerät'),(9,1,'Bordcomputer'),(10,1,'CD-DVD-Radio'),(11,1,'Kupplungsaktuator'),(12,1,'Getriebe-Multitronic-Steuergerät'),(13,1,'Kombiinstrument-Tacho'),(14,1,'Komfort-Zentralveriegerung-Steuergerät'),(15,1,'Chip-Tuning-Leistungssteigerung'),(16,1,'Turbolader'),(17,1,'Drosselklappe'),(18,1,'SBC-Steuergerät-Einheit'),(19,1,'Motor- Zünd- Steuergerät'),(20,1,'Airbag-Steuergerät'),(21,1,'ABS-ESP-DSC-Steuergerät');
/*!40000 ALTER TABLE `component_names` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:30
