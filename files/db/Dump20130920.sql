CREATE DATABASE  IF NOT EXISTS `melarossa` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `melarossa`;
-- MySQL dump 10.13  Distrib 5.6.11, for Win32 (x86)
--
-- Host: localhost    Database: melarossa
-- ------------------------------------------------------
-- Server version	5.6.13

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
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrators`
--

LOCK TABLES `administrators` WRITE;
/*!40000 ALTER TABLE `administrators` DISABLE KEYS */;
INSERT INTO `administrators` VALUES (16,'jack','jack','4ff9fc6e4e5d5f590c4f2134a8cc96d1','jack'),(17,'john','john','527bd5b5d689e2c32ae974c6229ff785','operator'),(18,'alfred','alfred','1','operator'),(19,'simon','simon','1','operator'),(20,'james','james','1','operator'),(21,'operator','op','c4ca4238a0b923820dcc509a6f75849b','operator'),(22,'jane','jane','1','operator');
/*!40000 ALTER TABLE `administrators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `categories_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categories_categories1_idx` (`categories_id`),
  CONSTRAINT `fk_categories_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (10,'Topo',NULL),(11,'Giardinaggio',NULL),(13,'Cancelleria',NULL),(14,'categoria',10),(15,'categoria',10),(16,'categoria',10),(17,'categoria',10),(18,'categoria',10),(19,'categoria',11),(20,'categoria',11),(21,'categoria',11),(22,'categoria',11),(23,'categoria',11),(24,'categoria',13),(25,'categoria',13),(26,'categoria',13),(27,'categoria',13),(28,'categoria',13);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_images`
--

DROP TABLE IF EXISTS `company_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(100) DEFAULT NULL,
  `company_info_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`company_info_id`),
  KEY `fk_company_images_company_info1_idx` (`company_info_id`),
  CONSTRAINT `fk_company_images_company_info1` FOREIGN KEY (`company_info_id`) REFERENCES `company_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_images`
--

LOCK TABLES `company_images` WRITE;
/*!40000 ALTER TABLE `company_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_info`
--

DROP TABLE IF EXISTS `company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `piva` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_info`
--

LOCK TABLES `company_info` WRITE;
/*!40000 ALTER TABLE `company_info` DISABLE KEYS */;
INSERT INTO `company_info` VALUES (1,'Mela Rossa','Cash n Carry','12345678901','049731934','049752846','via Uruguay 1');
/*!40000 ALTER TABLE `company_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `piva` varchar(11) DEFAULT NULL,
  `cod_fis` varchar(16) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `cellphone` varchar(45) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `password` varchar(45) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  `price_range` varchar(45) DEFAULT NULL,
  `administrators_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`administrators_id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_customers_administrators1_idx` (`administrators_id`),
  CONSTRAINT `fk_customers_administrators1` FOREIGN KEY (`administrators_id`) REFERENCES `administrators` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Giacomo','Bianchetto','12345678901','','via Ungaretti 7','oz.ntone@gmail.com','049821743','3487562298',1,'c4ca4238a0b923820dcc509a6f75849b','merchant','3',17);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(150) DEFAULT NULL,
  `orders_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`orders_id`),
  KEY `fk_invoices_orders1_idx` (`orders_id`),
  CONSTRAINT `fk_invoices_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(2,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(3,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(4,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(5,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(6,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(7,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(8,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(9,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(10,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(11,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(12,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(13,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(14,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(15,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(16,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(17,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4);
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime DEFAULT NULL,
  `confirmed` tinyint(4) DEFAULT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `operator` varchar(45) DEFAULT NULL,
  `customers_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'2013-09-19 16:00:00',0,NULL,NULL,'1'),(2,'2013-09-19 16:04:20',0,NULL,NULL,'1'),(3,'2013-09-19 16:04:50',0,NULL,NULL,'1'),(4,'2013-09-19 16:05:06',1,'2013-09-20 14:33:26','jack','1'),(5,'2013-09-19 16:06:15',0,NULL,NULL,'1'),(6,'2013-09-19 16:10:11',1,'2013-09-20 13:05:16','jack','1'),(7,'2013-09-19 16:11:28',0,NULL,NULL,'1'),(8,'2013-09-19 16:13:27',0,NULL,NULL,'1'),(9,'2013-09-19 16:14:11',1,'2013-09-20 13:01:50','jack','1'),(10,'2013-09-19 16:15:26',1,'2013-09-20 13:00:08','jack','1'),(11,'2013-09-19 16:15:40',0,NULL,NULL,'1'),(12,'2013-09-19 16:16:01',0,NULL,NULL,'1'),(13,'2013-09-19 16:27:44',1,'2013-09-20 12:57:18','jack','1'),(14,'2013-09-20 10:21:03',1,'2013-09-20 12:43:10','jack','1');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_has_products`
--

DROP TABLE IF EXISTS `orders_has_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_has_products` (
  `orders_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sold_price` double DEFAULT NULL,
  PRIMARY KEY (`orders_id`,`products_id`),
  KEY `fk_orders_has_products_products1_idx` (`products_id`),
  KEY `fk_orders_has_products_orders1_idx` (`orders_id`),
  CONSTRAINT `fk_orders_has_products_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_has_products_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_has_products`
--

LOCK TABLES `orders_has_products` WRITE;
/*!40000 ALTER TABLE `orders_has_products` DISABLE KEYS */;
INSERT INTO `orders_has_products` VALUES (1,71,2,120),(2,71,34,115),(3,71,6,120),(4,71,6,120),(5,71,6,120),(6,71,37,120),(7,71,45,120),(8,71,1,120),(9,71,1,120),(10,71,1,120),(11,71,1,120),(12,71,1,120),(13,71,1,120),(14,71,3,120),(14,72,1,1.01);
/*!40000 ALTER TABLE `orders_has_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(100) DEFAULT NULL,
  `products_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`products_id`),
  KEY `fk_product_images_products1_idx` (`products_id`),
  CONSTRAINT `fk_product_images_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (27,'../images/uploads/13793249111185144_426427224144853_657504927_n.jpg',71),(28,'../images/uploads/1379596962995993_417838021670440_1355886305_n.jpg',72);
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `new` tinyint(1) DEFAULT NULL,
  `offer` tinyint(1) DEFAULT NULL,
  `evidence` tinyint(1) DEFAULT NULL,
  `wholesale_price` double DEFAULT NULL,
  `retail_price` double DEFAULT NULL,
  `super_price` double DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `cod` varchar(45) DEFAULT NULL,
  `barcode` varchar(45) DEFAULT NULL,
  `single_qty` int(11) DEFAULT NULL,
  `pack_qty` int(11) DEFAULT NULL,
  `cardboard_qty` int(11) DEFAULT NULL,
  `categories_id` int(11) NOT NULL,
  `suppliers_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`categories_id`,`suppliers_id`),
  KEY `fk_products_categories_idx` (`categories_id`),
  KEY `fk_products_suppliers1_idx` (`suppliers_id`),
  CONSTRAINT `fk_products_categories` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_products_suppliers1` FOREIGN KEY (`suppliers_id`) REFERENCES `suppliers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (71,'Topastro',' \"If it won\'t float,\" remarked Dorothy, \"it will be of no use to us.\"\r\n\"True,\" answered Oz. \"But there is another way to make it float, which is to fill it with hot air. Hot air isn\'t as good as gas, for if the air should get cold the balloon would come down in the desert, and we should be lost.\"\r\n\"We!\" exclaimed the girl. \"Are you going with me?\"\r\n\"Yes, of course,\" replied Oz. \"I am tired of being such a humbug. If I should go out of this Palace my people would soon discover I am not a Wizard, and then they would be vexed with me for having deceived them. So I have to stay shut up in these rooms all day, and it gets tiresome. I\'d much rather go back to Kansas with you and be in a circus again.\"\r\n            \r\n            \r\n            ',0,0,1,150,120,115,100,'11','1',11,11,1,10,2),(72,'Gatto','Descriptionn            ',1,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(73,'sottoprova','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,14,2),(74,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(75,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(76,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(77,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(78,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(79,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(80,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(81,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(82,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(83,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(84,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(85,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(86,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(87,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(88,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(89,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(90,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(91,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(92,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(93,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(94,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(95,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(96,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(97,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(98,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(99,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(100,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(101,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(102,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(103,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(104,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(105,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(106,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(107,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(108,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(109,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(110,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(111,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(112,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(113,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(114,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(115,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(116,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(117,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(118,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(119,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(120,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(121,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(122,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(123,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(124,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(125,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(126,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(127,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(128,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(129,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(130,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(131,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(132,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(133,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(134,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(135,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(136,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(137,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(138,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(139,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(140,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(141,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(142,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(143,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(144,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(145,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(146,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(147,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(148,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(149,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(150,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(151,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(152,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(153,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(154,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(155,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(156,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(157,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(158,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(159,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(160,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(161,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(162,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(163,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(164,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(165,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(166,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(167,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(168,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(169,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(170,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(171,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(172,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(173,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(174,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(175,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(176,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(177,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(178,'Penna','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,13,2),(179,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(180,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(181,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(182,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(183,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(184,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `piva` varchar(11) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (2,'Nome','1!!','1','1','1','1'),(5,'o','o','o','o','o','ol');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-20 14:36:24
