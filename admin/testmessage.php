<?php

/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');

function edit_mode(){
    return isset($_GET['message']);
}

function edit_revision(){
    return edit_mode() && isset($_GET['revision']);
}

get_header_admin("Ecrire un message");

$infos = array(
    'title' => null,
    'content' => null
);

if(edit_revision()){
    $revision = new ForumRevision(array(
        'idm' => $_GET['message']
        , 'idr' => $_GET['revision']
    ));

    $infos['title'] = $revision->getTitle();
    $infos['content'] = $revision->getContent();
}elseif(edit_mode()){
    $lastRevision = ForumMessage::_getLastRevision($_GET['message']);
    $infos['title'] = $lastRevision->getTitle();
    $infos['content'] = $lastRevision->getContent();
}

if(isset($_POST) && form_new_post($_POST)){
    $_POST['uid'] = $user->getUid();

    if(edit_mode())
        $_POST['message'] = $_GET['messa ge'];

    $revision = generate_revision($_POST);

    $infos['title'] = $_POST['message_title'];
    $infos['content'] = $_POST['message_content'];
}

extract($infos);

?>

<div class="row">
    <h1 class="heading">Ecrire un message</h1>
    <form method="post" action="" class="col l-range-9 s-range-12">
        <label class="input-label">
            <span class="info-label">Titre du message</span>
            <input type="text" name="message_title" id="message_title" placeholder="Titre de votre message" value="<?php echo $title ?>" />
        </label>
        <label class="input-label">
            <span class="info-label">Contenu du message</span>
            <textarea name="message_content" id="message_content" placeholder="Ecrivez le contenu de votre message"><?php echo $content ?></textarea>    
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
            <?php foreach (ForumMessage::_getRevisions($_GET['message']) as $r){
                $date = date('m.d.Y', strtotime($r['date']));
                $href = 'testmessage.php?message='.intval($r['idm']).'&revision='.intval($r['idr']);
                echo "<li><a href=\"$href\">".$r['title'].' #'.$r['idr'].'</a> par '.$r['nickname'].' '.
                    "<span class=\"show-on-large label info tiny\">$date</span>".
                    "<span class=\"l-range-0\">le $date</span>".
                    '</li>';
            } ?>

        </ul>
    </div>
    <?php endif; ?>
</div>


<?php

get_footer_admin();