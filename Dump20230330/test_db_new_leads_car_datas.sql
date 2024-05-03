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
-- Table structure for table `new_leads_car_datas`
--

DROP TABLE IF EXISTS `new_leads_car_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `new_leads_car_datas` (
  `process_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `production_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_identification_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_power` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mileage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transmission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `broken_component` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_car` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_manufacturer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_partnumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_message_cache` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `component_company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `for_tech` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_component` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opend` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `new_leads_car_datas`
--

LOCK TABLES `new_leads_car_datas` WRITE;
/*!40000 ALTER TABLE `new_leads_car_datas` DISABLE KEYS */;
INSERT INTO `new_leads_car_datas` VALUES ('68411','Automakr','Model','12312','13123','1231','132312','circuit','petrol','awdawd',NULL,'','','PEISCHER','fdsaUrSACHE URSACHE !!!!',NULL,NULL,NULL,'2023-02-04 14:04:22','2023-02-07 12:20:44','aw',NULL,NULL),('54895',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','123123123123',NULL,'','',NULL,NULL,NULL,NULL,NULL,'2023-02-07 12:21:57','2023-02-07 12:22:10',NULL,NULL,NULL),('84762',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:18:41','2023-02-08 08:18:41',NULL,NULL,'yes'),('96165',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:19:02','2023-02-08 08:19:02',NULL,NULL,'yes'),('79129',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:19:27','2023-02-08 08:19:27',NULL,NULL,'yes'),('81165',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:20:07','2023-02-08 08:20:07',NULL,NULL,'yes'),('79826',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:20:20','2023-02-08 08:20:20',NULL,NULL,'yes'),('78571',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:20:36','2023-02-08 08:20:36',NULL,NULL,'yes'),('78692',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:21:02','2023-02-08 08:21:02',NULL,NULL,'yes'),('28617',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:21:34','2023-02-08 08:21:34',NULL,NULL,'yes'),('49152',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:21:48','2023-02-08 08:21:48',NULL,NULL,'yes'),('35786',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:22:05','2023-02-08 08:22:05',NULL,NULL,'yes'),('92632',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:22:14','2023-02-08 08:22:14',NULL,NULL,'yes'),('77394',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Kupplungsaktuator','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:22:24','2023-02-08 08:22:24',NULL,NULL,'yes'),('64726',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:23:45','2023-02-08 08:23:45',NULL,NULL,'yes'),('11385',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:24:02','2023-02-08 08:24:02',NULL,NULL,'yes'),('89685',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:24:10','2023-02-08 08:24:10',NULL,NULL,'yes'),('22963',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:24:25','2023-02-08 08:24:25',NULL,NULL,'yes'),('48726',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:24:33','2023-02-08 08:24:33',NULL,NULL,'yes'),('16842',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:24:40','2023-02-08 08:24:40',NULL,NULL,'yes'),('63263',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:25:07','2023-02-08 08:25:07',NULL,NULL,NULL),('98194',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:25:15','2023-02-08 08:25:15',NULL,NULL,NULL),('37783',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:25:48','2023-02-08 08:25:48',NULL,NULL,NULL),('95229',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:26:07','2023-02-08 08:26:07',NULL,NULL,NULL),('87126',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:26:19','2023-02-08 08:26:19',NULL,NULL,NULL),('14643',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:26:43','2023-02-08 08:26:43',NULL,NULL,NULL),('37791',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:26:54','2023-02-08 08:26:54',NULL,NULL,NULL),('62746',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:27:14','2023-02-08 08:27:14',NULL,NULL,NULL),('43762',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:27:36','2023-02-08 08:27:36',NULL,NULL,NULL),('58579',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:27:55','2023-02-08 08:27:55',NULL,NULL,NULL),('26223',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:28:03','2023-02-08 08:28:03',NULL,NULL,NULL),('63995',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:28:14','2023-02-08 08:28:14',NULL,NULL,NULL),('89298',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:28:35','2023-02-08 08:28:35',NULL,NULL,NULL),('29543',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:28:45','2023-02-08 08:28:45',NULL,NULL,NULL),('25452',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:29:01','2023-02-08 08:29:01',NULL,NULL,NULL),('96244',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:29:20','2023-02-08 08:29:20',NULL,NULL,NULL),('44849',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:29:40','2023-02-08 08:29:40',NULL,NULL,NULL),('73286',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:29:53','2023-02-08 08:29:53',NULL,NULL,NULL),('94335',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:30:58','2023-02-08 08:30:58',NULL,NULL,NULL),('73341',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Lenkungsteuergerät',NULL,'qwdqw','dwqd',NULL,NULL,NULL,NULL,NULL,'2023-02-08 08:31:27','2023-02-08 08:31:27',NULL,NULL,NULL),('27697',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Verdeck-Steuergerät','yes','123','123123',NULL,NULL,NULL,NULL,NULL,'2023-02-08 15:54:07','2023-02-08 15:54:07',NULL,NULL,'yes'),('27158',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','kgjk',NULL,'','',NULL,NULL,NULL,NULL,NULL,'2023-02-08 15:54:50','2023-02-08 15:57:19',NULL,NULL,'yes'),('92993','123','123','123','123','1231','60000','circuit','petrol','Chip-Tuning-Leistungssteigerung',NULL,'123','12312',NULL,NULL,NULL,NULL,NULL,'2023-02-10 09:17:42','2023-02-10 09:17:42',NULL,NULL,NULL),('53421',NULL,NULL,NULL,NULL,NULL,'112 km','circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-10 09:19:13','2023-02-10 09:19:13',NULL,NULL,NULL),('57759',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 08:48:45','2023-02-16 08:48:45',NULL,NULL,NULL),('44145',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 08:52:50','2023-02-16 08:52:50',NULL,NULL,NULL),('32165',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 08:59:56','2023-02-16 08:59:56',NULL,NULL,NULL),('45642',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:00:21','2023-02-16 09:00:21',NULL,NULL,NULL),('85115',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:00:48','2023-02-16 09:00:48',NULL,NULL,NULL),('72465',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:01:05','2023-02-16 09:01:05',NULL,NULL,NULL),('11731',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:01:41','2023-02-16 09:01:41',NULL,NULL,NULL),('19979',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:01:53','2023-02-16 09:01:53',NULL,NULL,NULL),('59656',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:02:18','2023-02-16 09:02:18',NULL,NULL,NULL),('27685',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:02:53','2023-02-16 09:02:53',NULL,NULL,NULL),('53735',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:03:44','2023-02-16 09:03:44',NULL,NULL,NULL),('49319',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:04:31','2023-02-16 09:04:31',NULL,NULL,NULL),('65859',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:04:50','2023-02-16 09:04:50',NULL,NULL,NULL),('21113',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:05:33','2023-02-16 09:05:33',NULL,NULL,NULL),('34813',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:05:48','2023-02-16 09:05:48',NULL,NULL,NULL),('49712',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:06:02','2023-02-16 09:06:02',NULL,NULL,NULL),('36968',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:06:11','2023-02-16 09:06:11',NULL,NULL,NULL),('71225',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:06:20','2023-02-16 09:06:20',NULL,NULL,NULL),('16211',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:06:28','2023-02-16 09:06:28',NULL,NULL,NULL),('48566',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:06:45','2023-02-16 09:06:45',NULL,NULL,NULL),('98567',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:07:56','2023-02-16 09:07:56',NULL,NULL,NULL),('21629',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:08:14','2023-02-16 09:08:14',NULL,NULL,NULL),('49523',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:08:22','2023-02-16 09:08:22',NULL,NULL,NULL),('61143',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:08:28','2023-02-16 09:08:28',NULL,NULL,NULL),('82177',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:08:33','2023-02-16 09:08:33',NULL,NULL,NULL),('17445',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:08:48','2023-02-16 09:08:48',NULL,NULL,NULL),('72547',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:10:14','2023-02-16 09:10:14',NULL,NULL,NULL),('34955',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-16 09:10:39','2023-02-16 09:10:39',NULL,NULL,NULL),('53517','ewqfaa','sfdasf','safsa','sfdsadf','dfsds','fsafd','circuit','petrol','Unbekanntes-Steuergerät',NULL,'31dsdfsadfasdfsa','12312312',NULL,NULL,NULL,NULL,NULL,'2023-02-28 18:54:21','2023-02-28 18:54:21',NULL,NULL,NULL),('46752',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-28 18:55:24','2023-02-28 18:55:24',NULL,NULL,NULL),('91696',NULL,NULL,NULL,NULL,NULL,NULL,'circuit','petrol','Unbekanntes-Steuergerät',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-03-20 08:41:26','2023-03-20 08:41:26',NULL,NULL,NULL),('57168','BMW','645','123','123123','333','123','on','on','1','on','123','123','231','23123123',NULL,NULL,NULL,'2023-03-27 14:25:34','2023-03-27 14:25:34',NULL,NULL,NULL),('53557','123','12312','2312','123123','312','31','circuit','petrol','1','yes','123','12312','23123','31',NULL,NULL,NULL,'2023-03-28 07:30:42','2023-03-28 07:30:42',NULL,NULL,'yes');
/*!40000 ALTER TABLE `new_leads_car_datas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:29