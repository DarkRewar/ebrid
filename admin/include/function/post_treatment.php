<?php

/**
 *  Check if all data in the post are ok
 *
 *  @param array $post the array to check
 *  @return bool
 *  @since 0.1
 */
function form_new_post($post){
    $a = array(
        'article_title' => '^[\w\s\!\?\:\.\-\\\/\'\" -à]{1,254}$'
        , 'article_content' => '.*'
        //, 'uid' => '^[\d]+$'
    );

    foreach ($a as $k => $v) {
        if( !isset($post[$k])
            || !preg_match("#$v#", $post[$k]))
            return false;
    }

    return true;
}

/**
 *  Generate a revision and an article
 *
 *  @param array $post about the revision
 *  @return bool
 *  @since 0.1
 */
function generate_revision($post){
    $revision = BlogRevision::_generateWith($post);
    return $revision;
}