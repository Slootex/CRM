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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_reset_tokens_table',1),(2,'2018_08_08_100000_create_telescope_entries_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2022_10_12_115136_new_orders_person_declarations',1),(6,'2022_10_12_120300_new_orders_car_declarations',1),(7,'2022_10_12_124018_new_order_acceptens',1),(8,'2022_10_13_064530_order_ids',1),(9,'2022_10_13_125730_employee_accounts',2),(10,'2022_10_16_160835_order_process_data',2),(11,'2022_10_16_164316_components',2),(12,'2022_10_18_074212_component',3),(13,'2022_10_25_131043_orderhistory_messages',3),(14,'2022_10_26_060527_bookings',3),(15,'2022_10_27_065633_intern_admin',3),(16,'2022_10_28_064352_leads_archive_persons',4),(17,'2022_10_28_064431_leads_archive_cars',4),(18,'2022_11_01_084832_helper_code',5),(19,'2022_11_03_073225_warenausgang_archive',5),(20,'2022_11_03_073238_where',5),(21,'2022_11_03_074605_umlagerungsauftrag',5),(22,'2022_11_04_080817_primary_devices',5),(23,'2022_11_08_071542_bpzfile',6),(24,'2022_11_25_135715_allow_barcodes',6),(25,'2022_12_01_075237_inshipping',6),(26,'2022_12_30_173846_transportschaden',7),(27,'2023_01_02_125234_tagesabschluss',7),(28,'2023_01_11_105425_zeiterfassung',8),(29,'2023_01_17_114248_emails_history',8),(30,'2023_01_27_123727_blacklist_status',8),(31,'2023_02_09_092710_create_mailbox_inbound_emails_table',8),(32,'2023_02_15_121300_pickups',8),(33,'2023_02_18_181834_entsorgung_history',8),(34,'2023_02_23_134819_tracking_history',8),(35,'2023_02_24_133819_email_inbox_history',8),(36,'2023_09_21_151054_create_jobs_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:21
