-- MySQL dump 10.13  Distrib 5.1.53, for apple-darwin10.3.0 (i386)
--
-- Host: localhost    Database: folio_db
-- ------------------------------------------------------
-- Server version	5.1.53

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `user` int(16) NOT NULL,
  `token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `deactivated` tinyint(1) NOT NULL DEFAULT '0',
  `created` date NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (3,3,'',1,0,'2011-10-16','2011-10-16 12:26:34'),(4,4,'',1,0,'2011-10-20','2011-10-20 07:33:57'),(7,27,'',1,0,'2011-10-29','2011-10-29 06:34:04'),(8,28,'',1,0,'2011-11-26','2011-11-27 04:52:42');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `active_sessions`
--

DROP TABLE IF EXISTS `active_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `active_sessions` (
  `session` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(16) NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `active_sessions`
--

LOCK TABLES `active_sessions` WRITE;
/*!40000 ALTER TABLE `active_sessions` DISABLE KEYS */;
INSERT INTO `active_sessions` VALUES ('c87d6e9bd5aa58a921256cb84279db61',3,'2012-03-30 11:46:48','2012-03-30 11:46:48'),('f732a4ba87ef3f5352f43a1d5b379194',3,'2012-03-30 07:46:04','2012-03-30 07:46:04'),('5b936a67715e8c445b7081a189cd5575',3,'2012-03-30 12:07:06','2012-03-30 12:07:06'),('e5af79196d38bdadb2c615257968e329',3,'2012-03-28 09:29:56','2012-03-28 09:29:56');
/*!40000 ALTER TABLE `active_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `user` int(16) DEFAULT NULL,
  `parent_type` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(16) DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,3,'image',373,'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','2012-03-24 04:01:58','2012-03-24 04:01:58'),(2,28,'image',373,'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2012-03-24 05:30:34','2012-03-24 05:30:34'),(3,28,'image',413,'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2012-03-24 05:31:24','2012-03-24 05:31:24'),(4,28,'image',414,'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2012-03-24 05:31:59','2012-03-24 05:31:59'),(5,28,'image',374,'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2012-03-24 05:33:11','2012-03-24 05:33:11'),(6,28,'image',83,'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2012-03-24 05:40:21','2012-03-24 05:40:21'),(7,3,'image',373,'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','2012-03-24 19:21:43','2012-03-24 19:21:43'),(50,3,'image',414,'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','2012-03-27 00:10:15','2012-03-27 00:10:15'),(49,3,'image',414,'reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident','2012-03-24 21:46:52','2012-03-24 21:46:52');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorites` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `item` int(16) DEFAULT NULL,
  `user` int(16) DEFAULT NULL,
  `type` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (2,69,3,'media','0000-00-00 00:00:00','2011-12-13 06:11:42'),(3,87,3,'media','0000-00-00 00:00:00','2011-12-13 06:14:24'),(4,70,3,'media','0000-00-00 00:00:00','2011-12-13 06:15:04'),(5,412,3,'media','0000-00-00 00:00:00','2011-12-13 06:16:37'),(35,78,3,'media','0000-00-00 00:00:00','2011-12-14 02:28:24'),(77,3,3,'media','2012-03-30 06:18:15','2012-03-30 06:18:15'),(49,89,28,'media','0000-00-00 00:00:00','2012-03-20 19:06:40'),(42,413,3,'media','0000-00-00 00:00:00','2012-03-13 02:00:28'),(47,78,28,'media','0000-00-00 00:00:00','2012-03-20 19:04:17'),(50,89,3,'media','0000-00-00 00:00:00','2012-03-20 19:07:26'),(54,371,3,'media','2012-03-25 05:25:12','2012-03-25 05:25:12'),(55,373,3,'media','2012-03-25 05:26:49','2012-03-25 05:26:49'),(69,370,3,'media','2012-03-30 06:08:21','2012-03-30 06:08:21'),(67,88,3,'media','2012-03-30 06:01:41','2012-03-30 06:01:41'),(87,73,3,'media','2012-03-30 06:30:12','2012-03-30 06:30:12'),(97,82,3,'media','2012-03-30 08:46:53','2012-03-30 08:46:53');
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medias`
--

DROP TABLE IF EXISTS `medias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medias` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `user` int(16) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `privacy` tinyint(1) DEFAULT NULL,
  `access_group` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` date NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=452 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medias`
--

LOCK TABLES `medias` WRITE;
/*!40000 ALTER TABLE `medias` DISABLE KEYS */;
INSERT INTO `medias` VALUES (1,3,'Winter','http://laika.local/folio/media/laika/506acb48_4ec6eb0275063.png','image',1,'everyone','desktop','2011-11-18','2011-11-26 08:10:16'),(2,3,'Hexley','http://laika.local/folio/media/laika/506acb48_4ec6eb0276dc7.png','image',0,'everyone','desktop','2011-11-18','2011-11-26 20:36:33'),(3,3,'Sartre','http://laika.local/folio/media/laika/506acb48_4ec6eb0277cb8.png','image',1,'everyone','desktop','2011-11-18','2011-11-26 08:10:16'),(5,3,'Birthday Card','http://laika.local/folio/media/laika/506acb48_4ec6eb02789cd.jpg','image',0,'everyone','','2011-11-18','2011-12-13 09:30:53'),(6,3,'Fall Desktop','http://laika.local/folio/media/laika/506acb48_4ec6eb0278ecd.png','image',1,'everyone','','2011-11-18','2011-11-26 19:50:50'),(75,3,'Fall Desktop','http://laika.local/folio/media/laika/506acb48_4ecdbec99f282.png','image',1,'everyone','','2011-11-23','2011-11-24 03:49:29'),(74,3,'Fall Desktop','http://laika.local/folio/media/laika/506acb48_4ecdbec99eb20.png','image',1,'everyone','','2011-11-23','2011-11-24 03:49:29'),(73,3,'','http://laika.local/folio/media/laika/506acb48_4ecdbec99d65b.jpg','image',1,'everyone','','2011-11-23','2011-11-24 03:49:29'),(72,3,'Yuri & Laika','http://laika.local/folio/media/laika/506acb48_4ecd7f21874d2.jpg','image',1,'everyone','','2011-11-23','2011-11-23 23:17:53'),(71,3,'Summer Desktop','http://laika.local/folio/media/laika/506acb48_4ecd7f2186e07.png','image',1,'everyone','','2011-11-23','2011-11-26 19:53:44'),(70,3,'Ewok Party','http://laika.local/folio/media/laika/506acb48_4ecd7f2186693.jpg','image',1,'everyone','','2011-11-23','2011-11-26 19:53:44'),(69,3,'Windows on Mac Desktop','http://laika.local/folio/media/laika/506acb48_4ecd7f2184c63.png','image',1,'everyone','','2011-11-23','2011-11-26 19:50:50'),(76,3,'Tux Desktop','http://laika.local/folio/media/laika/506acb48_4ecdbec99fa75.png','image',1,'everyone','','2011-11-23','2011-11-24 03:49:29'),(77,3,'Yuri and Laika','http://laika.local/folio/media/laika/506acb48_4ecdbec99ff4d.jpg','image',1,'everyone','','2011-11-23','2011-11-24 03:49:29'),(78,3,'Gagarin','http://laika.local/folio/media/laika/506acb48_4ecdbec9a0518.jpg','image',1,'everyone','','2011-11-23','2011-12-11 04:21:15'),(413,3,'CitizenCompass UI','http://laika.local/folio/media/laika/506acb48_4ee7cdb744b73.png','image',1,'everyone','Screenshot of the Q & A feature in the CitizenCompass Web App.','2011-12-13','2012-03-19 02:43:44'),(83,3,'New Year 2004','http://laika.local/folio/media/laika/506acb48_4ecdd8d431e5a.jpg','image',1,'everyone','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2011-11-24','2011-11-26 19:30:01'),(82,3,'New Year 2003','http://laika.local/folio/media/laika/506acb48_4ecdd8d430e38.jpg','image',1,'everyone','','2011-11-24','2011-11-26 19:32:26'),(84,3,'New Year 2006','http://laika.local/folio/media/laika/506acb48_4ecdd8d432029.jpg','image',1,'everyone','','2011-11-24','2011-11-26 19:31:22'),(85,3,'New Year 2007','http://laika.local/folio/media/laika/506acb48_4ecdd8d4323af.jpg','image',1,'everyone','','2011-11-24','2011-11-26 19:31:22'),(86,3,'New Year 2008','http://laika.local/folio/media/laika/506acb48_4ecdd8d4327bf.jpg','image',1,'everyone','','2011-11-24','2011-11-26 19:31:22'),(87,3,'New Year 2009','http://laika.local/folio/media/laika/506acb48_4ecdd8d432b05.jpg','image',1,'everyone','','2011-11-24','2011-11-26 19:31:22'),(88,3,'New Year 2010','http://laika.local/folio/media/laika/506acb48_4ecdd8d4332ee.jpg','image',1,'everyone','','2011-11-24','2011-11-26 19:31:22'),(89,3,'New Year 2011','http://laika.local/folio/media/laika/506acb48_4ecdd94e84b91.jpg','image',1,'everyone','','2011-11-24','2011-11-26 19:31:22'),(370,27,'','http://laika.local/folio/media/demo/f9950adc_4ed2f2c7a8300.jpg','image',1,'everyone',NULL,'2011-11-27','2011-11-28 02:32:39'),(371,27,'','http://laika.local/folio/media/demo/f9950adc_4ed2f92a4b4c4.jpg','image',1,'everyone',NULL,'2011-11-27','2011-11-28 02:59:54'),(372,27,'','http://laika.local/folio/media/demo/f9950adc_4ed2f92a4c835.jpg','image',1,'everyone',NULL,'2011-11-27','2011-11-28 02:59:54'),(373,27,'','http://laika.local/folio/media/demo/f9950adc_4ed2f92a4cc5e.jpg','image',1,'everyone',NULL,'2011-11-27','2011-11-28 02:59:54'),(374,27,'','http://laika.local/folio/media/demo/f9950adc_4ed2f92a4d55d.jpg','image',1,'everyone',NULL,'2011-11-27','2011-11-28 02:59:54'),(414,3,'Spring Desktop','http://laika.local/folio/media/laika/506acb48_4f5e887f20bce.png','image',1,'everyone','Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.','2012-03-12','2012-03-12 23:37:05'),(450,3,'','http://laika.local/folio/media/laika/506acb48_4f7399a8ca83a.png','image',1,'everyone',NULL,'2012-03-28','2012-03-28 23:07:20'),(451,3,'','http://laika.local/folio/media/laika/506acb48_4f7399a8caf6a.png','image',1,'everyone',NULL,'2012-03-28','2012-03-28 23:07:20');
/*!40000 ALTER TABLE `medias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `username` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `salt` int(8) NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `level` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `firstname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `logged_in` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'laika','856a492615258487089645ddeb0a5439',12136172,'witzel@post.harvard.edu','user','Leonard','Witzel',1,'0000-00-00 00:00:00','2012-03-30 11:46:48'),(4,'belka','0164ffda5b45b526e06ca91453cd878b',86098695,'oafbot@mac.com','user','Belka','Woof',0,'0000-00-00 00:00:00','2012-03-20 19:03:29'),(27,'demo','9dbd054c2d0027f6167cc598449d5643',95925362,'oafbot@me.com','user','Desmond','Demo',0,'0000-00-00 00:00:00','2012-03-30 11:46:19'),(28,'mushka','28fc8cbc11c27b50680960c4063da3d3',4242263,'oafbot@gmail.com','user','Leonard','Witzel',0,'0000-00-00 00:00:00','2012-03-25 04:18:26');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-03-30  9:45:11
