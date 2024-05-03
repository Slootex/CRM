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
-- Table structure for table `pickups`
--

DROP TABLE IF EXISTS `pickups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pickups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refrence` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packages` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `streetnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonenumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobilnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `prn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auftrag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shippingtype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pickups`
--

LOCK TABLES `pickups` WRITE;
/*!40000 ALTER TABLE `pickups` DISABLE KEYS */;
INSERT INTO `pickups` VALUES (10,'fensterpacktisch','9','123','28.02.2023 (11:00 - 13:00)','511','1','1','123','Speedlabor Ltd.','Herr','Alexander','Wigel','Alter Stadtberg','14','84524','Neuötting','37','info@speedlabor.de','086714034667','017685057815',NULL,'2023-02-23 10:34:53','2023-02-24 09:35:27','29JFJKI2KFM',NULL,NULL),(11,'fensterpacktisch','9','123','28.02.2023 (11:00 - 13:00)','511','1','1','123','Speedlabor Ltd.','Herr','Alexander','Wigel','Alter Stadtberg','14','84524','Neuötting','37','info@speedlabor.de','086714034667','017685057815',NULL,'2023-02-23 10:37:19','2023-02-24 09:15:09','29L1P768415',NULL,NULL),(12,'fensterpacktisch','1','2023_02_24_','28.02.2023 (14:00 - 16:00)','511','1','1','2023_02_24_','LUCAS GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412237',NULL,'2023-02-24 09:23:49','2023-02-24 09:23:56','29P1QJI72ID',NULL,NULL),(13,'fensterpacktisch','1','2023_02_24_','28.02.2023 (14:00 - 16:00)','511','1','1','2023_02_24_','LUCAS GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412237',NULL,'2023-02-24 09:24:40','2023-02-24 09:35:22','29PFKKIN11P',NULL,NULL),(14,'fensterpacktisch','1','2023_02_24_','28.02.2023 (14:00 - 16:00)','511','1','1','2023_02_24_','LUCAS GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412237',NULL,'2023-02-24 09:25:21','2023-02-24 09:34:13','29D1Q60E90C',NULL,NULL),(15,'fensterpacktisch','1','2023_02_24_','28.02.2023 (14:00 - 16:00)','511','1','1','2023_02_24_','LUCAS GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412237',NULL,'2023-02-24 09:25:25','2023-02-24 09:33:29','2991Q1FOC4H',NULL,NULL),(16,'fensterpacktisch',NULL,'2023_02_24_ dirk123','24.02.2023 (17:00 - 20:00)','511','1','1.0','2023_02_24_ dirk123','awdawd','Herr','Dirkawdawd','Binnenböse','Heilmannring','66a','13627','Berlin','37','overfutz@yahoo.com','03046988530','1',NULL,'2023-02-24 12:03:57','2023-02-24 12:04:34','299FK0G8GCP',NULL,'express'),(17,'fensterpacktisch',NULL,'2023_02_24_ dirk123','24.02.2023 (17:00 - 20:00)','511','1','1.0','2023_02_24_ dirk123','awdawd','Herr','Dirkawdawd','Binnenböse','Heilmannring','66a','13627','Berlin','37','overfutz@yahoo.com','03046988530','1',NULL,'2023-02-24 12:14:01','2023-02-24 12:14:17','299FK23FJ2S',NULL,'express'),(18,'fensterpacktisch',NULL,'2023_02_27_ Ecu','27.02.2023 (16:00 - 17:00)','511','1','5.0','2023_02_27_ Ecu','ecu.de','Herr','Glaubitz GmbH','& Co. KG','Görlitzer Straße','53','02763','Zittau','204','info@norwig-verwaltung.de','03583554780',NULL,NULL,'2023-02-27 12:09:05','2023-02-27 12:09:13','29K20E2QORF',NULL,'standard'),(19,'fensterpacktisch','1','2023_02_27_ dirk123','28.02.2023 (10:00 - 15:00)','511','1','1.0','2023_02_27_ dirk123','123213','Herr','Dirkawdawd','Binnenböse','Heilmannring','66a','13627','Berlin','37','overfutz@yahoo.com','03046988530','1',NULL,'2023-02-27 14:10:37','2023-02-27 14:10:44','29720JHKBDL','12345','standard'),(20,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:26:25','2023-02-27 15:29:42','298FNFIQ64G','12341,12 1','standard'),(21,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:26:41','2023-02-27 15:29:41','29720K9IBSR','12341,12 1','standard'),(22,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:26:43','2023-02-27 15:29:39','29N20K1GKA8','12341,12 1','standard'),(23,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:26:45','2023-02-27 15:29:38','29CFNMBCN7M','12341,12 1','standard'),(24,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:26:54','2023-02-27 15:29:36','297FNN5QCJP','12341,12 1','standard'),(25,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:27:08','2023-02-27 15:29:34','29T209FDD2N','12341,12 1','standard'),(26,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:27:50','2023-02-27 15:29:33','29S20B04KMH','12341,12 1','standard'),(27,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:28:00','2023-02-27 15:29:31','29A20768OMH','12341,12 1','standard'),(28,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:28:09','2023-02-27 15:29:29','298204999H0','12341,12 1','standard'),(29,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:28:19','2023-02-27 15:29:21','297FNN2J3RD','12341,12 1','standard'),(30,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:28:30','2023-02-27 15:29:15','29SFN9RM50J','12341,12 1','standard'),(31,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 14:00)','511','1','1','2023_02_27_','GLOEDE IT','Herr','Lucas','Gloede','Matenzeile','7','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412337',NULL,'2023-02-27 15:28:47','2023-02-27 15:29:10','29S20D9DC3P','12341,12 1','standard'),(32,'fensterpacktisch','9','2023_02_27_ 2_alex','28.02.2023 (13:00 - 16:00)','511','1','5.0','2023_02_27_ 2_alex','Speedlabor Ltd.','Herr','Alexander','Wigel','Alter Stadtberg','14','84524','Neuötting','37','info@speedlabor.de','086714034667','017685057815',NULL,'2023-02-27 15:41:46','2023-02-27 16:23:59','29T206K54NG',NULL,'standard'),(33,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 16:00)','511','1','1','2023_02_27_','awdaw','Herr','awdawd','awd','Matenzeile','höio','13053','Berlin','Deutschland','test@steubel.de',NULL,'017683412237',NULL,'2023-02-27 16:21:39','2023-02-27 16:23:57','29SFNEJ1Q7G',NULL,'standard'),(34,'fensterpacktisch',NULL,'2023_02_27_','28.02.2023 (12:00 - 16:00)','511','1','1','2023_02_27_','awdaw','Herr','awdawd','awd','Matenzeile','höio','13053','AWDaw','Deutschland','test@steubel.de',NULL,'017683412237',NULL,'2023-02-27 16:23:38','2023-02-27 16:23:48','29SFNCAQ0AG',NULL,'standard'),(35,'fensterpacktisch',NULL,'2023_02_28_','28.02.2023 (11:00 - 15:00)','511','1','1','2023_02_28_','GlodeIT','Herr','Gazi','Ahmad','Strausbergerplatz','13','10243','Berlin','Deutschland','test@steubel.de',NULL,'017683412237',NULL,'2023-02-28 07:12:19','2023-02-28 07:12:24','29T216P6F2D',NULL,'standard'),(36,'fensterpacktisch',NULL,'2023_02_28_','28.02.2023 (11:00 - 16:00)','511','1','1','2023_02_28_','GloedeIT','Herr','Lucas','Gloede',NULL,'13','10243','Berlin','Deutschland','test@steubel.de',NULL,'017683412237',NULL,'2023-02-28 07:42:32','2023-02-28 07:43:27','29C219KJ0DM',NULL,'standard'),(37,'fensterpacktisch',NULL,'2023_02_28_','28.02.2023 (11:00 - 16:00)','511','1','1','2023_02_28_','GloedeIT','Herr','Lucas','Gloede','Struasbergerplatz','fünf','10243','Penis','Deutschland','test@steubel.de',NULL,'017683412237',NULL,'2023-02-28 07:43:13','2023-02-28 07:43:22','29721M1AFP4',NULL,'standard'),(38,'fensterpacktisch',NULL,'2023_02_28_','28.02.2023 (11:00 - 16:00)','511','1','1','2023_02_28_','GloedeIT','Herr','Lucas','Gloede','Struasbergerplatz','fünf','10243','Penis','Deutschland','test@steubel.de',NULL,'017683412237',NULL,'2023-02-28 07:47:34','2023-02-28 07:55:35','29721MGMDR6',NULL,'standard');
/*!40000 ALTER TABLE `pickups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:32
