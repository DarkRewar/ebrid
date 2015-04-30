<?php

/**
 * Fichier utility_intent.php
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
 * Draw all intents for the
 * requested intent in argument
 *
 * @param string $intent the intent to draw
 * @return mixed
 * @since Version 0.2
 * @version 0.2
 */
function intent($intent){
    global $intents;

    if( 
        !is_array( $intents ) || 
        !isset( $intents[$intent] ) ||
        !is_array( $intents[$intent] )
    ){
        return false;
    }

    foreach ($intents[$intent] as $index => $value) {
        $value->draw();
    }
    return true;

}

/**
 * Add an intent to the global intents
 *
 * @param string $index the intent index
 * @param mixed $intent the index to do
 * @return bool
 * @since Version 0.2
 * @version 0.2
 */
function add_intent($index, $intent){
    global $intents;

    if( !is_array( $intents ) ){
        return false;
    }else if( 
        !isset($intents[$index]) ||
        !is_array($intents[$index]) 
    ){
        $intents[$index] = array();
    }

    $intents[$index][] = $intent;

    return true;
}

/**
 * Load intents
 *
 * @param &array $intents the array intent to load
 * @param array $plugins plugins to load in intents
 * @return bool
 * @since Version 0.2
 * @version 0.2
 */
function load_intents(&$intents, $plugins = array()){
    if( !is_array($intents) ){
        return false;
    }

    foreach ($plugins as $plugin) {
        if( class_exists($plugin) ){
            $active = new $plugin();
            add_intent($active->getEnvironment(), $active);
        }
    }
}