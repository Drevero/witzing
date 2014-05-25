-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 25 Mai 2014 à 15:49
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `witzing`
--

-- --------------------------------------------------------

--
-- Structure de la table `au_clavier`
--

CREATE TABLE IF NOT EXISTS `au_clavier` (
  `id_evenement` int(11) NOT NULL AUTO_INCREMENT,
  `id_membre` int(11) NOT NULL,
  `salon` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_evenement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `au_clavier`
--


-- --------------------------------------------------------

--
-- Structure de la table `comment_statuts`
--

CREATE TABLE IF NOT EXISTS `comment_statuts` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_auteur` int(11) NOT NULL,
  `id_statut_comment` int(11) NOT NULL,
  `comment` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_comment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `comment_statuts`
--


-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE IF NOT EXISTS `membres` (
  `id_membre` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(21) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `passe` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mail` varchar(350) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `avatar` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `amis` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `derniere_con` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `derniere_activite` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `suivis` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `aime` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `attente_amis` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `theme_fil` int(11) NOT NULL,
  `fond_fil` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `admin` int(2) NOT NULL,
  `badges` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `membres`
--


-- --------------------------------------------------------

--
-- Structure de la table `messages_perso`
--

CREATE TABLE IF NOT EXISTS `messages_perso` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_auteur` int(11) NOT NULL,
  `salon` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lu` int(11) NOT NULL,
  `contenu` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_message` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `messages_perso`
--


-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id_notif` int(11) NOT NULL AUTO_INCREMENT,
  `membre_notif` int(11) NOT NULL,
  `contenu` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lien` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `emetteur_notif` int(11) NOT NULL,
  `lu` int(11) NOT NULL,
  PRIMARY KEY (`id_notif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `notifications`
--


-- --------------------------------------------------------

--
-- Structure de la table `salon`
--

CREATE TABLE IF NOT EXISTS `salon` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_auteur` int(11) NOT NULL,
  `contenu_message` longtext NOT NULL,
  `date_message` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `salon`
--


-- --------------------------------------------------------

--
-- Structure de la table `statuts`
--

CREATE TABLE IF NOT EXISTS `statuts` (
  `id_statut` int(11) NOT NULL AUTO_INCREMENT,
  `membre_statut` int(11) NOT NULL,
  `ecrivain_statut` int(11) NOT NULL,
  `aime_statut` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `aime_pas_statut` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contenu_statut` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_statut` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `partage` int(11) NOT NULL,
  PRIMARY KEY (`id_statut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `statuts`
--

