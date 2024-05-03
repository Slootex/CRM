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
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attachments` (
  `id` int unsigned NOT NULL DEFAULT '0',
  `company_id` int unsigned NOT NULL,
  `name` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `file` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `barcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
INSERT INTO `attachments` VALUES (1,1,'BPZ Sonstige','BPZ_Sonstige.pdf','BPZ_MISC'),(2,1,'BPZ Servolenkungssteuergerät','BPZ_Servolenkungssteuergerät.pdf','BPZ_MISC'),(3,1,'BPZ SBC-Steuergerät','BPZ_SBC-Steuergerät.pdf','BPZ_MISC'),(4,1,'BPZ Radio Tacho','BPZ_Radio_Tacho.pdf','BPZ_MISC'),(5,1,'BPZ Prüfung','BPZ_Prüfung.pdf','BPZ_MISC'),(6,1,'BPZ Motor-Steuergerät TECH 2','BPZ_Motor-Steuergerät_TECH_2.pdf','BPZ_MISC'),(7,1,'BPZ Motor-Steuergerät SET','BPZ_Motor-Steuergerät_SET.pdf','BPZ_MISC'),(8,1,'BPZ Motor-Steuergerät IMMO','BPZ_Motor-Steuergerät_IMMO.pdf','BPZ_MISC'),(9,1,'BPZ Motor-Steuergerät','BPZ_Motor-Steuergerät.pdf','BPZ_MSG'),(10,1,'BPZ Lenkungssteuergerät','BPZ_Lenkungssteuergerät.pdf','BPZ_MISC'),(11,1,'BPZ ECU AMERIKA 2 SCHLÜSSEL','BPZ_ECU_AMERIKA_2_SCHLÜSSEL.pdf','BPZ_MISC'),(12,1,'BPZ Drosselklappe','BPZ_Drosselklappe.pdf','BPZ_MISC'),(13,1,'BPZ BSI','BPZ_BSI.pdf','BPZ_MISC'),(14,1,'BPZ Airbag-Steuergerät','BPZ_Airbag-Steuergerät.pdf','BPZ_AIR'),(15,1,'BPZ ABS Motorrad','BPZ_ABS_Motorrad.pdf','BPZ_MISC'),(16,1,'BPZ ABS ESP-Steuergerät','BPZ_ABS_ESP-Steuergerät.pdf','BPZ_ABS'),(17,1,'ALL Hinweis','ALL_Hinweis.pdf','BPZ_HIN'),(18,1,'Gummibärchen','none','gummi'),(20,1,'Überspannungsschutz','none','prot');
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:33
