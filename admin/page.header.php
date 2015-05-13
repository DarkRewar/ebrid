<?php

global $user;
$title = isset($title)?$title:'Ebrid Maquette';

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?> | Administration</title>
    <link rel="stylesheet" href="css/leaframe.min.css" />
    <link rel="stylesheet" href="css/main-custom.css" />
    <script src="js/jquery.js"></script>
    <script src="js/leaframe.min.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
</head>

<body>
    <nav class="top fixed">
        <div class="contain">
            <ul>
                <li data-drop="ebrid_infos">
                    <a href="./" class="title">Administration</a>
                    <div class="drop" id="ebrid_infos">
                        <ul>
                            <li><a href="http://<?php draw_site_url() ?>">Voir mon site</a></li>
                            <li><a href="">Modifier mon site</a></li>
                        </ul>
                    </div>
                </li>
                <li class="" data-drop="site-conf">
                    <a class="link-menu ref">Site</a>
                    <div id="site-conf" class="drop">
                        <ul>
                            <li><a href="modify-settings.php">Modifier les paramètres</a></li>
                            <li><a href="modify-theme.php">Changer de thème</a></li>
                            <li><a href="modify-plugin.php">Modifier des plugins</a></li>
                        </ul>
                    </div>
                </li>
                <li class="" data-drop="article">
                    <a class="link-menu ref">Articles</a>
                    <div id="article" class="drop">
                        <ul>
                            <li><a href="new-post.php">Poster un article</a></li>
                            <li><a href="list-article.php">Liste des articles</a></li>
                        </ul>
                    </div>
                </li>
                <li class="" data-drop="forum">
                    <a class="link-menu ref">Forum</a>
                    <div id="forum" class="drop">
                        <ul>
                            <li><a href="manage-category.php">Gestion des catégories</a></li>
                            <li><a href="manage-forum.php">Gestion des forums</a></li>
                        </ul>
                    </div>
                </li>
                <li class="right" data-drop="compte">
                    <a class="link-menu ref">Compte: <?php echo $user->getNickname(); ?></a>
                    <div id="compte" class="drop">
                        <ul>
                            <li><a>Configurer mon compte</a>
                            </li>
                            <li><a>Voir mon profil</a>
                            </li>
                            <li><a href="login.php">Se déconnecter</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>    
    <div class="space"></div>