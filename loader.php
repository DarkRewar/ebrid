<?php

/**
 * Load all you need for the front panel
 *
 * @package Ebrid
 * @since Version 0.1
 * @version 0.2
 */
require_once dirname(__FILE__) . '/settings.php';

require_once EBRIDINC . '/loader.interface.php';
require_once EBRIDINC . '/loader.function.php';
require_once EBRIDINC . '/loader.class.php';

require_once EBRIDINC . '/instantiate.php';

get_page_theme();