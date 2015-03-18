<?php

/**
 * Here are all functions to use for server
 *
 * @package Ebrid
 */

/**
 * Check if the page called is on browser
 *
 * @return bool
 * @since 0.1
 */
function is_request($file) {
    if (isset($_SERVER) && _slash($file) == _slash($_SERVER['SCRIPT_FILENAME'])) {
        return true;
    }
    return false;
}

/**
 * Redirect user to a page
 *
 * @param string $page name page
 * @param boolean $custom set TRUE if you want to redirect
 *                        to a custom location
 * @since 0.1
 */
function redirect($str = null, $custom = false) {
    if ($custom) {
        header("Location: " . $str);
    } 
    else {
        $r = array(
            'admin-panel' => "/admin/",
            'login' => '/admin/login.php'
        );
        
        if (isset($r[$str])) header("Location: " . $r[$str]);
        else {
            header("Location: /");
        }
    }
}

/**
 * The actual page
 *
 * @param string $str the page
 * @return bool
 * @since 0.1
 */
function actual_page($str) {
    return $str == $_SERVER['REQUEST_URI'];
}

/**
 * Get an element in the session
 *
 * @param string $str the element to take
 * @return mixed
 * @since 0.1
 */
function get_session($str) {
    if (isset($_SESSION[$str])) {
        return $_SESSION[$str];
    }
    return null;
}

/**
 * Get an element in the session
 *
 * @param string $id the element id to set
 * @param string $str the element to set
 * @since 0.1
 */
function set_session($id, $str) {
    $_SESSION[$id] = $str;
}

/**
 * Check if an user is connected
 * Return the user connected
 * If no one is connected, return empty class
 *
 * @return User
 * @since 0.1
 */
function user_connected() {
    $uid = get_session('uid');
    return new User($uid);
}
