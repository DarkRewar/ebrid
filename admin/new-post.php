<?php

/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');

function edit_mode(){
    return isset($_GET['article']);
}

function edit_revision(){
    return edit_mode() && isset($_GET['revision']);
}

get_header_admin("Ecrire un article");

$infos = array(
    'title' => null,
    'content' => null,
    'categories' => array()
);

if(edit_revision()){
    $revision = new BlogRevision(array(
        'ida' => $_GET['article']
        , 'idr' => $_GET['revision']
    ));

    $infos['title'] = $revision->getTitle();
    $infos['content'] = $revision->getContent();
    $infos['categories'] = $revision->getCategories();
}elseif(edit_mode()){
    $lastRevision = BlogArticle::_getLastRevision($_GET['article']);
    $infos['title'] = $lastRevision->getTitle();
    $infos['content'] = $lastRevision->getContent();
    $infos['categories'] = $lastRevision->getCategories();
}

if(isset($_POST['article_post']) && form_new_post($_POST)){
    unset($_POST['article_post']);
    $_POST['uid'] = $user->getUid();

    if(edit_mode())
        $_POST['article'] = $_GET['article'];

    $revision = generate_revision($_POST);

    redirect('?article='.$revision->getIda().'&revision='.$revision->getIdr(), true);

    $infos['title'] = $_POST['article_title'];
    $infos['content'] = $_POST['article_content'];
}

extract($infos);

?>

<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "#article_content"
 });
</script>

<div class="row">
    <h1 class="heading">Ecrire un article</h1>
    <form method="post" action="">
        <div class="col l-range-9 s-range-12">
            
            <input type="text" class="title-zone" name="article_title" id="article_title" placeholder="Titre de votre article" value="<?php echo $title ?>" />
            
            <textarea name="article_content" id="article_content" class="area-write-zone" placeholder="Ecrivez le contenu de votre article"><?php echo $content ?></textarea>    
            
            <div class="row">
                <div class="col s-range-12 m-range-4">
                    <input type="submit" name="article_post" class="button expand success rounded" value="Publier"/>
                </div>
                <div class="col s-range-12 m-range-4 m-offset-4">
                    <button type="submit" class="button expand info rounded">Enregistrer un brouillon</button>
                </div>
            </div>
        </div>

        <div class="col l-range-3 s-range-12">
            <?php if(edit_mode()): ?>
                <article class="special-block">
                    <header>
                        <h4>Liste des dernières révisions</h4>
                    </header>
                    <section>
                        <ul class="classic">
                            <?php foreach (BlogArticle::_getRevisions($_GET['article']) as $r){
                                $date = date('m.d.Y', strtotime($r['date']));
                                $href = 'new-post.php?article='.intval($r['ida']).'&revision='.intval($r['idr']);
                                echo "<li><a href=\"$href\">".$r['title'].' #'.$r['idr'].'</a> par '.$r['nickname'].' '.
                                    "<span class=\"show-on-large label info tiny\">$date</span>".
                                    "<span class=\"l-range-0\">le $date</span>".
                                    '</li>';
                            } ?>
                        </ul>
                    </section>
                    <footer>
                        <a class="button small warning rounded">Sauvegarder</a>
                    </footer>
                </article>                
            <?php endif; ?>
            <article class="special-block">
                <header>
                    <h4>Liste des catégories</h4>
                </header>
                <section>
                    <?php draw_tree_category($categories) ?>
                </section>
                <footer>
                    <button class="info" data-modal="add-category">Ajouter une catégorie</button>                    
                </footer>
            </article>
        </div>
    </form>
</div>
<div id="add-category" class="modal"> 
    <a class="close">×</a> 
    <h1>Ajouter une catégorie</h1>
    <form action="" method="post" id="add_new_category">
        <input type="text" name="cat-name" id="cat-name" class="" placeholder="Nom de la catégorie" value="" />
        <textarea name="cat-desc" placeholder="(Optionnel) Description de la catégorie"></textarea>
        <p>
            Catégorie Parente
            <?php draw_list_category(array(
                "container" => array(
                    "markup" => "select",
                    "name" => "cat-parent"
                ),
                "list" => array(
                    "markup" => "option",
                    "value" => "#idc#",
                    "content" => "#name#"
                )
            )); ?>
        </p>
        <input type="submit" name="cat-send" id="cat-send" class="button info" placeholder="" value="Ajouter" />
    </form>
</div>

<script type="text/javascript" src="js/new-post.js"></script>

<?php
get_footer_admin();