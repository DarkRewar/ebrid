<?php

/**
 *  This file define all constants
 *  
 *  @package Ebrid
 */
session_start();

define('EBRIDPATH', dirname(__FILE__));
define('EBRIDINC', EBRIDPATH . '/include');
define('EBRIDADMIN', EBRIDPATH . '/admin');
define('EBRIDDISPLAY', EBRIDPATH . '/display');

define('DBHOST', 'localhost');
define('DBNAME', 'ebrid');
define('DBUSER', 'root');
define('DBPASSWORD', '');

define('THEME', 'default');