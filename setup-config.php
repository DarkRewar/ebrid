<?php
if (isset($_POST)) {
    $dbhost = $_POST['dbhost'];
    $dbname = $_POST['dbname'];
    $dbuser = $_POST['dbuser'];
    $dbpassword = $_POST['dbpassword'];
}

function checkDB($dbhost, $dbname, $dbuser, $dbpassword)
{
    try {
        $bdd = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname . ';charset=utf8', '' . $dbuser . '', '' . $dbpassword . '');
    } catch (Exception $e) {
        return $e;
    }
    return true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Installation d'Ebrid</title>
    <meta charset="utf-8">
</head>
<body>
    <div class="main-section">
        <div class="row">
            <div class="col m-range-9">
                <div class="row">
                    <div class="col m-range-12">
                        <div class="article-preview">
                            <?php
                            $step = isset($_GET['step']) ? (int)$_GET['step'] : 0;
                            switch ($step) {
                                case 0:
                                    $step_1 = 'setup-config.php?step=1';
                                    ?>
                                    <h1>Installation</h1>
                                    <p>Bienvenue dans WordPress. Avant de nous lancer, nous avons besoin de certaines
                                        informations sur votre base de données. Il va vous falloir réunir les informations
                                        suivantes pour continuer.</p>
                                    <ol>
                                        <li>Nom de la base de données</li>
                                        <li>Nom d’utilisateur MySQL</li>
                                        <li>Mot de passe de l’utilisateur</li>
                                        <li>Adresse de la base de données</li>
                                        <li>Préfixe de table (si vous souhaitez avoir plusieurs Ebrid sur une même base de
                                            données)
                                        </li>
                                    </ol>
                                    <p>
                                        <strong>Nous allons utiliser cette information pour créer le fichier wp-config.php.
                                            Si, pour quelque raison que ce soit, la création automatique du fichier ne
                                            fonctionne pas, pas de panique. Tout ce qu’elle fait, c’est de compléter le
                                            fichier de configuration avec les informations de connexion à la base de
                                            données. Vous pouvez tout aussi bien ouvrir le fichier wp-config-sample.php dans
                                            un éditeur de texte, y saisir les informations en question, et enregistrer le
                                            fichier sous le nom wp-config.php.</strong>
                                    </p>

                                    <p>Vous devriez normalement avoir reçu ces informations de la part de votre hébergeur.
                                        Si vous ne les avez pas, il vous faudra contacter votre hébergeur afin de continuer.
                                        Si vous êtes prêt…</p>

                                    <p class="step"><a href="<?php echo $step_1; ?>" class="button button-large">Let's
                                            Go!</a></p>
                                    <?php
                                    break;
                                case 1:
                                    $step_2 = 'setup-config.php?step=2';
                                    ?>
                                    <h1>Installation : Etape 1</h1>
                                    <form method="post" action="<?php echo $step_2; ?>">
                                        <p>Vous devez saisir ci-dessous les détails de connexion à votre base de données. Si
                                            vous ne les connaissez pas, contactez votre hébergeur.</p>
                                        <table class="#">
                                            <tr>
                                                <th scope="row"><label for="dbname">Nom de la base de données</label></th>
                                                <td><input name="dbname" id="dbname" type="text" size="25" value="Ebrid"/>
                                                </td>
                                                <td>Le nom de la base de données dans laquelle vous souhaitez installer
                                                    WordPress.
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><label for="dbuser  ">Identifiant</label></th>
                                                <td><input name="dbuser" id="dbuser " type="text" size="25"
                                                           value="Utilisateur"/></td>
                                                <td>Votre identifiant MySQL</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><label for="dbpassword">Mot de passe</label></th>
                                                <td><input name="dbpassword" id="dbpassword" type="text" size="25"
                                                           value="Mot de passe"></td>
                                                <td>…et son mot de passe MySQL.</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><label for="dbhost">Adresse de la base de données</label>
                                                </th>
                                                <td><input name="dbhost" id="dbhost" type="text" size="25"
                                                           value="localhost"/></td>
                                                <td>Si localhost ne fonctionne pas, votre hébergeur doit pouvoir vous donner
                                                    la bonne information.
                                                </td>
                                            </tr>
                                            <tr>
                                        </table>
                                        <input name="submit" type="submit" value="Envoyer" class="#"/></p>
                                    </form>
                                    <?php
                                    break;
                                case 2:
                                    $step_3 = 'setup-config.php?step=3';
                                    $checkDB = checkDB($dbhost, $dbname, $dbuser, $dbpassword);
                                    if ($checkDB !== true) {
                                        ?>
                                        <p>Erreur lors de la connexion à la base de données :</p>
                                        <p><?php echo $checkDB->getMessage(); ?></p>
                                    <?php
                                    } else {
                                        ?>
                                        <p>La connexion à la base de données s'est bien passée.</p>
                                        <?php
                                        $bdd = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname . ';charset=utf8', '' . $dbuser . '', '' . $dbpassword . '');
                                        $creation = 'USE `' . $dbname . '`;

                                                 -- --------------------------------------------------------

                                                 --
                                                 -- Structure de la table `blog_article`
                                                 --

                                                 DROP TABLE IF EXISTS `blog_article`;
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


                                                 -- --------------------------------------------------------

                                                 --
                                                 -- Structure de la table `blog_article_category`
                                                 --

                                                 DROP TABLE IF EXISTS `blog_article_category`;
                                                 CREATE TABLE IF NOT EXISTS `blog_article_category` (
                                                   `ida` int(11) NOT NULL,
                                                   `idc` int(11) NOT NULL,
                                                   KEY `ida` (`ida`),
                                                   KEY `idc` (`idc`)
                                                 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                                                 --
                                                 -- Contenu de la table `blog_article_category`
                                                 --


                                                 -- --------------------------------------------------------

                                                 --
                                                 -- Structure de la table `blog_category`
                                                 --

                                                 DROP TABLE IF EXISTS `blog_category`;
                                                 CREATE TABLE IF NOT EXISTS `blog_category` (
                                                   `idc` int(10) NOT NULL AUTO_INCREMENT,
                                                   `idc_parent` int(11) NOT NULL DEFAULT \'0\',
                                                   `name` varchar(255) NOT NULL,
                                                   `description` varchar(255) NOT NULL,
                                                   `access` int(10) NOT NULL DEFAULT \'0\',
                                                   `level` int(10) NOT NULL DEFAULT \'0\',
                                                   PRIMARY KEY (`idc`),
                                                   KEY `idc_parent` (`idc_parent`)
                                                 ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

                                                 --
                                                 -- Contenu de la table `blog_category`
                                                 --


                                                 -- --------------------------------------------------------

                                                 --
                                                 -- Structure de la table `blog_revision`
                                                 --

                                                 DROP TABLE IF EXISTS `blog_revision`;
                                                 CREATE TABLE IF NOT EXISTS `blog_revision` (
                                                   `idr` int(11) NOT NULL,
                                                   `ida` int(11) NOT NULL,
                                                   `idc` int(11) NOT NULL DEFAULT \'0\',
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


                                                 -- --------------------------------------------------------

                                                 --
                                                 -- Structure de la table `forum_category`
                                                 --

                                                 DROP TABLE IF EXISTS `forum_category`;
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

                                                 DROP TABLE IF EXISTS `forum_forum`;
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

                                                 DROP TABLE IF EXISTS `forum_message`;
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

                                                 DROP TABLE IF EXISTS `forum_topic`;
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

                                                 DROP TABLE IF EXISTS `user`;
                                                 CREATE TABLE IF NOT EXISTS `user` (
                                                   `uid` int(11) NOT NULL AUTO_INCREMENT,
                                                   `email` varchar(255) NOT NULL,
                                                   `nickname` varchar(30) NOT NULL,
                                                   `password` varchar(255) NOT NULL,
                                                   `first_name` varchar(255) NULL DEFAULT NULL,
                                                   `last_name` varchar(255) NULL DEFAULT NULL,
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
                                                 -- Contenu de la table `user`
                                                 --

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
                                                   ADD CONSTRAINT `forum_topic_ibfk_1` FOREIGN KEY (`idf`) REFERENCES `forum_forum` (`idf`) ON DELETE CASCADE ON UPDATE CASCADE;';
                                        $bdd->exec($creation);
                                        ?>
                                        <p>La database a bien été créée.</p>
                                    <?php
                                    }
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>