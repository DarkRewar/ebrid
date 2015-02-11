<?php

/**
 *  Load all you need for the admin panel
 *
 *  @package Ebrid
 */

/**
 *  We need to define a messages warning, success or error
 *  to treat those later or to prevent the user.
 */
$_messages = array();

require_once( dirname(dirname(__FILE__)) . '/include/loader.function.php' );
require_once( dirname(__FILE__) . '/include/loader.admin.function.php' );

if(is_request(__FILE__)) redirect('admin-panel');

require_once( dirname(dirname(__FILE__)) . '/include/loader.class.php' );
require_once( dirname(__FILE__) . '/include/loader.class.php' );

require_once( dirname(dirname(__FILE__)) . '/include/db.php' );

require_once( dirname(dirname(__FILE__)) . '/include/instantiate.php' );