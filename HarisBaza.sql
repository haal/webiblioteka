-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 13, 2009 at 08:28 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `webiblioteka`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `idAuth` int(11) NOT NULL AUTO_INCREMENT,
  `KorisnickoIme` varchar(20) COLLATE utf8_slovenian_ci NOT NULL,
  `Sifra` varchar(20) COLLATE utf8_slovenian_ci NOT NULL,
  `Odobren` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idAuth`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`idAuth`, `KorisnickoIme`, `Sifra`, `Odobren`) VALUES
(1, 'admin', 'admin', 1),
(2, 'bibliotekar', 'bibliotekar', 1),
(3, 'clan', 'clan', 1),
(4, 'haris', 'sirah', 1),
(6, 'nizam', 'mazin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `autor`
--

CREATE TABLE IF NOT EXISTS `autor` (
  `idAutor` int(11) NOT NULL AUTO_INCREMENT,
  `Ime` varchar(25) COLLATE utf8_slovenian_ci NOT NULL,
  `Prezime` varchar(35) COLLATE utf8_slovenian_ci NOT NULL,
  `Biografija` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`idAutor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `autor`
--


-- --------------------------------------------------------

--
-- Table structure for table `biblioteka`
--

CREATE TABLE IF NOT EXISTS `biblioteka` (
  `idBiblioteka` int(11) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `Adresa` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `WebAdresa` varchar(25) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Email` varchar(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Telefon` varchar(13) COLLATE utf8_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`idBiblioteka`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `biblioteka`
--

INSERT INTO `biblioteka` (`idBiblioteka`, `Naziv`, `Adresa`, `WebAdresa`, `Email`, `Telefon`) VALUES
(1, 'webiblioteka', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `iznajmljivanje`
--

CREATE TABLE IF NOT EXISTS `iznajmljivanje` (
  `idAkcija` int(11) NOT NULL AUTO_INCREMENT,
  `DatumPosudjivanja` date DEFAULT NULL,
  `DatumVracanja` date DEFAULT NULL,
  `idOsobaClan` int(11) NOT NULL,
  `idOsobaBibliotekar` int(11) NOT NULL,
  `idPrimjerakKnjige` int(11) NOT NULL,
  `idRezervacije` int(11) DEFAULT '0',
  PRIMARY KEY (`idAkcija`),
  KEY `fk_Akcija_Osoba1` (`idOsobaClan`),
  KEY `fk_Akcija_PrimjerakKnjige1` (`idPrimjerakKnjige`),
  KEY `fk_Akcija_Osoba2` (`idOsobaBibliotekar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `iznajmljivanje`
--


-- --------------------------------------------------------

--
-- Table structure for table `knjigaopis`
--

CREATE TABLE IF NOT EXISTS `knjigaopis` (
  `idKnjigaOpis` int(11) NOT NULL AUTO_INCREMENT,
  `Naslov` varchar(200) COLLATE utf8_slovenian_ci NOT NULL,
  `Podnaslov` varchar(220) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `ISBN` varchar(13) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Izdanje` varchar(5) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Opis` text COLLATE utf8_slovenian_ci,
  `Jezik` varchar(20) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `GodinaIzdavanja` year(4) DEFAULT NULL,
  `idZanr` int(11) DEFAULT NULL,
  `DatumUlaza` timestamp NULL DEFAULT NULL,
  `BrojPrimjeraka` int(11) DEFAULT NULL,
  `Status` varchar(20) COLLATE utf8_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`idKnjigaOpis`),
  UNIQUE KEY `ISBN` (`ISBN`),
  KEY `idZanr` (`idZanr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `knjigaopis`
--

INSERT INTO `knjigaopis` (`idKnjigaOpis`, `Naslov`, `Podnaslov`, `ISBN`, `Izdanje`, `Opis`, `Jezik`, `GodinaIzdavanja`, `idZanr`, `DatumUlaza`, `BrojPrimjeraka`, `Status`) VALUES
(2, 'Osnove raèunarstva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2009-11-22 23:59:35', 5, NULL),
(3, 'Raèunarske arhitekture', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2009-11-23 00:00:30', 8, NULL),
(5, 'Rat i mir', 'Nema podnaslova', '1234567890123', '2', 'Ovdje ide opis rata i mira :)\r\nhhaha', 'bosanski', 2008, 1, '2009-12-05 23:00:19', 31, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `obavijest`
--

CREATE TABLE IF NOT EXISTS `obavijest` (
  `idObavijest` int(11) NOT NULL AUTO_INCREMENT,
  `Naslov` varchar(25) COLLATE utf8_slovenian_ci NOT NULL,
  `Tekst` text COLLATE utf8_slovenian_ci NOT NULL,
  `Datum` date DEFAULT NULL,
  `idOsoba` int(11) NOT NULL,
  `idPoslovnica` int(11) NOT NULL,
  PRIMARY KEY (`idObavijest`),
  KEY `fk_Obavijest_Osoba1` (`idOsoba`),
  KEY `fk_Obavijest_Poslovnica1` (`idPoslovnica`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `obavijest`
--

INSERT INTO `obavijest` (`idObavijest`, `Naslov`, `Tekst`, `Datum`, `idOsoba`, `idPoslovnica`) VALUES
(1, 'Neradni dan', 'Obaviještavamo cijenjene korisnike usluga da poslovnica neæe raditi dana 12.4.2009. u periodu od 12 do 15 sati. Ponovni rad se nastavlja 15.4.2009.\r\nNakon editovanja', '2009-03-12', 1, 1),
(2, 'Dan drzavnosti', 'Necemo raditi za dan drzavnosti', '2009-06-09', 3, 1),
(9, 'Nova godina', 'Ne radimo za novu godinu tj. 30,31.12 te 1.1.2010 godine. Ovo je nakon editovanja', '2009-10-07', 2, 2),
(10, 'Asdf', 'skcfnsva jsrj gnfb gnf', '2009-12-07', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ocjena`
--

CREATE TABLE IF NOT EXISTS `ocjena` (
  `idOcjena` int(11) NOT NULL AUTO_INCREMENT,
  `Vrijednost` tinyint(4) NOT NULL,
  `Komentar` text COLLATE utf8_slovenian_ci,
  `idOsoba` int(11) NOT NULL,
  `idKnjigaOpis` int(11) NOT NULL,
  PRIMARY KEY (`idOcjena`),
  KEY `fk_Ocjena_Osoba1` (`idOsoba`),
  KEY `fk_Ocjena_KnjigaOpis1` (`idKnjigaOpis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ocjena`
--


-- --------------------------------------------------------

--
-- Table structure for table `osoba`
--

CREATE TABLE IF NOT EXISTS `osoba` (
  `idOsoba` int(11) NOT NULL AUTO_INCREMENT,
  `Ime` varchar(25) COLLATE utf8_slovenian_ci NOT NULL,
  `Prezime` varchar(35) COLLATE utf8_slovenian_ci NOT NULL,
  `JMBG` varchar(13) COLLATE utf8_slovenian_ci NOT NULL,
  `UlicaIBroj` varchar(25) COLLATE utf8_slovenian_ci NOT NULL,
  `PostanskiBroj` varchar(5) COLLATE utf8_slovenian_ci NOT NULL,
  `Grad` varchar(25) COLLATE utf8_slovenian_ci NOT NULL,
  `Telefon` varchar(13) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Email` varchar(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Status` varchar(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `idTipOsobe` int(11) NOT NULL,
  `idAuth` int(11) DEFAULT NULL,
  `idPoslovnica` int(11) NOT NULL,
  PRIMARY KEY (`idOsoba`),
  KEY `fk_Osoba_TipOsobe1` (`idTipOsobe`),
  KEY `fk_Osoba_Auth1` (`idAuth`),
  KEY `fk_Osoba_Poslovnica1` (`idPoslovnica`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `osoba`
--

INSERT INTO `osoba` (`idOsoba`, `Ime`, `Prezime`, `JMBG`, `UlicaIBroj`, `PostanskiBroj`, `Grad`, `Telefon`, `Email`, `Status`, `idTipOsobe`, `idAuth`, `idPoslovnica`) VALUES
(1, 'Site', 'Admin', '1111', 'xxxx', '1111', 'xxxx', NULL, NULL, NULL, 1, 1, 1),
(2, 'Haris', 'Aleševiæ', '1111', 'xxxx', '1111', 'xxxx', NULL, NULL, NULL, 2, 2, 1),
(3, 'Admir', 'Heriæ', '1111', 'xxxx', '1111', 'xxxx', NULL, NULL, NULL, 3, 3, 1),
(7, 'Haris', 'Aleševiæ', '2147483647', 'Bardakèije 1', '77000', 'Sarajevo', '061/460-110', 'haris@biblioteka.ba', NULL, 3, 4, 2),
(9, 'Nizam', 'Aleševiæ', '2147483647', 'Logavina 3', '77245', 'Bužim', '061/123-456', 'nizo@biblioteka.ba', NULL, 2, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pisac`
--

CREATE TABLE IF NOT EXISTS `pisac` (
  `idAutor` int(11) NOT NULL AUTO_INCREMENT,
  `idKnjigaOpis` int(11) NOT NULL,
  PRIMARY KEY (`idAutor`,`idKnjigaOpis`),
  KEY `idAutor` (`idAutor`),
  KEY `idKnjigaOpis` (`idKnjigaOpis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pisac`
--


-- --------------------------------------------------------

--
-- Table structure for table `poslovnica`
--

CREATE TABLE IF NOT EXISTS `poslovnica` (
  `idPoslovnica` int(11) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `UlicaIBroj` varchar(25) COLLATE utf8_slovenian_ci NOT NULL,
  `PostanskiBroj` varchar(5) COLLATE utf8_slovenian_ci NOT NULL,
  `Grad` varchar(25) COLLATE utf8_slovenian_ci NOT NULL,
  `Telefon` varchar(13) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Email` varchar(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `idBiblioteka` int(11) NOT NULL,
  PRIMARY KEY (`idPoslovnica`),
  KEY `fk_Poslovnica_Biblioteka1` (`idBiblioteka`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `poslovnica`
--

INSERT INTO `poslovnica` (`idPoslovnica`, `Naziv`, `UlicaIBroj`, `PostanskiBroj`, `Grad`, `Telefon`, `Email`, `idBiblioteka`) VALUES
(1, 'Poslovnica br.1', 'Logavina 12', '77000', 'Sarajevo', '033-123-456', 'pbr1@webiblioteka.ba', 1),
(2, 'Poslovnica br.2', 'Bardakcije 1', '77000', 'Sarajevo', '033-123-456', 'pbr2@webiblioteka.ba', 1),
(3, 'Poslovnica br.3', 'Zaima Šarca 13', '77000', 'Sarajevo', '033123456', 'pbr3@webiblioteka.ba', 1);

-- --------------------------------------------------------

--
-- Table structure for table `primjerakknjige`
--

CREATE TABLE IF NOT EXISTS `primjerakknjige` (
  `idPrimjerakKnjige` int(11) NOT NULL AUTO_INCREMENT,
  `idKnjigaOpis` int(11) NOT NULL,
  `idPoslovnica` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idPrimjerakKnjige`),
  KEY `fk_PrimjerakKnjige_KnjigaOpis1` (`idKnjigaOpis`),
  KEY `fk_PrimjerakKnjige_Poslovnica1` (`idPoslovnica`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `primjerakknjige`
--

INSERT INTO `primjerakknjige` (`idPrimjerakKnjige`, `idKnjigaOpis`, `idPoslovnica`, `Status`) VALUES
(1, 5, 1, 0),
(2, 5, 1, 0),
(3, 5, 1, 0),
(4, 5, 1, 0),
(5, 5, 1, 0),
(6, 5, 1, 0),
(7, 5, 1, 0),
(8, 5, 1, 0),
(9, 5, 1, 0),
(10, 5, 1, 0),
(11, 5, 1, 0),
(12, 5, 1, 0),
(13, 5, 2, 0),
(14, 5, 2, 0),
(15, 5, 2, 0),
(16, 5, 2, 0),
(17, 5, 2, 0),
(18, 5, 2, 0),
(19, 5, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--

CREATE TABLE IF NOT EXISTS `rezervacija` (
  `idRezervacija` int(11) NOT NULL AUTO_INCREMENT,
  `Datum` date NOT NULL,
  `Osoba_idOsoba` int(11) NOT NULL,
  `KnjigaOpis_idKnjigaOpis` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idRezervacija`),
  KEY `fk_Rezervacija_Osoba1` (`Osoba_idOsoba`),
  KEY `fk_Rezervacija_KnjigaOpis1` (`KnjigaOpis_idKnjigaOpis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rezervacija`
--


-- --------------------------------------------------------

--
-- Table structure for table `tiposobe`
--

CREATE TABLE IF NOT EXISTS `tiposobe` (
  `idTipOsobe` int(11) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(25) COLLATE utf8_slovenian_ci NOT NULL,
  `Opis` varchar(200) COLLATE utf8_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`idTipOsobe`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tiposobe`
--

INSERT INTO `tiposobe` (`idTipOsobe`, `Naziv`, `Opis`) VALUES
(1, 'admin', NULL),
(2, 'bibliotekar', NULL),
(3, 'clan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zanr`
--

CREATE TABLE IF NOT EXISTS `zanr` (
  `idZanr` int(11) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `Opis` varchar(200) COLLATE utf8_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`idZanr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `zanr`
--

INSERT INTO `zanr` (`idZanr`, `Naziv`, `Opis`) VALUES
(1, 'Informatika', 'Informtièka literatura'),
(3, 'Pravo', 'Knjige koje spadaju u domenu pravnih nauka');

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
-- Constraints for table `pisac`
--
ALTER TABLE `pisac`
  ADD CONSTRAINT `idAutor` FOREIGN KEY (`idAutor`) REFERENCES `autor` (`idAutor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idKnjigaOpis` FOREIGN KEY (`idKnjigaOpis`) REFERENCES `knjigaopis` (`idKnjigaOpis`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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