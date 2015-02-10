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