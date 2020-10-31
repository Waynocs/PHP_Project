-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 31 oct. 2020 à 10:33
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `editor`
--

DROP TABLE IF EXISTS `editor`;
CREATE TABLE IF NOT EXISTS `editor` (
  `id_editor` int(6) NOT NULL AUTO_INCREMENT,
  `surname` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `mail_address` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `dateCreate` datetime NOT NULL,
  PRIMARY KEY (`id_editor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `editor`
--

INSERT INTO `editor` (`id_editor`, `surname`, `name`, `mail_address`, `password`, `dateCreate`) VALUES
(4, 'Serano', 'Waian', 'wainser@free.fr', '$2y$10$LfF.YtF1at2xuZz/M1JuUOMex.cgiCoouTjcymq/XB5M3qNL2Q0KW', '2020-10-25 20:04:42'),
(5, 'Serano', 'Waian', 'nathanhanen@gmail.com', '$2y$10$B5PwkF8auHT1nWbVyAGFeO/3yFBWFKiTW1Gf87lt8v7ZRp6jQT.D2', '2020-10-28 22:24:12');

-- --------------------------------------------------------

--
-- Structure de la table `langue`
--

DROP TABLE IF EXISTS `langue`;
CREATE TABLE IF NOT EXISTS `langue` (
  `id_langue` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id_langue`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `langue`
--

INSERT INTO `langue` (`id_langue`, `title`) VALUES
(11, 'Chinois'),
(10, 'Anglais'),
(9, 'Fran&ccedil;ais'),
(12, 'Japonais'),
(13, 'italien'),
(14, 'Espagnol');

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme` int(11) NOT NULL,
  `id_langue` int(11) NOT NULL,
  `title_news` varchar(100) NOT NULL,
  `date_news` datetime NOT NULL,
  `text_news` text NOT NULL,
  `id_editor` int(11) NOT NULL,
  PRIMARY KEY (`id_news`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`id_news`, `id_theme`, `id_langue`, `title_news`, `date_news`, `text_news`, `id_editor`) VALUES
(10, 6, 9, 'Un skateur bourr&eacute;', '2020-10-29 15:54:40', 'Un homme se crash en skateboard pr&egrave;s de porcelette', 5),
(11, 6, 9, 'Un skateur d&eacute;fonc&eacute;', '2020-10-29 16:07:35', 'Un skateur d&eacute;fonc&eacute; fuit les policiers avec 3 kilos de beuh dans les poches !', 5),
(12, 6, 10, 'Skateur fou', '2020-10-29 17:02:33', 'He died in skateboard', 5),
(13, 6, 13, '&eacute;&quot;zaaz', '2020-10-30 14:32:02', 'qezfzefze', 5),
(14, 9, 14, 'zqdsq', '2020-10-30 19:43:11', 'qsdsq', 5);

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `id_theme` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id_theme`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`id_theme`, `title`, `description`) VALUES
(6, 'Skateboard', 'Le th&egrave;me du skateboard en Moselle'),
(7, 'wakeboard', 'Surf sur le l\'eau'),
(8, 'Surf', 'Le surf c\'est sur l\'eau'),
(9, 'Snowboard', ' Le snow c\'est sur la neige');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
