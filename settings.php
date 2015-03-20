<?php
/**
 * This file define all constants
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

define('THEME', 'default');

/**
 * The REWRITE RULE 
 *
 * @since Version 0.1
 */
define('REWRITE_RULE', '/?article={ida}');

?>