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
-- Table structure for table `transportschaden`
--

DROP TABLE IF EXISTS `transportschaden`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transportschaden` (
  `process_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `component_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `borken_report` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transportschaden`
--

LOCK TABLES `transportschaden` WRITE;
/*!40000 ALTER TABLE `transportschaden` DISABLE KEYS */;
INSERT INTO `transportschaden` VALUES ('17645','17645-18-ORG-2','qawdawd awd','dummy123456#',NULL,'2022-12-30 16:59:53','2022-12-30 16:59:53'),('17645','17645-84-ORG-2','asdawd awd awd a','dummy123456#',NULL,'2022-12-30 20:41:26','2022-12-30 20:41:26'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 08:59:11','2022-12-31 08:59:11'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:02:19','2022-12-31 09:02:19'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:03:30','2022-12-31 09:03:30'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:06:06','2022-12-31 09:06:06'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:07:08','2022-12-31 09:07:08'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:08:17','2022-12-31 09:08:17'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:09:04','2022-12-31 09:09:04'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:12:21','2022-12-31 09:12:21'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:15:58','2022-12-31 09:15:58'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:16:27','2022-12-31 09:16:27'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:16:39','2022-12-31 09:16:39'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:17:03','2022-12-31 09:17:03'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:17:28','2022-12-31 09:17:28'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:17:59','2022-12-31 09:17:59'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:18:36','2022-12-31 09:18:36'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:18:45','2022-12-31 09:18:45'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:18:53','2022-12-31 09:18:53'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:19:55','2022-12-31 09:19:55'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:20:18','2022-12-31 09:20:18'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:50:31','2022-12-31 09:50:31'),('17645','17645-74-ORG-2','asdawsd awd aw','dummy123456#',NULL,'2022-12-31 09:50:42','2022-12-31 09:50:42'),('17645','17645-45-ORG-3','dawdawdawd','dummy123456#',NULL,'2023-01-02 15:17:54','2023-01-02 15:17:54'),('17645','17645-28-ORG-4','awd awd awd aw','dummy123456#',NULL,'2023-01-02 15:18:58','2023-01-02 15:18:58'),('37539','37539-32-ORG-1','DAS GERÄT IS KAPUUTTTTT','dummy123456#',NULL,'2023-01-04 07:54:47','2023-01-04 07:54:47'),('17645','17645-29-ORG-5','Da liegen 5 kleine teile mit drinne','dummy123456#',NULL,'2023-01-04 17:22:55','2023-01-04 17:22:55');
/*!40000 ALTER TABLE `transportschaden` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:25
