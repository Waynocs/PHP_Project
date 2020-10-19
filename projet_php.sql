-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 19 Octobre 2020 à 14:04
-- Version du serveur :  5.5.39
-- Version de PHP :  5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `projet_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `editor`
--

CREATE TABLE IF NOT EXISTS `editor` (
`id_editor` int(6) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `mail_address` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
`id_news` int(11) NOT NULL,
  `id_theme` int(11) NOT NULL,
  `title_news` varchar(100) NOT NULL,
  `date_news` date NOT NULL,
  `text_news` text NOT NULL,
  `id_editor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
`id_theme` int(11) NOT NULL,
  `id_translation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `editor`
--
ALTER TABLE `editor`
 ADD PRIMARY KEY (`id_editor`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
 ADD PRIMARY KEY (`id_news`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
 ADD PRIMARY KEY (`id_theme`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `editor`
--
ALTER TABLE `editor`
MODIFY `id_editor` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
MODIFY `id_news` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
MODIFY `id_theme` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
