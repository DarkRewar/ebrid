<?php

/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');

get_header_admin("Affichage des articles");

if(isset($_POST['activer'])){
    BlogArticle::_activate($ida);

}
?>
<body>
    <div>
        <form method="post" action="index.php">
            <?php
                foreach(BlogArticle::_getArticles() as $v){
                    echo "<a href=\"new-post.php?article=".$v['ida']."\">".$v['title']."</a><input type='checkbox' name='activer'>Activer</input><br />
                     ";  
                }
            ?>

            <input type="submit">
        </form>
</div>
</body>
</html>

