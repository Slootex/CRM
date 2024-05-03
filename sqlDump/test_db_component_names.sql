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
-- Table structure for table `component_names`
--

DROP TABLE IF EXISTS `component_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `component_names` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `bpz1` varchar(255) DEFAULT NULL,
  `bpz2` varchar(255) DEFAULT NULL,
  `seal` varchar(255) DEFAULT NULL,
  `gummi` varchar(255) DEFAULT NULL,
  `prot` varchar(255) DEFAULT NULL,
  `shortcut` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `component_names`
--

LOCK TABLES `component_names` WRITE;
/*!40000 ALTER TABLE `component_names` DISABLE KEYS */;
INSERT INTO `component_names` VALUES (1,'Unbekanntes-Steuergerät','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(2,'Unbekanntes-Steuergerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(3,'Unbekanntes-Steuergerät','Gutschrift','','','0','0','0',NULL),(4,'Unbekanntes-Steuergerät','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(5,'Xenon-Steuergerät','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(6,'Xenon-Steuergerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(7,'Xenon-Steuergerät','Gutschrift','','','0','0','0',NULL),(8,'Xenon-Steuergerät','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(9,'Luftmengenmesser','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(10,'Luftmengenmesser','Prüfung','BPZ Prüfung','','0','1','0',NULL),(11,'Luftmengenmesser','Gutschrift','','','0','0','0',NULL),(12,'Luftmengenmesser','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(13,'Lenkungsteuergerät','Überholung','BPZ Lenkungssteuergerät','All Hinweis ','1','1','0',NULL),(14,'Lenkungsteuergerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(15,'Lenkungsteuergerät','Gutschrift','','','0','0','0',NULL),(16,'Lenkungsteuergerät','Austausch','BPZ Lenkungssteuergerät','All Hinweis ','1','1','0',NULL),(17,'Klimasteuergerät-Klimaanlage','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(18,'Klimasteuergerät-Klimaanlage','Prüfung','BPZ Prüfung','','0','1','0',NULL),(19,'Klimasteuergerät-Klimaanlage','Gutschrift','','','0','0','0',NULL),(20,'Klimasteuergerät-Klimaanlage','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(21,'Verdeck-Steuergerät','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(22,'Verdeck-Steuergerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(23,'Verdeck-Steuergerät','Gutschrift','','','0','0','0',NULL),(24,'Verdeck-Steuergerät','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(25,'Navigationsgerät','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(26,'Navigationsgerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(27,'Navigationsgerät','Gutschrift','','','0','0','0',NULL),(28,'Navigationsgerät','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(29,'Pumpensteuergerät','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(30,'Pumpensteuergerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(31,'Pumpensteuergerät','Gutschrift','','','0','0','0',NULL),(32,'Pumpensteuergerät','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(33,'Bordcomputer','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(34,'Bordcomputer','Prüfung','BPZ Prüfung','','0','1','0',NULL),(35,'Bordcomputer','Gutschrift','','','0','0','0',NULL),(36,'Bordcomputer','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(37,'CD-DVD-Radio','Überholung','BPZ Radio Tacho','All Hinweis ','1','1','0',NULL),(38,'CD-DVD-Radio','Prüfung','BPZ Prüfung','','0','1','0',NULL),(39,'CD-DVD-Radio','Gutschrift','','','0','0','0',NULL),(40,'CD-DVD-Radio','Austausch','BPZ Radio Tacho','All Hinweis ','1','1','0',NULL),(41,'Kupplungsaktuator','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(42,'Kupplungsaktuator','Prüfung','BPZ Prüfung','','0','1','0',NULL),(43,'Kupplungsaktuator','Gutschrift','','','0','0','0',NULL),(44,'Kupplungsaktuator','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(45,'Getriebe-Multitronic-Steuergerät','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(46,'Getriebe-Multitronic-Steuergerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(47,'Getriebe-Multitronic-Steuergerät','Gutschrift','','','0','0','0',NULL),(48,'Getriebe-Multitronic-Steuergerät','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(49,'Kombiinstrument-Tacho','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(50,'Kombiinstrument-Tacho','Prüfung','BPZ Prüfung','','0','1','0',NULL),(51,'Kombiinstrument-Tacho','Gutschrift','','','0','0','0',NULL),(52,'Kombiinstrument-Tacho','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(53,'Komfort-Zentralveriegerung-Steuergerät','Überholung','BPZ BSI','All Hinweis ','1','1','0',NULL),(54,'Komfort-Zentralveriegerung-Steuergerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(55,'Komfort-Zentralveriegerung-Steuergerät','Gutschrift','','','0','0','0',NULL),(56,'Komfort-Zentralveriegerung-Steuergerät','Austausch','BPZ BSI','All Hinweis ','1','1','0',NULL),(57,'Chip-Tuning-Leistungssteigerung','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(58,'Chip-Tuning-Leistungssteigerung','Prüfung','BPZ Prüfung','','0','1','0',NULL),(59,'Chip-Tuning-Leistungssteigerung','Gutschrift','','','0','0','0',NULL),(60,'Chip-Tuning-Leistungssteigerung','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(61,'Turbolader','Überholung','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(62,'Turbolader','Prüfung','BPZ Prüfung','','0','1','0',NULL),(63,'Turbolader','Gutschrift','','','0','0','0',NULL),(64,'Turbolader','Austausch','BPZ Sonstige','All Hinweis ','1','1','0',NULL),(65,'Drosselklappe','Überholung','BPZ Drosselklappe','All Hinweis ','1','1','0',NULL),(66,'Drosselklappe','Prüfung','BPZ Prüfung','','0','1','0',NULL),(67,'Drosselklappe','Gutschrift','','','0','0','0',NULL),(68,'Drosselklappe','Austausch','BPZ Drosselklappe','All Hinweis ','1','1','0',NULL),(69,'SBC-Steuergerät-Einheit','Überholung','BPZ SBC-Steuergerät','All Hinweis ','1','1','0',NULL),(70,'SBC-Steuergerät-Einheit','Prüfung','BPZ Prüfung','','0','1','0',NULL),(71,'SBC-Steuergerät-Einheit','Gutschrift','','','0','0','0',NULL),(72,'SBC-Steuergerät-Einheit','Austausch','BPZ SBC-Steuergerät','All Hinweis ','1','1','0',NULL),(73,'Motor- Zünd- Steuergerät','Überholung','BPZ Motor-Steuergerät','All Hinweis ','1','1','0',NULL),(74,'Motor- Zünd- Steuergerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(75,'Motor- Zünd- Steuergerät','Gutschrift','','','0','0','0',NULL),(76,'Motor- Zünd- Steuergerät','Austausch','BPZ Motor-Steuergerät','All Hinweis ','1','1','0',NULL),(77,'Airbag-Steuergerät','Überholung','BPZ Airbag-Steuergerät','All Hinweis ','1','1','0',NULL),(78,'Airbag-Steuergerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(79,'Airbag-Steuergerät','Gutschrift','','','0','0','0',NULL),(80,'Airbag-Steuergerät','Austausch','BPZ Airbag-Steuergerät','All Hinweis ','1','1','0',NULL),(81,'ABS-ESP-DSC-Steuergerät','Überholung','BPZ ABS ESP-Steuergerät','All Hinweis ','1','1','0',NULL),(82,'ABS-ESP-DSC-Steuergerät','Prüfung','BPZ Prüfung','','0','1','0',NULL),(83,'ABS-ESP-DSC-Steuergerät','Gutschrift','','','0','0','0',NULL),(84,'ABS-ESP-DSC-Steuergerät','Austausch','BPZ ABS ESP-Steuergerät','All Hinweis ','1','1','0',NULL);
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

-- Dump completed on 2024-02-23 11:35:20
