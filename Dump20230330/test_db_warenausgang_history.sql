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
-- Table structure for table `warenausgang_history`
--

DROP TABLE IF EXISTS `warenausgang_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `warenausgang_history` (
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
  `label` varchar(255) DEFAULT NULL,
  `fotoauftrag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warenausgang_history`
--

LOCK TABLES `warenausgang_history` WRITE;
/*!40000 ALTER TABLE `warenausgang_history` DISABLE KEYS */;
INSERT INTO `warenausgang_history` VALUES ('58298','94','58298-94-ORG-1','1','ORG','on','on','on',NULL,'0',NULL,NULL,'Kunde',NULL,'2023-01-09 14:59:37','2023-01-09 14:59:37','','65',NULL,'awd','awdaw','dawd','awda','123123','1231',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','test@steubel.de',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('98998','16','98998-16-ORG-1','1','ORG','','','','BPZ Servolenkungssteuergerät','BPZ Motor-Steuergerät TECH 2',NULL,NULL,'Kunde',NULL,'2023-01-09 15:25:19','2023-01-09 15:25:19','','65',NULL,'wad','awda','wdawd','1231','2312','3123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','test@steubel.de',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('98998','16','98998-16-ORG-1','1','ORG','','','','BPZ Servolenkungssteuergerät','BPZ Motor-Steuergerät TECH 2',NULL,NULL,'Kunde',NULL,'2023-01-09 15:25:19','2023-01-09 15:25:19','','65',NULL,'wad','awda','wdawd','1231','2312','3123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','test@steubel.de',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('98998','16','98998-16-ORG-1','1','ORG','','','','BPZ Servolenkungssteuergerät','BPZ Motor-Steuergerät TECH 2',NULL,NULL,'Kunde',NULL,'2023-01-09 15:25:19','2023-01-09 15:25:19','','65',NULL,'wad','awda','wdawd','1231','2312','3123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','test@steubel.de',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('11212','26','11212-26-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-19 22:18:29','2023-01-19 22:18:29','','65',NULL,'awdawd','awdaw','dawdaw','dwad','awd','awd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawd',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('11212','45','11212-45-ORG-2','2','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-20 07:50:10','2023-01-20 07:50:10','','65',NULL,'awdawd','awdaw','dawdaw','dwad','awd','awd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawd',NULL,NULL,'',NULL),('11212','45','11212-45-ORG-2','2','ORG','','','','BPZ_MISC','BPZ_ABS',NULL,NULL,'Kunde',NULL,'2023-01-20 07:50:10','2023-01-20 07:50:10','','65',NULL,'awdawd','awdaw','dawdaw','dwad','awd','awd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawd',NULL,NULL,'',NULL),('84926','41','84926-41-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-20 08:12:59','2023-01-20 08:12:59','','65',NULL,'awda','wdawd','Matenzeile','7','13053','Berlin','awd',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awd',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('99287','35','99287-35-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-20 08:14:04','2023-01-20 08:14:04','','65',NULL,'awda','wdaw','dawd','awda','wdaw','dawd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awd',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('99287','76','99287-76-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-20 08:15:21','2023-01-20 08:15:21','','65',NULL,'awda','wdaw','dawd','awda','wdaw','dawd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awd',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('38392','72','38392-72-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-23 10:54:23','2023-01-23 10:54:23','','65','otootot','otootototootototootot','otootot','otootototootot','otootot','otootot','otootot',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','weohwfopweb.de',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('13139','29','13139-29-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-24 07:11:09','2023-01-24 07:11:09','','65',NULL,'awda','wdaw','daw','dawd','aw','dawd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','d',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('13139','29','13139-29-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-24 07:11:32','2023-01-24 07:11:32','','65',NULL,'awda','wdaw','daw','dawd','aw','dawd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','d',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('13139','29','13139-29-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-24 07:12:50','2023-01-24 07:12:50','','65',NULL,'awda','wdaw','daw','dawd','aw','dawd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','d',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('13139','29','13139-29-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-24 07:13:05','2023-01-24 07:13:05','','65',NULL,'awda','wdaw','daw','dawd','aw','dawd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','d',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('13139','29','13139-29-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-24 07:13:18','2023-01-24 07:13:18','','65',NULL,'awda','wdaw','daw','dawd','aw','dawd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','d',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('13139','29','13139-29-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-24 07:13:30','2023-01-24 07:13:30','','65',NULL,'awda','wdaw','daw','dawd','aw','dawd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','d',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('13139','29','13139-29-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-24 07:13:32','2023-01-24 07:13:32','','65',NULL,'awda','wdaw','daw','dawd','aw','dawd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','d',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('13112','54','13112-54-ORG-1','1','ORG','','','','BPZ_MISC','BPZ_MISC',NULL,NULL,'Kunde',NULL,'2023-01-26 08:00:22','2023-01-26 08:00:22','','65',NULL,'awd','awdaw','daw','dawd','awda','wdawd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awd',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('46215','73','46215-73-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-27 09:59:01','2023-01-27 09:59:01','','65',NULL,'awd','awda','wdawd','aw','dawd','awd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awd',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('46215','73','46215-73-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-27 10:03:12','2023-01-27 10:03:12','','65',NULL,'awd','awda','wdawd','aw','dawd','awd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awd',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('48351','13','48351-13-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-27 13:01:44','2023-01-27 13:01:44','','65',NULL,'awdaw','dawd','awd','dwad','awd','awd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awda',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('18379','77','18379-77-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-27 13:07:45','2023-01-27 13:07:45','','65',NULL,'wdawd','awda','awdada','d','wdawd','awd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawd',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('18379','77','18379-77-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-27 15:52:39','2023-01-27 15:52:39','','65',NULL,'wdawd','awda','awdada','d','wdawd','awd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awdawd',NULL,NULL,'1ZXXXXXXXXXXXXXXXX',NULL),('16153','33','16153-33-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-01-30 12:43:18','2023-01-30 12:43:18','','65',NULL,'awd','awd','awda','wda','wda','wd',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awd',NULL,NULL,'1ZA285F87990382535',NULL),('48592','42','48592-42-ORG-1','1','ORG','','','','BPZ_MISC','BPZ_MISC',NULL,NULL,'Kunde',NULL,'2023-02-02 08:55:31','2023-02-02 08:55:31','','65',NULL,'LzcasG','awdawd','Matenzeile','7','13053','Berlin',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','Lucasgloede20@gmailcom',NULL,NULL,'1ZA285F87990386648',NULL),('13852','52','13852-52-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-02-02 10:58:57','2023-02-02 10:58:57','','65',NULL,'awd','awdawdwa','awda','wdawd','123','12312',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','3123',NULL,NULL,'1ZA285F87998995154',NULL),('13852','69','13852-69-ORG-3','3','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-02-02 11:02:27','2023-02-02 11:02:27','','65',NULL,'awd','awdawdwa','awda','wdawd','123','12312',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','test@steubel.de',NULL,NULL,'1ZA285F87998705163',NULL),('18157','85','18157-85-ORG-1','1','ORG','','','','BPZ_MISC','BPZ_MISC',NULL,NULL,'Kunde',NULL,'2023-02-02 11:16:45','2023-02-02 11:16:45','','65',NULL,'1231','23123','1231','23123','3123','123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123123@wd.de',NULL,NULL,'1ZA285F87991767850',NULL),('98691','96','98691-96-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-02-03 10:06:20','2023-02-03 10:06:20','','65',NULL,'123','123','12312','3123','12312','3123','123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123123@ed.de',NULL,NULL,'1ZA285F87994559310',NULL),('95699','53','95699-53-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-02-03 12:03:51','2023-02-03 12:03:51','','65',NULL,'123','1231','23','1231','3123','312','123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123@d.de',NULL,NULL,'1ZA285F86897790843',NULL),('73131','76','73131-76-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-02-03 12:08:10','2023-02-03 12:08:10','','65',NULL,'123','12312','3123','1231','23','12312',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','awd@wd.de',NULL,NULL,'1ZA285F86895242251',NULL),('13139','29','13139','1','ORG',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Entsorgung',NULL,'2023-02-18 17:46:16','2023-02-18 17:46:16',NULL,NULL,'test','wad','awd','awd','1','awd','awd','1234567',NULL,'0,00','20','20','30',NULL,'5,0','1','test@steubel.de',NULL,NULL,'1ZA285F86890383359',NULL),('31829','26','31829-26-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-02-20 17:32:27','2023-02-20 17:32:27','','65',NULL,'123','12312','312','23123','123','1',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123q@d.de',NULL,NULL,'1ZA285F8FX97713734',NULL),('93659','24','93659-24-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-02-21 11:21:26','2023-02-21 11:21:26','','65',NULL,'123','123','12312','3123','123','123123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123123@d.e',NULL,NULL,'1ZA285F86895538549',NULL),('54949','98','54949-98-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-02-23 10:46:07','2023-02-23 10:46:07','','65',NULL,'1231','23123','123','123','123','12312','123',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','3123d@d.de',NULL,NULL,'1ZA285F86892815503',NULL),('89645','95','89645-95-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-02-24 09:43:57','2023-02-24 09:43:57','','65',NULL,'Lucas','Gloede','Matenzeile','7','13053','Berlin','017683412237',NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','test@steubel.de',NULL,NULL,'1ZA285F86897166152',NULL),('78141','89','78141-89-ORG-1','1','ORG','','','',NULL,NULL,NULL,NULL,'Kunde',NULL,'2023-02-24 09:46:30','2023-02-24 09:46:30','','65',NULL,'1231','231','23123','123','123','123',NULL,NULL,'0,00','30','20','10',NULL,'5.0','Deutschland','123123d@d.de',NULL,NULL,'1ZA285F86897136167',NULL);
/*!40000 ALTER TABLE `warenausgang_history` ENABLE KEYS */;
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
