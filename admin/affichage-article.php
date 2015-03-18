<?php

/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');

get_header_admin("Affichage des articles");



?>
<body>
    <div>
        <?php
            foreach(BlogArticle::_getArticles() as $v){
                echo "<a href=\"new-post.php?article=".$v['ida']."\">".$v['title']."</a><button class=\"activeArticle\" id='active_article_".$v['ida']."'>Activer</button><br />
                 ";  
            }
        ?>

    </div>
    <script type="text/javascript" src="./js/mod/active_article.js"></script>
</body>
</html>

