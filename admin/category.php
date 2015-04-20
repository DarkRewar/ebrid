<?php

/**
 *  Index page of Administration
 *
 * @package Ebrid
 */

require_once(dirname(__FILE__) . '/loader.php');

function edit_mode()
{
    return isset($_GET['category']);
}


get_header_admin("Nouvelle categorie");

$infos = array(
    'title' => null,
    'content' => null,
    'categories' => array()
);

if (isset($_POST['category_post']) && form_new_post($_POST)) {
    unset($_POST['category_post']);
    $_POST['uid'] = $user->getUid();

    if (edit_mode())
        $_POST['category'] = $_GET['category'];

    $revision = generate_revision($_POST);

    redirect('?category=' . $revision->getIda() . '&revision=' . $revision->getIdr(), true);

    $infos['title'] = $_POST['category_title'];
    $infos['content'] = $_POST['category_content'];
}

if (isset($_GET['trashed']))
{

    BlogCategory::_deleteCategory($_GET['category']);
}

// Modification de la catégorie.

if (isset($_POST['cat'])) {
    $idc = $_POST['cat'];
    if ($_POST['cat-name'] != '' && $_POST['cat-desc'] != '') {
        $name = 'name';
        $changement = $_POST['cat-name'];
        BlogCategory::_updateCategory($name, $changement, $idc);
        $name = 'description';
        $changement = $_POST['cat-desc'];
        BlogCategory::_updateCategory($name, $changement, $idc);
    } elseif ($_POST['cat-name'] != '') {
        echo $idc;
        $name = 'name';
        $changement = $_POST['cat-name'];
        echo $name . $changement;
        BlogCategory::_updateCategory($name, $changement, $idc);
    } elseif ($_POST['cat-desc'] != '' ) {
        $name = 'description';
        $changement = $_POST['cat-desc'];
        BlogCategory::_updateCategory($name, $changement, $idc);
    }
}

extract($infos);

?>

<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "#category_content"
 });
</script>
            <category class="special-block">
                <header>
                    <h4>Liste des catégories</h4>
                </header>
                <section>
                    <?php draw_tree_category() ?>
                </section>
                <footer>
                    <button class="info" data-modal="add-category">Ajouter une catégorie</button>
                    <button href="updateCategory.php" class="info" data-modal="modif-category">Modifier une catégorie</button>
                    <button class="info" data-modal="del-category">Supprimer une catégorie</button>                    
                </footer>
            </category>
        </div>
    </form>
</div>

<div id="add-category" class="modal"> 
    <a class="close">×</a> 
    <h1>Nouvelle catégorie</h1>
    <form action="" method="post" id="add_new_category">
        <input type="text" name="cat-name" id="cat-name" class="" placeholder="Nom de la catégorie" value="" />
        <textarea name="cat-desc" placeholder="(Optionnel) Description de la catégorie"></textarea>
        <p>
            Catégorie Parente
            <?php
                draw_list_category(array(
                    "container" => array(
                        "markup" => "select",
                        "name" => "cat-parent"
                    ),
                    "list" => array(
                        "markup" => "option",
                        "value" => "#idc#",
                        "content" => "#name#"
                    )
                ));
            ?>
        </p>
        <input type="submit" name="cat-send" id="cat-send" class="button info" placeholder="" value="Ajouter" />
    </form>
</div>

<div id="modif-category" class="modal"> 
    <a class="close">×</a> 
    <h1>Modifier la catégorie</h1>
    <form action="" method="post" name="modif_category">
        <p>
            Catégorie à modifier
            <?php
                draw_list_category(array(
                    "container" => array(
                        "markup" => "select",
                        "name" => "cat"
                    ),
                    "list" => array(
                        "markup" => "option",
                        "value" => "#idc#",
                        "content" => "#name#"
                    )
                ));
            ?>
        </p>
        <input type="text" name="cat-name" id="cat-name" class="" placeholder="Nouveau nom" />
        <textarea name="cat-desc" placeholder="Nouvelle description"></textarea>
        <input type="submit" name="cat-send" id="cat-send" class="button info" placeholder="" value="Modifier" />
    </form>
</div>

<div id="del-category" class="modal"> 
    <a class="close">×</a> 
    <h1>Supprimer la catégorie</h1>
        <form action="" method="post" id="del_this_category">
        <p>
            Catégorie Parente
            <?php
                draw_list_category(array(
                    "container" => array(
                    "markup" => "select",
                    "name" => "cat-parent"
                ),
                "list" => array(
                    "markup" => "option",
                    "value" => "#idc#",
                    "content" => "#name#"
                )
                ));
            ?>
        </p>
        <?php
            foreach (BlogCategory::_getCategory() as $v){
            $category = new BlogCategory($v['idc']);
            echo "
                <button class=\"supprimerCategory\" id='supprimer_category" . $v['idc'] . "'>
                    <a href=\"category.php?category=" . $v['idc'] . "&trashed=true\">". $category->getName() .
                    "</a>
                </button>";
            }
        ?>
    </form>
</div>
<script type="text/javascript" src="js/new-post.js"></script>

<?php
get_footer_admin();