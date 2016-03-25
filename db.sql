-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2016 at 01:03 AM
-- Server version: 5.7.9
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serverside`
--

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

DROP TABLE IF EXISTS `listings`;
CREATE TABLE IF NOT EXISTS `listings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL,
  `paid_until` timestamp NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text,
  `price` int(11) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`id`, `user_id`, `active`, `created_at`, `paid_until`, `name`, `slug`, `description`, `price`, `img_path`) VALUES
(1, 1, 1, '2016-03-21 20:28:58', '2016-03-21 20:28:58', 'Gibson Custom Shop 1959 Les Paul Reissue VOS 2013 in Lemon Burst', '59-les-paul-custom-shop', 'The Gibson Les Paul LPR9 1959 Reissue Les Paul VOS (Vintage Original Specification) is a true joy to behold: Gibson have pulled out all the stops to recreate this Les Paul Standard closer than ever before to the 635 guitars they shipped in 1959. New features for 2013 include period correct Aniline dye finishes, hot hide glue neck joins, historic no-tubing truss rod assembly and Kluson deluxe machine heads. Perhaps the biggest step towards the original tone of the 1959 Les Paul Standard however is the new Custom Bucker which is painfully recreated from an original late 50s PAF (Patent Applied For) Humbucker. Thanks in part to the Bumble Bee tone cap the LPR9 sings beautifully at full volume and when rolled off has a distinct creamy character that cleans up stunningly.', 599999, 'http://content.andertons.co.uk/2/1/images/catalog/i/xxld_16219-LPR93VOLBNH1_super.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listing_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notes` text,
  `paid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `credit` int(11) NOT NULL,
  `seller` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `credit`, `seller`) VALUES
(1, 'jimmy', '$2y$10$eVb1fmzQJF/UE0HcBPYxreS/i7PE5qYKFZdYwT6P.VvnudR1kccgi', 'Jimmy', 'Cook', 'fake@fake.com', 556789010, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
