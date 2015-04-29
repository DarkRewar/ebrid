<?php
/**
 * File settings.php
 *
 * This file define all constants
 * settings we need to load correctly
 * Ebrid and the website
 *
 * @package Ebrid
 * @since Version 0.1
 * @version Version 0.1
 */

define('EBRIDPATH', dirname(__FILE__));
define('EBRIDINC', EBRIDPATH . '/include');
define('EBRIDADMIN', EBRIDPATH . '/admin');
define('EBRIDDISPLAY', EBRIDPATH . '/display');

define('DBHOST', 'localhost');
define('DBNAME', 'ebrid');
define('DBUSER', 'root');
define('DBPASSWORD', '');

/**
 * The Theme that is used
 * for the website
 *
 * @since Version 0.1
 */
define('SITENAME', 'Ebrid WebSite');

/**
 * The Date Format that is used
 * for the website
 *
 * @since Version 0.1
 */
define('DATEFORMAT', 'd/m/Y');

/**
 * The Time Format that is used
 * for the website
 *
 * @since Version 0.1
 */
define('TIMEFORMAT', 'H:i:s');

/**
 * The Theme that is used
 * for the website
 *
 * @since Version 0.1
 */
define('THEME', 'showcase');

/**
 * The REWRITE RULE 
 *
 * @since Version 0.1
 */
define('REWRITE_RULE', '/blog/{article_id}-{article_name}');