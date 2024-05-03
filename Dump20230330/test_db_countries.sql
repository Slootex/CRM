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
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `frontend` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Deutschland','DE','1'),(2,'Österreich','AT','1'),(4,'Niederlande','NL','1'),(5,'Großbritannien','GB','1'),(6,'Spanien','ES','1'),(7,'Polen','PL','1'),(8,'Italien','IT','1'),(9,'Litauen','LT','1'),(10,'Schweiz','CH','1'),(11,'Luxemburg','LU','1'),(12,'Ungarn','HU','1'),(13,'Schweden','SE','1'),(14,'Neukaledonien','NC','1'),(15,'Saudi-Arabien','SA','1'),(16,'Tadschikistan','TJ','1'),(17,'Futuna-Inseln','WF','1'),(18,'Zentralafrika','CF','1'),(19,'Burkina Faso','BF','1'),(20,'Griechenland','GR','1'),(21,'Kaimaninseln','KY','1'),(22,'Sierra Leone','SL','1'),(23,'Turkmenistan','TM','1'),(24,'Tschechische','CZ','1'),(25,'Weißrussland','BY','1'),(26,'Samoa-Inseln','AS','1'),(27,'Afghanistan','AF','1'),(28,'Argentinien','AR','1'),(29,'Bangladesch','BD','1'),(30,'Cook-Inseln','CK','1'),(31,'Mauretanien','MR','1'),(33,'Philippinen','PH','1'),(34,'Puerto Rico','PR','1'),(35,'El Salvador','SV','1'),(36,'St. Maarten','SX','1'),(37,'Polen','PL','1'),(38,'Französisch','GF','1'),(39,'Kanalinseln','JE','1'),(40,'Kanalinseln','GG','1'),(41,'St. Vincent','VC','1'),(42,'Mikronesien','FM','1'),(43,'Australien','AU','1'),(44,'Costa Rica','CR','1'),(45,'Frankreich','FR','1'),(46,'Guadeloupe','GP','1'),(47,'Indonesien','ID','1'),(48,'Kambodscha','KH','1'),(49,'Kasachstan','KZ','1'),(50,'Montenegro','ME','1'),(51,'Madagaskar','MG','1'),(52,'Mazedonien','MK','1'),(53,'Martinique','MQ','1'),(54,'Montserrat','MS','1'),(55,'Neuseeland','NZ','1'),(56,'Seychellen','SC','1'),(57,'San Marino','SM','1'),(58,'Usbekistan','UZ','1'),(60,'Bulgarien','BG','1'),(61,'Brasilien','BR','1'),(62,'Kolumbien','CO','1'),(63,'Kap Verde','CV','1'),(64,'Dschibuti','DJ','1'),(65,'Äthiopien','ET','1'),(66,'Gibraltar','GI','1'),(67,'Guatemala','GT','1'),(68,'Jordanien','JO','1'),(69,'Kirgistan','KG','1'),(70,'St. Lucia','LC','1'),(71,'Sri Lanka','LK','1'),(73,'Moldawien','MD','1'),(74,'Mauritius','MU','1'),(75,'Malediven','MV','1'),(76,'Nicaragua','NI','1'),(77,'Salomonen','SB','1'),(78,'Slowenien','SI','1'),(79,'Swasiland','SZ','1'),(80,'Venezuela','VE','1'),(81,'Südafrika','ZA','1'),(82,'Anguilla','AI','1'),(83,'Albanien','AL','1'),(84,'Armenien','AM','1'),(85,'Barbados','BB','1'),(86,'Bolivien','BO','1'),(87,'Botswana','BW','1'),(88,'Dominica','DM','1'),(89,'Algerien','DZ','1'),(90,'Finnland','FI','1'),(91,'Georgien','GE','1'),(92,'Grönland','GL','1'),(93,'Hongkong','HK','1'),(94,'Honduras','HN','1'),(95,'Kroatien','HR','1'),(96,'Kiribati','KI','1'),(97,'Lettland','LV','1'),(98,'Mongolei','MN','1'),(99,'Malaysia','MY','1'),(100,'Mosambik','MZ','1'),(101,'Norwegen','NO','1'),(102,'Pakistan','PK','1'),(103,'Paraguay','PY','1'),(104,'Rumänien','RO','1'),(105,'Russland','RU','1'),(107,'Singapur','SG','1'),(108,'Thailand','TH','1'),(109,'Osttimor','TL','1'),(110,'Tunesien','TN','1'),(111,'Tansania','TZ','1'),(112,'Simbabwe','ZW','1'),(113,'Marianen','MP','1'),(114,'Slowakei','SK','1'),(115,'Dominika','DO','1'),(116,'Dänemark','DK','1'),(117,'Andorra','AD','1'),(118,'Belgien','BE','1'),(119,'Bahrain','BH','1'),(120,'Burundi','BI','1'),(121,'Bermuda','BM','1'),(122,'Bahamas','BS','1'),(124,'Kamerun','CM','1'),(125,'Curaçao','CW','1'),(126,'Ecuador','EC','1'),(127,'Estland','EE','1'),(128,'Ägypten','EG','1'),(129,'Eritrea','ER','1'),(130,'Fidschi','FJ','1'),(131,'Grenada','GD','1'),(132,'Jamaika','JM','1'),(133,'Komoren','KM','1'),(134,'Libanon','LB','1'),(135,'Liberia','LR','1'),(136,'Lesotho','LS','1'),(138,'Marokko','MA','1'),(139,'Myanmar','MM','1'),(140,'Namibia','NA','1'),(141,'Nigeria','NG','1'),(142,'Réunion','RE','1'),(143,'Serbien','RS','1'),(144,'Senegal','SN','1'),(145,'Surinam','SR','1'),(146,'Ukraine','UA','1'),(147,'Uruguay','UY','1'),(148,'Vietnam','VN','1'),(149,'Vanuatu','VU','1'),(150,'Mayotte','YT','1'),(152,'Antigua','AG','1'),(153,'Bosnien','BA','1'),(154,'Angola','AO','1'),(155,'Brunei','BN','1'),(156,'Bhutan','BT','1'),(157,'Belize','BZ','1'),(158,'Kanada','CA','1'),(159,'Zypern','CY','1'),(160,'Gambia','GM','1'),(161,'Guinea','GN','1'),(162,'Guyana','GY','1'),(164,'Irland','IE','1'),(165,'Israel','IL','1'),(166,'Indien','IN','1'),(167,'Island','IS','1'),(168,'Kosovo','KV','1'),(169,'Kuwait','KW','1'),(170,'Libyen','LY','1'),(171,'Malawi','MW','1'),(172,'Mexiko','MX','1'),(173,'Panama','PA','1'),(174,'Tahiti','PF','1'),(175,'Azoren','PT','1'),(176,'Ruanda','RW','1'),(177,'Tschad','TD','1'),(178,'Türkei','TR','1'),(179,'Tuvalu','TV','1'),(180,'Taiwan','TW','1'),(181,'Uganda','UG','1'),(182,'Sambia','ZM','1'),(183,'Monaco','MC','1'),(184,'Tobago','TT','1'),(185,'Aruba','AW','1'),(186,'Benin','BJ','1'),(187,'Chile','CL','1'),(188,'Ceuta','ES','1'),(189,'Gabun','GA','1'),(190,'Wales','GB','1'),(191,'Ghana','GH','1'),(192,'Haiti','HT','1'),(193,'Japan','JP','1'),(194,'Kenia','KE','1'),(195,'Macau','MO','1'),(196,'Malta','MT','1'),(197,'Niger','NE','1'),(198,'Nepal','NP','1'),(199,'Palau','PW','1'),(200,'Katar','QA','1'),(201,'Tonga','TO','1'),(202,'Samoa','WS','1'),(203,'Jemen','YE','1'),(205,'Papua','PG','1'),(206,'Kongo','CG','1'),(207,'China','CN','1'),(208,'Korea','KR','1'),(209,'Kongo','CD','1'),(210,'Saba','BQ','1'),(211,'Guam','GU','1'),(212,'Irak','IQ','1'),(213,'Laos','LA','1'),(214,'Mali','ML','1'),(215,'Oman','OM','1'),(216,'Peru','PE','1'),(217,'Togo','TG','1'),(218,'Gaza','PS','1'),(219,'UAE','AE','1'),(220,'USA','US','1');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-30 12:40:30
