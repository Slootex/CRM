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
-- Table structure for table `bpzfiles`
--

DROP TABLE IF EXISTS `bpzfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bpzfiles` (
  `id` varchar(255) DEFAULT NULL,
  `component_name` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `Datei_1` varchar(255) DEFAULT NULL,
  `Datei_2` varchar(255) DEFAULT NULL,
  `seal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bpzfiles`
--

LOCK TABLES `bpzfiles` WRITE;
/*!40000 ALTER TABLE `bpzfiles` DISABLE KEYS */;
INSERT INTO `bpzfiles` VALUES ('1','Unbekanntes-Steuergerät','Überholung','BPZ SONSTIGE','TEIL2','1'),('2','Unbekanntes-Steuergerät','Ablehnung','BPZ PRÜFUNG','','0'),('3','Unbekanntes-Steuergerät','Prüfung','BPZ PRÜFUNG','','0'),('4','Unbekanntes-Steuergerät','Gutschrift','','','0'),('5','Unbekanntes-Steuergerät','Austausch','BPZ SONSTIGE','TEIL2','1'),('6','Xenon-Steuergerät','Überholung','BPZ SONSTIGE','','1'),('7','Xenon-Steuergerät','Ablehnung','BPZ PRÜFUNG','','0'),('8','Xenon-Steuergerät','Prüfung','BPZ PRÜFUNG','','0'),('9','Xenon-Steuergerät','Gutschrift','','','0'),('10','Xenon-Steuergerät','Austausch','BPZ SONSTIGE','TEIL2','1'),('11','Luftmengenmesser','Überholung','BPZ SONSTIGE','TEIL2','1'),('12','Luftmengenmesser','Ablehnung','BPZ PRÜFUNG','','0'),('13','Luftmengenmesser','Prüfung','BPZ PRÜFUNG','','0'),('14','Luftmengenmesser','Gutschrift','','','0'),('15','Luftmengenmesser','Austausch','BPZ SONSTIGE','TEIL2','1'),('16','Lenkungsteuergerät','Überholung','BPZ LENKUNGSSTEUERGERÄT','TEIL2','1'),('17','Lenkungsteuergerät','Ablehnung','BPZ PRÜFUNG','','0'),('18','Lenkungsteuergerät','Prüfung','BPZ PRÜFUNG','','0'),('19','Lenkungsteuergerät','Gutschrift','','','0'),('20','Lenkungsteuergerät','Austausch','BPZ LENKUNGSSTEUERGERÄT','TEIL2','1'),('21','Klimasteuergerät-Klimaanlage','Überholung','BPZ SONSTIGE','TEIL2','1'),('22','Klimasteuergerät-Klimaanlage','Ablehnung','BPZ PRÜFUNG','','0'),('23','Klimasteuergerät-Klimaanlage','Prüfung','BPZ PRÜFUNG','','0'),('24','Klimasteuergerät-Klimaanlage','Gutschrift','','','0'),('25','Klimasteuergerät-Klimaanlage','Austausch','BPZ SONSTIGE','TEIL2','1'),('26','Verdeck-Steuergerät','Überholung','BPZ SONSTIGE','TEIL2','1'),('27','Verdeck-Steuergerät','Ablehnung','BPZ PRÜFUNG','','0'),('28','Verdeck-Steuergerät','Prüfung','BPZ PRÜFUNG','','0'),('29','Verdeck-Steuergerät','Gutschrift','','','0'),('30','Verdeck-Steuergerät','Austausch','BPZ SONSTIGE','TEIL2','1'),('31','Navigationsgerät','Überholung','BPZ SONSTIGE','TEIL2','1'),('32','Navigationsgerät','Ablehnung','BPZ PRÜFUNG','','0'),('33','Navigationsgerät','Prüfung','BPZ PRÜFUNG','','0'),('34','Navigationsgerät','Gutschrift','','','0'),('35','Navigationsgerät','Austausch','BPZ SONSTIGE','TEIL2','1'),('36','Pumpensteuergerät','Überholung','BPZ SERVOLENKUNGSSTEUERGERÄT','TEIL2','1'),('37','Pumpensteuergerät','Ablehnung','BPZ PRÜFUNG','','0'),('38','Pumpensteuergerät','Prüfung','BPZ PRÜFUNG','','0'),('39','Pumpensteuergerät','Gutschrift','','','0'),('40','Pumpensteuergerät','Austausch','BPZ SERVOLENKUNGSSTEUERGERÄT','TEIL2','1'),('41','Bordcomputer','Überholung','BPZ SONSTIGE','TEIL2','1'),('42','Bordcomputer','Ablehnung','BPZ PRÜFUNG','','0'),('43','Bordcomputer','Prüfung','BPZ PRÜFUNG','','0'),('44','Bordcomputer','Gutschrift','','','0'),('45','Bordcomputer','Austausch','BPZ SONSTIGE','TEIL2','1'),('46','CD-DVD-Radio','Überholung','BPZ RADIO TACHO','TEIL2','1'),('47','CD-DVD-Radio','Ablehnung','BPZ PRÜFUNG','','0'),('48','CD-DVD-Radio','Prüfung','BPZ PRÜFUNG','','0'),('49','CD-DVD-Radio','Gutschrift','','','0'),('50','CD-DVD-Radio','Austausch','BPZ RADIO TACHO','TEIL2','1'),('51','Kupplungsaktuator','Überholung','BPZ SONSTIGE','TEIL2','1'),('52','Kupplungsaktuator','Ablehnung','BPZ PRÜFUNG','','0'),('53','Kupplungsaktuator','Prüfung','BPZ PRÜFUNG','','0'),('54','Kupplungsaktuator','Gutschrift','','','0'),('55','Kupplungsaktuator','Austausch','BPZ SONSTIGE','TEIL2','1'),('56','Getriebe-Multitronic-Steuergerät','Überholung','BPZ SONSTIGE','TEIL2','1'),('57','Getriebe-Multitronic-Steuergerät','Ablehnung','BPZ PRÜFUNG','','0'),('58','Getriebe-Multitronic-Steuergerät','Prüfung','BPZ PRÜFUNG','','0'),('59','Getriebe-Multitronic-Steuergerät','Gutschrift','','','0'),('60','Getriebe-Multitronic-Steuergerät','Austausch','BPZ SONSTIGE','TEIL2','1'),('61','Kombiinstrument-Tacho','Überholung','BPZ SONSTIGE','TEIL2','1'),('62','Kombiinstrument-Tacho','Ablehnung','BPZ PRÜFUNG','','0'),('63','Kombiinstrument-Tacho','Prüfung','BPZ PRÜFUNG','','0'),('64','Kombiinstrument-Tacho','Gutschrift','','','0'),('65','Kombiinstrument-Tacho','Austausch','BPZ SONSTIGE','TEIL2','1'),('66','Komfort-Zentralveriegerung-Steuergerät','Überholung','BPZ BSI','TEIL2','1'),('67','Komfort-Zentralveriegerung-Steuergerät','Ablehnung','BPZ PRÜFUNG','','0'),('68','Komfort-Zentralveriegerung-Steuergerät','Prüfung','BPZ PRÜFUNG','','0'),('69','Komfort-Zentralveriegerung-Steuergerät','Gutschrift','','','0'),('70','Komfort-Zentralveriegerung-Steuergerät','Austausch','BPZ BSI','TEIL2','1'),('71','Chip-Tuning-Leistungssteigerung','Überholung','BPZ SONSTIGE','TEIL2','1'),('72','Chip-Tuning-Leistungssteigerung','Ablehnung','BPZ PRÜFUNG','','0'),('73','Chip-Tuning-Leistungssteigerung','Prüfung','BPZ PRÜFUNG','','0'),('74','Chip-Tuning-Leistungssteigerung','Gutschrift','','','0'),('75','Chip-Tuning-Leistungssteigerung','Austausch','BPZ SONSTIGE','TEIL2','1'),('76','Turbolader','Überholung','BPZ SONSTIGE','TEIL2','1'),('77','Turbolader','Ablehnung','BPZ PRÜFUNG','','0'),('78','Turbolader','Prüfung','BPZ PRÜFUNG','','0'),('79','Turbolader','Gutschrift','','','0'),('80','Turbolader','Austausch','BPZ SONSTIGE','TEIL2','1'),('81','Drosselklappe','Überholung','BPZ DROSSELKLAPPE','TEIL2','1'),('82','Drosselklappe','Ablehnung','BPZ PRÜFUNG','','0'),('83','Drosselklappe','Prüfung','BPZ PRÜFUNG','','0'),('84','Drosselklappe','Gutschrift','','','0'),('85','Drosselklappe','Austausch','BPZ DROSSELKLAPPE','TEIL2','1'),('86','SBC-Steuergerät-Einheit','Überholung','BPZ SBC-STEUERGERÄT','TEIL2','1'),('87','SBC-Steuergerät-Einheit','Ablehnung','BPZ PRÜFUNG','','0'),('88','SBC-Steuergerät-Einheit','Prüfung','BPZ PRÜFUNG','','0'),('89','SBC-Steuergerät-Einheit','Gutschrift','','','0'),('90','SBC-Steuergerät-Einheit','Austausch','BPZ SBC-STEUERGERÄT','TEIL2','1'),('91','Motor- Zünd- Steuergerät','Überholung','BPZ MOTOR-STEUERGERÄT','TEIL2','1'),('92','Motor- Zünd- Steuergerät','Ablehnung','BPZ PRÜFUNG','','0'),('93','Motor- Zünd- Steuergerät','Prüfung','BPZ PRÜFUNG','','0'),('94','Motor- Zünd- Steuergerät','Gutschrift','','','0'),('95','Motor- Zünd- Steuergerät','Austausch','BPZ MOTOR-STEUERGERÄT','TEIL2','1'),('96','Airbag-Steuergerät','Überholung','BPZ AIRBAG-STEUERGERÄT','TEIL2','1'),('97','Airbag-Steuergerät','Ablehnung','BPZ PRÜFUNG','','0'),('98','Airbag-Steuergerät','Prüfung','BPZ PRÜFUNG','','0'),('99','Airbag-Steuergerät','Gutschrift','','','0'),('100','Airbag-Steuergerät','Austausch','BPZ AIRBAG-STEUERGERÄT','TEIL2','1'),('101','ABS-ESP-DSC-Steuergerät','Überholung','BPZ ABS ESP-STEUERGERÄT','TEIL2','1'),('102','ABS-ESP-DSC-Steuergerät','Ablehnung','BPZ PRÜFUNG','','0'),('103','ABS-ESP-DSC-Steuergerät','Prüfung','BPZ PRÜFUNG','','0'),('104','ABS-ESP-DSC-Steuergerät','Gutschrift','','','0'),('105','ABS-ESP-DSC-Steuergerät','Austausch','BPZ ABS ESP-STEUERGERÄT','TEIL2','1');
/*!40000 ALTER TABLE `bpzfiles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:35
