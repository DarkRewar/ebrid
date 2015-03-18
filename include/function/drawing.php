<?php

/**
 *  Functions which draws some things
 *  for the front end
 *
 *  @package Ebrid
 */

/**
 * Function which draws stylesheet ou scripts
 * @param  string  $type   the type of drawing
 * @param  mixed   $value  the value in the draw container
 * @since 0.1
 */
function _draw($type, $value){
    switch ($type) {
        case 'style':
            echo '<link rel="stylesheet" type="text/css" href="' . $value . '" />';
            break;    
        case 'script':
            echo '<script type="text/javascript" src="' . $value . '"></script>';
            break;    
        default:
            break;
    }
}