# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.42)
# Database: serverside
# Generation Time: 2016-04-14 21:02:45 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `slug` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `name`, `slug`)
VALUES
	(1,'Electric Guitar','electric-guitar'),
	(2,'Acoustic Guitar','acoustic-guitar'),
	(3,'Bass Guitar','bass-guitar');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table listings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `listings`;

CREATE TABLE `listings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `paid_until` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text,
  `price` int(11) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `listings` WRITE;
/*!40000 ALTER TABLE `listings` DISABLE KEYS */;

INSERT INTO `listings` (`id`, `user_id`, `created_at`, `paid_until`, `name`, `slug`, `description`, `price`, `img_path`, `category_id`, `active`, `updated_at`)
VALUES
	(1,1,'2016-04-05 22:45:09','2016-04-15 00:00:00','Gibson Custom Shop 1959 Les Paul Reissue VOS 2013 in Lemon Burst','59-les-paul-custom-shop','The Gibson Les Paul LPR9 1959 Reissue Les Paul VOS (Vintage Original Specification) is a true joy to behold: Gibson have pulled out all the stops to recreate this Les Paul Standard closer than ever before to the 635 guitars they shipped in 1959. New features for 2013 include period correct Aniline dye finishes, hot hide glue neck joins, historic no-tubing truss rod assembly and Kluson deluxe machine heads. Perhaps the biggest step towards the original tone of the 1959 Les Paul Standard however is the new Custom Bucker which is painfully recreated from an original late 50s PAF (Patent Applied For) Humbucker. Thanks in part to the Bumble Bee tone cap the LPR9 sings beautifully at full volume and when rolled off has a distinct creamy character that cleans up stunningly.',599999,'/images/listings/59-les-paul.jpg',1,1,'2016-04-14 22:01:51'),
	(9,1,'2016-04-05 22:45:49','2016-04-15 00:00:00','Fender American Vintage 65 Strat in Burgundy Mist Metallic','fender-american-vintage-65-strat-in-burgundy-mist-metallic','Fender American Vintage guitars are built 100% to vintage specifications. Tastefully acknowledging the great history and heritage of Fender throughout the 50s and 60s, the new 2012 American Vintage guitars bring to life classic Fender instruments of the early years of electric guitars in a modern, period-accurate form.',99999,'/images/listings/strat.jpg',1,1,'2016-04-14 22:02:08'),
	(13,1,'2016-04-06 18:04:26','2016-04-15 00:00:00','Faith Naked Series Venus Electro Acoustic Guitar','faith-naked-series-venus-electro-acoustic-guitar','Faith acoustic',39999,'http://content.andertons.co.uk/2/1/images/catalog/i/xxld_42286-tmpC024.jpg',2,1,'2016-04-14 22:02:08'),
	(11,1,'2016-04-06 01:57:11','2016-04-15 00:00:00','Gibson SG Standard','gibson-sg-standard','It\'s an SG what more do you need?',99999,'/images/listings/sg.jpg',1,1,'2016-04-14 22:01:51');

/*!40000 ALTER TABLE `listings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listing_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` text,
  `status` varchar(10) NOT NULL DEFAULT 'processing',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `credit` bigint(100) NOT NULL,
  `seller` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `credit`, `seller`)
VALUES
	(1,'jimmy','$2y$10$eVb1fmzQJF/UE0HcBPYxreS/i7PE5qYKFZdYwT6P.VvnudR1kccgi','Jimmy','Cook','fake@fake.com',64798,0),
	(18,'test','$2y$10$e3PnoR0AvtS.R9tRYvqVu.Fr6d/uyVl1Q25rNKy42IsXAoLKoOAs6','test','test','test@test.com',55713,0),
	(19,'ruthie','$2y$10$1Kv3o00XLQsOFQcuZkK67eGy8Fm3J7bqFRqNbyssSaBsnj3zDv17e','Ruth','Coles','ruth.hc.coles@gmail.com',9223372036854775807,0);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
