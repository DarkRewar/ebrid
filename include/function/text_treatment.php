<?php

/**
 *  Here are all functions to treat text
 *  All functions which treats text is marked
 *  with an underscore before.
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

/**
 *  Hash a text in sha256
 *
 *  @param string $str the string to hash
 *  @return string
 *  @since 0.1
 */
function _sha4($str){
    return hash('sha256', $str);
}