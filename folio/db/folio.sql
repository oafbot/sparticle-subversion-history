-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2011 at 09:08 PM
-- Server version: 5.1.53
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `folio_db`
--
CREATE DATABASE `folio_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `folio_db`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `user` int(16) NOT NULL,
  `token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `deactivated` tinyint(1) NOT NULL DEFAULT '0',
  `created` date NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user`, `token`, `confirmed`, `deactivated`, `created`, `updated`) VALUES
(3, 3, '', 1, 0, '2011-10-16', '2011-10-16 08:26:34'),
(4, 4, '', 1, 0, '2011-10-20', '2011-10-20 03:33:57'),
(7, 27, '', 1, 0, '2011-10-29', '2011-10-29 02:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `active_sessions`
--

CREATE TABLE IF NOT EXISTS `active_sessions` (
  `session` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(16) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `active_sessions`
--

INSERT INTO `active_sessions` (`session`, `user_id`, `updated`) VALUES
('6615eff30be4e0804ea4fc2475305ed6', 7, '2011-10-29 01:10:46'),
('6615eff30be4e0804ea4fc2475305ed6', 7, '2011-10-29 00:57:41'),
('704533d78afff5db673a69afe9c23f6e', 3, '2011-11-17 15:55:15'),
('4f376987dcfdfa0ed5eda671418dbb4c', 3, '2011-11-17 15:55:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `username` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `salt` int(8) NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `level` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `firstname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `logged_in` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `level`, `firstname`, `lastname`, `logged_in`) VALUES
(3, 'laika', '856a492615258487089645ddeb0a5439', 12136172, 'witzel@post.harvard.edu', 'user', 'Leonard', 'Witzel', 1),
(4, 'belka', '0164ffda5b45b526e06ca91453cd878b', 86098695, 'oafbot@mac.com', 'user', 'Belka', 'Woof', 0),
(27, 'demo', '9dbd054c2d0027f6167cc598449d5643', 95925362, 'oafbot@me.com', 'user', 'Desmond', 'Demo', 0);
