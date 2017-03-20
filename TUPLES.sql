-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 19, 2017 at 03:38 PM
-- Server version: 5.5.54-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `symfony`
--

-- --------------------------------------------------------

--
-- Table structure for table `annonce`
--

CREATE TABLE IF NOT EXISTS `annonce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conducteur` int(11) NOT NULL,
  `annonceur` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nb_places` int(11) DEFAULT NULL,
  `duree_detour` int(11) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `dateDep` datetime NOT NULL,
  `dateArr` datetime NOT NULL,
  `ville_dep` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ville_arr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adresse_dep` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adresse_arr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `array_passagers` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `annonce`
--

INSERT DELAYED INTO `annonce` (`id`, `id_conducteur`, `annonceur`, `titre`, `description`, `nb_places`, `duree_detour`, `prix`, `dateDep`, `dateArr`, `ville_dep`, `ville_arr`, `adresse_dep`, `adresse_arr`, `array_passagers`) VALUES
(1, 2, 2, 'Covoit : Nantes -Rennes', 'Coivoiturage sympa', 3, 10, 10, '2012-01-01 00:00:00', '2012-01-01 00:00:00', 'Nantes', 'Rennes', NULL, NULL, 0),
(2, 2, 2, 'Covoit : Rennes - Nantes', 'Covoiturage avec musique', 4, 10, 10, '2012-05-01 02:10:00', '2017-08-03 03:04:00', 'Rennes', 'Nantes', NULL, NULL, 0),
(9, 2, 2, 'Covoiturage avec JP', '', 800, 3, 53, '2017-12-11 12:00:00', '2017-12-11 13:00:00', 'Paris', 'Nantes', NULL, NULL, 0),
(10, 2, 2, 'Covoiturage avec JP', '', 5, 3, 44, '2017-12-10 00:00:00', '2017-12-11 00:00:00', 'Bordeaux', 'Nouvelle Zelande', NULL, NULL, 0),
(11, 2, 2, 'Covoiturage avec JP', '', 2, 4, 60, '2017-12-11 12:00:00', '2017-12-11 13:00:00', 'Paris', 'Rennes', NULL, NULL, 0),
(12, 0, 0, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 0),
(13, 1, 1, 'Covoiturave avec flo', '', 4, 4, 44, '2017-12-11 12:00:00', '2017-12-11 13:00:00', 'Nantes', 'Bruxelle', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fos_user`
--

CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fos_user`
--

INSERT DELAYED INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(2, 'flo', 'jfieozf', 'fezf', 'fezfe', 0, 'fezaf', '123', '2017-03-08 00:00:00', 'fez', '2017-03-23 00:00:00', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_annonce` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `reservation`
--

INSERT DELAYED INTO `reservation` (`id`, `id_annonce`, `id_user`) VALUES
(1, 2, 1),
(2, 9, 1),
(3, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mdp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `voiture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:object)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `utilisateur`
--

INSERT DELAYED INTO `utilisateur` (`id`, `email`, `mdp`, `nom`, `prenom`, `age`, `telephone`, `voiture`, `photo`) VALUES
(1, 'flo@flo', '123', 'flo', 'flo', 45, NULL, '0', NULL),
(2, 'thib2@1', '123', 'JP', 'Branchette', 24, '0237492900', 'Clio', NULL),
(3, 'QuentinD@1', '123', 'Delanou', 'Quentin', NULL, NULL, NULL, 'N;'),
(4, 'QuentinD@1', '123', 'Delanou', 'Quentin', NULL, NULL, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `voiture`
--

CREATE TABLE IF NOT EXISTS `voiture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proprietaire` int(11) DEFAULT NULL,
  `marque` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modele` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capacite_dispo` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `voiture`
--

INSERT DELAYED INTO `voiture` (`id`, `proprietaire`, `marque`, `modele`, `capacite_dispo`, `image`) VALUES
(1, 1, 'mercedes', 'c1000', 3, NULL),
(2, 2, 'citroen', 'c3', 4, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
