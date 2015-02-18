<?

$db = mysqli_connect("127.0.0.1", "root", "", "ebrid");
if (mysqli_connect_errno($db)) {
    var_dump("Echec lors de la connexion à MySQL : " . mysqli_connect_error());
    die();
}



/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');


BlogArticle::_getArticles();
BlogArticle::_getRevisions();
BlogArticle::_getLastRevision();

?>

<div>
    <a href="new-post.php">Créer un nouvel article</a>
</div>
</html>