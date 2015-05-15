<?php

require_once (dirname(__FILE__) . '/loader.php');

get_header_admin("Modifications des catégories");

$category = new ForumCategory($_GET['category']);

if(isset($_POST['name']) && isset($_POST['description'])){
        $category->setName($_POST['name']);
        $category->setDescription($_POST['description']);
        $category->updateCategory();
        redirect("manage-category.php", true);
        
}

?>
<?php
echo '<form action="" method="post">
            <div class="row" id="main-container">
                <div class="col range-6">
                    <label for="article" class="input-label center" style="background: #fff">
                        <span class="info-label" style="background:linear-gradient(to top, #eee, #85C8FF)">Titre de la categorie</span>
                        <input type="text" name="name" value="'.$category->getName().'">
                    </label>
                    <label for="article" class="input-label center" style="background: #fff">
                        <span class="info-label" style="background:linear-gradient(to top, #eee, #85C8FF)">Description de la categorie</span>
                        <input type="text" name="description" value="'.$category->getDescription().'">
                    </label>
                    <input type="submit" value="Modifier">
                </div>
            </div>
        </form>'


?>