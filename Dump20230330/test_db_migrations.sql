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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2019_12_14_000001_create_personal_access_tokens_table',1),(2,'2022_10_12_115136_new_orders_person_declarations',1),(3,'2022_10_12_120300_new_orders_car_declarations',1),(4,'2022_10_12_124018_new_order_acceptens',1),(5,'2022_10_13_064530_order_ids',1),(6,'2022_10_13_072327_status_historis',1),(7,'2022_10_13_115645_new_leads_person_datas',1),(8,'2022_10_13_115653_new_leads_car_datas',1),(9,'2022_10_13_115659_old_leads_person_datas',1),(10,'2022_10_13_115709_old_leads_car_datas',1),(11,'2022_10_13_125730_employee_accounts',1),(12,'2022_10_16_160057_shelfes',1),(13,'2022_10_16_160835_order_process_data',1),(14,'2022_10_16_164316_components',1),(15,'2022_10_17_111910_device_orders',1),(16,'2022_10_18_074212_component',1),(17,'2022_10_24_135538_phone_history',2),(18,'2022_10_24_135541_phone_historys',2),(19,'2022_10_25_073314_active_orders_person_datas',3),(20,'2022_10_25_073325_active_orders_car_datas',3),(21,'2022_10_25_131043_orderhistory_messages',4),(22,'2022_10_26_060527_bookings',5),(23,'2022_10_27_065603_intern_admin',6),(24,'2022_10_27_101157_wareneingang',7),(25,'2022_10_27_101201_warenausgang',7),(26,'2022_10_27_101205_intern',7),(27,'2022_10_28_064352_leads_archive_persons',8),(28,'2022_10_28_064431_leads_archive_cars',8),(29,'2022_10_27_101205_interns',9),(30,'2022_10_31_072134_intern_history',10),(31,'2022_11_01_084832_shipping_order',11),(32,'2022_11_01_084832_helper_code',12),(33,'2022_11_03_073225_warenausgang_archive',13),(34,'2022_11_03_073238_where',13),(35,'2022_11_03_074605_umlagerungsauftrag',13),(36,'2022_11_04_080817_primary_devices',13),(37,'2022_11_07_103119_files',14),(38,'2022_11_07_103119_file',15),(39,'2022_11_08_071542_bpzfile',15),(40,'2022_10_27_065633_intern_admin',16),(41,'2022_11_25_135715_allow_barcodes',17),(42,'2022_12_01_075237_inshipping',18),(43,'2022_12_05_072625_permissions',19),(44,'2022_12_05_084323_warenausgang_history',20),(45,'2022_12_06_072154_shelfes_archive',21),(46,'2022_12_30_173846_transportschaden',22),(47,'2023_01_02_125234_tagesabschluss',23),(48,'2023_01_05_142315_vergleichstexte',24),(49,'2023_01_09_125751_roles',25),(50,'2023_01_09_125803_rolepermissions',26),(51,'2023_01_11_105425_zeiterfassung',27),(52,'2023_01_17_114248_emails_history',28),(53,'2023_01_18_130109_auftraghistory',29),(54,'2023_01_18_130114_auftragshistory',29),(55,'2023_01_27_123727_blacklist_status',30),(56,'2023_02_09_092710_create_mailbox_inbound_emails_table',31),(57,'2023_02_15_121300_pickups',32),(58,'2023_02_18_181834_entsorgung_history',33),(59,'2023_01_05_142315_vergleichste',34),(60,'2023_01_05_142315_vergleichstext',34),(61,'2023_02_23_134819_tracking_history',35),(62,'2023_02_24_133819_email_inbox_history',36),(63,'2023_03_03_122846_create_permission_tables',37),(64,'2014_10_12_000000_create_users_table',38),(65,'2014_10_12_100000_create_password_reset_tokens_table',38),(66,'2019_08_19_000000_create_failed_jobs_table',38),(67,'2018_08_08_100000_create_telescope_entries_table',39);
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

-- Dump completed on 2023-03-30 12:40:25
