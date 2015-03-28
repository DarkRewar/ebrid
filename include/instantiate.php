<?php
/**
 * File instantiate.php
 *
 * @package Ebrid
 * @since Version 0.1
 */

session_start();

Database::_init();

if(!is_null(Database::_lastError())){
    Database::_lastError()->getMessage();
    die;
}

/**
 * Instantiate the current user
 * if he's  connected.
 * If he's not, instantiate an
 * empty User object.
 *
 * @since Version 0.1
 * @version 0.1
 */
$user = user_connected();

/**
 * Instantiate the settings of
 * Ebrid that we need to launch
 * functions.
 *
 * @var object
 */
$settings = new EbridSettings( 'settings.php' );

/**
 * Instantiate the current active
 * theme to display it to visitors
 *
 * @since Version 0.1
 * @version 0.1
 */
$theme = new EbridTheme(THEME);

/**
 * Instantiate the Rewrite Rule
 * to get the current page
 *
 * @since Version 0.1
 * @version 0.1
 */
$rewrite = new EbridRewriteRule(REWRITE_RULE);

/**
 * Variable which contains all
 * the articles of the current page
 *
 * @since Version 0.1
 * @version 0.1
 */
$articles = get_article_with_uri(get_current_url());
