-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2013 at 05:46 PM
-- Server version: 5.6.13
-- PHP Version: 5.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bowling`
--
CREATE DATABASE IF NOT EXISTS `bowling` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bowling`;

-- --------------------------------------------------------

--
-- Table structure for table `bowling-game`
--

CREATE TABLE IF NOT EXISTS `bowling-game` (
  `game_id` bigint(20) NOT NULL,
  `round` int(10) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `try_n` int(10) NOT NULL,
  `value` int(11) NOT NULL,
  KEY `game_id` (`game_id`),
  KEY `round` (`round`),
  KEY `user` (`user_id`),
  KEY `try_n` (`try_n`),
  KEY `all_grouped` (`game_id`,`round`,`user_id`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bowling-game`
--

INSERT INTO `bowling-game` (`game_id`, `round`, `user_id`, `try_n`, `value`) VALUES
(3, 1, 36, 1, 3),
(3, 1, 35, 1, 4),
(3, 1, 30, 1, 12),
(3, 1, 35, 2, 1),
(3, 1, 36, 2, 4),
(3, 2, 30, 1, 1),
(3, 2, 35, 1, 4),
(3, 2, 36, 1, 8),
(3, 2, 30, 2, 5),
(3, 2, 35, 2, 3),
(3, 2, 36, 2, 2),
(3, 3, 30, 1, 12),
(4, 1, 30, 1, 1),
(4, 1, 23, 1, 3),
(3, 3, 36, 1, 2),
(3, 3, 36, 2, 2),
(3, 3, 35, 1, 4),
(3, 3, 35, 2, 4),
(3, 4, 30, 1, 3),
(3, 4, 35, 1, 3),
(3, 4, 36, 1, 5),
(3, 4, 36, 2, 5),
(4, 1, 23, 2, 3),
(4, 1, 30, 2, 4),
(4, 2, 30, 1, 3),
(4, 2, 30, 2, 2),
(4, 2, 23, 1, 2),
(4, 2, 23, 2, 3),
(4, 3, 30, 1, 4),
(4, 3, 23, 1, 5),
(4, 3, 30, 2, 5),
(4, 3, 23, 2, 1),
(4, 4, 30, 1, 9),
(4, 4, 23, 1, 12),
(4, 4, 30, 2, 0),
(4, 5, 23, 1, 8),
(4, 5, 23, 2, 0),
(4, 5, 30, 1, 7),
(4, 5, 30, 2, 1),
(4, 6, 23, 1, 12),
(4, 6, 30, 1, 12),
(4, 7, 23, 1, 1),
(4, 7, 23, 2, 0),
(4, 7, 30, 1, 9),
(4, 7, 30, 2, 1),
(4, 8, 23, 1, 12),
(4, 8, 30, 1, 3),
(4, 8, 30, 2, 1),
(4, 9, 23, 1, 7),
(4, 9, 30, 1, 4),
(4, 9, 23, 2, 1),
(4, 9, 30, 2, 1),
(4, 10, 23, 1, 12),
(4, 10, 30, 1, 12),
(3, 4, 30, 2, 1),
(3, 4, 35, 2, 1),
(3, 5, 30, 1, 12),
(3, 5, 35, 1, 12),
(3, 5, 36, 1, 12),
(3, 6, 30, 1, 12),
(3, 6, 35, 1, 12),
(3, 6, 36, 1, 12),
(3, 7, 30, 1, 12),
(3, 7, 35, 1, 12),
(3, 7, 36, 1, 12),
(3, 8, 30, 1, 12),
(3, 8, 35, 1, 12),
(3, 8, 36, 1, 12),
(3, 9, 30, 1, 12),
(3, 9, 35, 1, 12),
(3, 9, 36, 1, 12),
(3, 10, 30, 1, 12),
(3, 10, 35, 1, 12),
(3, 10, 36, 1, 9),
(3, 10, 36, 2, 0),
(3, 10, 36, 3, 1),
(5, 1, 41, 1, 4),
(6, 1, 41, 1, 4),
(7, 1, 36, 1, 4),
(8, 1, 36, 1, 4),
(9, 1, 36, 1, 4),
(9, 1, 41, 1, 1),
(9, 1, 41, 2, 1),
(9, 1, 36, 2, 1),
(9, 2, 36, 1, 1),
(9, 2, 36, 2, 1),
(10, 1, 41, 1, 1),
(11, 1, 41, 1, 1),
(12, 1, 41, 1, 1),
(12, 1, 41, 2, 3),
(10, 1, 41, 2, 1),
(10, 2, 41, 1, 2),
(10, 2, 41, 2, 3),
(10, 3, 41, 1, 8),
(10, 3, 41, 2, 1),
(10, 4, 41, 1, 12),
(10, 5, 41, 1, 0),
(10, 5, 41, 2, 10),
(10, 6, 41, 1, 2),
(10, 6, 41, 2, 8),
(10, 7, 41, 1, 12),
(10, 8, 41, 1, 12),
(10, 9, 41, 1, 12),
(10, 10, 41, 1, 12),
(13, 1, 41, 1, 12),
(13, 1, 36, 1, 1),
(13, 1, 36, 2, 1),
(13, 2, 41, 1, 2),
(7, 1, 36, 2, 2),
(14, 1, 29, 1, 2),
(7, 1, 41, 1, 1),
(7, 1, 41, 2, 3),
(7, 2, 36, 1, 4),
(7, 2, 36, 2, 4),
(7, 2, 41, 1, 1),
(7, 2, 41, 2, 1),
(15, 1, 30, 1, 1),
(15, 1, 41, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('ab7e99a5fbbf31c2efd81f6e4313fe78', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.59.8 (KHTML, like Gecko) Version/5.1.9 Safari/534.59.8', 1377441849, 'a:1:{s:11:"rnd_captcha";s:5:"22257";}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(20) CHARACTER SET utf8 NOT NULL,
  `nick` varchar(20) CHARACTER SET utf8 NOT NULL,
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`),
  KEY `id_4` (`id`),
  KEY `id_5` (`id`),
  KEY `id_6` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `nick`) VALUES
(23, 'Plotnic', 'Eugen', 'EPlotnic'),
(2, 'Alexandru', 'Plotnic', 'Alex_Plotnic'),
(29, 'Ion', 'Rusu', 'IonRusu'),
(30, 'Ana', 'Brinz', 'Ana'),
(34, 'Palamarciuc', 'Snejana', 'Fulg'),
(35, 'Felicia', 'Caruceru', 'FeliciaG'),
(36, 'Jaffa', 'Fruit', 'Premium'),
(41, 'Sergiu', 'Gordienco', 'Scorpion'),
(43, 'wqeq', 'wqeq', 'qeqw');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
