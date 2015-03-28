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
                    <a href="./" class="title">Ebrid_Maquette</a>
                    <div class="drop" id="ebrid_infos">
                        <ul>
                            <li><a href="http://ebrid.dev">Ebrid.dev</a></li>
                            <li><a>Voir mon site</a></li>
                            <li><a>Modifier mon site</a></li>
                        </ul>
                    </div>
                </li>
                <li class="" data-drop="article">
                    <a class="link-menu ref">Articles</a>
                    <div id="article" class="drop">
                        <ul>
                            <li><a href="new-post.php">Poster un article</a></li>
                            <li><a href="affichage-article.php">Liste des articles</a></li>
                            <li><a href="testmessage.php">Poster un message</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="modify-theme.php">Changer de thème</a></li>
                <li><a href="modify-settings.php">Modifier les paramètres</a></li>
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