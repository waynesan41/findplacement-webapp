-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: photoinventory
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_Connection=@@COLLATION_Connection */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `Connection`
--

/*!40000 ALTER TABLE `Connection` DISABLE KEYS */;
INSERT  IGNORE INTO `Connection` VALUES (303,302,1),(304,302,1),(305,302,1);
/*!40000 ALTER TABLE `Connection` ENABLE KEYS */;

--
-- Dumping data for table `Location`
--

/*!40000 ALTER TABLE `Location` DISABLE KEYS */;
INSERT  IGNORE INTO `Location` VALUES (1,301,NULL,0,0,'Book Box 1',1,NULL),(2,301,NULL,0,0,'Book Box 2',1,NULL),(3,301,NULL,0,0,'Book Box 3',1,NULL);
/*!40000 ALTER TABLE `Location` ENABLE KEYS */;

--
-- Dumping data for table `MainLocation`
--

/*!40000 ALTER TABLE `MainLocation` DISABLE KEYS */;
INSERT  IGNORE INTO `MainLocation` VALUES (1,300,'Default Main Location',0,0,0),(2,301,'Default Main Location',0,0,0),(300,300,'Dummy Main Location',0,0,0),(301,302,'House',3,0,0),(302,303,'Default Main Location',0,0,0),(303,304,'Default Main Location',0,0,0),(304,305,'Default Main Location',0,0,0);
/*!40000 ALTER TABLE `MainLocation` ENABLE KEYS */;

--
-- Dumping data for table `ObjectLibrary`
--

/*!40000 ALTER TABLE `ObjectLibrary` DISABLE KEYS */;
INSERT  IGNORE INTO `ObjectLibrary` VALUES (1,300,'Default Library',0),(2,301,'Default Library',0),(300,300,'Dummy Library',0),(301,302,'Home Inventory',51),(302,303,'Default Library',0),(303,304,'Default Library',0),(304,305,'Default Library',0);
/*!40000 ALTER TABLE `ObjectLibrary` ENABLE KEYS */;

--
-- Dumping data for table `ObjectLocation`
--

/*!40000 ALTER TABLE `ObjectLocation` DISABLE KEYS */;
INSERT  IGNORE INTO `ObjectLocation` VALUES (1,301,302,1,301,1,NULL,'2022-09-13 20:55:09'),(1,301,302,2,301,1,NULL,'2022-09-13 20:54:45'),(1,301,302,3,301,1,NULL,'2022-09-13 20:56:46'),(1,301,302,4,301,1,NULL,'2022-09-13 20:56:50'),(1,301,302,5,301,1,NULL,'2022-09-13 20:55:37'),(1,301,302,6,301,1,NULL,'2022-09-13 20:54:18'),(1,301,302,7,301,1,NULL,'2022-09-13 20:54:59'),(1,301,302,8,301,1,NULL,'2022-09-13 20:56:22'),(1,301,302,9,301,1,NULL,'2022-09-13 20:56:10'),(1,301,302,10,301,1,NULL,'2022-09-13 20:56:01'),(1,301,302,11,301,1,NULL,'2022-09-13 20:55:45'),(1,301,302,12,301,1,NULL,'2022-09-13 20:56:32'),(1,301,302,13,301,1,NULL,'2022-09-13 20:56:41'),(1,301,302,14,301,1,NULL,'2022-09-13 20:51:08'),(1,301,302,21,301,1,NULL,'2022-09-13 22:27:36'),(1,301,302,49,301,1,NULL,'2022-09-13 22:27:06'),(1,301,302,50,301,1,NULL,'2022-09-13 22:27:09'),(2,301,302,16,301,1,NULL,'2022-09-13 22:03:13'),(2,301,302,17,301,1,NULL,'2022-09-13 22:03:23'),(2,301,302,26,301,1,NULL,'2022-09-13 22:03:30'),(2,301,302,27,301,1,NULL,'2022-09-13 22:04:58'),(2,301,302,28,301,1,NULL,'2022-09-13 22:02:36'),(2,301,302,29,301,1,NULL,'2022-09-13 22:03:06'),(2,301,302,30,301,1,NULL,'2022-09-13 22:05:01'),(2,301,302,31,301,1,NULL,'2022-09-13 22:03:44'),(2,301,302,32,301,1,NULL,'2022-09-13 22:04:02'),(2,301,302,33,301,1,NULL,'2022-09-13 22:04:41'),(2,301,302,34,301,1,NULL,'2022-09-13 22:02:49'),(2,301,302,35,301,1,NULL,'2022-09-13 22:04:13'),(2,301,302,38,301,1,NULL,'2022-09-13 22:04:20'),(2,301,302,45,301,1,NULL,'2022-09-13 22:04:28'),(2,301,302,51,301,1,NULL,'2022-09-13 22:28:51'),(3,301,302,15,301,1,NULL,'2022-09-13 21:58:35'),(3,301,302,18,301,1,NULL,'2022-09-13 22:01:33'),(3,301,302,19,301,1,NULL,'2022-09-13 22:01:12'),(3,301,302,20,301,1,NULL,'2022-09-13 22:01:24'),(3,301,302,22,301,1,NULL,'2022-09-13 21:58:44'),(3,301,302,23,301,1,NULL,'2022-09-13 22:00:31'),(3,301,302,24,301,1,NULL,'2022-09-13 21:59:53'),(3,301,302,25,301,1,NULL,'2022-09-13 22:01:05'),(3,301,302,36,301,1,NULL,'2022-09-13 21:58:55'),(3,301,302,37,301,1,NULL,'2022-09-13 21:59:07'),(3,301,302,39,301,1,NULL,'2022-09-13 21:59:22'),(3,301,302,40,301,1,NULL,'2022-09-13 21:59:47'),(3,301,302,41,301,1,NULL,'2022-09-13 22:00:12'),(3,301,302,42,301,1,NULL,'2022-09-13 22:00:23'),(3,301,302,43,301,1,NULL,'2022-09-13 21:59:14'),(3,301,302,44,301,1,NULL,'2022-09-13 22:00:39'),(3,301,302,46,301,1,NULL,'2022-09-13 22:26:36'),(3,301,302,47,301,1,NULL,'2022-09-13 22:26:33'),(3,301,302,48,301,1,NULL,'2022-09-13 22:26:40');
/*!40000 ALTER TABLE `ObjectLocation` ENABLE KEYS */;

--
-- Dumping data for table `Objects`
--

/*!40000 ALTER TABLE `Objects` DISABLE KEYS */;
INSERT  IGNORE INTO `Objects` VALUES (1,301,'Managerial Accounting Garrison Noreen Brevwer',1,'Book','2022-09-13 19:47:28'),(2,301,'Precalculus Larson Hostetler',1,'Book','2022-09-13 19:48:08'),(3,301,'A Pocket Style Manual Grammar',1,'Book MLA Update Grammar Diana Hacker','2022-09-13 19:49:14'),(4,301,'The woman who watches over the world',1,'Book Linda Hogan','2022-09-13 20:44:03'),(5,301,'Adventures Spanish',1,'Book','2022-09-13 20:44:26'),(6,301,'Bioen 215',1,'Book Alyssa Taylor Bioengineering','2022-09-13 20:45:36'),(7,301,'Introduction to Organic Laboratory Techniques',1,'Book','2022-09-13 20:46:28'),(8,301,'Mathematics With Applications',1,NULL,'2022-09-13 20:47:02'),(9,301,'Finical Accounting',1,'Book','2022-09-13 20:47:45'),(10,301,'Student\'s Solutions Manual Mathmatics',1,'Book','2022-09-13 20:48:11'),(11,301,'Real Writing with Readings',1,'Book','2022-09-13 20:48:43'),(12,301,'Longman Preparation Course for Tofel Test',1,'Book Next Generation iBT','2022-09-13 20:49:28'),(13,301,'Media Now Understanding Media',1,'Book','2022-09-13 20:50:02'),(14,301,'GO! Office 2007',1,'Book','2022-09-13 20:50:23'),(15,301,'Longman Business English Dictionary',1,'Book','2022-09-13 21:00:48'),(16,301,'The Curious Writer',1,'Book Bruce Ballenger','2022-09-13 21:01:19'),(17,301,'BIOL&160 General Biology 1',1,'Book Bellevue Community College Custom Edition','2022-09-13 21:02:06'),(18,301,'Microeconomics in Context',1,'Book','2022-09-13 21:02:31'),(19,301,'Seeing & Writing 4',1,'Book Donald McQuade','2022-09-13 21:03:12'),(20,301,'Writing Research Paper A Complete Guide',1,'Book','2022-09-13 21:03:41'),(21,301,'Casio Piano Manual',1,'Book Manual User Guide','2022-09-13 21:04:25'),(22,301,'Pathways to Bliss Mythology',1,'Book Joseph Campbell','2022-09-13 21:05:58'),(23,301,'New York Know the City Like a Native',1,'Book','2022-09-13 21:07:27'),(24,301,'75 Readings an Anthology 11th',1,'Book','2022-09-13 21:10:16'),(25,301,'Current Issues and Enduring Questions',1,'Book','2022-09-13 21:11:07'),(26,301,'Earth Materials and Processes',1,'Book','2022-09-13 21:11:31'),(27,301,'The Least you should know about English ',1,'Book','2022-09-13 21:12:09'),(28,301,'The Informed Argument',1,'Book Robert K. Miller','2022-09-13 21:12:33'),(29,301,'Macro Economics',1,'Book Colander','2022-09-13 21:12:58'),(30,301,'Chartbook A Reference Grammar',1,'Book English Grammar','2022-09-13 21:13:31'),(31,301,'Raise The Issues Critical Thinking',1,'Book Carol Numrich','2022-09-13 21:14:01'),(32,301,'World Place Locations',1,'Book Douglas Roselle','2022-09-13 21:14:37'),(33,301,'The Penguin Historical Atlas of the Vikings',1,'Book The Penguin','2022-09-13 21:15:15'),(34,301,'The Informed Argument',1,'Book Better Condition','2022-09-13 21:22:37'),(35,301,'Applied Statistics for Engineers',1,'Book Devore / Farnum','2022-09-13 21:24:03'),(36,301,'Communicating Across Cultures',1,'Book Stella Ting-Toomey','2022-09-13 21:25:05'),(37,301,'The Curious Researcher Research Paper',1,'Book Bruce Ballenger','2022-09-13 21:25:41'),(38,301,'Principles of Economics',1,'Book Timothy Taylor','2022-09-13 21:26:14'),(39,301,'Doing Grammar',1,'Book Max Morenberg ','2022-09-13 21:26:50'),(40,301,'75 Readings an Anthology 10th',1,'Book','2022-09-13 21:27:56'),(41,301,'Write a Winning College Application Essay',1,'Book','2022-09-13 21:32:56'),(42,301,'Essays From Contemporary Culture',1,'Book Katherine Anne Ackley','2022-09-13 21:55:12'),(43,301,'Reading America Critical Thinking and Writing',1,'Book Gray Colombo, Robert Cullen, Bonnie Lisle','2022-09-13 21:56:11'),(44,301,'MLA Handbook for Writers of Research Paper',1,'Book','2022-09-13 21:56:30'),(45,301,'Aventuras Spanish Workbook/Video',1,'Book','2022-09-13 21:56:58'),(46,301,'Cryptocurrency Investing Bible',1,'Book Alan T. Norman I bought it.','2022-09-13 22:18:40'),(47,301,'True Diary of Part-Time Indian',1,'Book Sherman Alexie Bellevue English Class','2022-09-13 22:19:23'),(48,301,'Food Rules',1,'Book Michael Pollan','2022-09-13 22:19:59'),(49,301,'Honda Civic 2015 Owner\'s Manual',1,'Vehicle Certificate of Title Inside','2022-09-13 22:24:31'),(50,301,'Toyota Camry 2013 Owner\'s Manual',1,NULL,'2022-09-13 22:25:36'),(51,301,'Accounting General Journal 21 Century',1,'High School Book','2022-09-13 22:28:39');
/*!40000 ALTER TABLE `Objects` ENABLE KEYS */;

--
-- Dumping data for table `ObjectTag`
--

/*!40000 ALTER TABLE `ObjectTag` DISABLE KEYS */;
/*!40000 ALTER TABLE `ObjectTag` ENABLE KEYS */;

--
-- Dumping data for table `SharedLibrary`
--

/*!40000 ALTER TABLE `SharedLibrary` DISABLE KEYS */;
INSERT  IGNORE INTO `SharedLibrary` VALUES (301,303,1),(301,304,3),(301,305,1);
/*!40000 ALTER TABLE `SharedLibrary` ENABLE KEYS */;

--
-- Dumping data for table `SharedLocation`
--

/*!40000 ALTER TABLE `SharedLocation` DISABLE KEYS */;
INSERT  IGNORE INTO `SharedLocation` VALUES (301,303,1),(301,304,3),(301,305,1);
/*!40000 ALTER TABLE `SharedLocation` ENABLE KEYS */;

--
-- Dumping data for table `Tags`
--

/*!40000 ALTER TABLE `Tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `Tags` ENABLE KEYS */;

--
-- Dumping data for table `User`
--

/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT  IGNORE INTO `User` VALUES (300,'Dummy User','dummyUser1','Qwer`123','dummy@User.com','2022-09-14 02:40:21',1),(301,'Test User','testUser','Slowwyne4$','testUser@gg.com','2022-09-14 02:41:26',1),(302,'Wayne San','waynesan41','Slowwyne4$','waynesan41@gmail.com','2022-09-14 02:44:41',1),(303,'Duy N','duythu98','Duynguyen34.','duythu98@gmail.com','2022-09-17 05:49:37',1),(304,'Zaw','arshin1995','1234567890Qaz!','arshin1995@gmail.com','2022-09-19 04:19:27',1),(305,'Duy Nguyen','hunt_56','Huntthem_56','duynguye034@gmail.com','2022-10-24 21:50:45',1);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;

--
-- Dumping data for table `UserSession`
--

/*!40000 ALTER TABLE `UserSession` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserSession` ENABLE KEYS */;

--
-- Dumping data for table `UserTracker`
--

/*!40000 ALTER TABLE `UserTracker` DISABLE KEYS */;
INSERT  IGNORE INTO `UserTracker` VALUES (300,1,1,0,0),(301,0,0,0,0),(302,0,0,0,0),(303,0,0,0,0),(304,0,0,0,0),(305,0,0,0,0);
/*!40000 ALTER TABLE `UserTracker` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_Connection=@OLD_COLLATION_Connection */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-25  2:49:24
