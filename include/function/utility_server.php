<?php

/**
 * Here are all functions to use for server
 *
 * @package Ebrid
 * @since Version 0.1
 * @version 0.2
 */

/**
 * Get or set an element in the session
 * To get an element: session('element');
 * To set an element: session('element', 'value');
 *
 * @param string $key the element key
 * @param mixed $val the element value
 * @return mixed -Return the value if you use the getter function
 *               -Return a boolean if you use the setter function
 * @since Version 0.1
 * @version 0.2
 */
function session() {
    $argc = func_num_args();
    $argv = func_get_args();

    if($argc == 1){
        $key = $argv[0];
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
    }else if($argc == 2){
        $key = $argv[0];
        $val = $argv[1];

        return (bool)($_SESSION[$key] = $val);
    }

    return null;
}

/**
 * Check if the page called is on browser
 *
 * @return bool
 * @since Version 0.1
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
 * @since Version 0.1
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
 * @since Version 0.1
 */
function actual_page($str) {
    return $str == $_SERVER['REQUEST_URI'];
}

/**
 * Check if an user is connected
 * Return the user connected
 * If no one is connected, return empty User class
 *
 * @return \User
 * @since Version 0.1
 * @version 0.2
 */
function user_connected() {
    $uid = session('uid');
    return new User($uid);
}

/**
 * Get the current $_REQUESTURI
 * 
 * @return string
 * @since Version 0.1
 */
function get_current_url(){
    return $_SERVER['REQUEST_URI'];
}

/**
 * Check if a post contains all
 * the datas required
 *
 * @param string $index the page to check
 * @return bool
 * @since Version 0.2
 * @version 0.2
 */
function post($index, $post){
    /**
     * We define all the posts that we
     * want to check.
     * Usage: - $checker contains the require posts
     *        - you can make a simple check just to verify
     *          if you have an index in post using the index
     *          of the post in value of the checker.
     *        - you can make regex verification using the index
     *          of the post in index of the checker and as value
     *          write the regex
     */
    switch ( $index ) {
        case 'manage-user':
            $checker = array(
                'modify-first-name' => "#^[a-zA-Z\-\' -à]+$#",
                'modify-last-name' => "#^[a-zA-Z\-\' -à]+$#"
            );
            break;        
        default:
            $checker = array();
            break;
    }

    foreach ($checker as $key => $val) {
        if( is_numeric($key)){
            if( !isset($post[$val]) ) return false;
        }else{
            if( !isset($post[$key]) || !preg_match($val, $post[$key]) ){
                return false;
            }
        }
    }

    return true;
}
