<?php

/**
 * Fichier utility_plugin.php
 *
 * PHP version 5
 *
 * @category Utility
 * @package Ebrid
 * @license http://opensource.org/licenses/MIT
 * @link http://ebrid.lignusdev.com
 * @since Version 0.2
 * @version 0.2
 */

/**
 * Get all active plugins in the
 * plugin directory
 *
 * @return array
 * @since Version 0.2
 * @version 0.2
 */
function get_active_plugins(){
    $plugins = array();

    $open = opendir( EBRIDDISPLAY . '/plugins');
    while ( ( $file = readdir($open) ) !== false ){
        if( $file === '..' || $file === '.' ){
            continue;
        }

        $plugins[] = preg_replace('#(.*)\.php$#', '$1', $file);
    }

    return $plugins;
}

/**
 * Load all plugins passed throught
 * parameters
 *
 * @param array $plugins list of plugins to include
 * @since Version 0.2
 * @version 0.2
 */
function load_plugins($plugins){
    foreach ($plugins as $plugin) {
        include EBRIDDISPLAY . '/plugins/' . $plugin . '.php';
    }
}