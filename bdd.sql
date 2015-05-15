--
-- Structure de la table `blog_article`
--

CREATE TABLE IF NOT EXISTS `blog_article` (
  `ida` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `url` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ida`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `blog_article`
--

INSERT INTO `blog_article` (`ida`, `uid`, `url`, `date`, `status`) VALUES
(1, 1, 'Bienvenue', '2015-05-13 00:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `blog_article_category`
--

CREATE TABLE IF NOT EXISTS `blog_article_category` (
  `ida` int(11) NOT NULL,
  `idc` int(11) NOT NULL,
  KEY `ida` (`ida`),
  KEY `idc` (`idc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blog_article_category`
--

INSERT INTO `blog_article_category` (`ida`, `idc`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `blog_category`
--

CREATE TABLE IF NOT EXISTS `blog_category` (
  `idc` int(10) NOT NULL AUTO_INCREMENT,
  `idc_parent` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `access` int(10) NOT NULL DEFAULT '0',
  `level` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idc`),
  KEY `idc_parent` (`idc_parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `blog_category`
--

INSERT INTO `blog_category` (`idc`, `idc_parent`, `name`, `description`, `access`, `level`) VALUES
(1, 0, 'News', '', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `blog_revision`
--

CREATE TABLE IF NOT EXISTS `blog_revision` (
  `idr` int(11) NOT NULL,
  `ida` int(11) NOT NULL,
  `idc` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `content` longtext NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  KEY `idr` (`idr`,`ida`),
  KEY `ida` (`ida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blog_revision`
--

INSERT INTO `blog_revision` (`idr`, `ida`, `idc`, `uid`, `title`, `content`, `date`, `status`) VALUES
(1, 1, 0, 1, 'Bienvenue', '<h1>Bienvenue sur Ebrid</h1>\r\n<p>&nbsp;</p>\r\n<p>Ebrid est un CMS permettant de réaliser facilement un blog ou un forum. A vous de jouer !</p>', '2015-05-13 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `forum_category`
--

CREATE TABLE IF NOT EXISTS `forum_category` (
  `idc` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `access` tinyint(3) NOT NULL,
  `level` tinyint(3) NOT NULL,
  PRIMARY KEY (`idc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `forum_forum`
--

CREATE TABLE IF NOT EXISTS `forum_forum` (
  `idf` int(11) NOT NULL AUTO_INCREMENT,
  `idc` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`idf`),
  KEY `idc` (`idc`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `forum_message`
--

CREATE TABLE IF NOT EXISTS `forum_message` (
  `idm` int(11) NOT NULL,
  `idr` int(11) NOT NULL,
  `idt` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `content` longtext NOT NULL,
  KEY `idm` (`idm`),
  KEY `idr` (`idr`),
  KEY `idt` (`idt`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_topic`
--

CREATE TABLE IF NOT EXISTS `forum_topic` (
  `idt` int(11) NOT NULL AUTO_INCREMENT,
  `idf` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `idf` (`idf`,`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `signature` longtext NOT NULL,
  `created` datetime NOT NULL,
  `connected` datetime NOT NULL,
  `navigated` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `bantime` datetime NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `blog_article_category`
--
ALTER TABLE `blog_article_category`
  ADD CONSTRAINT `blog_article_category_ibfk_1` FOREIGN KEY (`ida`) REFERENCES `blog_article` (`ida`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_article_category_ibfk_2` FOREIGN KEY (`idc`) REFERENCES `blog_category` (`idc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `blog_revision`
--
ALTER TABLE `blog_revision`
  ADD CONSTRAINT `blog_revision_ibfk_1` FOREIGN KEY (`ida`) REFERENCES `blog_article` (`ida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `forum_forum`
--
ALTER TABLE `forum_forum`
  ADD CONSTRAINT `forum_forum_ibfk_1` FOREIGN KEY (`idc`) REFERENCES `forum_category` (`idc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `forum_message`
--
ALTER TABLE `forum_message`
  ADD CONSTRAINT `forum_message_ibfk_1` FOREIGN KEY (`idt`) REFERENCES `forum_topic` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `forum_topic`
--
ALTER TABLE `forum_topic`
  ADD CONSTRAINT `forum_topic_ibfk_1` FOREIGN KEY (`idf`) REFERENCES `forum_forum` (`idf`) ON DELETE CASCADE ON UPDATE CASCADE;
