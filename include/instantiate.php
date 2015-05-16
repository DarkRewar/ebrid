<?php
/**
 * File instantiate.php
 *
 * @package Ebrid
 * @since Version 0.1
 */

session_start();

if (!defined('DBHOST') && !defined('DBNAME') && defined('DBUSER') && defined('DBPASSWORD')) {
    header('Location: /setup-config.php');
}

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
 * @var object
 * @since Version 0.1
 * @version 0.1
 */
$theme = new EbridTheme(THEME);

/**
 * Instantiate the Rewrite Rule
 * to get the current page
 *
 * @var object
 * @since Version 0.1
 * @version 0.1
 */
$rewrite = new EbridRewriteRule(REWRITE_RULE);

/**
 * Variable which contains all
 * the articles of the current page
 *
 * @var array
 * @since Version 0.1
 * @version 0.1
 */
$articles = get_article_with_uri(get_current_url());

/**
 * Variable which contains all intents
 * to draw/add/remove/set/get
 *
 * @var array
 * @since Version 0.2
 * @version 0.2
 */
$intents = array();

/**
 * Variable which contains all plugins 
 * which are in the plugins directory
 * and are activated
 *
 * @var array
 * @since Version 0.2
 * @version 0.2
 */
$plugins = get_active_plugins();

/**
 * Loaders
 */
load_plugins( $plugins );
load_intents( $intents , $plugins);