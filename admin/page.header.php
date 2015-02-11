<?php

global $user;
$title = isset($title)?$title:'Ebrid Maquette';

?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $title ?> | Administration</title>
    <link rel="stylesheet" href="css/leaframe.min.css" />
    <script src="js/jquery.js"></script>
    <script src="js/leaframe.min.js"></script>
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
                <li>
                    <a>Changer de thème</a>
                </li>
                <a href="new-post.php" class="button info rounded">Poster un article</a>
                <li class="right" data-drop="compte">
                    <a class="link-menu ref">Compte: <?php echo $user->getNickname(); ?></a>
                    <div id="compte" class="drop">
                        <ul>
                            <li><a>Configurer mon compte</a>
                            </li>
                            <li><a>Voir mon profil</a>
                            </li>
                            <li><a>Se déconnecter</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>    
    <div class="space"></div>