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

/**
 *  Vérifie si un utilisateur est connecté
 *
 *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 *  @return bool
 */
function isConnected(){
    if(isset($_SESSION['id'])) return true;
    return false;
}

/**
 *  Vérifie si un utilisateur est admin
 *
 *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 *  @return bool
 */
function isAdmin(){
    if(!isConnected()) return false;
    $u = new User($_SESSION['id']);
    return $u->isAdmin();
}

/**
 *  Alert
 *
 *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 *  @param string $msg le message d'alerte
 *  @param string $type le type d'alerte
 *  @return string
 */
function alert($msg, $type = "error"){
    return '<div class="message '.$type.'">
        '.$msg.'
        <a class="close">×</a>
    </div>';
}

/**
 *  Vérifie le pseudo d'un utilisateur est conforme
 *
 *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 *  @param string $name le pseudo
 *  @return bool
 */
function verifPseudo($name = null) 
{
    if (is_null($name)) return false;
    if (!preg_match("#^[a-zA-Z0-9]{4,40}$#", $name)) 
    {
        return false;
    }
    return true;
}

/**
 *  Vérifie si le mail est conforme
 *
 *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 *  @param string $mail le mail de l'user
 *  @return bool
 */
function verifMail($mail = null) 
{
    if (is_null($mail)) return false;
    if (!preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,4}$#", $mail)) 
    {
        return false;
    }
    return true;
}

/**
 *  Vérifie si le mot de passe est conforme
 *
 *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 *  @param string $pswd le mot de passe user
 *  @return bool
 */
function verifPassword($pswd = null) 
{
    if (is_null($pswd)) return false;
    if (!preg_match("#^[\w\.\#\-\s]{6,}$#", $pswd)) 
    {
        return false;
    }
    return true;
}

/**
 *  Vérifie si le commentaire est conforme
 *
 *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 *  @param string $com le commentaire
 *  @return bool
 */
function verifCom($com = null) 
{
    if (is_null($com)) return false;
    if (!preg_match("#^[\w\.\#\-\s\'\"\(\)]{1,}$#", $com)) 
    {
        return false;
    }
    return true;
}


/**
 *  Vérifie si c'est un int
 *
 *  @author Curtis Pelissier <curtis.pelissier@laposte.net>
 *
 *  @param mixed $int le param
 *  @return bool
 */
function checkInt($int){
    if(is_object($int)) return false;
    elseif(is_array($int)) return false;
    elseif(!preg_match("#^[\d]+$#", $int)) return false;
    return true;
}