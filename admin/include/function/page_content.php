<?php

/**
 *  Get the header of the page
 *
 *  @param string $title the title of the page
 *  @since 0.1
 */
function get_header_admin($title = null){
    require_once( EBRIDPATH . '/admin/page.header.php');
}

/**
 *  Get the footer of the page
 *
 *  @since 0.1
 */
function get_footer_admin(){
    require_once( EBRIDPATH . '/admin/page.footer.php');
}

/**
 *  Verify if there is logs
 *
 *  @return bool
 *  @since 0.1
 */
function have_log(){
    if(!isset($GLOBALS['_messages'])) return false;

    global $_messages;
    if(!empty($_messages)) return true;
    return false;
}