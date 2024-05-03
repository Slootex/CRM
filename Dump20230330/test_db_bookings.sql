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
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `process_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_sum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `open_sum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `free_shipping` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `free_payment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `samstagszuschlag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mwst` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `netto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brutto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mwst_betrag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES ('55483','2','standard','transfer','35.89','333.32263157895',NULL,'2022-10-26 07:15:59','2022-10-26 08:07:58','0','0','0','19','-281.77828254848',NULL,'15.654349030471',NULL,NULL),('61578','2','international','transfer','41.6','41.6',NULL,'2022-10-26 08:10:00','2022-10-26 08:10:00','0','0','0','19','41.6',NULL,NULL,NULL,NULL),('55746','2','standard','transfer','32.19','32.19',NULL,'2022-10-26 08:11:36','2022-10-26 08:11:36','0','0','0','19','0',NULL,'0',NULL,NULL),('25157','2','standard','transfer','30.495789473684','30.495789473684',NULL,'2022-10-26 08:13:07','2022-10-26 08:13:07','0','0','0','19','30.495789473684',NULL,'1.6942105263158',NULL,NULL),('38739','2','standard','transfer','31.663684210526','31.663684210526',NULL,'2022-10-26 08:21:41','2022-10-26 08:21:41','0','0','0','19','9.4736842105263',NULL,'0.52631578947368',NULL,NULL),('69894','2','pickup','transfer','26.618679019725','26.618679019725',NULL,'2022-10-26 08:55:15','2022-10-26 08:55:15','0','0','0','19','26.618679019725','26.6','0.71428571428571',NULL,NULL),('47656','2','pickup','transfer','26.6','26.6',NULL,'2022-10-26 08:58:53','2022-10-26 08:58:53','0','0','0','19','25.885714285714','26.6','0.71428571428571',NULL,NULL),('34982','2','standard','transfer','105.59','343.54',NULL,'2022-10-26 09:06:25','2022-10-26 09:59:38','0','0','0','19','268.67','123.74085087286','1.138030527944',NULL,NULL),('59889','2','standard','transfer','105.59','211.18',NULL,'2022-10-26 10:00:38','2022-10-26 10:02:04','0','0','0','19','211.18','220.34934574786','0.1799412823184',NULL,NULL),('58496','2','standard','transfer','105.59','105.59',NULL,'2022-10-26 10:03:38','2022-10-26 10:03:38','0','0','0','19','105.59','105.76994128232','0.1799412823184',NULL,NULL),('52586','2','standard','transfer','105.59','105.59',NULL,'2022-10-26 10:07:32','2022-10-26 10:07:32','0','0','0','19','105.59','105.76994128232','0.1799412823184',NULL,NULL),('32612','2','standard','transfer','105.59','205.59',NULL,'2022-10-26 10:12:21','2022-10-26 10:33:11','0','0','0','19','205.59','267.2621','42.6721',NULL,NULL),('75272','2','standard','transfer','105.59','105.59',NULL,'2022-10-26 11:02:12','2022-10-26 11:02:12','0','0','0','19','105.59','125.6521','20.0621',NULL,NULL),('98224','2','pickup','transfer','100','350.2421',NULL,'2022-10-26 11:04:00','2022-10-26 11:04:18','0','0','0','19','205.59','244.6521','39.0621',NULL,NULL),('98224','2','pickup','transfer','200','832.8942',NULL,'2022-10-27 05:53:14','2022-10-27 05:53:14','0','0','0','19','405.59','482.6521','77.0621',NULL,NULL),('98224','2','pickup','transfer','200','832.8942',NULL,'2022-10-27 06:47:11','2022-10-27 06:47:11','0','0','0','19','405.59','482.6521','77.0621',NULL,NULL),('98224','2','pickup','transfer','200','1553.5463',NULL,'2022-10-27 06:48:24','2022-10-27 06:48:24','0','0','0','19','605.59','720.6521','115.0621',NULL,NULL),('95956','2','pickup','cash','100','100',NULL,'2022-11-03 12:33:28','2022-11-03 12:33:28','0','0','0','19','100','119','19',NULL,NULL),('95956','2','standard','transfer','105.59','344.6521',NULL,'2022-11-03 12:33:55','2022-11-03 12:33:55','0','0','0','19','205.59','244.6521','39.0621',NULL,NULL),('61937','2','standard','transfer','17.59','17.59',NULL,'2022-11-08 06:51:19','2022-11-08 06:51:19','0','0','0','19','17.59','20.9321','3.3421',NULL,NULL),('61937','1','standard','transfer','17.59','59.4542',NULL,'2022-11-08 06:51:26','2022-11-08 06:51:26','0','0','0','19','35.18','41.8642','6.6842',NULL,NULL),('82779','rechnung','standard','nachnahme','323.6','323.6',NULL,'2023-01-14 09:09:55','2023-01-14 09:09:55','on','on',NULL,NULL,'323.6','385.084','61.484',NULL,NULL),('59783','rechnung','standard','nachnahme','124.6','124.6',NULL,'2023-01-31 13:32:24','2023-01-31 13:32:24','on','on',NULL,NULL,'124.6','148.274','23.674',NULL,NULL),('59783','rechnung','standard','nachnahme','124.6','421.148',NULL,'2023-01-31 13:44:32','2023-01-31 13:44:32','on','on',NULL,NULL,'249.2','296.548','47.348',NULL,NULL),('75451','rechnung','standard','nachnahme','424.6','424.6',NULL,'2023-02-01 12:41:24','2023-02-01 12:41:24','on','on',NULL,NULL,'424.6','505.274','80.674',NULL,NULL),('75451','rechnung','standard','nachnahme','524.6','1554.148',NULL,'2023-02-01 12:41:41','2023-02-01 12:41:41','on','on',NULL,NULL,'949.2','1129.548','180.348',NULL,NULL),('98691','rechnung','standard','nachnahme','124.6','124.6',NULL,'2023-02-03 10:06:07','2023-02-03 10:06:07','on','on',NULL,NULL,'124.6','148.274','23.674',NULL,NULL),('71725','rechnung','standard','nachnahme','224.6','224.6',NULL,'2023-02-04 14:31:25','2023-02-04 14:31:25','on','on',NULL,NULL,'224.6','267.274','42.674',NULL,NULL),('37148','rechnung','standard','nachnahme','24.6','24.6',NULL,'2023-03-01 18:17:01','2023-03-01 18:17:01','on','on',NULL,NULL,'24.6','29.274','4.674',NULL,NULL);
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:34
