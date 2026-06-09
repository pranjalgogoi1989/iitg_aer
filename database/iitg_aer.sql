/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for osx10.20 (arm64)
--
-- Host: localhost    Database: iitg_aer
-- ------------------------------------------------------
-- Server version	11.7.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(45) DEFAULT NULL,
  `country_name` varchar(45) DEFAULT NULL,
  `short_name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES
(1,'93','Afghanistan','AFG','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(2,'355','Albania','ALB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(3,'213','Algeria','DZA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(4,'1-684','American Samoa','ASM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(5,'376','Andorra','AND','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(6,'244','Angola','AGO','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(7,'1-264','Anguilla','AIA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(8,'1-268','Antigua and Barbuda','ATG','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(9,'54','Argentina','ARG','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(10,'374','Armenia','ARM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(11,'297','Aruba','ABW','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(12,'61','Australia','AUS','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(13,'43','Austria','AUT','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(14,'994','Azerbaijan','AZE','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(15,'1-242','Bahamas','BHS','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(16,'973','Bahrain','BHR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(17,'880','Bangladesh','BGD','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(18,'1-246','Barbados','BRB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(19,'375','Belarus','BLR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(20,'32','Belgium','BEL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(21,'501','Belize','BLZ','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(22,'229','Benin','BEN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(23,'1-441','Bermuda','BMU','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(24,'975','Bhutan','BTN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(25,'591','Bolivia','BOL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(26,'387','Bosnia and Herzegovina','BIH','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(27,'267','Botswana','BWA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(28,'55','Brazil','BRA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(29,'1-284','British Virgin Islands','VGB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(30,'673','Brunei','BRN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(31,'359','Bulgaria','BGR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(32,'226','Burkina Faso','BFA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(33,'257','Burundi','BDI','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(34,'238','Cabo Verde','CPV','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(35,'855','Cambodia','KHM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(36,'237','Cameroon','CMR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(37,'1','Canada','CAN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(38,'1-345','Cayman Islands','CYM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(39,'236','Central African Republic','CAF','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(40,'235','Chad','TCD','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(41,'56','Chile','CHL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(42,'86','China','CHN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(43,'57','Colombia','COL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(44,'269','Comoros','COM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(45,'242','Congo','COG','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(46,'682','Cook Islands','COK','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(47,'506','Costa Rica','CRI','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(48,'225','Cote dIvoire','CIV','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(49,'385','Croatia','HRV','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(50,'53','Cuba','CUB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(51,'599','Curaçao','CUW','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(52,'357','Cyprus','CYP','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(53,'420','Czech Republic (Czechia)','CZE','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(54,'45','Denmark','DNK','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(55,'253','Djibouti','DJI','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(56,'1-767','Dominica','DMA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(57,'1-809, 1-829, 1-849','Dominican Republic','DOM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(58,'243','DR Congo','COD','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(59,'593','Ecuador','ECU','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(60,'20','Egypt','EGY','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(61,'503','El Salvador','SLV','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(62,'240','Equatorial Guinea','GNQ','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(63,'291','Eritrea','ERI','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(64,'372','Estonia','EST','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(65,'268','Eswatini','SWZ','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(66,'251','Ethiopia','ETH','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(67,'298','Faeroe Islands','FRO','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(68,'500','Falkland Islands','FLK','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(69,'679','Fiji','FJI','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(70,'358','Finland','FIN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(71,'33','France','FRA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(72,'689','French Polynesia','PYF','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(73,'241','Gabon','GAB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(74,'220','Gambia','GMB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(75,'995','Georgia','GEO','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(76,'49','Germany','DEU','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(77,'233','Ghana','GHA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(78,'350','Gibraltar','GIB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(79,'30','Greece','GRC','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(80,'299','Greenland','GRL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(81,'1-473','Grenada','GRD','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(82,'1-671','Guam','GUM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(83,'502','Guatemala','GTM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(84,'224','Guinea','GIN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(85,'245','Guinea-Bissau','GNB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(86,'592','Guyana','GUY','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(87,'509','Haiti','HTI','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(88,'379','Holy See','VAT','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(89,'504','Honduras','HND','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(90,'852','Hong Kong','HKG','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(91,'36','Hungary','HUN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(92,'354','Iceland','ISL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(93,'91','India','IND','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(94,'62','Indonesia','IDN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(95,'98','Iran','IRN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(96,'964','Iraq','IRQ','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(97,'353','Ireland','IRL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(98,'44-1624','Isle of Man','IMN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(99,'972','Israel','ISR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(100,'39','Italy','ITA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(101,'1-876','Jamaica','JAM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(102,'81','Japan','JPN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(103,'962','Jordan','JOR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(104,'7','Kazakhstan','KAZ','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(105,'254','Kenya','KEN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(106,'686','Kiribati','KIR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(107,'965','Kuwait','KWT','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(108,'996','Kyrgyzstan','KGZ','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(109,'856','Laos','LAO','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(110,'371','Latvia','LVA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(111,'961','Lebanon','LBN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(112,'266','Lesotho','LSO','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(113,'231','Liberia','LBR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(114,'218','Libya','LBY','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(115,'423','Liechtenstein','LIE','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(116,'370','Lithuania','LTU','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(117,'352','Luxembourg','LUX','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(118,'853','Macao','MAC','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(119,'261','Madagascar','MDG','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(120,'265','Malawi','MWI','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(121,'60','Malaysia','MYS','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(122,'960','Maldives','MDV','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(123,'223','Mali','MLI','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(124,'356','Malta','MLT','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(125,'692','Marshall Islands','MHL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(126,'222','Mauritania','MRT','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(127,'230','Mauritius','MUS','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(128,'262','Mayotte','MYT','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(129,'52','Mexico','MEX','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(130,'691','Micronesia','FSM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(131,'373','Moldova','MDA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(132,'377','Monaco','MCO','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(133,'976','Mongolia','MNG','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(134,'382','Montenegro','MNE','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(135,'1-664','Montserrat','MSR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(136,'212','Morocco','MAR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(137,'258','Mozambique','MOZ','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(138,'95','Myanmar','MMR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(139,'264','Namibia','NAM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(140,'674','Nauru','NRU','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(141,'977','Nepal','NPL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(142,'31','Netherlands','NLD','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(143,'687','New Caledonia','NCL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(144,'64','New Zealand','NZL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(145,'505','Nicaragua','NIC','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(146,'227','Niger','NER','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(147,'234','Nigeria','NGA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(148,'683','Niue','NIU','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(149,'1-670','Northern Mariana Islands','MNP','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(150,'850','North Korea','PRK','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(151,'389','North Macedonia','MKD','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(152,'47','Norway','NOR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(153,'968','Oman','OMN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(154,'92','Pakistan','PAK','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(155,'680','Palau','PLW','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(156,'507','Panama','PAN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(157,'675','Papua New Guinea','PNG','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(158,'595','Paraguay','PRY','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(159,'51','Peru','PER','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(160,'63','Philippines','PHL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(161,'48','Poland','POL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(162,'351','Portugal','PRT','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(163,'1-787, 1-939','Puerto Rico','PRI','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(164,'974','Qatar','QAT','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(165,'262','Réunion','REU','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(166,'40','Romania','ROU','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(167,'7','Russia','RUS','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(168,'250','Rwanda','RWA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(169,'590','Saint Barthelemy','BLM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(170,'290','Saint Helena','SHN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(171,'1-869','Saint Kitts & Nevis','KNA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(172,'1-758','Saint Lucia','LCA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(173,'590','Saint Martin','MAF','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(174,'508','Saint Pierre & Miquelon','SPM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(175,'685','Samoa','WSM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(176,'378','San Marino','SMR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(177,'239','Sao Tome & Principe','STP','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(178,'966','Saudi Arabia','SAU','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(179,'221','Senegal','SEN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(180,'381','Serbia','SRB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(181,'248','Seychelles','SYC','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(182,'232','Sierra Leone','SLE','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(183,'65','Singapore','SGP','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(184,'1-721','Sint Maarten','SXM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(185,'421','Slovakia','SVK','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(186,'386','Slovenia','SVN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(187,'677','Solomon Islands','SLB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(188,'252','Somalia','SOM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(189,'27','South Africa','ZAF','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(190,'82','South Korea','KOR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(191,'211','South Sudan','SSD','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(192,'34','Spain','ESP','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(193,'94','Sri Lanka','LKA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(194,'970','State of Palestine','PSE','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(195,'1-784','St. Vincent & Grenadines','VCT','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(196,'249','Sudan','SDN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(197,'597','Suriname','SUR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(198,'46','Sweden','SWE','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(199,'41','Switzerland','CHE','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(200,'963','Syria','SYR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(201,'886','Taiwan','TWN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(202,'992','Tajikistan','TJK','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(203,'255','Tanzania','TZA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(204,'66','Thailand','THA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(205,'670','Timor-Leste','TLS','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(206,'228','Togo','TGO','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(207,'690','Tokelau','TKL','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(208,'676','Tonga','TON','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(209,'1-868','Trinidad and Tobago','TTO','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(210,'216','Tunisia','TUN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(211,'90','Turkey','TUR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(212,'993','Turkmenistan','TKM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(213,'1-649','Turks and Caicos','TCA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(214,'688','Tuvalu','TUV','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(215,'256','Uganda','UGA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(216,'380','Ukraine','UKR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(217,'971','United Arab Emirates','ARE','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(218,'44','United Kingdom','GBR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(219,'1','United States','USA','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(220,'598','Uruguay','URY','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(221,'1-340','U.S. Virgin Islands','VIR','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(222,'998','Uzbekistan','UZB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(223,'678','Vanuatu','VUT','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(224,'58','Venezuela','VEN','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(225,'84','Vietnam','VNM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(226,'681','Wallis & Futuna','WLF','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(227,'212','Western Sahara','ESH','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(228,'967','Yemen','YEM','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(229,'260','Zambia','ZMB','2026-06-09 17:10:14','2026-06-09 17:10:14'),
(230,'263','Zimbabwe','ZWE','2026-06-09 17:10:14','2026-06-09 17:10:14');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) DEFAULT NULL,
  `short_name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES
(1,'Biotechnology','BT','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(2,'Biosciences & Bioengineering','BT','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(3,'Chemical Engineering','CL','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(4,'Chemistry','CH','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(5,'Civil Engineering','CE','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(6,'Computer Science& Engineering','CS','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(7,'Design','DD','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(8,'Electronics and Communication Engineering','ECE','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(9,'Electronics and Electrical Engineering','EEE','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(10,'HSS (Humanities and Social Sciences)','HSS','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(11,'Mathematics','MA','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(12,'Mechanical Engineering','ME','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(13,'Physics','PH','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(14,'Centre for The Environment','ENV','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(15,'Centre for Nanotechnology','NT','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(16,'Centre for Linguistic Science and Technology','LS','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(17,'Centre for Disaster Management and Research','DM','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(18,'Centre for Intelligent Cyber Physical Systems','CICPS','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(19,'Centre for Sustainable Polymers','SP','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(20,'Centre for Indian Knowledge Systems','IKS','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(21,'Centre for Rural Technology','RT','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(22,'Centre for Energy','EN','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(23,'School of Agro and Rural Technology','RT','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(24,'School of Data Science and Artificial Intelligence','DS','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(25,'Mehta Family School of Data Science and Artificial Intelligence','DSAI','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(26,'School of Energy Science and Engineering','EN','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(27,'School of Health Sciences & Technology','HT','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(28,'Jyoti and Bhupat Mehta School of Health Sciences & Technology','HT','2026-06-09 17:18:13','2026-06-09 17:18:13'),
(29,'School of Business','SB','2026-06-09 17:18:13','2026-06-09 17:18:13');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_verification`
--

DROP TABLE IF EXISTS `email_verification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_verification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `verification_code` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_verification`
--

LOCK TABLES `email_verification` WRITE;
/*!40000 ALTER TABLE `email_verification` DISABLE KEYS */;
INSERT INTO `email_verification` VALUES
(1,'pranjal.gogoi983@gmail.com','334486','2026-06-09 20:58:27','2026-06-09 20:58:27');
/*!40000 ALTER TABLE `email_verification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel`
--

DROP TABLE IF EXISTS `hostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hostel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostel_name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel`
--

LOCK TABLES `hostel` WRITE;
/*!40000 ALTER TABLE `hostel` DISABLE KEYS */;
INSERT INTO `hostel` VALUES
(1,'Non-Hosteller','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(2,'Barak','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(3,'Brahmaputra','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(4,'Disang','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(5,'Dihing','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(6,'Kameng','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(7,'Kapili','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(8,'Lohit','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(9,'Manas','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(10,'Siang','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(11,'Subansiri','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(12,'Dhansiri','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(13,'Umiam','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(14,'Dikhow','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(15,'Married Hostel','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(16,'Other','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(17,'Dibang','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(18,'Disang (Girls Block)','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(19,'Gaurang','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(20,'Lohit (Part B)','2026-06-09 17:34:00','2026-06-09 17:34:00'),
(21,'Other','2026-06-09 17:34:00','2026-06-09 17:34:00');
/*!40000 ALTER TABLE `hostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programmes`
--

DROP TABLE IF EXISTS `programmes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `programmes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prog` varchar(45) DEFAULT NULL,
  `programme_name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programmes`
--

LOCK TABLES `programmes` WRITE;
/*!40000 ALTER TABLE `programmes` DISABLE KEYS */;
INSERT INTO `programmes` VALUES
(1,'B.Tech','Bachelor of Technology','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(2,'M.Sc','Master of Science','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(3,'M.Tech','Master of Technology','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(4,'PhD','Doctor of Philosophy','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(5,'Dual (M.Tech+PhD)','Dual Degree in Engineering','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(6,'MBA','Master of Business Administration','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(7,'MS(R)','Master of Science (Research)','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(8,'MA','Master of Arts','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(9,'B.Des','Bachelor of Design','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(10,'M.Des','Master of Design','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(11,'Dual (MS+PhD)','Dual Degree in Research','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(12,'Trainee','Training','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(13,'Intern','Internship','2026-06-09 17:41:13','2026-06-09 17:41:13'),
(14,'Other','Other','2026-06-09 17:41:13','2026-06-09 17:41:13');
/*!40000 ALTER TABLE `programmes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roll_no` varchar(45) DEFAULT NULL,
  `salutation` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `iitg_email` varchar(45) DEFAULT NULL,
  `alt_email` varchar(45) DEFAULT NULL,
  `country_code` varchar(45) DEFAULT NULL,
  `mobile_number` varchar(45) DEFAULT NULL,
  `department` varchar(45) DEFAULT NULL,
  `programme` varchar(45) DEFAULT NULL,
  `joining_year` varchar(45) DEFAULT NULL,
  `graduation_year` varchar(45) DEFAULT NULL,
  `hostel` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `pincode` varchar(45) DEFAULT NULL,
  `linkedin` varchar(45) DEFAULT NULL,
  `whatsapp` varchar(45) DEFAULT NULL,
  `organization` varchar(45) DEFAULT NULL,
  `designation` varchar(45) DEFAULT NULL,
  `next_venture` varchar(200) DEFAULT NULL,
  `passport_photo` varchar(100) DEFAULT NULL,
  `transcript` varchar(100) DEFAULT NULL,
  `certificate` varchar(100) DEFAULT NULL,
  `email_verified` varchar(45) DEFAULT NULL,
  `application_status` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES
(1,'1234567890','Mr','Pranjal','Gogoi','pranjal.gogoi983@gmail.com','pranjal.gogoi983@gmail.com','1','9401389359','Biotechnology','M.Sc','2022','2025','Barak','Albania','Assam','Naharkatia',NULL,'786610','','1234567789','','','','','','','pending','not submitted','2026-06-09 20:58:27','2026-06-09 20:58:27');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Pranjal','pranjal.gogoi983@gmail.com','$2y$10$QWhay61dudSkOV0P9pAy6e0IM3FhSulkz3cdYVkMiHEpiT0XiQ09S','student',0,NULL,'2026-06-09 20:58:27','2026-06-09 20:58:27');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-06-10  2:47:17
