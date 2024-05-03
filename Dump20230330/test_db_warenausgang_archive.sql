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
-- Table structure for table `warenausgang_archive`
--

DROP TABLE IF EXISTS `warenausgang_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `warenausgang_archive` (
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
  `fotoauftrag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warenausgang_archive`
--

LOCK TABLES `warenausgang_archive` WRITE;
/*!40000 ALTER TABLE `warenausgang_archive` DISABLE KEYS */;
INSERT INTO `warenausgang_archive` VALUES ('11193','78','11193-78-ORG-1','1','ORG','','','','0','0',NULL,'','Techniker',NULL,'2022-11-23 14:52:53','2022-11-23 14:52:53','1_ecu_pl','65','Autokomputery','Krzysztof','Jelenski','Wagrowiecka','9','62-110','Damaslawek','0048601616171',NULL,'0,00','30','20','10',NULL,'5.0','7','ecuexpert@hot.pl',NULL,NULL,NULL),('85928','26','85928-26-ORG-1','1','ORG','','','','0','0',NULL,'','Techniker',NULL,'2022-11-23 14:53:32','2022-11-23 14:53:32','1_ecu_pl','65','Autokomputery','Krzysztof','Jelenski','Wagrowiecka','9','62-110','Damaslawek','0048601616171',NULL,'0,00','30','20','10',NULL,'5.0','7','ecuexpert@hot.pl',NULL,NULL,NULL),('85928','26','85928-26-ORG-1','1','ORG','','','','BPZ MOTOR-STEUERGERÄT','6',NULL,'','Kunde',NULL,'2022-11-23 15:10:12','2022-11-23 15:10:12','','65',NULL,'awdawdawd','awdawd','aqwdawd','12','124124','awdawd','2412421',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','wadwadd.e',NULL,NULL,NULL),('85928','26','85928-26-ORG-1','1','ORG','','','','BPZ MOTOR-STEUERGERÄT','6',NULL,'','Kunde',NULL,'2022-11-23 15:10:30','2022-11-23 15:10:30','','65',NULL,'awdawdawd','awdawd','aqwdawd','12','124124','awdawd','2412421',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','wadwadd.e',NULL,NULL,NULL),('11193','78','11193-78-ORG-1','1','ORG','','','','BPZ SONSTIGE','TEIL2',NULL,'','Kunde',NULL,'2022-11-28 06:35:58','2022-11-28 06:35:58','','65',NULL,'awdawd','awdwad','awdwad','123','124124','awdaw','124',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','dawdawd@wdf.dae',NULL,NULL,NULL),('11193','78','11193-78-ORG-1','1','ORG','','','','BPZ SONSTIGE','TEIL2',NULL,'','Kunde',NULL,'2022-11-28 06:35:59','2022-11-28 06:35:59','','65',NULL,'awdawd','awdwad','awdwad','123','124124','awdaw','124',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','dawdawd@wdf.dae',NULL,NULL,NULL),('75778','15','75778-15-ORG-1','1','ORG','','','','BPZ SONSTIGE','TEIL2',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben','Kunde',NULL,'2022-11-30 09:45:23','2022-11-30 09:45:23','','65',NULL,'test','test','test','12','12345','test',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawdadawdd@d.d',NULL,NULL,NULL),('75778','15','75778-15-ORG-1','1','ORG','','','','BPZ SONSTIGE','TEIL2',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben & dawd awda wda w','Kunde',NULL,'2022-11-30 09:46:41','2022-11-30 09:46:41','','65',NULL,'test','test','test','12','12345','test',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawdadawdd@d.d',NULL,NULL,NULL),('75778','15','75778-15-ORG-1','1','ORG','','','','BPZ SONSTIGE','TEIL2',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben & dawd awda wda w','Kunde',NULL,'2022-11-30 09:47:00','2022-11-30 09:47:00','','65',NULL,'test','test','test','12','12345','test',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawdadawdd@d.d',NULL,NULL,NULL),('75778','15','75778-15-ORG-1','1','ORG','','','','BPZ SONSTIGE','TEIL2',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben & dawd awda wda w','Kunde',NULL,'2022-11-30 09:47:16','2022-11-30 09:47:16','','65',NULL,'test','test','test','12','12345','test',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawdadawdd@d.d',NULL,NULL,NULL),('75778','15','75778-15-ORG-1','1','ORG','','','','BPZ SONSTIGE','TEIL2',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben & dawd awda wda w','Kunde',NULL,'2022-11-30 09:47:44','2022-11-30 09:47:44','','65',NULL,'test','test','test','12','12345','test',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawdadawdd@d.d',NULL,NULL,NULL),('75778','15','75778-15-ORG-1','1','ORG','','','','BPZ SONSTIGE','TEIL2',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben & Bitte nerv nicht hurenoshn','Kunde',NULL,'2022-11-30 09:48:35','2022-11-30 09:48:35','','65',NULL,'test','test','test','12','12345','test',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawdadawdd@d.d',NULL,NULL,NULL),('75778','15','75778-15-ORG-1','1','ORG','','','','BPZ SONSTIGE','TEIL2',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben & Bitte nerv nicht hurenoshn','Kunde',NULL,'2022-11-30 09:48:52','2022-11-30 09:48:52','','65',NULL,'test','test','test','12','12345','test',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawdadawdd@d.d',NULL,NULL,NULL),('75778','15','75778-15-ORG-1','1','ORG','','','','BPZ SONSTIGE','TEIL2',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben & Bitte nerv nicht hurenoshn','Kunde',NULL,'2022-11-30 09:50:30','2022-11-30 09:50:30','','65',NULL,'test','test','test','12','12345','test',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawdadawdd@d.d',NULL,NULL,NULL),('14246','27','14246-27-AT-1','1','AT','','','','0','0',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben','Techniker',NULL,'2022-12-02 13:53:06','2022-12-02 13:53:06','schuster','65','Tachoreparatur24.com GmbH','Johann','Schuster','Ysenburger Str.','6','63607','Wächtersbach','01711694275','060538097343','0,00','30','20','10',NULL,'5.0','1','info@tachoreparatur24.com',NULL,NULL,NULL),('34824','75','34824-75-ORG-1','1','ORG','','','','BPZ Drosselklappe','BPZ ECU AMERIKA 2 SCHLÜSSEL',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben & awda wd awd awd wad','Kunde',NULL,'2022-12-02 14:21:22','2022-12-02 14:21:22','','65',NULL,'Lucas','Gloede','Lea-gRundig-streaß.e','23123','12321','3123123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawdda@.weawdawe',NULL,NULL,NULL),('34824','75','34824-75-ORG-1','1','ORG','','','',NULL,'0',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben & awda wd awd awd wad','Kunde',NULL,'2022-12-02 14:23:32','2022-12-02 14:23:32','','65',NULL,'Lucas','Gloede','Lea-gRundig-streaß.e','23123','12321','3123123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawdda@.weawdawe',NULL,NULL,NULL),('11844','86','11844-86-ORG-1','1','ORG','','','',NULL,'0',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben','Kunde',NULL,'2022-12-02 14:38:14','2022-12-02 14:38:14','','65',NULL,'awda','wdawd','awd','123213','12321','123','123123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','dawdawd@web.dcde',NULL,NULL,NULL),('58661','29','58661-29-ORG-1','1','ORG','','','',NULL,'0',NULL,'Bitte umbedingt fremde Kleber vom alten Techniker überkleben','Kunde',NULL,'2022-12-05 08:36:11','2022-12-05 08:36:11','','65',NULL,'awda','wdawd','awdawd','123','123123','1231','123123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','23123ewadawdw.de@dawd.aew',NULL,NULL,NULL),('91744','84','91744-84-ORG-1','1','ORG','','','',NULL,'0',NULL,'','Kunde',NULL,'2022-12-06 06:00:10','2022-12-06 06:00:10','','65',NULL,'awda','wdawd','awd','12','123213','awdaw','123123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','d123123awew@a.de',NULL,NULL,NULL),('37559','49','37559-49-ORG-2','2','ORG','','','',NULL,'0',NULL,'','Kunde',NULL,'2022-12-08 06:56:55','2022-12-08 06:56:55','','65',NULL,'12312','3123','12312312','31231','231231','2312',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','312321@.d@',NULL,NULL,NULL),('86578','25','86578-25-ORG-1','1','ORG','','','',NULL,'0',NULL,'','Kunde',NULL,'2022-12-08 06:58:14','2022-12-08 06:58:14','','65',NULL,'awda','wdawd','awdwad','1231','23123','123123','aw123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123123@-.de',NULL,NULL,NULL),('86578','25','86578-25-AT-1','1','AT','','','','BPZ SONSTIGE','TEIL2',NULL,'','Kunde',NULL,'2022-12-08 08:53:33','2022-12-08 08:53:33','','65',NULL,'awda','wdawd','awdwad','1231','23123','123123','aw123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123123@-.de',NULL,NULL,NULL),('86578','25','86578-25-AT-1','1','AT','','','','BPZ SONSTIGE','TEIL2',NULL,'','Kunde',NULL,'2022-12-08 08:53:33','2022-12-08 08:53:33','','65',NULL,'awda','wdawd','awdwad','1231','23123','123123','aw123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123123@-.de',NULL,NULL,NULL),('37559','49','37559-49-ORG-2','2','ORG','nein','ja','ja','BPZ MOTOR-STEUERGERÄT','TEIL2',NULL,'','Kunde',NULL,'2022-12-12 08:11:12','2022-12-12 08:11:12','','65',NULL,'12312','3123','12312312','31231','231231','2312',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','312321@.d@',NULL,NULL,NULL),('3947','3947','3947','3947','3947','ja','nein','ja','BPZ Prüfung','BPZ BSI',NULL,NULL,'standard',NULL,'2022-12-19 08:06:19','2022-12-19 08:06:19',NULL,'65',NULL,'awd','awdaw','dawd','123','123','123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland',NULL,'standard','transfer',NULL),('3947','3947','3947','3947','3947','ja','nein','ja','BPZ SBC-Steuergerät','BPZ SBC-Steuergerät',NULL,NULL,'Direkt Versand',NULL,'2022-12-19 08:09:47','2022-12-19 08:09:47',NULL,'65',NULL,'awdaw','dawd','awdawd','12','123123','123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland',NULL,'standard','transfer',NULL);
/*!40000 ALTER TABLE `warenausgang_archive` ENABLE KEYS */;
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
