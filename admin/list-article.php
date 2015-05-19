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
    redirect("list-article.php", true);
}
?>
    <div class="row">
        <table class="dif">
            <thead>
                <tr>
                    <th>Articles</th>
                    <th>Modifications articles</th>
                    <th>Publier l'article</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
        <?php
foreach (BlogArticle::_getArticles() as $v) 
{
    echo "
            <tr>
                <td>
                    <a style=\"color:#000\" href=\"new-post.php?article=" . $v['ida'] . "\">" . $v['title'] . "</a>
                </td>
                <td>
                    <a class=\"button info rounded\" href=\"new-post.php?article=" . $v['ida'] . "\">Modifier</a>
                </td>
                <td>
                    <button class=\"activeArticle success rounded\" id='active_article_" . $v['ida'] . "'>Activer</button>
                </td>
                <td>    <a id='supprimer_article_" . $v['ida'] . "' class=\"supprimerArticle button error rounded\" href=\"?article=" . $v['ida'] . "&trashed=true\">Supprimer
                        </a>
                    <br />
                </td>
            </tr>
                
                 ";
}
?>
            
            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="./js/mod/active_article.js"></script>

<?php
get_footer_admin();
