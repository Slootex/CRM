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
-- Table structure for table `leads_archive_persons`
--

DROP TABLE IF EXISTS `leads_archive_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leads_archive_persons` (
  `process_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_street` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_street_number` int NOT NULL,
  `home_zipcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_back_company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_back_gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_back_firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_back_lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_back_street` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_back_street_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_back_zipcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_back_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_back_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pricemwst` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `submit_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `zuteilung` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_payment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads_archive_persons`
--

LOCK TABLES `leads_archive_persons` WRITE;
/*!40000 ALTER TABLE `leads_archive_persons` DISABLE KEYS */;
INSERT INTO `leads_archive_persons` VALUES ('89941','31',NULL,'herr','12312','312','23123@web.de','123','12321','3123',312,'123','123','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-10-28 05:46:38','2022-10-28 05:46:38',NULL,NULL),('64346','31',NULL,'herr','awdawd','awdaw','test@steubel.de','123123','123123','dawdawd',12,'12312','dadwaw','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-10-28 05:53:34','2022-10-28 05:53:34',NULL,NULL),('99536','31',NULL,'herr','Lucas','Gloede','lucasgloede20@gmail.cm','0305631077','01575125004','Lea-Grundig-Straße',2,'12679','Berlin','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-10-28 07:43:51','2022-10-28 07:43:51',NULL,NULL),('39311','31',NULL,'herr','Lucas','Gloede','test@steubel.de','123123','123123','Lea-Grundig-Straße',2,'12679','Berlin','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-10-28 10:51:07','2022-10-28 10:51:07',NULL,NULL),('29126','31',NULL,'herr','Lucas','Gloede','test@steubel.de','015751250004','015751250004','Lea-Grundig-Straße',2,'12679','Berlin','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-01 10:57:01','2022-11-01 10:57:01',NULL,NULL),('35138','31',NULL,'herr','Lucas','Gloede','test@steubel.de','015751250004','015751250004','Lea-Grundig-Straße',2,'123','213','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-01 11:01:26','2022-11-01 11:01:26',NULL,NULL),('57626','31',NULL,'herr','Lucas','Gloede','test@steubel.de','017683412237','017683412237','Lea-Grundig-Stra0e',2,'12679','Berlin','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-03 06:18:21','2022-11-03 06:18:21',NULL,NULL),('34754','31',NULL,'herr','Lucas','Gloede','test@steubel.de','017683412237','017683412237','Lea-Grundig-Straße',2,'12679','Berlin','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-03 08:23:48','2022-11-03 08:23:48',NULL,NULL),('22824','31',NULL,'herr','asdf','sadf','1ghjkjlo723@web.de','23142134','1223234','sadfa',123,'123','123','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-03 08:28:04','2022-11-03 08:28:04',NULL,NULL),('93641','31',NULL,'herr','sfdaf','asd','adwa@web.de',NULL,NULL,'fasd',12,'12','ada','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','1','0','intern',NULL,'2022-11-04 08:55:17','2022-11-04 08:55:17',NULL,NULL),('15579','31',NULL,'herr','asdfsa','dfsadf','awdwad@web.dde',NULL,NULL,'sadfsad',2,'123124','asdawd','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-04 08:57:24','2022-11-04 08:57:24',NULL,NULL),('68517','31',NULL,'herr','sadaw','dawd','awr568fughkmd@web.de','34','23423','wadawd',12,'123','12d1','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-07 06:25:37','2022-11-07 06:25:37',NULL,NULL),('53331','31',NULL,'herr','4567','456754','546754e@web.de','41342345','12423','675467',546754,'675467','5467','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-07 06:28:44','2022-11-07 06:28:44',NULL,NULL),('47331','31',NULL,'herr','awdaw','dawd','awdaw@web.de','12','123','awdwad',2,'12341','awdawd','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-07 11:16:30','2022-11-07 11:16:30',NULL,NULL),('12529','31',NULL,'herr','awdaw','dawd','aqw@web.de',NULL,NULL,'awdwd',12,'12341','dawd','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-08 06:12:13','2022-11-08 06:12:13',NULL,NULL),('61937','31',NULL,'herr','dfg','sdfg','dawd@we.dw',NULL,NULL,'sdfg',123,'12312','dadaw','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-08 06:44:20','2022-11-08 06:44:20',NULL,NULL),('51666','31',NULL,'herr','adwa','awda','awdawd@eb.de','124214','1241243','awdawd',2,'12341','awd','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-11 07:55:36','2022-11-11 07:55:36',NULL,NULL),('35957','31',NULL,'herr','awd','awdaw','12312@wdawd.awdea1','12','3123','awdawd',123,'123123','123','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0,00','standard','transaction','intern',NULL,'2022-11-14 11:19:26','2022-11-14 11:19:26',NULL,NULL),('66216','dummy123456#',NULL,'Herr','superauftrag','superauftrag','test@steubel.de',NULL,'01575125004','Lea-Grundig-Straße',2,'12679','Berlin','Deutschland',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Deutschland','19','standard','nachnahme','intern',NULL,'2022-11-23 06:25:44','2022-11-23 06:25:44','0','0'),('85928','dummy123456#',NULL,'Herr','awdawdawd','awdawd','wadwadd.e',NULL,'2412421','aqwdawd',12,'124124','awdawd','Deutschland',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Deutschland','19','standard','nachnahme','intern',NULL,'2022-11-23 14:16:34','2022-11-23 14:16:34','0','0'),('42998','dummy123456#',NULL,'Herr','awdawd','wd','123123@d.dae',NULL,NULL,'awdwd',123123,'123123','123','Deutschland',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Deutschland','19','standard','nachnahme','intern',NULL,'2022-12-26 23:09:05','2022-12-26 23:09:05','0','0'),('82779','dummy123456#',NULL,'Herr','awdaw','dawd','123123@wdaqw.dawe',NULL,'3123','awdawdaw',12312,'312','12','Deutschland',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Deutschland','19','inernational','transfer','intern',NULL,'2023-01-13 20:50:48','2023-01-13 20:50:48','0','0'),('28822','fensterpacktisch',NULL,'Herr','123','123123','123123@wd.e',NULL,'123123','123',123123,'123','123','Deutschland',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Deutschland','19','standard','nachnahme','intern',NULL,'2023-01-14 09:20:59','2023-01-14 09:20:59','0','0'),('56443','fensterpacktisch',NULL,'Herr','12312','3123','2312312@e.de',NULL,NULL,'12312',3123,'23123','1231','Deutschland',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Deutschland','19','standard','nachnahme','intern',NULL,'2023-01-14 12:04:04','2023-01-14 12:04:04','0','0'),('55245','dummy123456#',NULL,'Herr','awdaw','dawd','daa@weserfb.de',NULL,'123','awdawda',2,'12341','awdaw','Deutschland',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Deutschland','19','standard','nachnahme','intern',NULL,'2023-01-18 18:59:12','2023-01-18 18:59:12','0','0'),('48464','fensterpacktisch',NULL,'Herr','awd','awdaw','23123',NULL,NULL,'dawd',123,'123','1231','Deutschland',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Deutschland','19','standard','nachnahme','intern',NULL,'2023-01-19 08:42:22','2023-01-19 08:42:22','0','0'),('38392','fensterpacktisch','trest','Frau','hsdifdhi','ofdahpisafdhpo','weohwfopweb.de',NULL,NULL,'adfhdsfisdh',121,'55456','ljfhswfk','Deutschland',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Deutschland','19','standard','nachnahme','intern',NULL,'2023-01-20 10:55:22','2023-01-20 10:55:22','0','0');
/*!40000 ALTER TABLE `leads_archive_persons` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:28
