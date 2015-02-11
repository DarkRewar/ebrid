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
    'content' => null
);

if(edit_revision()){
    $revision = new BlogRevision(array(
        'ida' => $_GET['article']
        , 'idr' => $_GET['revision']
    ));

    $infos['title'] = $revision->getTitle();
    $infos['content'] = $revision->getContent();
}elseif(edit_mode()){
    $lastRevision = BlogArticle::_getLastRevision($_GET['article']);
    $infos['title'] = $lastRevision->getTitle();
    $infos['content'] = $lastRevision->getContent();
}

if(isset($_POST) && form_new_post($_POST)){
    $_POST['uid'] = $user->getUid();

    if(edit_mode())
        $_POST['article'] = $_GET['article'];

    $revision = generate_revision($_POST);

    $infos['title'] = $_POST['article_title'];
    $infos['content'] = $_POST['article_content'];
}

extract($infos);

?>

<div class="row">
    <h1 class="heading">Ecrire un article</h1>
    <form method="post" action="" class="col l-range-9 s-range-12">
        <label class="input-label">
            <span class="info-label">Titre de l'article</span>
            <input type="text" name="article_title" id="article_title" placeholder="Titre de votre article" value="<?php echo $title ?>" />
        </label>
        <label class="input-label">
            <span class="info-label">Contenu de l'article</span>
            <textarea name="article_content" id="article_content" placeholder="Ecrivez le contenu de votre article"><?php echo $content ?></textarea>    
        </label>
        <div class="row">
            <div class="col s-range-12 m-range-4">
                <button type="submit" class="expand success rounded">Publier</button>
            </div>
            <div class="col s-range-12 m-range-4 m-offset-4">
                <button type="submit" class="expand info rounded">Enregistrer un brouillon</button>
            </div>
        </div>
    </form>

    <?php if(edit_mode()): ?>
    <div class="col l-range-3 s-range-12">
        <h4 class="heading">Liste des dernières révisions</h4>
        <ul class="classic">
            <?php foreach (BlogArticle::_getRevisions($_GET['article']) as $r){
                $date = date('m.d.Y', strtotime($r['date']));
                $href = 'new-post.php?article='.intval($r['ida']).'&revision='.intval($r['idr']);
                echo "<li><a href=\"$href\">".$r['title'].' #'.$r['idr'].'</a> par '.$r['nickname'].' '.
                    "<span class=\"show-on-large label info tiny\">$date</span>".
                    "<span class=\"l-range-0\">le $date</span>".
                    '</li>';
            } ?>
            <!-- <li><a>Titre de l'article lors de la révision précédente #3</a> par Rewar <span class="show-on-large label info tiny">02.02.2015</span><span class="l-range-0">le 02.02.2015</span></li>
            <li><a>Titre de l'article lors de la révision précédente #2</a> par Goulaheau <span class="show-on-large label info tiny">31.01.2015</span><span class="l-range-0">le 31.01.2015</span></li>
            <li><a>Titre de l'article lors de la révision précédente #1</a> par Rewar  <span class="show-on-large label info tiny">15.01.2015</span><span class="l-range-0">le 15.01.2015</span></li>
         --></ul>
    </div>
    <?php endif; ?>
</div>


<?php

get_footer_admin();