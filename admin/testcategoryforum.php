<?php
require_once (dirname(__FILE__) . '/loader.php');

get_header_admin("Création des catégories de forum");

if (isset($_POST['nom_cat_forum']) && isset($_POST['desc_cat_forum'])) 
{
    $categorie = new ForumCategory();
    
    if (!$categorie->setName($_POST['nom_cat_forum'])) 
    {
        echo "<div> Le nom de la catégorie n'est pas rentrée</div>";
        
    } else if (!$categorie->setDescription($_POST['desc_cat_forum'])) 
    {
        echo "<div> Vous n'avez pas rentré la description de la catégorie </div>";
    } else if (!$categorie->insert()) 
    {
        echo "<div>Il y a eu un problème à l'insertion</div>";
    } else
    {
        echo "<div> Vous avez créé votre catégorie</div>";
    }
}
?>

<body>
    <div>
        <form method="post" action"">
            <input type="text" name="nom_cat_forum" placeholder="nom de la catégorie">
            <br />
            <input type="text" name="desc_cat_forum" placeholder="description de la catégorie">
            <br />
            <input type="submit" value="Valider">
        </form>
    </div>
</body>