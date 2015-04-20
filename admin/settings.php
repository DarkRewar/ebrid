<?php

require_once (dirname(__FILE__) . '/loader.php');

$filename = 'settings.php';

if(file_exists($filename)){
     get_header_admin("Erreur");
    echo "<div class=\"row\">
            Vous avez déjà installer Ebrid. Si vous vous le réinstaller , supprimez votre base de données
          </div>"
            ;

}elseif ($_POST['nameDB'] == ) {
    
}else{


    $req = " CREATE DATABASE '".$_POST['nameDB']."'";
    $res = Database::_exec($req);

    if(!isset($_POST['idDB'])){
        echo "L'identifiant n\'a pas été entré";
    }elseif((!isset($_POST['DBhost'])){
        echo "La base hote n\'a pas été entrée";
    
    }

    
}
