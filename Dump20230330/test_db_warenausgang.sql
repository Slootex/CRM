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
-- Table structure for table `warenausgang`
--

DROP TABLE IF EXISTS `warenausgang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `warenausgang` (
  `process_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `component_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_count` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gummi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `protection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bpz1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bpz2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ex_space` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shortcut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carriers_service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `streetno` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobilnumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonenumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `length` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weigth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locked` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nachnahme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fotoauftrag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warenausgang`
--

LOCK TABLES `warenausgang` WRITE;
/*!40000 ALTER TABLE `warenausgang` DISABLE KEYS */;
INSERT INTO `warenausgang` VALUES ('71884','22','71884-22-ORG-1','1','ORG',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Extern',NULL,'2023-03-03 09:58:28','2023-03-03 09:58:28',NULL,'standard','GloedeIT','wqd','awd','Mateneile','3','13053','Berlin',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland',NULL,NULL,NULL,NULL,NULL,'off',NULL,NULL,'Herr'),('37148','99','37148-99-ORG-2','2','ORG',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Extern',NULL,'2023-03-22 11:14:29','2023-03-22 11:14:29',NULL,'standard','GloedeIT','Lucas','Gloede','Matenzeile','7','13053','Berlin',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('15421','27','15421-27-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-03-22 11:21:35','2023-03-22 11:21:35','','express',NULL,'123','123','Matenzeile','7','13053','Berlin',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','test@steubel.de',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('27572','49','27572-49-ORG-2','2','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-03-22 11:24:09','2023-03-22 11:24:09','','65',NULL,'123','123','1231','2312','312321','3123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123123@123.de',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('37148','21','37148-21-ORG-2','2','ORG','','','',NULL,NULL,NULL,'','Kunde',NULL,'2023-03-22 13:11:39','2023-03-22 13:11:39','','standard',NULL,'Lucas','Gloede',NULL,'7','12679','Berlin','015371483714','015371483714','0,00','30','20','10',NULL,'5.0','Litauen','info@gaziahmad.de',NULL,NULL,NULL,NULL,'on',NULL,NULL,NULL),('86211','26','86211-26-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-03-24 10:00:05','2023-03-24 10:00:05','','65',NULL,'123','123','123','123','123','123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123@123.123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('18491','56','18491-56-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-03-24 10:00:59','2023-03-24 10:00:59','','65',NULL,'123','12312','312','3123','123','12312',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','312321@d.de',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('18491','56','18491-56-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-03-24 10:01:08','2023-03-24 10:01:08','','65',NULL,'123','12312','312','3123','123','12312',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','312321@d.de',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('86211','26','86211-26-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-03-24 10:01:59','2023-03-24 10:01:59','','65',NULL,'123','123','123','123','123','123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123@123.123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('25818','15','25818-15-ORG-1','1','ORG','','','',NULL,NULL,NULL,'Dritt Land Rechnungen Internationale Sendungen REMINDER “Achtung Internationale Sendung, Kunden Rechnung muss 2-Fach an das Paket von Außen geklebt werden','Kunde',NULL,'2023-03-28 12:05:44','2023-03-28 12:05:44','','on',NULL,'123123','123123','123123123','123','12312','123123','123123','1231','0,00','30','20','10',NULL,'5.0','USA','123123@wev.de',NULL,NULL,NULL,NULL,'off',NULL,NULL,NULL),('85137','37','85137-37-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-03-28 13:15:40','2023-03-28 13:15:40','','65',NULL,'123','123','123','123','123','123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','3123123@123123.1231',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('29229','46','29229-46-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-03-29 11:02:57','2023-03-29 11:02:57','','standard',NULL,'adawd','awd','StrausbergerPlotawdawd','1231','10243','Berlin','12','312','0,00','30','20','10',NULL,'5.0','Deutschland','123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('28116','36','28116-36-ORG-1','1','ORG','','','',NULL,NULL,NULL,'','Kunde',NULL,'2023-03-29 11:05:22','2023-03-29 11:05:22','','standard',NULL,'Lcuasdüawd','awdaw','Matenzeile123123123','7','12345','12345','123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123',NULL,NULL,NULL,NULL,'off',NULL,NULL,NULL),('28116','36','28116-36-ORG-1','1','ORG','','','',NULL,NULL,NULL,'','Kunde',NULL,'2023-03-29 14:13:20','2023-03-29 14:13:20','','standard',NULL,'Lcuasdüawd','awdaw','Matenzeile123123123','7','13053','Berlin','123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123',NULL,NULL,NULL,NULL,'off',NULL,NULL,NULL),('28116','36','28116-36-ORG-1','1','ORG','','','',NULL,NULL,NULL,'','Kunde',NULL,'2023-03-29 14:34:06','2023-03-29 14:34:06','','standard',NULL,'Lcuasdüawd','awdaw','Matenzeile123123123','7','13053','Berlin','123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123',NULL,NULL,NULL,NULL,'off',NULL,NULL,NULL),('28116','36','28116-36-ORG-1','1','ORG','','','',NULL,NULL,NULL,'','Kunde',NULL,'2023-03-29 14:36:22','2023-03-29 14:36:22','','standard',NULL,'Lcuasdüawd','awdaw','Matenzeile123123123','7','13053','Berlin','123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123',NULL,NULL,NULL,NULL,'off',NULL,NULL,NULL);
/*!40000 ALTER TABLE `warenausgang` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:31
