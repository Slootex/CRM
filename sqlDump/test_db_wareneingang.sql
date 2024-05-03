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
-- Table structure for table `wareneingang`
--

DROP TABLE IF EXISTS `wareneingang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wareneingang` (
  `process_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `component_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_count` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `opened` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sticker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used_shelfe` varchar(255) DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `gerätefotos` varchar(255) DEFAULT NULL,
  `auftragsfotos` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wareneingang`
--

LOCK TABLES `wareneingang` WRITE;
/*!40000 ALTER TABLE `wareneingang` DISABLE KEYS */;
INSERT INTO `wareneingang` VALUES ('U4868','55','ORG','1','U4868-55-ORG-1',NULL,'2024-01-05 07:51:38','2024-01-05 07:51:38','off','off','4',NULL,1,NULL,NULL),('Y6533','37','ORG','1','Y6533-37-ORG-1',NULL,'2024-01-08 11:31:51','2024-01-08 11:31:51','off','off','4',NULL,2,NULL,NULL),('Y6533','31','ORG','2','Y6533-31-ORG-2',NULL,'2024-01-09 09:00:35','2024-01-09 09:00:35','off','off','4',NULL,3,NULL,NULL),('Y6533','99','ORG','3','Y6533-99-ORG-3',NULL,'2024-01-09 09:55:53','2024-01-09 09:55:53','off','off','4',NULL,4,NULL,NULL),('M2401','99','ORG','1','M2401-99-ORG-1',NULL,'2024-01-09 12:03:49','2024-01-09 12:03:49','off','off','4',NULL,5,NULL,NULL),('H7672','83','ORG','2','H7672-83-ORG-2',NULL,'2024-01-10 09:39:49','2024-01-10 09:39:49','off','off','4',NULL,6,NULL,NULL),('E5313','76','ORG','1','E5313-76-ORG-1',NULL,'2024-01-11 13:13:29','2024-01-11 13:13:29','off','off','4',NULL,7,NULL,NULL),('E5313','45','ORG','2','E5313-45-ORG-2',NULL,'2024-01-12 09:14:37','2024-01-12 09:14:37','off','off','4',NULL,8,NULL,NULL),('E5313','72','ORG','3','E5313-72-ORG-3',NULL,'2024-01-18 10:46:47','2024-01-18 10:46:47','off','off','4',NULL,9,NULL,NULL),('E5313','15','ORG','4','E5313-15-ORG-4',NULL,'2024-01-18 17:12:43','2024-01-18 17:12:43','off','off','4',NULL,10,NULL,NULL),('J5058','59','ORG','1','J5058-59-ORG-1',NULL,'2024-01-22 13:14:45','2024-01-22 13:14:45','off','off','4',NULL,11,NULL,NULL),('J5058','92','ORG','2','J5058-92-ORG-2',NULL,'2024-01-22 13:56:44','2024-01-22 13:56:44','off','off','4',NULL,12,NULL,NULL),('J5058','23','ORG','3','J5058-23-ORG-3',NULL,'2024-01-22 19:02:35','2024-01-22 19:02:35','off','off','4',NULL,13,NULL,NULL),('J5058','66','ORG','4','J5058-66-ORG-4',NULL,'2024-01-22 19:37:23','2024-01-22 19:37:23','off','off','4',NULL,14,NULL,NULL),('J5058','66','AT','1','J5058-66-AT-1',NULL,'2024-01-22 19:38:09','2024-01-22 19:38:09','off','off','4',NULL,15,NULL,NULL),('J5058','23','ORG','3','J5058-23-ORG-3',NULL,'2024-01-23 10:29:28','2024-01-23 10:29:28','off','off','4',NULL,16,NULL,NULL),('J5058','28','ORG','5','J5058-28-ORG-5',NULL,'2024-01-23 10:38:35','2024-01-23 10:38:35','off','off','4','1A2',17,NULL,NULL),('J5058','28','ORG','5','J5058-28-ORG-5',NULL,'2024-01-23 13:26:26','2024-01-23 13:26:26','off','off','4','1A10',18,NULL,NULL),('J5058','47','ORG','6','J5058-47-ORG-6',NULL,'2024-01-23 21:01:08','2024-01-23 21:01:08','on','off','4','1A11',19,NULL,NULL),('J5058','61','ORG','10','J5058-61-ORG-10',NULL,'2024-01-23 21:19:55','2024-01-23 21:19:55','on','off','4','1B4',20,'off','on'),('J5058','94','ORG','11','J5058-94-ORG-11',NULL,'2024-01-24 07:25:17','2024-01-24 07:25:17','off','off','4','1B5',21,'off','off'),('J5058','66','ORG','4','J5058-66-ORG-4',NULL,'2024-01-24 10:34:58','2024-01-24 10:34:58','off','off','4','1B6',22,'off','off'),('J5058','23','ORG','3','J5058-23-ORG-3',NULL,'2024-01-24 10:44:01','2024-01-24 10:44:01','off','off','4','1B7',23,'off','off'),('J5058','82','ORG','12','J5058-82-ORG-12',NULL,'2024-01-24 10:45:13','2024-01-24 10:45:13','off','off','4','1B8',24,'off','off'),('J5058','64','ORG','13','J5058-64-ORG-13',NULL,'2024-01-24 10:51:10','2024-01-24 10:51:10','off','off','4','1B9',25,'off','off'),('J5058','57','ORG','14','J5058-57-ORG-14',NULL,'2024-01-24 10:52:25','2024-01-24 10:52:25','off','off','4','1B10',26,'off','off'),('J5058','39','ORG','15','J5058-39-ORG-15',NULL,'2024-01-24 10:52:41','2024-01-24 10:52:41','off','off','4','1B11',27,'off','off'),('J5058','39','AT','1','J5058-39-AT-1',NULL,'2024-01-24 10:52:56','2024-01-24 10:52:56','off','off','4','2A1',28,'off','off'),('J5058','39','AT','2','J5058-39-AT-2',NULL,'2024-01-24 10:53:13','2024-01-24 10:53:13','off','off','4','2A2',29,'off','off'),('X5517','84','ORG','1','X5517-84-ORG-1',NULL,'2024-01-24 14:01:50','2024-01-24 14:01:50','off','off','4','2A5',30,'off','off'),('X5517','84','ORG','1','X5517-84-ORG-1',NULL,'2024-01-26 07:26:01','2024-01-26 07:26:01','off','off','4','2A6',31,'off','off'),('X5517','78','ORG','2','X5517-78-ORG-2',NULL,'2024-01-26 19:38:36','2024-01-26 19:38:36','off','off','4','2A9',32,'off','off'),('X5517','86','ORG','3','X5517-86-ORG-3',NULL,'2024-01-26 20:01:49','2024-01-26 20:01:49','off','off','4','2A11',33,'off','off'),('X5517','14','ORG','4','X5517-14-ORG-4',NULL,'2024-01-26 20:02:00','2024-01-26 20:02:00','off','off','4','2B1',34,'off','off'),('X5517',NULL,NULL,NULL,'X5517---',NULL,'2024-01-26 21:45:10','2024-01-26 21:45:10',NULL,NULL,'4','2B2',35,'off','off'),('X5517','82','ORG','5','X5517-82-ORG-5',NULL,'2024-01-26 21:47:10','2024-01-26 21:47:10','off','off','4','2B4',36,'off','off'),('L9995','78','ORG','3','L9995-78-ORG-3',NULL,'2024-01-27 09:50:01','2024-01-27 09:50:01','off','off','4','2B8',37,'off','off'),('L9995','87','ORG','4','L9995-87-ORG-4',NULL,'2024-01-27 09:50:28','2024-01-27 09:50:28','off','on','4','2B9',38,'off','off'),('J9248','19','ORG','1','J9248-19-ORG-1',NULL,'2024-01-27 10:21:56','2024-01-27 10:21:56','off','off','4','3A1',39,'off','off'),('X5517','14','ORG','4','X5517-14-ORG-4',NULL,'2024-01-27 11:41:23','2024-01-27 11:41:23','off','off','4','3A3',40,'off','off'),('X5517','14','ORG','4','X5517-14-ORG-4',NULL,'2024-01-27 12:24:19','2024-01-27 12:24:19','off','off','4','3A4',41,'off','off'),('J9248','26','ORG','2','J9248-26-ORG-2',NULL,'2024-01-27 12:31:54','2024-01-27 12:31:54','off','off','4','3A5',42,'off','off'),('X5517','14','ORG','4','X5517-14-ORG-4',NULL,'2024-01-27 12:52:09','2024-01-27 12:52:09','off','off','4','3A6',43,'off','off'),('J4410','61','ORG','1','J4410-61-ORG-1',NULL,'2024-01-29 09:27:42','2024-01-29 09:27:42','off','off','4','0A2',44,'off','off'),('J4410','29','ORG','2','J4410-29-ORG-2',NULL,'2024-01-31 07:15:06','2024-01-31 07:15:06','off','off','4','0A3',45,'on','off'),('J4410','55','ORG','3','J4410-55-ORG-3',NULL,'2024-01-31 11:49:18','2024-01-31 11:49:18','on','off','4','0A4',46,'off','on'),('J4410','37','ORG','4','J4410-37-ORG-4',NULL,'2024-01-31 12:10:54','2024-01-31 12:10:54','off','off','4','0A6',47,'off','off'),('J4410','78','ORG','5','J4410-78-ORG-5',NULL,'2024-01-31 12:11:31','2024-01-31 12:11:31','off','off','4','0A7',48,'off','off'),('J4410','78','AT','1','J4410-78-AT-1',NULL,'2024-01-31 12:11:51','2024-01-31 12:11:51','off','off','4','0A8',49,'off','off'),('J4410','57','ORG','6','J4410-57-ORG-6',NULL,'2024-01-31 12:12:04','2024-01-31 12:12:04','off','off','4','0A9',50,'off','off'),('T9125','56','ORG','1','T9125-56-ORG-1',NULL,'2024-02-02 13:39:45','2024-02-02 13:39:45','off','off','4','0A10',51,'off','off'),('T9125','56','ORG','1','T9125-56-ORG-1',NULL,'2024-02-03 23:25:04','2024-02-03 23:25:04','off','off','4','0A11',52,'off','off'),('T9125','56','ORG','1','T9125-56-ORG-1',NULL,'2024-02-03 23:30:31','2024-02-03 23:30:31','off','off','4','0B1',53,'off','off'),('T9125','56','ORG','1','T9125-56-ORG-1',NULL,'2024-02-03 23:32:42','2024-02-03 23:32:42','off','off','4','0B2',54,'off','off'),('T9125','56','ORG','1','T9125-56-ORG-1',NULL,'2024-02-03 23:39:08','2024-02-03 23:39:08','off','off','4','0B3',55,'off','off'),('T9125','56','ORG','1','T9125-56-ORG-1',NULL,'2024-02-04 12:11:05','2024-02-04 12:11:05','off','off','4','0B5',56,'off','off'),('M1957','44','ORG','1','M1957-44-ORG-1',NULL,'2024-02-04 15:08:45','2024-02-04 15:08:45','off','off','4','0B7',57,'off','off'),('O3826','69','ORG','1','O3826-69-ORG-1',NULL,'2024-02-06 19:25:03','2024-02-06 19:25:03','off','off','4','0B8',58,'off','off'),('X5303','29','ORG','1','X5303-29-ORG-1',NULL,'2024-02-06 19:47:15','2024-02-06 19:47:15','off','off','4','0B9',59,'off','off'),('M7086','72','ORG','1','M7086-72-ORG-1',NULL,'2024-02-06 19:54:11','2024-02-06 19:54:11','off','off','4','0B10',60,'off','off'),('F8596','77','ORG','1','F8596-77-ORG-1',NULL,'2024-02-09 15:33:34','2024-02-09 15:33:34','off','off','4','0B11',61,'off','off'),('T9125','87','ORG','2','T9125-87-ORG-2',NULL,'2024-02-11 06:55:01','2024-02-11 06:55:01','off','off','4','1A1',62,'off','off'),('T9125','92','ORG','3','T9125-92-ORG-3',NULL,'2024-02-11 07:14:04','2024-02-11 07:14:04','off','off','4','1A2',63,'on','off'),('T9125','56','ORG','1','T9125-56-ORG-1',NULL,'2024-02-11 09:19:30','2024-02-11 09:19:30','off','off','4','1A3',64,'off','off');
/*!40000 ALTER TABLE `wareneingang` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:18
