<?php

/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */

require_once (dirname(__FILE__) . '/loader.php');

get_header_admin("Affichage des articles");

if (isset($_GET['trashed'])) 
{

    BlogArticle::_deleteArticle($_GET['article']);
}
?>
    <div class="row">
        <table class="dif">
        <?php
foreach (BlogArticle::_getArticles() as $v) 
{
    echo "<a href=\"new-post.php?article=" . $v['ida'] . "\">" . $v['title'] . "</a>
                <button class=\"activeArticle\" id='active_article_" . $v['ida'] . "'>Activer</button>
                <button class=\"supprimerArticle\" id='supprimer_article_" . $v['ida'] . "'>
                    <a href=\"affichage-article.php?article=" . $v['ida'] . "&trashed=true\">Supprimer
                    </a>
                </button>
                <br />
                 ";
}
?>
        </table>
    </div>
    <script type="text/javascript" src="./js/mod/active_article.js"></script>

<?php

get_footer_admin();
