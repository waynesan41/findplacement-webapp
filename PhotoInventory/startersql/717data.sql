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
INSERT  IGNORE INTO `Connection` VALUES (1001,1000,0),(1001,1002,1),(1003,1001,1),(1003,1002,1);
/*!40000 ALTER TABLE `Connection` ENABLE KEYS */;

--
-- Dumping data for table `location`
--

/*!40000 ALTER TABLE `Location` DISABLE KEYS */;
INSERT  IGNORE INTO `Location` VALUES (1,1001,NULL,0,0,'Wayne desk',1,NULL),(2,1001,NULL,0,0,'Cabinet1',1,NULL),(3,1001,NULL,0,0,'Joe desk',1,'Something\r\n'),(4,1001,2,0,0,'Cabinet Layer 1',1,NULL),(5,1001,2,0,0,'Cabinet Layer 2',1,NULL),(6,1001,2,0,0,'Cabinet Layer 3',1,NULL),(7,1001,12,0,0,'Under Table',1,NULL),(8,1001,7,0,0,'Box of Spray',1,'On the Right Side of Table'),(9,1001,1,0,0,'Personal Box',1,NULL),(10,1001,NULL,0,0,'Black Desk',1,NULL),(11,1001,NULL,0,0,'Gust Desk',1,'Some Random Desciption'),(12,1001,NULL,0,0,'Kitchen',1,NULL),(13,1001,8,0,0,'Paper Box',1,NULL),(14,1001,2,0,0,'Cabinet Side Storage',1,NULL),(15,1001,NULL,0,0,'Snack and Swag',1,NULL),(16,1001,NULL,0,0,'Guest Computer',1,NULL),(17,1001,12,0,0,'Old Cabinet',1,NULL),(18,1001,12,0,0,'Table Top',1,NULL),(19,1001,17,0,0,'Top OC',1,NULL),(20,1001,17,0,0,'Middle OC',1,NULL),(21,1001,17,0,0,'Bottom OC',1,NULL),(22,1001,12,0,0,'Fridge Table',1,NULL),(23,1001,3,0,0,'Back Drawer',1,NULL),(24,1001,3,0,0,'Beautiful Design',1,NULL),(25,1001,NULL,0,0,'Closet',1,NULL),(26,1001,25,0,0,'CS Ground Layer',1,NULL),(27,1001,26,0,0,'Box of Everything',1,NULL),(28,1001,NULL,0,0,'TV & Printer Table',1,NULL),(29,1001,27,0,0,'Bag of Unknown Objects',1,NULL),(30,1001,25,0,0,'CS Second Layer',1,NULL),(31,1001,17,0,0,'OC Ground',1,NULL),(32,1001,1,0,0,'Pen Holder',0,'No Picture');
/*!40000 ALTER TABLE `Location` ENABLE KEYS */;

--
-- Dumping data for table `mainlocation`
--

/*!40000 ALTER TABLE `Mainlocation` DISABLE KEYS */;
INSERT  IGNORE INTO `Mainlocation` VALUES (1,1000,'Default Main Location',0,0,0),(1000,1000,'Dummy Main Location',0,0,0),(1001,1001,'717 Office 1',32,0,0),(1002,1000,'Default Main Location',0,0,0),(1004,1002,'Default Main Location',0,0,0),(1006,1003,'Main Location',0,0,0),(1007,1001,'test',0,0,0),(1008,1002,'test333',0,0,0);
/*!40000 ALTER TABLE `Mainlocation` ENABLE KEYS */;

--
-- Dumping data for table `objectlibrary`
--

/*!40000 ALTER TABLE `Objectlibrary` DISABLE KEYS */;
INSERT  IGNORE INTO `Objectlibrary` VALUES (1,1000,'Default Library',0),(1000,1000,'Dummy Library',0),(1001,1001,'717 Inventory 1',147),(1002,1000,'Default Library',0),(1004,1002,'Default Library',0),(1005,1003,'Default Library',0),(1006,1001,'test',0),(1007,1002,'tes111',0);
/*!40000 ALTER TABLE `Objectlibrary` ENABLE KEYS */;

--
-- Dumping data for table `ObjectLocation`
--

/*!40000 ALTER TABLE `ObjectLocation` DISABLE KEYS */;
INSERT  IGNORE INTO `ObjectLocation` VALUES (1,1001,1001,2,1001,1,NULL,'2022-08-24 09:29:08'),(1,1001,1002,3,1001,12,'','2022-08-31 22:30:46'),(1,1001,1001,5,1001,1,NULL,'2022-08-24 09:29:05'),(1,1001,1001,6,1001,4,'Different Color','2022-08-24 09:29:24'),(1,1001,1001,7,1001,1,NULL,'2022-08-24 09:29:01'),(1,1001,1001,9,1001,1,NULL,'2022-08-24 16:43:02'),(1,1001,1001,13,1001,1,NULL,'2022-08-24 15:11:43'),(1,1001,1001,14,1001,1,NULL,'2022-08-24 16:42:58'),(1,1001,1001,15,1001,1,NULL,'2022-08-24 15:11:48'),(1,1001,1001,16,1001,1,'On Computer','2022-08-24 16:42:18'),(1,1001,1001,17,1001,1,NULL,'2022-08-24 15:11:57'),(1,1001,1002,20,1001,123,NULL,'2022-08-31 22:28:40'),(4,1001,1001,10,1001,1,NULL,'2022-08-26 22:26:13'),(4,1001,1001,88,1001,1,NULL,'2022-08-26 23:48:00'),(4,1001,1001,92,1001,1,NULL,'2022-08-26 23:51:26'),(4,1001,1001,93,1001,1,NULL,'2022-08-26 23:50:33'),(4,1001,1001,94,1001,1,NULL,'2022-08-26 23:50:29'),(4,1001,1001,95,1001,1,NULL,'2022-08-26 23:50:37'),(4,1001,1001,97,1001,1,'At The Back','2022-08-26 23:51:17'),(4,1001,1001,99,1001,1,NULL,'2022-08-26 23:56:21'),(4,1001,1001,103,1001,1,NULL,'2022-08-26 23:54:20'),(4,1001,1001,105,1001,1,NULL,'2022-08-26 23:54:16'),(5,1001,1001,89,1001,1,NULL,'2022-08-26 23:49:55'),(5,1001,1001,91,1001,1,NULL,'2022-08-26 23:50:13'),(5,1001,1001,100,1001,1,NULL,'2022-08-26 23:58:54'),(5,1001,1001,101,1001,1,NULL,'2022-08-26 23:55:58'),(5,1001,1001,102,1001,3,NULL,'2022-08-26 23:56:06'),(5,1001,1001,104,1001,1,NULL,'2022-08-26 23:58:58'),(6,1001,1001,96,1001,1,NULL,'2022-08-26 23:55:24'),(6,1001,1001,98,1001,3,NULL,'2022-08-26 23:54:46'),(6,1001,1001,106,1001,1,NULL,'2022-08-26 23:59:05'),(6,1001,1001,107,1001,1,NULL,'2022-08-26 23:55:35'),(6,1001,1001,108,1001,1,NULL,'2022-08-26 23:55:31'),(6,1001,1003,143,1001,1,NULL,'2022-08-31 10:55:18'),(7,1001,1003,18,1001,1,'WTH Wayne, where is it? How much is in it\r\n','2022-08-31 13:35:24'),(7,1001,1003,19,1001,3,'Auto Zone','2022-08-24 20:21:13'),(7,1001,1001,20,1001,0,'','2022-09-22 15:58:17'),(7,1001,1001,22,1001,2,'One of them is Half Full','2022-08-24 20:30:34'),(7,1001,1001,24,1001,2,'Both bottle are low about 15%','2022-08-24 20:31:24'),(7,1001,1001,25,1001,2,NULL,'2022-08-24 20:31:31'),(7,1001,1001,26,1001,1,NULL,'2022-08-24 20:31:38'),(7,1001,1001,27,1001,1,'','2022-08-24 20:31:41'),(7,1001,1001,28,1001,1,NULL,'2022-08-24 20:31:45'),(7,1001,1001,29,1001,2,'One of them is only 50%','2022-08-24 20:33:21'),(7,1001,1001,30,1001,1,NULL,'2022-08-24 20:33:57'),(7,1001,1001,31,1001,1,NULL,'2022-08-24 20:32:14'),(7,1001,1001,32,1001,1,NULL,'2022-08-24 20:32:02'),(7,1001,1001,33,1001,1,NULL,'2022-08-24 20:31:53'),(7,1001,1001,34,1001,1,NULL,'2022-08-24 20:31:56'),(7,1001,1001,35,1001,6,NULL,'2022-08-24 20:32:26'),(7,1001,1001,37,1001,1,NULL,'2022-08-24 20:32:09'),(7,1001,1001,38,1001,1,NULL,'2022-08-24 20:32:06'),(7,1001,1001,40,1001,1,NULL,'2022-08-24 20:34:52'),(7,1001,1001,41,1001,1,NULL,'2022-08-24 20:34:08'),(7,1001,1001,42,1001,1,NULL,'2022-08-24 20:32:30'),(7,1001,1001,43,1001,22,NULL,'2022-08-24 20:33:46'),(7,1001,1001,44,1001,30,NULL,'2022-08-24 20:33:52'),(8,1001,1001,21,1001,1,NULL,'2022-08-24 20:31:02'),(8,1001,1001,23,1001,2,NULL,'2022-08-24 20:30:58'),(8,1001,1001,36,1001,1,NULL,'2022-08-24 20:34:42'),(8,1001,1001,39,1001,1,NULL,'2022-08-24 20:34:31'),(8,1001,1001,45,1001,2,NULL,'2022-08-24 20:34:35'),(8,1001,1001,46,1001,2,NULL,'2022-08-24 20:34:27'),(8,1001,1001,47,1001,1,NULL,'2022-08-24 20:34:23'),(8,1001,1001,48,1001,1,NULL,'2022-08-24 20:34:20'),(9,1001,1003,109,1001,2,'ABC','2022-08-30 14:07:57'),(10,1001,1001,11,1001,1,NULL,'2022-08-24 16:42:05'),(10,1001,1001,62,1001,1,NULL,'2022-08-26 23:45:20'),(10,1001,1001,63,1001,1,NULL,'2022-08-26 23:45:23'),(10,1001,1001,64,1001,1,NULL,'2022-08-26 23:45:25'),(10,1001,1001,65,1001,2,NULL,'2022-08-26 23:45:28'),(10,1001,1001,66,1001,1,NULL,'2022-08-26 23:45:31'),(10,1001,1001,67,1001,1,NULL,'2022-08-26 23:45:35'),(10,1001,1001,68,1001,2,NULL,'2022-08-26 23:45:38'),(10,1001,1001,69,1001,1,NULL,'2022-08-26 23:45:41'),(10,1001,1001,71,1001,1,NULL,'2022-08-26 23:45:49'),(10,1001,1001,72,1001,1,NULL,'2022-08-26 23:45:54'),(10,1001,1001,73,1001,1,NULL,'2022-08-26 23:46:34'),(10,1001,1001,74,1001,2,NULL,'2022-08-26 23:45:59'),(10,1001,1001,75,1001,1,NULL,'2022-08-26 23:46:21'),(10,1001,1001,76,1001,1,NULL,'2022-08-26 23:46:07'),(10,1001,1001,77,1001,1,NULL,'2022-08-26 23:46:03'),(10,1001,1001,78,1001,1,NULL,'2022-08-26 23:46:42'),(10,1001,1001,79,1001,1,NULL,'2022-08-26 23:46:13'),(10,1001,1001,80,1001,1,NULL,'2022-08-26 23:46:10'),(10,1001,1001,81,1001,1,NULL,'2022-08-26 23:47:39'),(10,1001,1001,82,1001,1,NULL,'2022-08-26 23:47:43'),(10,1001,1001,83,1001,1,NULL,'2022-08-26 23:59:19'),(10,1001,1001,84,1001,1,NULL,'2022-08-26 23:46:46'),(10,1001,1001,85,1001,1,NULL,'2022-08-26 23:46:49'),(10,1001,1001,90,1001,1,NULL,'2022-08-26 23:59:16'),(11,1001,1001,12,1001,1,NULL,'2022-08-24 16:46:31'),(14,1001,1001,86,1001,1,NULL,'2022-08-26 23:48:43'),(14,1001,1001,87,1001,1,NULL,'2022-08-26 23:48:40'),(15,1001,1001,49,1001,3,NULL,'2022-08-26 23:43:42'),(15,1001,1001,50,1001,3,NULL,'2022-08-26 23:43:46'),(15,1001,1001,51,1001,10,NULL,'2022-08-26 23:43:57'),(15,1001,1001,52,1001,25,NULL,'2022-08-26 23:44:02'),(15,1001,1001,53,1001,1,NULL,'2022-08-26 23:44:05'),(15,1001,1001,54,1001,35,NULL,'2022-08-26 23:44:14'),(15,1001,1001,55,1001,5,NULL,'2022-08-26 23:44:22'),(15,1001,1001,56,1001,15,NULL,'2022-08-26 23:44:30'),(15,1001,1001,57,1001,1,NULL,'2022-08-26 23:44:34'),(15,1001,1001,58,1001,8,NULL,'2022-08-26 23:44:38'),(15,1001,1001,59,1001,10,NULL,'2022-08-26 23:44:43'),(15,1001,1001,60,1001,14,NULL,'2022-08-26 23:44:55'),(20,1001,1003,110,1001,2,NULL,'2022-08-31 10:31:41'),(20,1001,1003,111,1001,1,NULL,'2022-08-31 10:31:32'),(21,1001,1003,112,1001,1,'Under The Cabinet','2022-08-31 10:31:21'),(21,1001,1003,113,1001,1,NULL,'2022-08-31 10:31:09'),(23,1001,1001,70,1001,2,NULL,'2022-08-26 23:51:36'),(26,1001,1003,116,1001,1,NULL,'2022-08-31 10:56:33'),(27,1001,1003,115,1001,1,NULL,'2022-08-31 10:51:16'),(27,1001,1003,117,1001,1,NULL,'2022-08-31 10:51:31'),(27,1001,1003,118,1001,1,NULL,'2022-08-31 10:51:35'),(27,1001,1003,119,1001,1,NULL,'2022-08-31 10:51:39'),(27,1001,1003,120,1001,1,NULL,'2022-08-31 10:51:45'),(27,1001,1003,121,1001,1,NULL,'2022-08-31 10:51:48'),(27,1001,1003,122,1001,1,NULL,'2022-08-31 10:51:52'),(27,1001,1003,123,1001,1,NULL,'2022-08-31 10:51:56'),(27,1001,1003,127,1001,1,NULL,'2022-08-31 10:52:09'),(27,1001,1003,130,1001,1,NULL,'2022-08-31 10:52:29'),(27,1001,1003,131,1001,1,NULL,'2022-08-31 10:52:32'),(27,1001,1003,133,1001,1,NULL,'2022-08-31 10:56:47'),(27,1001,1003,134,1001,1,NULL,'2022-08-31 10:56:44'),(27,1001,1003,135,1001,1,NULL,'2022-08-31 10:56:42'),(27,1001,1003,137,1001,1,NULL,'2022-08-31 10:56:38'),(27,1001,1003,139,1001,1,NULL,'2022-08-31 10:54:55'),(27,1001,1003,141,1001,1,NULL,'2022-08-31 10:55:07'),(27,1001,1003,142,1001,1,NULL,'2022-08-31 10:56:59'),(27,1001,1003,144,1001,1,NULL,'2022-08-31 10:55:02'),(28,1001,1003,61,1001,5,NULL,'2022-08-31 10:30:47'),(29,1001,1003,124,1001,1,NULL,'2022-08-31 10:48:21'),(29,1001,1003,125,1001,1,NULL,'2022-08-31 10:48:29'),(29,1001,1003,126,1001,1,NULL,'2022-08-31 10:52:00'),(29,1001,1003,128,1001,1,NULL,'2022-08-31 10:52:19'),(29,1001,1003,129,1001,1,NULL,'2022-08-31 10:52:22'),(29,1001,1003,136,1001,1,NULL,'2022-08-31 10:56:51'),(30,1001,1003,114,1001,1,NULL,'2022-08-31 10:51:09'),(30,1001,1003,132,1001,1,'Look For the Bag','2022-08-31 11:10:23'),(30,1001,1003,138,1001,1,NULL,'2022-08-31 10:57:10'),(31,1001,1003,140,1001,1,'Under the Cabinet','2022-08-31 11:01:03');
/*!40000 ALTER TABLE `ObjectLocation` ENABLE KEYS */;

--
-- Dumping data for table `Objects`
--

/*!40000 ALTER TABLE `Objects` DISABLE KEYS */;
INSERT  IGNORE INTO `Objects` VALUES (2,1001,'Box Cutter',1,'$1','2022-08-24 08:14:16'),(3,1001,'Tape Measure 30\"',1,'$1','2022-08-24 09:24:20'),(5,1001,'Wireless Mouse Logitech G502',1,'Gaming MouseLightspeed','2022-08-24 09:27:58'),(6,1001,'Small Sticky Note',1,NULL,'2022-08-24 09:28:19'),(7,1001,'Dell Keyboard',1,'Basic Keyboard','2022-08-24 09:28:42'),(9,1001,'Bose QC35 Earbuds',1,'','2022-08-24 13:14:41'),(10,1001,'Tape Dispenser Blurry Tape',1,'','2022-08-24 13:16:03'),(11,1001,'Glove',1,NULL,'2022-08-24 13:16:35'),(12,1001,'Mouse Pad',1,'New but Smaller Size','2022-08-24 14:28:04'),(13,1001,'Body Lotion Small Bottle',1,'$1','2022-08-24 15:07:32'),(14,1001,'Hand Sanitizer Small Bottle',1,'$1','2022-08-24 15:08:05'),(15,1001,'Tape Dispenser Clear Tape',1,NULL,'2022-08-24 15:09:07'),(16,1001,'Wireless Charger + Germ Killer',1,'Joe Stuff','2022-08-24 15:10:30'),(17,1001,'Game Controller',1,'Not made by Sony','2022-08-24 15:11:01'),(18,1001,'Motor Oil Diesel Specialoil SAE 15W-40',1,NULL,'2022-08-24 16:51:25'),(19,1001,'Steering Fluid',1,'Auto Zone','2022-08-24 16:52:13'),(20,1001,'Bug Remove Windshield washer Fluid',1,'Bug Remover','2022-08-24 16:53:47'),(21,1001,'Quick Funnel Cone',1,'Used with Engine Oil','2022-08-24 16:54:24'),(22,1001,'Blue DEF',1,'All Diesel SCR systems','2022-08-24 16:54:57'),(23,1001,'Window Cleaner Bottle',1,'Without Spray','2022-08-24 16:55:24'),(24,1001,'Diesel Engine Oil SAE 15W-40',1,NULL,'2022-08-24 16:56:03'),(25,1001,'Small Traffic Cone',1,'Used with RV','2022-08-24 16:56:35'),(26,1001,'Multi-Purpose Cleaner',1,'Makes 64 Gallons','2022-08-24 16:57:35'),(27,1001,'Prestone Brake Fluid DOT 4',1,NULL,'2022-08-24 16:58:04'),(28,1001,'Bleach Javellisant',1,'Fresh scent Parfum Frais','2022-08-24 16:58:57'),(29,1001,'Ultrapure DEF',1,NULL,'2022-08-24 16:59:23'),(30,1001,'Small Heater',1,NULL,'2022-08-24 16:59:38'),(31,1001,'Engine Oil SAE 10W-30 Diesel-Gas-Natural Gas',1,NULL,'2022-08-24 17:00:25'),(32,1001,'Antifreeze+coolant',1,'Do not add water','2022-08-24 17:01:00'),(33,1001,'Prestone Antifreeze + Coolant',1,'All vehicles','2022-08-24 17:01:36'),(34,1001,'Prestone Antifreeze/Coolant',1,'Do not Add Water','2022-08-24 17:02:17'),(35,1001,'Antifreeze & Coolant',1,'Do not Add Water','2022-08-24 17:02:58'),(36,1001,'Window Glass Cleaner',1,'$1','2022-08-24 17:03:31'),(37,1001,'Transmission Fluid',1,NULL,'2022-08-24 17:03:54'),(38,1001,'Deer Guard Part',1,NULL,'2022-08-24 17:08:17'),(39,1001,'Antibacterial Spray Cleaner',1,NULL,'2022-08-24 17:09:48'),(40,1001,'Strap',1,'Truck','2022-08-24 17:10:15'),(41,1001,'Broken Red Gladhand',1,NULL,'2022-08-24 17:10:46'),(42,1001,'Broken Shock Absorber',1,NULL,'2022-08-24 17:11:25'),(43,1001,'Premium Paper Towel',1,'Strong Thick and Absorbent','2022-08-24 17:11:51'),(44,1001,'Toilet Paper',1,NULL,'2022-08-24 17:12:02'),(45,1001,'Glass Cleaner Spray',1,NULL,'2022-08-24 17:12:17'),(46,1001,'Window Cleaner Spray',1,NULL,'2022-08-24 17:12:30'),(47,1001,'Cleaner with Bleach Spray',1,NULL,'2022-08-24 17:12:57'),(48,1001,'Micro Fiber Towel ',1,NULL,'2022-08-24 17:16:53'),(49,1001,'AFP Swag White Bottle',1,'2022','2022-08-26 22:27:07'),(50,1001,'AFP Swag Black Water Bottle',1,'Narrow Top','2022-08-26 22:27:52'),(51,1001,'AFP Swag Hat',1,'Soft Top','2022-08-26 22:28:21'),(52,1001,'AFP Swag Cap',1,NULL,'2022-08-26 22:28:46'),(53,1001,'AFP Swag Glove',1,NULL,'2022-08-26 22:29:04'),(54,1001,'AFP Swag T-shirt',1,NULL,'2022-08-26 22:29:24'),(55,1001,'AFP Swag Mask',1,NULL,'2022-08-26 22:29:41'),(56,1001,'AFP Swag T-Shirt Blue',1,NULL,'2022-08-26 22:30:21'),(57,1001,'AFP Swag Reflective Vest',1,NULL,'2022-08-26 22:30:54'),(58,1001,'AFP Swag Orange Reflective Vest',1,NULL,'2022-08-26 22:31:10'),(59,1001,'AFP Swag Beanie Hat',1,NULL,'2022-08-26 22:32:14'),(60,1001,'Breathsavers Mint',1,NULL,'2022-08-26 22:33:02'),(61,1001,'Spotless Fleets Pamphlet',1,'250 per bulk','2022-08-26 22:33:58'),(62,1001,'USB Power Adapter 90 degree Angle',1,NULL,'2022-08-26 22:35:03'),(63,1001,'USB Power Adapter',1,'Unknown','2022-08-26 22:35:47'),(64,1001,'USB Power Adapter Kasa Camera',1,'Come with KASA Camera.','2022-08-26 22:36:33'),(65,1001,'AA Batteries (Double A)',1,NULL,'2022-08-26 22:37:40'),(66,1001,'Amazon Fire Tablet 8',1,NULL,'2022-08-26 22:38:00'),(67,1001,'George Resume',1,NULL,'2022-08-26 22:38:33'),(68,1001,'Dell Wire Mouse',1,NULL,'2022-08-26 22:38:49'),(69,1001,'Whiteboard Tools & Instruction',1,'','2022-08-26 22:39:30'),(70,1001,'LG Monitor Manual ',1,NULL,'2022-08-26 22:40:39'),(71,1001,'GPU Placeholder',1,'From Wayne PC Case','2022-08-26 22:42:06'),(72,1001,'Car USB Adapter',1,'Dual Port','2022-08-26 22:43:43'),(73,1001,'Grey Glove Light Duty',1,'$1','2022-08-26 22:44:03'),(74,1001,'Car USB Adapter Dual Ports',1,'$1','2022-08-26 22:44:39'),(75,1001,'Car USB Adapter Single Port',1,'$1','2022-08-26 22:45:05'),(76,1001,'Tape Measure 16 ft / 5 m',1,'$1 Multiple Stopper','2022-08-26 22:46:03'),(77,1001,'1 LB Magnetic Pick-up Tool',1,'3 feet','2022-08-26 22:56:48'),(78,1001,'Micro USB Cable 37\"',1,NULL,'2022-08-26 22:57:49'),(79,1001,'Display Port Cable 55\"',1,'','2022-08-26 22:58:19'),(80,1001,'USB-A Cable 70\"',1,NULL,'2022-08-26 23:17:49'),(81,1001,'White Board Push Pin Magnets',1,'Different Colors','2022-08-26 23:18:44'),(82,1001,'Car Power Adapter',1,'AC, USB, USB-C Ports','2022-08-26 23:19:30'),(83,1001,'Vest Bag',1,NULL,'2022-08-26 23:19:46'),(84,1001,'Bendable Metal Wire',1,NULL,'2022-08-26 23:20:41'),(85,1001,'Unknow Object',1,NULL,'2022-08-26 23:20:55'),(86,1001,'Cabinet Door Knobs',1,'Wood Color','2022-08-26 23:21:28'),(87,1001,'TV Stand for Cabinet TV',1,NULL,'2022-08-26 23:21:57'),(88,1001,'Envelopes 4.1\" x 9.5\"',1,NULL,'2022-08-26 23:23:36'),(89,1001,'Soft Sticker for Object',1,NULL,'2022-08-26 23:23:58'),(90,1001,'Micro USB Cable 115\"',1,'KASA Camera ','2022-08-26 23:25:09'),(91,1001,'COVID-19 Test Kit',1,'15 Minutes','2022-08-26 23:26:14'),(92,1001,'Pilot Color Pens',1,'Blue, Red, Green , Purple','2022-08-26 23:27:45'),(93,1001,'Large Paper Clips 50mm',1,NULL,'2022-08-26 23:28:11'),(94,1001,'Car Dash Cam Power Cable and SD Card',1,NULL,'2022-08-26 23:28:44'),(95,1001,'White Basic Tape',1,'$1','2022-08-26 23:28:59'),(96,1001,'File Folders',1,NULL,'2022-08-26 23:30:04'),(97,1001,'717 Joe Business Card',1,'It is a White Box','2022-08-26 23:30:30'),(98,1001,'Asepso Antiseptic Wipes',1,'6\" x 7\"','2022-08-26 23:31:18'),(99,1001,'Sticky Notes Default Size',1,'Come in Color','2022-08-26 23:31:48'),(100,1001,'Repair Markers Wood Laminate',1,'Furniture','2022-08-26 23:32:20'),(101,1001,'Box of Rubber Band',1,NULL,'2022-08-26 23:32:53'),(102,1001,'COVID-19 Test',1,'1 Test Per Box','2022-08-26 23:33:19'),(103,1001,'Standard Staples',1,'5000 Staples','2022-08-26 23:33:46'),(104,1001,'RV Vehicle Title Application',1,NULL,'2022-08-26 23:34:09'),(105,1001,'Paperclips Jumbo',1,'100 Paper Clips','2022-08-26 23:35:07'),(106,1001,'Sheet Protectors',1,'Some Chinese Brand too','2022-08-26 23:35:26'),(107,1001,'Box of Small size Envelope',1,NULL,'2022-08-26 23:35:47'),(108,1001,'10 x 13 Clasp Envelopes',1,NULL,'2022-08-26 23:36:15'),(109,1001,'中文字幕',1,NULL,'2022-08-30 11:08:16'),(110,1001,'AFP Swag Backpack',1,'Good for carrying lunch','2022-08-30 14:15:52'),(111,1001,'George Backpack',1,NULL,'2022-08-30 14:16:30'),(112,1001,'Air Mattress',1,NULL,'2022-08-30 14:17:07'),(113,1001,'Febreze Plug Refill',1,'150 Days','2022-08-30 14:18:00'),(114,1001,'Tape Measure 25\'',1,'High Quality','2022-08-31 10:33:08'),(115,1001,'Starding Fluid',1,'Bought it for repairing RV Generator.','2022-08-31 10:33:47'),(116,1001,'Broom and Dust Pan',1,NULL,'2022-08-31 10:34:22'),(117,1001,'WD-40 Sprays',1,NULL,'2022-08-31 10:34:49'),(118,1001,'Tool Box Buddy',1,NULL,'2022-08-31 10:35:34'),(119,1001,'Trailer Part',1,NULL,'2022-08-31 10:35:51'),(120,1001,'Door Knobs',1,NULL,'2022-08-31 10:36:13'),(121,1001,'Metal Hammer',1,NULL,'2022-08-31 10:36:44'),(122,1001,'Rubber O Ring Sealing Gasket',1,'Classic Truck AC Repair','2022-08-31 10:37:55'),(123,1001,'TV Stand for Sebastian Truck',1,NULL,'2022-08-31 10:38:40'),(124,1001,'Unknow Object',1,NULL,'2022-08-31 10:38:52'),(125,1001,'Unknow Object',1,NULL,'2022-08-31 10:39:03'),(126,1001,'Phone Holder of Something',1,NULL,'2022-08-31 10:39:16'),(127,1001,'Tire Air Pressure',1,NULL,'2022-08-31 10:39:43'),(128,1001,'Unknow Object',1,NULL,'2022-08-31 10:39:54'),(129,1001,'Unknow Object',1,NULL,'2022-08-31 10:40:12'),(130,1001,'Rubber Strap Light Duty',1,NULL,'2022-08-31 10:40:49'),(131,1001,'Small Broom',1,NULL,'2022-08-31 10:41:05'),(132,1001,'Glad Hand Seals',1,'3 Black 1 Red','2022-08-31 10:41:30'),(133,1001,'Unknown Object',1,NULL,'2022-08-31 10:41:48'),(134,1001,'Head Light',1,NULL,'2022-08-31 10:42:07'),(135,1001,'Sebastian Dog Stuff',1,NULL,'2022-08-31 10:42:36'),(136,1001,'Unknow Object',1,NULL,'2022-08-31 10:42:46'),(137,1001,'Hose Clamps Pipe Seal',1,NULL,'2022-08-31 10:43:34'),(138,1001,'Blue Disposable Gloves',1,NULL,'2022-08-31 10:44:56'),(139,1001,'Glove',1,'$1','2022-08-31 10:45:08'),(140,1001,'Broken AC Part from Classic Truck',1,'From Classic truck','2022-08-31 10:45:30'),(141,1001,'Bag of Bolts',1,NULL,'2022-08-31 10:46:12'),(142,1001,'Missing Tool Piece',1,NULL,'2022-08-31 10:46:29'),(143,1001,'Reusable Bag',1,NULL,'2022-08-31 10:46:56'),(144,1001,'Broken Light Cover',1,'Don\'t Know where is this from1','2022-08-31 10:47:23');
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
INSERT  IGNORE INTO `SharedLibrary` VALUES (1001,1002,3),(1001,1003,3),(1006,1002,3);
/*!40000 ALTER TABLE `SharedLibrary` ENABLE KEYS */;

--
-- Dumping data for table `SharedLocation`
--

/*!40000 ALTER TABLE `SharedLocation` DISABLE KEYS */;
INSERT  IGNORE INTO `SharedLocation` VALUES (1001,1002,3),(1001,1003,3),(1007,1002,3);
/*!40000 ALTER TABLE `SharedLocation` ENABLE KEYS */;

--
-- Dumping data for table `Tags`
--

/*!40000 ALTER TABLE `Tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `Tags` ENABLE KEYS */;

--
-- Dumping data for table `user`
--

/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT  IGNORE INTO `User` VALUES (1000,'Dummy User','dummyuser1','Qwer`123','dummy@user.com','2022-08-24 03:35:40',1),(1001,'Wayne San1','waynesan41','Wayne123!','waynesan1@gg.com','2022-08-24 03:41:39',1),(1002,'Joe khalil','joek','Kristina@2','joekhalil7079@gmail.com','2022-08-24 21:12:49',1),(1003,'Sharbel Zogheib','szsz','Wayne123!','sz@sodecosolutions.com','2022-08-25 04:02:55',1);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;

--
-- Dumping data for table `usersession`
--

/*!40000 ALTER TABLE `UserSession` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserSession` ENABLE KEYS */;

--
-- Dumping data for table `UserTracker`
--

/*!40000 ALTER TABLE `UserTracker` DISABLE KEYS */;
INSERT  IGNORE INTO `UserTracker` VALUES (1000,0,0,0,0,0),(1001,1,1,0,0,0),(1002,1,1,0,0,0),(1003,0,1,0,0,0);
/*!40000 ALTER TABLE `UserTracker` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_Connection=@OLD_COLLATION_Connection */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-22 22:09:03
