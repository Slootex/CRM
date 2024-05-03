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
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attachments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `bpz` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `shortcut` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
INSERT INTO `attachments` VALUES (1,'ABS-ESP-DSC-Steuergerät','BPZ ABS ESP-Steuergerät','BPZ_ABS','ABS'),(2,'Airbag-Steuergerät','BPZ Airbag-Steuergerät','BPZ_AIR','AIRBAG'),(3,'Bordcomputer','BPZ Sonstige','BPZ_MISC','BSI'),(4,'CD-DVD-Radio','BPZ Radio Tacho','BPZ_MISC','CD'),(5,'Chip-Tuning-Leistungssteigerung','BPZ Sonstige','BPZ_MISC','TUNING'),(6,'Drosselklappe','BPZ Drosselklappe','BPZ_MISC','DROSSEL'),(7,'Getriebe-Multitronic-Steuergerät','BPZ Sonstige','BPZ_MISC','GSG'),(8,'Klimasteuergerät-Klimaanlage','BPZ Sonstige','BPZ_MISC','KLIMA'),(9,'Kombiinstrument-Tacho','BPZ Sonstige','BPZ_MISC','TACHO'),(10,'Komfort-Zentralveriegerung-Steuergerät','BPZ BSI','BPZ_MISC','ZV'),(11,'Kupplungsaktuator','BPZ Sonstige','BPZ_MISC','KA'),(12,'Lenkungsteuergerät','BPZ Lenkungssteuergerät','BPZ_MISC','LENKUNG'),(13,'Luftmengenmesser','BPZ Sonstige','BPZ_MISC','LMM'),(14,'Motor- Zünd- Steuergerät','BPZ Motor-Steuergerät','BPZ_MSG','MSG'),(15,'Navigationsgerät','BPZ Sonstige','BPZ_MISC','NAVI'),(16,'Pumpensteuergerät','BPZ Sonstige','BPZ_MISC','PUMPE'),(17,'SBC-Steuergerät-Einheit','BPZ SBC-Steuergerät','BPZ_MISC','SBC'),(18,'Turbolader','BPZ Sonstige','BPZ_MISC','TURBO'),(19,'Unbekanntes-Steuergerät','BPZ Sonstige','BPZ_MISC','UNKNOW'),(20,'Verdeck-Steuergerät','BPZ Sonstige','BPZ_MISC','VERDECK'),(21,'Xenon-Steuergerät','BPZ Sonstige','BPZ_MISC','XENON'),(22,'Prüfung','BPZ Prüfung','BPZ_TEST','TEST'),(23,'Allgemiener Hinweis','All Hinweis','BPZ_TEIL_2','HINWEIS'),(24,'Gummibärchen','gummi','gummi','GUMMI'),(25,'Überspannungsschutz','prot','prot','PROT'),(26,'Verplomben','seal','seal','SEAL');
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

-- Dump completed on 2024-02-23 11:35:22
