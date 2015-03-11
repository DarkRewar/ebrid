<?php

/**
 *  Load all you need for the front panel
 *
 *  @package Ebrid
 */

require( dirname(__FILE__) . '/settings.php' );
require( EBRIDINC . '/loader.function.php' );
require( EBRIDINC . '/loader.class.php' );

require_once( EBRIDINC . '/instantiate.php' );

get_page_theme();