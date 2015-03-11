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

/**
 *  Draw the list
 *
 *  @param array $options the options of the drawer
 *  @since 0.1
 */
function draw_list_category($option = array(), $array = array(), $level = 0){
    $options = array(
        "container" => array(
            "markup" => "ul",
            "name" => "",
            "class" => array(),
            "id" => "",
            "style" => ""
        ),
        "list" => array(
            "markup" => "li",
            "name" => "",
            "class" => array(),
            "id" => "",
            "style" => "",
            "value" => "",
            "content" => ""
        )
    );

    $options = array_replace_recursive($options, $option);

    $array = (!empty($array))?$array:BlogCategory::_getTree();

    if($level == 0) draw_open_element($options["container"]);

    foreach ($array as $k => $v) {
        $v['name'] = str_repeat('-', 2*$level).$v['name'];
        draw_element($options['list'], $v);

        if(!empty($v['leafs'])) draw_list_category($option, $v['leafs'], $level+1);
    }

    if($level == 0) draw_close_element($options['container']);
}

function draw_open_element($option, $content = array()){
    if(!isset($option['markup'])) return;
    echo "<".$option['markup'];
    unset($option['markup']);

    if(isset($option['content'])) unset($option['content']);

    foreach ($option as $k => $v) {
        echo " ";

        if(is_array($v)){
            echo "$k=\"".implode($v, ' ').'"';
        }else{
            if(preg_match("#\#.*\##", $v)){
                $match = preg_replace("#\#(.*)\##", "$1", $v);
                if(isset($content[$match]))
                    echo "$k=\"".$content[$match].'"';
            }else{
                echo "$k=\"$v\"";
            }
        }
    }
    echo ">";
}

function draw_close_element($option){
    if(!isset($option['markup'])) return;
    echo "</".$option['markup'].">";
}

function draw_element($option, $content = array()){
    draw_open_element($option, $content);

    if(isset($option['content'])){
        if(preg_match("#\#.*\##", $option['content'])){
            $match = preg_replace("#\#(.*)\##", "$1", $option['content']);
            if(isset($content[$match]))
                echo $content[$match];
        }else{
            echo $options['content'];
        }
    }

    draw_close_element($option);
}