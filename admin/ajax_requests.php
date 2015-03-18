<?php

require( dirname(__FILE__) . '/loader.php' );

if(isset($_POST['requested'])){
    if($_POST['requested'] == 'addCategory'){
        $cat = new BlogCategory();
        echo json_encode($cat->generateWith($_POST));
    }else if($_POST['requested'] == "activeArticle"){
        BlogArticle::_activate($_POST['id']);
        echo "true";
    }else{
        echo json_encode(array("e"=>"error","message"=>"You can't access to this page"));
    }
}else{
    echo json_encode(array("e"=>"error","message"=>"You can't access to this page"));
}
