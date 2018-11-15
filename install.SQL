-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 29 dec 2015 om 00:43
-- Serverversie: 5.6.17
-- PHP-versie: 5.5.12

--
-- Databasestruktuur voor het webprogramma Trainbase 
-- ©2016 Erik Baalbergen
--
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";

--
-- Databank: `trainbase`
--
CREATE DATABASE IF NOT EXISTS `trainbase` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `trainbase`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `decoder`
--

DROP TABLE IF EXISTS `decoder`;
CREATE TABLE IF NOT EXISTS `decoder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(200) NOT NULL,
  `producent` varchar(200) DEFAULT NULL,
  `artiekelnummer` mediumint(9) DEFAULT NULL,
  `numFuncties` tinyint(4) DEFAULT NULL,
  `functieDecoder` tinyint(1) DEFAULT NULL,
  `numLogicFuncties` tinyint(4) DEFAULT NULL,
  `functiesMappable` tinyint(1) DEFAULT NULL,
  `effecten` tinyint(1) DEFAULT NULL,
  `geluid` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voertuig`
--

DROP TABLE IF EXISTS `voertuig`;
CREATE TABLE IF NOT EXISTS `voertuig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(250) NOT NULL,
  `soort` enum('GoederenWagon','PersonenWagon','Lokomotief','') DEFAULT NULL,
  `nummer` int(11) DEFAULT NULL,
  `numAsses` tinyint(4) DEFAULT NULL,
  `gewichtGrootSpoor` int(11) DEFAULT NULL,
  `gewichtModelSpoor` smallint(6) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `omschrijving` text,
  `kleur` varchar(50) DEFAULT NULL,
  `lengteGrootSpoor` mediumint(9) DEFAULT NULL,
  `tijdperk` varchar(4) DEFAULT NULL,
  `maatschapij` varchar(150) DEFAULT NULL,
  `staat` enum('perfect','zeergoed','goed','matig','slecht','zeerslecht') DEFAULT NULL,
  `drierail` tinyint(1) DEFAULT '0',
  `projectAfgerond` tinyint(1) DEFAULT NULL,
  `producent` varchar(150) DEFAULT NULL,
  `artiekelnummer` int(11) DEFAULT NULL,
  `toegelatenLanden` varchar(1000) DEFAULT NULL,
  `doos` tinyint(4) DEFAULT NULL,
  `digitaal` tinyint(1) DEFAULT NULL,
  `adres` smallint(6) DEFAULT NULL,
  `decoderType` tinyint(4) DEFAULT NULL,
  `speedStepTabel` smallint(6) DEFAULT NULL,
  `brandstof` enum('Diesel','Benzine','HandKracht','Electriciteit','Stoom (kolen)','Stoom (olie)','Stoom (stoomketel)','geen') DEFAULT NULL,
  `vermogen` int(11) DEFAULT NULL,
  `geluid` tinyint(1) DEFAULT NULL,
  `vrachtType` varchar(1000) DEFAULT NULL,
  `maximaalGewicht` mediumint(9) DEFAULT NULL,
  `bagageWagen` tinyint(1) DEFAULT NULL,
  `numPasagiers` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
