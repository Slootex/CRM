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
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id` int DEFAULT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (81,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',575483),(81,18,'2023-07-10 21:29:26','2023-07-10 21:29:26',452986),(82,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',903729),(83,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',25548),(84,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',520406),(85,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',69840),(86,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',231180),(87,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',956356),(88,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',762453),(89,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',909768),(90,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',32492),(90,16,'2023-07-10 21:27:53','2023-07-10 21:27:53',378048),(90,18,'2023-07-10 21:29:26','2023-07-10 21:29:26',245197),(90,19,'2023-07-10 21:30:31','2023-07-10 21:30:31',169725),(90,20,'2023-07-10 21:32:25','2023-07-10 21:32:25',450805),(90,21,'2023-07-10 21:33:00','2023-07-10 21:33:00',38098),(91,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',530191),(91,16,'2023-07-10 21:27:53','2023-07-10 21:27:53',467665),(91,18,'2023-07-10 21:29:26','2023-07-10 21:29:26',851460),(91,19,'2023-07-10 21:30:31','2023-07-10 21:30:31',962109),(91,20,'2023-07-10 21:32:25','2023-07-10 21:32:25',933267),(91,21,'2023-07-10 21:33:00','2023-07-10 21:33:00',850838),(92,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',102312),(92,18,'2023-07-10 21:29:26','2023-07-10 21:29:26',973426),(92,19,'2023-07-10 21:30:31','2023-07-10 21:30:31',880534),(92,20,'2023-07-10 21:32:25','2023-07-10 21:32:25',915671),(92,21,'2023-07-10 21:33:00','2023-07-10 21:33:00',203176),(93,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',247971),(93,16,'2023-07-10 21:27:53','2023-07-10 21:27:53',330618),(93,19,'2023-07-10 21:30:31','2023-07-10 21:30:31',511960),(94,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',984190),(94,18,'2023-07-10 21:29:26','2023-07-10 21:29:26',716872),(95,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',546524),(96,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',574633),(96,16,'2023-07-10 21:27:53','2023-07-10 21:27:53',559559),(97,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',866168),(97,16,'2023-07-10 21:27:53','2023-07-10 21:27:53',140189),(98,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',8620),(98,16,'2023-07-10 21:27:53','2023-07-10 21:27:53',44254),(99,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',786943),(99,16,'2023-07-10 21:27:53','2023-07-10 21:27:53',351765),(100,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',916986),(100,20,'2023-07-10 21:32:25','2023-07-10 21:32:25',79049),(101,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',399606),(101,20,'2023-07-10 21:32:25','2023-07-10 21:32:25',869020),(102,15,'2023-07-10 21:41:23','2023-07-10 21:41:23',63099),(102,16,'2023-07-10 21:27:53','2023-07-10 21:27:53',889068),(102,18,'2023-07-10 21:29:26','2023-07-10 21:29:26',557894),(102,19,'2023-07-10 21:30:31','2023-07-10 21:30:31',647760),(102,20,'2023-07-10 21:32:25','2023-07-10 21:32:25',182220),(102,21,'2023-07-10 21:33:00','2023-07-10 21:33:00',580560),(103,15,'2023-07-10 21:41:23','2023-07-10 21:41:23',46844),(103,16,'2023-07-10 21:27:53','2023-07-10 21:27:53',75226),(103,18,'2023-07-10 21:29:26','2023-07-10 21:29:26',555215),(103,19,'2023-07-10 21:30:31','2023-07-10 21:30:31',620141),(103,20,'2023-07-10 21:32:25','2023-07-10 21:32:25',615364),(103,21,'2023-07-10 21:33:00','2023-07-10 21:33:00',583260),(104,15,'2023-07-10 21:27:45','2023-07-10 21:27:45',745048),(105,15,'2023-07-10 21:41:34','2023-07-10 21:41:34',50871),(106,15,'2023-07-10 21:41:34','2023-07-10 21:41:34',18761),(106,18,'2023-07-10 21:29:26','2023-07-10 21:29:26',184315),(106,19,'2023-07-10 21:30:31','2023-07-10 21:30:31',519342),(106,20,'2023-07-10 21:32:25','2023-07-10 21:32:25',808120),(106,21,'2023-07-10 21:33:00','2023-07-10 21:33:00',668658);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:24
