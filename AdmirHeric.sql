-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 15, 2009 at 03:32 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`idAuth`, `KorisnickoIme`, `Sifra`, `Odobren`) VALUES
(1, 'admin', 'admin', 1),
(3, 'clan', 'clan', 1),
(17, 'deni', 'deni', 1),
(19, 'bibliotekar', 'bibliotekar', 1),
(20, 'alen', 'alen', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `autor`
--

INSERT INTO `autor` (`idAutor`, `Ime`, `Prezime`, `Biografija`) VALUES
(1, 'Željko', 'Juriæ', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `biblioteka`
--

CREATE TABLE `biblioteka` (
  `idBiblioteka` int(11) NOT NULL auto_increment,
  `Naziv` varchar(45) collate utf8_slovenian_ci NOT NULL,
  `Adresa` varchar(100) collate utf8_slovenian_ci default NULL,
  `WebAdresa` varchar(25) collate utf8_slovenian_ci default NULL,
  `Email` varchar(50) collate utf8_slovenian_ci default NULL,
  `Telefon` varchar(13) collate utf8_slovenian_ci default NULL,
  PRIMARY KEY  (`idBiblioteka`)
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

CREATE TABLE `iznajmljivanje` (
  `idIznajmljivanje` int(11) NOT NULL auto_increment,
  `DatumPosudjivanja` timestamp NULL default CURRENT_TIMESTAMP,
  `DatumVracanja` timestamp NULL default NULL,
  `idOsobaClan` int(11) NOT NULL,
  `idOsobaBibliotekar` int(11) NOT NULL,
  `idPrimjerakKnjige` int(11) NOT NULL,
  `Status` int(11) default NULL,
  PRIMARY KEY  (`idIznajmljivanje`),
  KEY `fk_Akcija_Osoba1` (`idOsobaClan`),
  KEY `fk_Akcija_PrimjerakKnjige1` (`idPrimjerakKnjige`),
  KEY `fk_Akcija_Osoba2` (`idOsobaBibliotekar`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `iznajmljivanje`
--

INSERT INTO `iznajmljivanje` (`idIznajmljivanje`, `DatumPosudjivanja`, `DatumVracanja`, `idOsobaClan`, `idOsobaBibliotekar`, `idPrimjerakKnjige`, `Status`) VALUES
(1, '2009-12-15 03:07:24', '2009-12-15 03:12:28', 8, 1, 57, 1),
(2, '2009-12-15 03:12:28', NULL, 5, 7, 57, 0);

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
  `GodinaIzdavanja` year(4) default NULL,
  `idZanr` int(11) default NULL,
  `DatumUlaza` timestamp NULL default NULL,
  `BrojPrimjeraka` int(11) default NULL,
  `Status` varchar(20) collate utf8_slovenian_ci default NULL,
  PRIMARY KEY  (`idKnjigaOpis`),
  UNIQUE KEY `ISBN` (`ISBN`),
  KEY `idZanr` (`idZanr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `knjigaopis`
--

INSERT INTO `knjigaopis` (`idKnjigaOpis`, `Naslov`, `Podnaslov`, `ISBN`, `Izdanje`, `Opis`, `Jezik`, `GodinaIzdavanja`, `idZanr`, `DatumUlaza`, `BrojPrimjeraka`, `Status`) VALUES
(3, 'Ra', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2009-11-23 00:00:30', 8, NULL),
(5, 'Rat i mir', 'Nema podnaslova', '1234567890123', '2', 'Ovdje ide opis rata i mira :)\r\nhhaha', 'bosanski', 2008, 1, '2009-12-05 23:00:19', 31, NULL),
(7, 'Razumijes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2009-12-14 22:26:05', 5, NULL),
(8, 'Fizika', '', '', '', '', '', 1988, 3, '2009-12-14 22:55:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `idlog` int(11) NOT NULL auto_increment,
  `vrijeme` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `userid` int(11) NOT NULL default '0',
  `dogadjaj` varchar(255) collate utf8_slovenian_ci NOT NULL,
  PRIMARY KEY  (`idlog`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=40 ;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`idlog`, `vrijeme`, `userid`, `dogadjaj`) VALUES
(26, '2009-12-15 01:37:53', 5, 'Iznajmljen primjerak'),
(25, '2009-12-15 00:11:54', 4, 'Iznajmljen primjerak'),
(24, '2009-12-15 00:11:52', 4, 'Iznajmljen primjerak'),
(23, '2009-12-15 00:11:50', 4, 'Iznajmljen primjerak'),
(22, '2009-12-15 00:06:14', 4, 'Primjerak rezervisan'),
(27, '2009-12-15 02:30:21', 7, 'Vraceni primjerci knjige'),
(28, '2009-12-15 02:31:22', 7, 'Vraceni primjerci knjige'),
(29, '2009-12-15 03:02:03', 5, 'Primjerak rezervisan'),
(30, '2009-12-15 03:02:06', 5, 'Primjerak rezervisan'),
(31, '2009-12-15 03:02:08', 5, 'Iznajmljen primjerak'),
(32, '2009-12-15 03:04:32', 8, 'Primjerak rezervisan'),
(33, '2009-12-15 03:04:34', 8, 'Primjerak rezervisan'),
(34, '2009-12-15 03:04:36', 8, 'Primjerak rezervisan'),
(35, '2009-12-15 03:07:24', 8, 'Iznajmljen primjerak'),
(36, '2009-12-15 03:07:39', 5, 'Primjerak rezervisan'),
(37, '2009-12-15 03:08:41', 7, 'Vracen primjerak knjige id=57'),
(38, '2009-12-15 03:12:28', 7, 'Vracen primjerak knjige id=57'),
(39, '2009-12-15 03:12:28', 7, 'Iznajmljen primjerak clanu id=5 (rezervacija)');

-- --------------------------------------------------------

--
-- Table structure for table `obavijest`
--

CREATE TABLE `obavijest` (
  `idObavijest` int(11) NOT NULL auto_increment,
  `Naslov` varchar(25) collate utf8_slovenian_ci NOT NULL,
  `Tekst` text collate utf8_slovenian_ci NOT NULL,
  `Datum` date default NULL,
  `idOsoba` int(11) NOT NULL,
  `idPoslovnica` int(11) NOT NULL,
  PRIMARY KEY  (`idObavijest`),
  KEY `fk_Obavijest_Osoba1` (`idOsoba`),
  KEY `fk_Obavijest_Poslovnica1` (`idPoslovnica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `obavijest`
--


-- --------------------------------------------------------

--
-- Table structure for table `ocjena`
--

CREATE TABLE `ocjena` (
  `idOcjena` int(11) NOT NULL auto_increment,
  `Vrijednost` tinyint(4) NOT NULL,
  `Komentar` text collate utf8_slovenian_ci,
  `idOsoba` int(11) NOT NULL,
  `idKnjigaOpis` int(11) NOT NULL,
  PRIMARY KEY  (`idOcjena`),
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
  `idTipOsobe` int(11) default NULL,
  `idAuth` int(11) default NULL,
  `idPoslovnica` int(11) NOT NULL,
  PRIMARY KEY  (`idOsoba`),
  KEY `fk_Osoba_Auth1` (`idAuth`),
  KEY `fk_Osoba_Poslovnica1` (`idPoslovnica`),
  KEY `idTipOsobe` (`idTipOsobe`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `osoba`
--

INSERT INTO `osoba` (`idOsoba`, `Ime`, `Prezime`, `JMBG`, `UlicaIBroj`, `PostanskiBroj`, `Grad`, `Telefon`, `Email`, `Status`, `idTipOsobe`, `idAuth`, `idPoslovnica`) VALUES
(1, 'Site', 'Admin', '', '', '', '', NULL, NULL, NULL, NULL, 1, 1),
(5, 'Denis', 'Marusic', '343534534', 'dkhfjdhf', '4545', 'rrr', '0623483984', 'admirheric@gmail.co', NULL, NULL, 17, 1),
(7, 'Haris', 'Alesevic', '0', '', '0', '', '', '', NULL, NULL, 19, 2),
(8, 'Alen', 'Alenovic', '0', '', '0', '', '', '', NULL, NULL, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pisac`
--

CREATE TABLE `pisac` (
  `idAutor` int(11) NOT NULL auto_increment,
  `idKnjigaOpis` int(11) NOT NULL,
  PRIMARY KEY  (`idAutor`,`idKnjigaOpis`),
  KEY `idAutor` (`idAutor`),
  KEY `idKnjigaOpis` (`idKnjigaOpis`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pisac`
--

INSERT INTO `pisac` (`idAutor`, `idKnjigaOpis`) VALUES
(1, 3),
(1, 5),
(1, 7),
(1, 8);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `poslovnica`
--

INSERT INTO `poslovnica` (`idPoslovnica`, `Naziv`, `UlicaIBroj`, `PostanskiBroj`, `Grad`, `Telefon`, `Email`, `idBiblioteka`) VALUES
(1, 'Poslovnica br.1', 'Logavina 12', '77000', 'Sarajevo', '033-123-456', 'pbr1@webiblioteka.ba', 1),
(2, 'Poslovnica br.2', 'Bardakcije 1', '77000', 'Sarajevo', '033-123-456', 'pbr2@webiblioteka.ba', 1),
(3, 'Poslovnica br.3', 'Zaima ', '77000', 'Sarajevo', '033123456', 'pbr3@webiblioteka.ba', 1);

-- --------------------------------------------------------

--
-- Table structure for table `primjerakknjige`
--

CREATE TABLE `primjerakknjige` (
  `idPrimjerakKnjige` int(11) NOT NULL auto_increment,
  `idKnjigaOpis` int(11) NOT NULL,
  `idPoslovnica` int(11) NOT NULL,
  `Status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`idPrimjerakKnjige`),
  KEY `fk_PrimjerakKnjige_KnjigaOpis1` (`idKnjigaOpis`),
  KEY `fk_PrimjerakKnjige_Poslovnica1` (`idPoslovnica`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=58 ;

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
(10, 5, 1, 0),
(11, 5, 1, 0),
(13, 5, 2, 0),
(15, 5, 2, 0),
(17, 5, 2, 0),
(21, 3, 1, 0),
(55, 7, 1, 0),
(56, 7, 1, 0),
(57, 8, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--

CREATE TABLE `rezervacija` (
  `idRezervacija` int(11) NOT NULL auto_increment,
  `Vrijeme` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `Osoba_idOsoba` int(11) NOT NULL,
  `KnjigaOpis_idKnjigaOpis` int(11) NOT NULL,
  `Status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`idRezervacija`),
  KEY `fk_Rezervacija_Osoba1` (`Osoba_idOsoba`),
  KEY `fk_Rezervacija_KnjigaOpis1` (`KnjigaOpis_idKnjigaOpis`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rezervacija`
--

INSERT INTO `rezervacija` (`idRezervacija`, `Vrijeme`, `Osoba_idOsoba`, `KnjigaOpis_idKnjigaOpis`, `Status`) VALUES
(1, '2009-12-15 03:07:38', 5, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tiposobe`
--

CREATE TABLE `tiposobe` (
  `idTipOsobe` int(11) NOT NULL,
  `Naziv` varchar(25) collate utf8_slovenian_ci NOT NULL,
  `Opis` varchar(200) collate utf8_slovenian_ci default NULL,
  KEY `idTipOsobe` (`idTipOsobe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `tiposobe`
--

INSERT INTO `tiposobe` (`idTipOsobe`, `Naziv`, `Opis`) VALUES
(1, 'admin', NULL),
(5, 'clan', NULL),
(7, 'bibliotekar', NULL),
(8, 'clan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zanr`
--

CREATE TABLE `zanr` (
  `idZanr` int(11) NOT NULL auto_increment,
  `Naziv` varchar(45) collate utf8_slovenian_ci NOT NULL,
  `Opis` varchar(200) collate utf8_slovenian_ci default NULL,
  PRIMARY KEY  (`idZanr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `zanr`
--

INSERT INTO `zanr` (`idZanr`, `Naziv`, `Opis`) VALUES
(1, 'Informatika', 'Informti'),
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
  ADD CONSTRAINT `fk_PrimjerakKnjige_Poslovnica1` FOREIGN KEY (`idPoslovnica`) REFERENCES `poslovnica` (`idPoslovnica`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD CONSTRAINT `fk_Rezervacija_Osoba1` FOREIGN KEY (`Osoba_idOsoba`) REFERENCES `osoba` (`idOsoba`) ON DELETE NO ACTION ON UPDATE NO ACTION;