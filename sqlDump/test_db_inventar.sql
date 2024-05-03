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
-- Table structure for table `inventar`
--

DROP TABLE IF EXISTS `inventar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `min` varchar(255) DEFAULT NULL,
  `einheit` varchar(255) DEFAULT NULL,
  `addresse` varchar(255) DEFAULT NULL,
  `epreis` varchar(255) DEFAULT NULL,
  `timediff` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventar`
--

LOCK TABLES `inventar` WRITE;
/*!40000 ALTER TABLE `inventar` DISABLE KEYS */;
INSERT INTO `inventar` VALUES (15,'Luftpolsterfolie Große Noppe 2x 50 cm 30 m','2',NULL,'https://www.ebay.de/itm/133665459575','13,245','150',NULL,NULL),(16,'Karton 30x30x30 cm','120',NULL,'https://www.ebay.de/itm/351643752822','1,3825','150',NULL,NULL),(17,'Karton 26x24x20 cm','300',NULL,'https://www.ebay.de/itm/331639296861','0,9849','150',NULL,NULL),(18,'Kleber 72 Rollen, Braun und Transparent','72',NULL,'https://www.ebay.de/itm/351765921713','1,19652777777778','150',NULL,NULL),(19,'Kelber 36 Rollen, Vorsicht Glas','36',NULL,'https://www.ebay.de/itm/133402789176','0,997222222222222','150',NULL,'2024-01-04 14:21:35'),(20,'Gummibären','3',NULL,'https://www.ebay.de/itm/353068049978','28,47','150',NULL,NULL),(21,'Beipackzettel','1000',NULL,'https://www.saxoprint.de/geschaeftsausstattung/briefpapier/briefpapier-drucken','0,04121','150',NULL,NULL),(22,'Brother Thermo Rolle Versandetiketten','10',NULL,'https://www.ebay.de/itm/194821997355','9,9','150',NULL,'2024-01-04 14:22:53'),(23,'Schaum-Schiebeschachtel 30x20x10 cm (2,73€)','420',NULL,'https://karton-billiger.de/Noppenschaumschachtel-300x200x100mm','2,78357142857143','150',NULL,NULL),(24,'Schriftband-Kassette','24',NULL,'https://www.ebay.de/itm/175042674431','2,09666666666667','150',NULL,NULL),(25,'Papier, DIN-A4 ⋅ 2500 Blatt ⋅ 100g/m²','1',NULL,'https://www.ebay.de/itm/291040575679','28,99','150',NULL,NULL),(26,'Druckerpatronen (S/W) Kyocera ECOSYS P2040DN','4',NULL,'https://www.ebay.de/itm/384745187666','9,725','150',NULL,'2024-01-04 14:24:23'),(27,'QR Code Siegel','500',NULL,'https://shop.advast-suisse.com/de/shop/barcode-sicherheitsetiketten-25x40mm-mit-hologramm-smartlabels/','0,8295','150',NULL,NULL),(28,'QR Code Siegel','448',NULL,'https://www.hologramm-sticker.de/personalisierbare-hologramm-sticker-siegel/43/teil-personalisiert-3d-hologramm-sicherheitssiegel-4-x-3-cm-gold-mit-schwarzem-druck?number=S585.4','0,245535714285714','150',NULL,NULL);
/*!40000 ALTER TABLE `inventar` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-23 11:35:26
