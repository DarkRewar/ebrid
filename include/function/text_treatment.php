<?php

/**
 *  Here are all functions to treat text
 *
 *  @package Ebrid
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