<?php

/**
 *  Load all functions you need
 *
 * @package Ebrid
 */

/**
 *  Replace backslashes by slashes
 *  or revert
 *
 *  @param string $string
 *  @param bool $reverse if you want to
 *  @return string
 *  @since 0.1
 */
function _slash($string, $reverse = false){
    if($reverse){
        return str_replace('/', '\\', $string);
    }else{
        return str_replace('\\', '/', $string);
    }
}

/**
 *  Check if the page called is on browser
 *
 *  @return bool
 *  @since 0.1
 */
function is_request($file){
    if(
        isset($_SERVER) &&
        _slash($file) == _slash($_SERVER['SCRIPT_FILENAME'])
    ){
        return true;
    }
    return false;
}

/**
 *  Redirect user to a page
 *
 *  @param string $page name page
 *  @since 0.1
 */
function redirect($str = null){
    $r = array(
        'admin-panel' => "/admin/"
    );

    if(isset($r[$str]))
        header("Location: ".$r[$str]);
    else{
        header("Location: /");
    }
}