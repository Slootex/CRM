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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (81,'change.lagereinstellungen','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(82,'change.userprofile','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(83,'stop.warenausgang','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(84,'set.roles_perms','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(85,'set.zeiterfassung.future','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(86,'select.zeiterfassung.users','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(87,'edit_delete.zeiterfassung','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(88,'see.online.users.zeiterfassung','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(89,'set.holidays.zeiterfassung','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(90,'see.orders','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(91,'see.leads','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(92,'see.packtisch','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(93,'use.email.postfach','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(94,'auftrag.überwachung','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(95,'see.einkauf','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(96,'see.buchhaltung','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(97,'rechnung.buchen','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(98,'zahlung.buchen','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(99,'edit.mahnung','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(100,'statistik.auftrag','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(101,'statistik.interessent','web','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(102,'see.leftmenu.aufträge','','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(103,'see.leftmenu.interessenten','','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(104,'see.leftmenu.kunden','','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(105,'see.leftmenu.einkauf','','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL),(106,'see.leftmenu.packtisch','','2023-07-10 07:06:50','2023-07-10 07:06:50',NULL,NULL,NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:23
