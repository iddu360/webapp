-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 24. Feb 2019 um 15:01
-- Server-Version: 8.0.15
-- PHP-Version: 7.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `yourad`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `category`
--

CREATE TABLE `category` (
                          `id` int(11) NOT NULL,
                          `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                          `parent_category_id` int(11) DEFAULT NULL,
                          `icon` varchar(15) COLLATE utf8_general_ci NOT NULL,
                          `border` enum('1','2','3','4','5','6','7','8','9','10','11','12') COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `category`
--

INSERT INTO `category` (`id`, `name`, `parent_category_id`, `icon`, `border`) VALUES
(1, 'Elektronik', NULL, 'fa fa-laptop', '2'),
(2, 'Kleidung', NULL, 'fa fa-asterisk', '8');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image`
--

CREATE TABLE `image` (
                       `id` int(11) NOT NULL,
                       `path` varchar(500) COLLATE utf8_general_ci NOT NULL,
                       `thumbnail` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
                       `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `image`
--

INSERT INTO `image` (`id`, `path`, `thumbnail`, `post_id`) VALUES
(20, 'cropped_apple-iphone-smartphone-technology.jpg', 'thumbnail_apple-iphone-smartphone-technology.jpg', 23),
(21, 'cropped_pexels-photo-699122.jpeg', 'thumbnail_pexels-photo-699122.jpeg', 23),
(22, 'cropped_pexels-photo-265658.jpeg', 'thumbnail_pexels-photo-265658.jpeg', 23),
(23, 'cropped_pexels-photo-374135.jpeg', 'thumbnail_pexels-photo-374135.jpeg', 24);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `post`
--

CREATE TABLE `post` (
                      `id` int(11) NOT NULL,
                      `user_id` int(11) NOT NULL,
                      `category_id` int(11) NOT NULL,
                      `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `is_seller` tinyint(1) NOT NULL,
                      `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      `pricing_base` enum('fixed','negotiable','free','') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'fixed',
                      `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `post`
--

INSERT INTO `post` (`id`, `user_id`, `category_id`, `title`, `description`, `is_seller`, `pricing_base`, `price`) VALUES
(23, 4, 1, 'iPhone zu verkaufen', 'Hier verkaufe ich mein altes iPhone, wenig Gebrauchsspuren!', 1, 'fixed', '650'),
(24, 4, 2, 'Schöne Jacke von H&M', 'Hiermit verkaufe ich meine leider nur wenig getragene Lederjacke von H&M! Verhandelbar!', 1, 'negotiable', '60');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
                      `id` int(11) NOT NULL,
                      `first_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `last_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `username` varchar(50) COLLATE utf8_general_ci NOT NULL,
                      `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `mobile_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `password` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `plz` int(11) NOT NULL,
                      `street` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `country` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `city` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `username`, `email`, `mobile_number`, `password`, `plz`, `street`, `country`, `city`) VALUES
(1, 'Alexander', 'Korus', 'AlKo', 'alko@korusweb.de', '015164305038', 'test', 71394, 'Beinsteiner Straße 11', 'Germany', 'Kernen im Remstal'),
(2, 'test', 'test', 'test', 'test@test.de', '234234234', 'ced6adcdf0b361c28d38b0edff28ed9e52027a448721ef3042ec86c7a8ec516c', 1023123, 'test', 'test', 'test'),
(3, 'Selig', 'Dennis', 'Selichio', 'akorus@me.com', '0123324', 'ced6adcdf0b361c28d38b0edff28ed9e52027a448721ef3042ec86c7a8ec516c', 12345, 'Jahnstraße', 'Test', 'Test'),
(4, 'Korus', 'Alexander', 'a_korus', 'alexander.korus@svote.io', '+49 0152 643 0503', '90aaf4b1a8dd4a7c4bcaca0b1b9dc6b187c2b0f42c505fc06431488a01266578', 71394, 'Musterstraße 11', 'Deutschland', 'Kernen im Remstal');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indizes für die Tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT für Tabelle `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints der Tabelle `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
