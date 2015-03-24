<?php
/**
 * Load all you need for the front panel
 *
 * @package Ebrid
 * @since Version 0.1
 */

require( dirname(__FILE__) . '/settings.php' );
require( EBRIDINC . '/loader.function.php' );
require( EBRIDINC . '/loader.class.php' );

require_once( EBRIDINC . '/instantiate.php' );

$ida = BlogArticle::_query(array(
    "url" => "salut",
    "status" => "0",
    "date_year" => "2015"
));

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <?php var_dump($ida); ?>
</body>
</html>