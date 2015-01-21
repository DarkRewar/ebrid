<?php

/**
 *  Load all you need for the admin panel
 *
 *  @package Ebrid
 */

require_once( dirname(dirname(__FILE__)) . '/include/loader.function.php');

if(is_request(__FILE__)) redirect('admin-panel');

require_once( dirname(dirname(__FILE__)) . '/include/loader.class.php');
require_once( dirname(__FILE__) . '/include/loader.class.php');

require_once( dirname(dirname(__FILE__)) . '/include/db.php');