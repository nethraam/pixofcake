<?php header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; flush(); exit;?>

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 03 nov 2023 om 08:28
-- Serverversie: 5.7.40
-- PHP-versie: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `wb_mod_pixofcake`
--

DROP TABLE IF EXISTS `{TABLE_PREFIX}mod_pixofcake`;
CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}mod_pixofcake` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `url` text,
  `crop_images` varchar(10) DEFAULT NULL,
  `show_filenames` varchar(10) DEFAULT '',
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
