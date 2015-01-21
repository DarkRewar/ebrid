<?php

/**
 *  Here are all functions to use for server
 *
 *  @package Ebrid
 */

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