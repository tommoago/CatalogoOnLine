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
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(45) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `province` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (11,'via Verdi 34','35010','Vigodarzere','Padova','Italia'),(14,'via Ungaretti 20','35030','Saccolongo','Padova','Italia'),(15,'via Verdi 34','35010','Vigodarzere','Padova','Italia');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (10,'Cucina',29),(13,'Cancelleria',NULL),(29,'Casalighi',NULL),(30,'Pentole',10),(31,'Mestoli',30);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_images`
--

LOCK TABLES `company_images` WRITE;
/*!40000 ALTER TABLE `company_images` DISABLE KEYS */;
INSERT INTO `company_images` VALUES (1,'../images/uploads/13807169291187062_499183803504973_284074883_n.jpg',1);
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
-- Table structure for table `customers_has_addresses`
--

DROP TABLE IF EXISTS `customers_has_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers_has_addresses` (
  `customers_id` int(11) NOT NULL,
  `addresses_id` int(11) NOT NULL,
  PRIMARY KEY (`customers_id`,`addresses_id`),
  KEY `fk_customers_has_addresses_addresses1_idx` (`addresses_id`),
  KEY `fk_customers_has_addresses_customers1_idx` (`customers_id`),
  CONSTRAINT `fk_customers_has_addresses_addresses1` FOREIGN KEY (`addresses_id`) REFERENCES `addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_customers_has_addresses_customers1` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers_has_addresses`
--

LOCK TABLES `customers_has_addresses` WRITE;
/*!40000 ALTER TABLE `customers_has_addresses` DISABLE KEYS */;
INSERT INTO `customers_has_addresses` VALUES (1,14),(1,15);
/*!40000 ALTER TABLE `customers_has_addresses` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(2,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(3,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(4,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(5,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(6,'../../../files/invoices/invoices-order6-date19-09-13.pdf',6),(7,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(8,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(9,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(10,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(11,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(12,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(13,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(14,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(15,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(16,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(17,'../../../files/invoices/invoices-order4-date19-09-13.pdf',4),(18,'../../../files/invoices/invoices-order8-date19-09-13.pdf',8),(19,'../../../files/invoices/invoices-order2-date19-09-13.pdf',2),(20,'../../../files/invoices/invoices-order1-date19-09-13.pdf',1),(21,'../../../files/invoices/invoices-order12-date19-09-13.pdf',12),(22,'../../../files/invoices/invoices-order15-date29-09-13.pdf',15);
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
  `addresses_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'2013-09-19 16:00:00',1,'2013-10-02 20:55:03','jack','1',NULL),(2,'2013-09-19 16:04:20',1,'2013-10-02 20:54:15','jack','1',NULL),(3,'2013-09-19 16:04:50',1,'2013-10-02 14:33:13','jack','1',NULL),(4,'2013-09-19 16:05:06',1,'2013-09-20 14:33:26','jack','1',NULL),(5,'2013-09-19 16:06:15',1,'2013-10-02 14:34:07','jack','1',NULL),(6,'2013-09-19 16:10:11',1,'2013-09-20 13:05:16','jack','1',NULL),(7,'2013-09-19 16:11:28',1,'2013-10-02 14:34:32','jack','1',NULL),(8,'2013-09-19 16:13:27',1,'2013-10-02 14:35:21','jack','1',NULL),(9,'2013-09-19 16:14:11',1,'2013-09-20 13:01:50','jack','1',NULL),(10,'2013-09-19 16:15:26',1,'2013-09-20 13:00:08','jack','1',NULL),(11,'2013-09-19 16:15:40',1,'2013-10-08 11:24:58','jack','1',NULL),(12,'2013-09-19 16:16:01',1,'2013-10-08 11:53:38','jack','1',NULL),(13,'2013-09-19 16:27:44',1,'2013-09-20 12:57:18','jack','1',NULL),(14,'2013-09-20 10:21:03',1,'2013-09-20 12:43:10','jack','1',NULL),(15,'2013-09-29 23:30:56',1,'2013-10-08 12:07:10','jack','1',NULL),(16,'2013-10-02 14:53:21',0,NULL,NULL,'1',NULL),(17,'2013-10-02 14:53:58',0,NULL,NULL,'1',NULL),(18,'2013-10-02 20:36:06',0,NULL,NULL,'1',14);
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
INSERT INTO `orders_has_products` VALUES (18,169,506,2.24);
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (31,'../images/uploads/13807303671237529_498735036883183_1101582016_n.jpg',169),(32,'../images/uploads/1380730781558066_498730976883589_711690301_n.jpg',179);
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
INSERT INTO `products` VALUES (169,'Pentola','Pentola per cucinare la pasta',1,1,1,2.28,2.6,2.24,2,'000AE567G','23985093093',1,10,100,10,2),(179,'Matita','Matita per disegnare',1,1,1,1.628,1.837,1.485,1.1,'00048TRD8','567894322',1,10,200,13,5),(180,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(181,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(182,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(183,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2),(184,'','Descrizione',0,0,0,1.01,1.01,1.01,1,'11','1',11,11,1,10,2);
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
  `email` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (2,'Pentole','Azienda di pentolame','1234567890','pentole@pentole.com','049398230','049398231','via Verdi 20'),(5,'Ingross','Grossista','123456780','info@ingross.it','049887483','049874483','via Matteotti 8'),(6,'Gardeners','Fornitura di giardinaggio','2134567890','gard@gardeners.it','346998950','346994970','via Orologio 10'),(7,'Henkel','Fornitura di materiale per cancelleria','1234567890','info@henkel.com','049372843','049882843','via Colombo 23');
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

-- Dump completed on 2013-10-09 12:15:59
