<?php

/**
 * Check a form
 *
 * @param array $post the form
 * @param array $verif the checker
 * @return bool
 * @since 0.1
 */
function _form($post, $verif) {
    foreach ($verif as $k => $v) {
        if (!isset($post[$k])) return false;
        if ((function_exists($v) && $v($post[$k])) || preg_match("#$v#", $post[$k])) {
            continue;
        } 
        else {
            var_dump($post[$k]);
            return false;
        }
    }
    return true;
}

/**
 * Check if all data in the post are ok
 *
 * @param array $post the array to check
 * @return bool
 * @since 0.1
 */
function form_new_post($post) {
    $a = array(
        'article_title' => '^[\w\s\!\?\:\.\-\\\/\'\" -à]{1,254}$',
        'article_content' => '.*'
        
        //, 'uid' => '^[\d]+$'
        
    );
    
    return _form($post, $a);
}

/**
 * Check if all data in the post are ok
 *
 * @param array $post the array to check
 * @return bool
 * @since 0.1
 */
function form_signup($post) {
    $a = array(
        'signup_nick' => 'checkNickname',
        'signup_mail' => 'checkEmail'
    );
    
    return _form($post, $a);
}

/**
 * Generate a revision and an article
 *
 * @param array $post about the revision
 * @return bool
 * @since 0.1
 */
function generate_revision($post) {
    $revision = BlogRevision::_generateWith($post);
    return $revision;
}
