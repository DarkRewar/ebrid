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

/**
 *  Draw the tree category for the post-new
 *
 *  @param array $categories the list of the categories 
 *                           that we need to check
 *  @param array $array the tree (empty for all the tree)
 *  @param int $level the level of the category in the tree,
 *                    0 is the top, the super parent category
 *  @since 0.1
 */
function draw_tree_category($categories = array(), $array = array(), $level = 0){
    if(empty($array)) $array = BlogCategory::_getTree();
    $ul = isset($array[0]['idc_parent'])&&$array[0]['idc_parent']=='0'?true:false;

    if($ul) echo '<ul>';

    foreach ($array as $k => $v) {
        echo '<li><label><input type="checkbox" value="'.$v['idc'].'" name="categories[]" data-parent="'
            .$v['idc_parent'].'"'
            .(in_array($v['idc'], $categories)?'checked':null).' />'
            .str_repeat('&nbsp;', 4*$level+1)
            .$v['name']
            .'</label></li>';

        if(!empty($v['leafs'])) draw_tree_category($categories, $v['leafs'], $level+1);
    }

    if($ul) echo '</ul>';
}