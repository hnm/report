-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Nov 2016 um 18:26
-- Server-Version: 10.1.10-MariaDB
-- PHP-Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `halter`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `report`
--

DROP TABLE IF EXISTS `report`;
CREATE TABLE `report` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `nql_query` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `report_enum_value`
--

DROP TABLE IF EXISTS `report_enum_value`;
CREATE TABLE `report_enum_value` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `enum_query_variable_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `report_query_variable`
--

DROP TABLE IF EXISTS `report_query_variable`;
CREATE TABLE `report_query_variable` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `target_entity_class` varchar(255) DEFAULT NULL,
  `report_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `report_enum_value`
--
ALTER TABLE `report_enum_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_enum_value_index_1` (`enum_query_variable_id`);

--
-- Indizes für die Tabelle `report_query_variable`
--
ALTER TABLE `report_query_variable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_query_variable_index_1` (`report_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `report`
--
ALTER TABLE `report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `report_enum_value`
--
ALTER TABLE `report_enum_value`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `report_query_variable`
--
ALTER TABLE `report_query_variable`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `report`
	ADD COLUMN `type` VARCHAR(255) NOT NULL DEFAULT 'nql' AFTER `name`;
ALTER TABLE `report`
	CHANGE COLUMN `nql_query` `query` TEXT NULL AFTER `type`;