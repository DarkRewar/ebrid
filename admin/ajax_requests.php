<?php

require( dirname(__FILE__) . '/loader.php' );

if(isset($_POST['requested'])){
    if($_POST['requested'] == 'addCategory'){
        $cat = new BlogCategory();
        echo json_encode($cat->generateWith($_POST));
    }else{
        echo json_encode(array("e"=>"error","message"=>"You can't access to this page"));
    }
}else{
    echo json_encode(array("e"=>"error","message"=>"You can't access to this page"));
}