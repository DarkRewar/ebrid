<?php

/**
 *  This file define all constants
 *  
 *  @package Ebrid
 */

session_start();

define('EBRIDPATH', dirname(dirname(__FILE__)));

define('DBHOST', 'localhost');
define('DBNAME', 'ebrid');
define('DBUSER', 'root');
define('DBPASSWORD', '');

Database::_init();

if(!is_null(Database::_lastError())){
    if(isset($_messages)){
        add_error($_messages, Database::_lastError()->getMessage());
    }
}

# Theme Active
define('THEME', 'default');
