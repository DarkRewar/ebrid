<?php

/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');

get_header_admin("Accueil");

?>

<div class="row">
    <h1 class="heading">Dashboard</h1>
    <div class="block-pres col s-range-12 m-range-6 l-range-4">
        <header>
            <h1>Une idée ? Un brouillon !</h1>
        </header>
        <section>
            <textarea placeholder="Ecrire un brouillon"></textarea>
        </section>
        <footer>
            <input class="button expand info" value="Sticker" />
        </footer>
    </div>
    <div class="block-pres col s-range-12 m-range-6 l-range-4">
        <header>
            <h1>Derniers articles</h1>
        </header>
        <section>
            <ul class="classic">
                <?php foreach(BlogArticle::_getArticles() as $a){
                    echo "<li><a href=\"new-post.php?article=".$a['ida']."\">".$a['title']."</a></li>";
                }?>
            </ul>
        </section>
        <footer>
            <button class="expand info">Voir les articles</button>
        </footer>
    </div>
</div>

<?php

get_footer_admin();