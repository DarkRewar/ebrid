<?php

$db = mysqli_connect("127.0.0.1", "root", "", "ebrid");
if (mysqli_connect_errno($db)) {
    var_dump("Echec lors de la connexion à MySQL : " . mysqli_connect_error());
    die();
}
/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');


if (isset($_POST['name']) && isset($_POST['description'])) 
{
    $com = new BlogCategory();
    if (!$com->setName($_POST['name'])) 
    {
        $alert = alert("La categorie n'a pas de nom");
    }
    elseif(!$com->setDescription($_POST['description']))
    {
       
        $alert = alert("La description est vide");
    }
     elseif (!$com->insert()) 
    
    {
        $alert = alert("Il y a eu un problème à l'insertion !");
    } else
    {
        $alert = alert("Le sujet a bien été posté");
   
    }
}

BlogCategory::afficherDerniereCategories();

?>

    <div class="row" id="sujet">
        <div class="col range-12">
            <form method="post" action="">
                <p>
                <label for="nom" class="input-label center">
                    <span class="info-label" style="background:linear-gradient(to top, #eee, #85C8FF)">Nom de votre categorie:</span>
                    <input type="text" name="name" id="nom" placeholder="Exemple: Ma nouvelle categorie..."/>
                </label>
                </p>
                </br>
                <p>
                <label for="description" class="input-label center">
                    <span class="info-label" style="background:linear-gradient(to top, #eee, #85C8FF)">Description de votre categorie:</span>
                    <textarea name="description" id="description" placeholder="Exemple: Bonjour, dans cette categorie je vais vous présenter ..."></textarea>
                 </label>
                </p>
                <p>
                <center><input type="submit" name="send" id="send" class="button info rounded" placeholder="" value="Soumettre" /></center>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
