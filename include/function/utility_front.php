<?php

/**
 *  Here are all functions to use in front
 *
 *  @package Ebrid
 */

/**
 *  Add an error to log messages
 *
 *  @param string $log logs
 *  @param string $message the error message
 *  @since 0.1
 */
function add_error(&$log, $message){
    if(!is_array($log)) return;

    $log[] = array(
        "type" => "Error",
        "message" => $message
    );
}

/**
 *  Add a success to log messages
 *
 *  @param string $log logs
 *  @param string $message the error message
 *  @since 0.1
 */
function add_success(&$log, $message){
    if(!is_array($log)) return;

    $log[] = array(
        "type" => "Success",
        "message" => $message
    );
}