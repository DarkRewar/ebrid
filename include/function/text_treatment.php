<?php

/**
 * Here are all functions to treat text
 * All functions which treats text is marked
 * with an underscore before.
 *
 * @package Ebrid
 * @since Version 0.1
 */

/**
 * Replace backslashes by slashes
 * or revert
 *
 * @param string $string
 * @param bool $reverse if you want to
 * @return string
 * @since Version 0.1
 */
function _slash($string, $reverse = false) {
    if ($reverse) {
        return str_replace('/', '\\', $string);
    } 
    else {
        return str_replace('\\', '/', $string);
    }
}

/**
 * Hash a text in sha256
 *
 * @param string $str the string to hash
 * @return string
 * @since Version 0.1
 */
function _sha4($str) {
    return hash('sha256', $str);
}

/**
 * Set a datetime to the website's config format
 *
 * @param string $date the datetime to format
 * @return string
 * @since Version 0.2
 */
function _date($date){
    $date = strtotime($date);
    $datetime = '\l\e ' . DATEFORMAT . ' \à ' . TIMEFORMAT;
    return date($datetime, $date);
}

/**
 * Delete html markups
 *
 * @param string $str the string
 * @return string
 * @since Version 0.2
 */
function subMarkup($str) {
    $regexLong = "#^(.*)<.*>(.*)</.*>(.*)$#Usi";
    while (preg_match($regexLong, $str)) {
        $str = preg_replace($regexLong, '$1$2$3', $str);
    }

    $regexSingle = "#^(.*)<.*/>(.*)$#Usi";
    while (preg_match($regexSingle, $str)) {
        $str = preg_replace($regexSingle, '$1$2', $str);
    }
    
    return $str;
}

/**
 * Show a number of words
 *
 * @param string $str the string to display
 * @return string
 * @since Version 0.2
 */
function displayWords($str, $number = 20) {
    $final = null;
    $words = explode(' ', $str);
    
    if(count($words) < 30) $number = count($words);

    for ($i = 0; $i < $number; ++$i) {
        $final.= $words[$i] . ' ';
    }
    
    unset($words);
    return $final;
}

