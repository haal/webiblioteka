-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 13, 2009 at 04:42 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webiblioteka`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE `auth` (
  `idAuth` int(11) NOT NULL auto_increment,
  `KorisnickoIme` varchar(20) collate utf8_slovenian_ci NOT NULL,
  `Sifra` varchar(20) collate utf8_slovenian_ci NOT NULL,
  `Odobren` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`idAuth`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `autor`
--

CREATE TABLE `autor` (
  `idAutor` int(11) NOT NULL auto_increment,
  `Ime` varchar(25) collate utf8_slovenian_ci NOT NULL,
  `Prezime` varchar(35) collate utf8_slovenian_ci NOT NULL,
  `Biografija` text collate utf8_slovenian_ci,
  PRIMARY KEY  (`idAutor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `biblioteka`
--

CREATE TABLE `biblioteka` (
  `idBiblioteka` int(11) NOT NULL,
  `Naziv` varchar(45) collate utf8_slovenian_ci NOT NULL,
  `Adresa` varchar(100) collate utf8_slovenian_ci default NULL,
  `WebAdresa` varchar(25) collate utf8_slovenian_ci default NULL,
  `Email` varchar(50) collate utf8_slovenian_ci default NULL,
  `Telefon` varchar(13) collate utf8_slovenian_ci default NULL,
  PRIMARY KEY  (`idBiblioteka`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iznajmljivanje`
--

CREATE TABLE `iznajmljivanje` (
  `idAkcija` int(11) NOT NULL,
  `DatumPosudjivanja` date default NULL,
  `DatumVracanja` date default NULL,
  `idOsobaClan` int(11) NOT NULL,
  `idOsobaBibliotekar` int(11) NOT NULL,
  `idPrimjerakKnjige` int(11) NOT NULL,
  PRIMARY KEY  (`idAkcija`),
  KEY `fk_Akcija_Osoba1` (`idOsobaClan`),
  KEY `fk_Akcija_PrimjerakKnjige1` (`idPrimjerakKnjige`),
  KEY `fk_Akcija_Osoba2` (`idOsobaBibliotekar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knjigaopis`
--

CREATE TABLE `knjigaopis` (
  `idKnjigaOpis` int(11) NOT NULL auto_increment,
  `Naslov` varchar(200) collate utf8_slovenian_ci NOT NULL,
  `Podnaslov` varchar(220) collate utf8_slovenian_ci default NULL,
  `ISBN` varchar(13) collate utf8_slovenian_ci default NULL,
  `Izdanje` varchar(5) collate utf8_slovenian_ci default NULL,
  `Opis` text collate utf8_slovenian_ci,
  `Jezik` varchar(20) collate utf8_slovenian_ci default NULL,
  `GodinaIzdavanja` int(4) default NULL,
  `idZanr` int(11) default NULL,
  `DatumUlaza` timestamp NULL default NULL,
  `BrojPrimjeraka` int(11) default NULL,
  `Status` varchar(20) collate utf8_slovenian_ci default NULL,
  PRIMARY KEY  (`idKnjigaOpis`),
  KEY `idZanr` (`idZanr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `obavijest`
--

CREATE TABLE `obavijest` (
  `idObavijest` int(11) NOT NULL,
  `Naslov` varchar(25) collate utf8_slovenian_ci NOT NULL,
  `Tekst` text collate utf8_slovenian_ci NOT NULL,
  `Datum` date default NULL,
  `idOsoba` int(11) NOT NULL,
  `idPoslovnica` int(11) NOT NULL,
  PRIMARY KEY  (`idObavijest`),
  KEY `fk_Obavijest_Osoba1` (`idOsoba`),
  KEY `fk_Obavijest_Poslovnica1` (`idPoslovnica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ocjena`
--

CREATE TABLE `ocjena` (
  `idOcjena` int(11) NOT NULL,
  `Vrijednost` tinyint(4) NOT NULL,
  `Komentar` text collate utf8_slovenian_ci,
  `idOsoba` int(11) NOT NULL,
  `idKnjigaOpis` int(11) NOT NULL,
  PRIMARY KEY  (`idOcjena`),
  KEY `fk_Ocjena_Osoba1` (`idOsoba`),
  KEY `fk_Ocjena_KnjigaOpis1` (`idKnjigaOpis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `osoba`
--

CREATE TABLE `osoba` (
  `idOsoba` int(11) NOT NULL auto_increment,
  `Ime` varchar(25) collate utf8_slovenian_ci NOT NULL,
  `Prezime` varchar(35) collate utf8_slovenian_ci NOT NULL,
  `JMBG` varchar(13) collate utf8_slovenian_ci NOT NULL,
  `UlicaIBroj` varchar(25) collate utf8_slovenian_ci NOT NULL,
  `PostanskiBroj` varchar(5) collate utf8_slovenian_ci NOT NULL,
  `Grad` varchar(25) collate utf8_slovenian_ci NOT NULL,
  `Telefon` varchar(13) collate utf8_slovenian_ci default NULL,
  `Email` varchar(50) collate utf8_slovenian_ci default NULL,
  `Status` varchar(50) collate utf8_slovenian_ci default NULL,
  `idTipOsobe` int(11) NOT NULL,
  `idAuth` int(11) NOT NULL,
  `idPoslovnica` int(11) NOT NULL,
  PRIMARY KEY  (`idOsoba`),
  KEY `fk_Osoba_TipOsobe1` (`idTipOsobe`),
  KEY `fk_Osoba_Auth1` (`idAuth`),
  KEY `fk_Osoba_Poslovnica1` (`idPoslovnica`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `pisac`
--

CREATE TABLE `pisac` (
  `idAutor` int(11) NOT NULL,
  `idKnjigaOpis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poslovnica`
--

CREATE TABLE `poslovnica` (
  `idPoslovnica` int(11) NOT NULL auto_increment,
  `Naziv` varchar(45) collate utf8_slovenian_ci NOT NULL,
  `UlicaIBroj` varchar(25) collate utf8_slovenian_ci NOT NULL,
  `PostanskiBroj` varchar(5) collate utf8_slovenian_ci NOT NULL,
  `Grad` varchar(25) collate utf8_slovenian_ci NOT NULL,
  `Telefon` varchar(13) collate utf8_slovenian_ci default NULL,
  `Email` varchar(50) collate utf8_slovenian_ci default NULL,
  `idBiblioteka` int(11) NOT NULL,
  PRIMARY KEY  (`idPoslovnica`),
  KEY `fk_Poslovnica_Biblioteka1` (`idBiblioteka`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `primjerakknjige`
--

CREATE TABLE `primjerakknjige` (
  `idPrimjerakKnjige` int(11) NOT NULL auto_increment,
  `idKnjigaOpis` int(11) NOT NULL,
  `idPoslovnica` int(11) NOT NULL,
  PRIMARY KEY  (`idPrimjerakKnjige`),
  KEY `fk_PrimjerakKnjige_KnjigaOpis1` (`idKnjigaOpis`),
  KEY `fk_PrimjerakKnjige_Poslovnica1` (`idPoslovnica`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--

CREATE TABLE `rezervacija` (
  `idRezervacija` int(11) NOT NULL auto_increment,
  `Datum` date NOT NULL,
  `Osoba_idOsoba` int(11) NOT NULL,
  `KnjigaOpis_idKnjigaOpis` int(11) NOT NULL,
  PRIMARY KEY  (`idRezervacija`),
  KEY `fk_Rezervacija_Osoba1` (`Osoba_idOsoba`),
  KEY `fk_Rezervacija_KnjigaOpis1` (`KnjigaOpis_idKnjigaOpis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tiposobe`
--

CREATE TABLE `tiposobe` (
  `idTipOsobe` int(11) NOT NULL,
  `Naziv` varchar(25) collate utf8_slovenian_ci NOT NULL,
  PRIMARY KEY  (`idTipOsobe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zanr`
--

CREATE TABLE `zanr` (
  `idZanr` int(11) NOT NULL,
  `Naziv` varchar(45) collate utf8_slovenian_ci NOT NULL,
  PRIMARY KEY  (`idZanr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `iznajmljivanje`
--
ALTER TABLE `iznajmljivanje`
  ADD CONSTRAINT `fk_Akcija_Osoba1` FOREIGN KEY (`idOsobaClan`) REFERENCES `osoba` (`idOsoba`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Akcija_Osoba2` FOREIGN KEY (`idOsobaBibliotekar`) REFERENCES `osoba` (`idOsoba`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Akcija_PrimjerakKnjige1` FOREIGN KEY (`idPrimjerakKnjige`) REFERENCES `primjerakknjige` (`idPrimjerakKnjige`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `knjigaopis`
--
ALTER TABLE `knjigaopis`
  ADD CONSTRAINT `idZanr` FOREIGN KEY (`idZanr`) REFERENCES `zanr` (`idZanr`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `obavijest`
--
ALTER TABLE `obavijest`
  ADD CONSTRAINT `fk_Obavijest_Osoba1` FOREIGN KEY (`idOsoba`) REFERENCES `osoba` (`idOsoba`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Obavijest_Poslovnica1` FOREIGN KEY (`idPoslovnica`) REFERENCES `poslovnica` (`idPoslovnica`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ocjena`
--
ALTER TABLE `ocjena`
  ADD CONSTRAINT `fk_Ocjena_KnjigaOpis1` FOREIGN KEY (`idKnjigaOpis`) REFERENCES `knjigaopis` (`idKnjigaOpis`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Ocjena_Osoba1` FOREIGN KEY (`idOsoba`) REFERENCES `osoba` (`idOsoba`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `osoba`
--
ALTER TABLE `osoba`
  ADD CONSTRAINT `fk_Osoba_Auth1` FOREIGN KEY (`idAuth`) REFERENCES `auth` (`idAuth`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Osoba_Poslovnica1` FOREIGN KEY (`idPoslovnica`) REFERENCES `poslovnica` (`idPoslovnica`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Osoba_TipOsobe1` FOREIGN KEY (`idTipOsobe`) REFERENCES `tiposobe` (`idTipOsobe`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `poslovnica`
--
ALTER TABLE `poslovnica`
  ADD CONSTRAINT `fk_Poslovnica_Biblioteka1` FOREIGN KEY (`idBiblioteka`) REFERENCES `biblioteka` (`idBiblioteka`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `primjerakknjige`
--
ALTER TABLE `primjerakknjige`
  ADD CONSTRAINT `fk_PrimjerakKnjige_KnjigaOpis1` FOREIGN KEY (`idKnjigaOpis`) REFERENCES `knjigaopis` (`idKnjigaOpis`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_PrimjerakKnjige_Poslovnica1` FOREIGN KEY (`idPoslovnica`) REFERENCES `poslovnica` (`idPoslovnica`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD CONSTRAINT `fk_Rezervacija_KnjigaOpis1` FOREIGN KEY (`KnjigaOpis_idKnjigaOpis`) REFERENCES `knjigaopis` (`idKnjigaOpis`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Rezervacija_Osoba1` FOREIGN KEY (`Osoba_idOsoba`) REFERENCES `osoba` (`idOsoba`) ON DELETE NO ACTION ON UPDATE NO ACTION;
