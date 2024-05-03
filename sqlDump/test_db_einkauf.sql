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
-- Table structure for table `einkauf`
--

DROP TABLE IF EXISTS `einkauf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `einkauf` (
  `id` int NOT NULL AUTO_INCREMENT,
  `process_id` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `rechnungs_datum` varchar(255) DEFAULT NULL,
  `rechnungsnummer` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `shippingdata` varchar(255) DEFAULT NULL,
  `tracking` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `pos` varchar(255) DEFAULT NULL,
  `menge` varchar(255) DEFAULT NULL,
  `artnr` varchar(255) DEFAULT NULL,
  `bezeichnung` varchar(255) DEFAULT NULL,
  `mwst` varchar(255) DEFAULT NULL,
  `netto` varchar(255) DEFAULT NULL,
  `mwstbetrag` varchar(255) DEFAULT NULL,
  `brutto` varchar(255) DEFAULT NULL,
  `rabatt` varchar(255) DEFAULT NULL,
  `pos_id` varchar(255) DEFAULT NULL,
  `new` varchar(255) DEFAULT NULL,
  `plattform` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `lieferantendaten` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `zahlart` varchar(255) DEFAULT NULL,
  `archiv` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `einkauf`
--

LOCK TABLES `einkauf` WRITE;
/*!40000 ALTER TABLE `einkauf` DISABLE KEYS */;
/*!40000 ALTER TABLE `einkauf` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:20
