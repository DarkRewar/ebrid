<?php

/**
 * Here are all functions to use in front
 *
 * @package Ebrid
 */

/**
 * Echo things
 *
 * @param mixed... arguments to echo
 * @since Version 1
 */
function __(){
    $argc = func_num_args();
    $argv = func_get_args();

    foreach ($argv as $thing) {
        echo $thing;
        if($argc > 1){
            echo ' ';
        }
    }
}

/**
 * Add an error to log messages
 *
 * @param string $log logs
 * @param string $message the error message
 * @since Version 0.1
 */
function add_error(&$log, $message) {
    if (!is_array($log)) return;
    
    $log[] = array(
        "type" => "error",
        "message" => $message
    );
}

/**
 * Add a success to log messages
 *
 * @param string $log logs
 * @param string $message the error message
 * @since Version 0.1
 */
function add_success(&$log, $message) {
    if (!is_array($log)) return;
    
    $log[] = array(
        "type" => "success",
        "message" => $message
    );
}

/**
 * Vérifie si un utilisateur est connecté
 *
 * @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 * @return bool
 */
function isConnected() {
    if (isset($_SESSION['id'])) return true;
    return false;
}

/**
 * Vérifie si un utilisateur est admin
 *
 * @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 * @return bool
 */
function isAdmin() {
    if (!isConnected()) return false;
    $u = new User($_SESSION['id']);
    return $u->isAdmin();
}

/**
 * Alert
 *
 * @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 * @param string $msg le message d'alerte
 * @param string $type le type d'alerte
 * @return string
 */
function alert($msg, $type = "error") {
    return '<div class="message ' . $type . '">
        ' . $msg . '
        <a class="close">×</a>
    </div>';
}

/**
 * Vérifie le pseudo d'un utilisateur est conforme
 *
 * @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 * @param string $name le pseudo
 * @return bool
 */
function checkNickname($name = null) {
    if (is_null($name)) return false;
    if (!preg_match("#^[a-zA-Z0-9]{4,40}$#", $name)) {
        return false;
    }
    return true;
}

/**
 * Vérifie si le mail est conforme
 *
 * @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 * @param string $mail le mail de l'user
 * @return bool
 */
function checkEmail($mail = null) {
    if (is_null($mail)) return false;
    if (!preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,4}$#", $mail)) {
        return false;
    }
    return true;
}

/**
 * Vérifie si le mot de passe est conforme
 *
 * @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 * @param string $pswd le mot de passe user
 * @return bool
 */
function checkPassword($pswd = null) {
    if (is_null($pswd)) return false;
    if (!preg_match("#^[\w\.\#\-\s]{6,}$#", $pswd)) {
        return false;
    }
    return true;
}

/**
 * Vérifie si le commentaire est conforme
 *
 * @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 * @param string $com le commentaire
 * @return bool
 */
function checkCom($com = null) {
    if (is_null($com)) return false;
    if (!preg_match("#^[\w\.\#\-\s\'\"\(\)]{1,}$#", $com)) {
        return false;
    }
    return true;
}

/**
 * Vérifie si c'est un int
 *
 * @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 * @param mixed $int le param
 * @return bool
 */
function checkInt($int) {
    if (is_object($int)) return false;
    elseif (is_array($int)) return false;
    elseif (!preg_match("#^[\d]+$#", $int)) return false;
    return true;
}

/**
 * Draw the name of the web site
 *
 * @since 0.1
 */
function draw_site_name() {
    echo SITENAME;
}

/**
 * Draw the URL of the website
 *
 * @since Version 0.1
 */
function draw_site_url(){
    echo $_SERVER['SERVER_NAME'];
}

/**
 * Get the page theme
 *
 * @since Version 0.1
 * @version 0.2
 */
function get_page_theme() {
    global $theme, $rewrite, $articles;
    
    $curUrl = get_current_url();
    $args_query = $rewrite->getArguments($curUrl);
    $typePage = get_page_type($curUrl);
    
    if ($typePage == 'home') {
        include ($theme->getPath() . '/index.php');
    } 
    elseif (count($args_query) == 0 || empty($articles)) {
        include ($theme->getPath() . '/404.php');
    } 
    else if( $typePage == 'blog' && $theme->hasPage('post') ){
        include ($theme->getPath() . '/post.php');
    }
    else {
        include ($theme->getPath() . '/index.php');
    }
}

/**
 * Get the type of the page
 * (if its a homepage, article,
 * forum, others...)
 *
 * @param string $currentUrl the current Url
 * @return string
 * @since Version 0.1
 */
function get_page_type($currentUrl) {
    if (preg_match("#^/$#", $currentUrl)) {
        return "home";
    } 
    elseif (preg_match("#^forum/#", $currentUrl)) {
        return "forum";
    } 
    else {
        return "blog";
    }
}

/**
 * Draw the framework CSS that Ebrid has
 *
 * @param string $name The name of the framework
 * @param int $version The version of the framework
 * @since Version 0.1
 * @version 0.2
 */
function use_ebrid_css($name = "leaframe", $version = 2) {
    switch ($name) {
        case 'bootstrap':
            _draw('style', "/display/css/bootstrap/$version/bootstrap.min.css");

            if( $version == 2 ){
                _draw('style', "/display/css/bootstrap/$version/bootstrap-responsive.min.css");
            }

            break;

        case 'foundation':
            _draw('style', '/display/css/foundation/foundation.min.css');
            _draw('style', '/display/css/foundation/normalize.min.css');
            break;

        default:
            _draw('style', '/display/css/leaframe/leaframe.min.css');
            break;
    }
}

/**
 * Get the path of the active theme
 *
 * @return string
 * @since Version 0.1
 */
function theme_path() {
    global $theme;
    return $theme->getPath(true);
}

/**
 * Get the style of the active theme
 *
 * @return string
 * @since Version 0.2
 */
function theme_style() {
    return theme_path() . '/style.css';
}

/**
 * Get the script of the active theme
 *
 * @param  string  $type   the type of drawing
 * @param  mixed   $value  the value in the draw container
 * @since Version 0.2
 */
function theme_draw($type, $value) {
    _draw($type, theme_path() . $value);
}
