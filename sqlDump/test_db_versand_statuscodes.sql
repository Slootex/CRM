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
-- Table structure for table `versand_statuscodes`
--

DROP TABLE IF EXISTS `versand_statuscodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `versand_statuscodes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `carrier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bezeichnung` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `versand_statuscodes`
--

LOCK TABLES `versand_statuscodes` WRITE;
/*!40000 ALTER TABLE `versand_statuscodes` DISABLE KEYS */;
INSERT INTO `versand_statuscodes` VALUES (219,'ups','GELIEFERT','Zugestellt',NULL,'2023-10-16 08:55:53','2023-12-12 13:08:46','doc'),(220,'ups','Raus zur Lieferung','Unterwegs',NULL,'2023-10-16 08:55:54','2023-10-16 08:55:54','truck'),(221,'ups','In der Einrichtung angekommen','Unterwegs',NULL,'2023-10-16 08:55:55','2023-10-16 08:55:55','truck'),(222,'ups','Verlassen der Einrichtung','Unterwegs',NULL,'2023-10-16 08:55:56','2023-10-16 08:55:56','truck'),(223,'ups','Origin-Scan','Unterwegs',NULL,'2023-10-16 08:55:57','2023-10-16 08:55:57','truck'),(224,'ups','Pickup-Scan','Unterwegs',NULL,'2023-10-16 08:55:58','2023-10-16 08:55:58','truck'),(225,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2023-10-16 08:56:42','2023-10-16 08:56:42','truck'),(226,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2023-10-16 12:22:27','2023-10-16 12:22:27','truck'),(227,'us-post','Geliefert, Rezeption/Rezeption/Poststelle','Unterwegs',NULL,'2023-11-03 19:49:47','2023-11-03 19:49:47','truck'),(228,'newgistics','Ihr Artikel wurde am 4. März 2023 um 11:26 Uhr in','Unterwegs',NULL,'2023-11-03 19:49:48','2023-11-03 19:49:48','truck'),(229,'us-post','Raus zur Lieferung','Unterwegs',NULL,'2023-11-03 19:49:49','2023-11-03 19:49:49','truck'),(230,'us-post','Bei der Post angekommen','Unterwegs',NULL,'2023-11-03 19:49:50','2023-11-03 19:49:50','truck'),(231,'us-post','Auf dem Weg zur nächsten Einrichtung','Unterwegs',NULL,'2023-11-03 19:49:51','2023-11-03 19:49:51','truck'),(232,'us-post','In der USPS Regional Origin Facility angekommen','Unterwegs',NULL,'2023-11-03 19:49:52','2023-11-03 19:49:52','truck'),(233,'us-post','USPS hat den Artikel abgeholt','Unterwegs',NULL,'2023-11-03 19:49:53','2023-11-03 19:49:53','truck'),(234,'us-post','Informationen vor dem Versand an USPS gesendet, US','Unterwegs',NULL,'2023-11-03 19:49:54','2023-11-03 19:49:54','truck'),(235,'newgistics','Der US-Postdienst wurde am 26. Februar 2023 vom Ve','Unterwegs',NULL,'2023-11-03 19:49:55','2023-11-03 19:49:55','truck'),(236,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2023-11-28 16:43:16','2023-11-28 16:43:16','truck'),(237,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2023-12-01 08:38:20','2023-12-01 08:38:20','truck'),(238,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2023-12-01 11:39:46','2023-12-01 11:39:46','truck'),(239,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2023-12-08 17:10:58','2023-12-08 17:10:58','truck'),(240,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2023-12-11 13:30:14','2023-12-11 13:30:14','truck'),(241,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2023-12-11 13:31:11','2023-12-11 13:31:11','truck'),(242,'ups','Unterwegs für heutige Lieferung','Unterwegs',NULL,'2024-01-28 12:34:45','2024-01-28 12:34:45','truck'),(243,'ups','Wir haben Ihr Paket','Unterwegs',NULL,'2024-01-28 12:34:48','2024-01-28 12:34:48','truck'),(244,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2024-01-28 12:34:49','2024-01-28 12:34:49','truck'),(245,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2024-01-28 12:40:15','2024-01-28 12:40:15','truck'),(246,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2024-01-28 12:40:21','2024-01-28 12:40:21','truck'),(247,'dhl-global-mail-asia','Erfolgreich zugestellt','Unterwegs',NULL,'2024-01-31 08:36:53','2024-01-31 08:36:53','truck'),(248,'dhl','Die Lieferung wurde erfolgreich zugestellt','Unterwegs',NULL,'2024-01-31 08:36:54','2024-01-31 08:36:54','truck'),(249,'us-post','Zugestellt, im/im Briefkasten','Unterwegs',NULL,'2024-01-31 08:36:55','2024-01-31 08:36:55','truck'),(250,'dhl-global-mail-asia','Es wurde ein Zustellversuch unternommen','Unterwegs',NULL,'2024-01-31 08:36:55','2024-01-31 08:36:55','truck'),(251,'dhl','Die Sendung wurde auf das Lieferfahrzeug verladen','Unterwegs',NULL,'2024-01-31 08:36:56','2024-01-31 08:36:56','truck'),(252,'dhl-global-mail-asia','Zur Lieferung am Bestimmungsort eingetroffen, wird','Unterwegs',NULL,'2024-01-31 08:36:57','2024-01-31 08:36:57','truck'),(253,'dhl','Die Sendung wird im Zustelldepot für die Ausliefe','Unterwegs',NULL,'2024-01-31 08:36:58','2024-01-31 08:36:58','truck'),(254,'us-post','In der USPS-Regionaleinrichtung angekommen','Unterwegs',NULL,'2024-01-31 08:36:59','2024-01-31 08:36:59','truck'),(255,'us-post','USPS-Regionaleinrichtung verlassen','Unterwegs',NULL,'2024-01-31 08:37:00','2024-01-31 08:37:00','truck'),(256,'dhl-global-mail-asia','Zur Lieferung am Bestimmungsort eingetroffen, wird','Unterwegs',NULL,'2024-01-31 08:37:04','2024-01-31 08:37:04','truck'),(257,'dhl','Die Sendung ist im Paketzentrum angekommen','Unterwegs',NULL,'2024-01-31 08:37:04','2024-01-31 08:37:04','truck'),(258,'dhl-global-mail-asia','Das Paket ist im Zielland angekommen','Unterwegs',NULL,'2024-01-31 08:37:05','2024-01-31 08:37:05','truck'),(259,'dhl-global-mail-asia','Verarbeitet im lokalen Vertriebszentrum','Unterwegs',NULL,'2024-01-31 08:37:06','2024-01-31 08:37:06','truck'),(260,'dhl','Die Sendung ist im Zielland/Zielgebiet angekommen','Unterwegs',NULL,'2024-01-31 08:37:07','2024-01-31 08:37:07','truck'),(261,'us-post','Durch die Einrichtung verarbeitet','Unterwegs',NULL,'2024-01-31 08:37:08','2024-01-31 08:37:08','truck'),(262,'dhl-global-mail-asia','Verarbeitet in der Transiteinrichtung','Unterwegs',NULL,'2024-01-31 08:37:08','2024-01-31 08:37:08','truck'),(263,'us-post','Abfahrt vom Transit Office of Exchange','Unterwegs',NULL,'2024-01-31 08:37:09','2024-01-31 08:37:09','truck'),(264,'dhl-global-mail-asia','Verlassen der Einrichtung','Unterwegs',NULL,'2024-01-31 08:37:10','2024-01-31 08:37:10','truck'),(265,'dhl-global-mail-asia','Verlassen der Transiteinrichtung','Unterwegs',NULL,'2024-01-31 08:37:11','2024-01-31 08:37:11','truck'),(266,'dhl-global-mail-asia','In der Einrichtung verarbeitet','Unterwegs',NULL,'2024-01-31 08:37:12','2024-01-31 08:37:12','truck'),(267,'dhl-global-mail-asia','In der Ursprungsanlage angekommen','Unterwegs',NULL,'2024-01-31 08:37:13','2024-01-31 08:37:13','truck'),(268,'dhl-global-mail-asia','Abholung an die Einrichtung geliefert','Unterwegs',NULL,'2024-01-31 08:37:13','2024-01-31 08:37:13','truck'),(269,'dhl-global-mail-asia','Unterwegs','Unterwegs',NULL,'2024-01-31 08:37:15','2024-01-31 08:37:15','truck'),(270,'dhl-global-mail-asia','Versand abgeholt','Unterwegs',NULL,'2024-01-31 08:37:15','2024-01-31 08:37:15','truck'),(271,'dhl-global-mail-asia','Sendungsdaten erhalten – Paketübergabe an DHL e','Unterwegs',NULL,'2024-01-31 08:37:16','2024-01-31 08:37:16','truck'),(272,'dhl-global-mail-asia','Eingereichte Daten – Warten auf Paketübergabe a','Unterwegs',NULL,'2024-01-31 08:37:17','2024-01-31 08:37:17','truck'),(273,'dhl-global-mail-asia','Zur Lieferung am Bestimmungsort eingetroffen, wird','Unterwegs',NULL,'2024-01-31 08:37:21','2024-01-31 08:37:21','truck'),(274,'dhl','Die Sendung wird im Zustelldepot für die Ausliefe','Unterwegs',NULL,'2024-01-31 08:37:22','2024-01-31 08:37:22','truck'),(275,'dhl-global-mail-asia','Zur Lieferung am Bestimmungsort eingetroffen, wird','Unterwegs',NULL,'2024-01-31 08:37:26','2024-01-31 08:37:26','truck'),(276,'dhl-global-mail-asia','Sendungsdaten erhalten – Paketübergabe an DHL e','Unterwegs',NULL,'2024-01-31 08:37:34','2024-01-31 08:37:34','truck'),(277,'dhl-global-mail-asia','Eingereichte Daten – Warten auf Paketübergabe a','Unterwegs',NULL,'2024-01-31 08:37:34','2024-01-31 08:37:34','truck'),(278,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2024-02-19 11:33:59','2024-02-19 11:33:59','truck'),(279,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2024-02-19 11:37:23','2024-02-19 11:37:23','truck'),(280,'ups','Der Versender hat ein Etikett erstellt, UPS hat da','Unterwegs',NULL,'2024-02-19 16:23:58','2024-02-19 16:23:58','truck');
/*!40000 ALTER TABLE `versand_statuscodes` ENABLE KEYS */;
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
