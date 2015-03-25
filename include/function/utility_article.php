<?php

/**
 * Fichier utility_article.php
 *
 * PHP version 5
 *
 * @category Utility
 * @package Ebrid
 * @license http://opensource.org/licenses/MIT
 * @link http://ebrid.lignusdev.com
 * @since Version 0.1
 */

/**
 * Get all the articles
 * of the current page
 *
 * @return array
 * @since Version 0.1
 */
function articles(){
    global $articles;
    return $articles;
}

/**
 * Get articles with the uri of the
 *
 *
 * @param string $uri the uri of the page
 * @return array
 * @since Version 0.1
 */
function get_article_with_uri($url = ""){
    global $rewrite;

    $return = array();

    $currentUrl = get_current_url();
    if(get_page_type($currentUrl) == "home"){
        $return = BlogArticle::_getArticles();
    }else{
        $params = $rewrite->getArguments($currentUrl);
        $single =  BlogArticle::_query($params);
        if($single !== null){
            $return[] = $single->toArray();
        }
    }

    return $return;
}

/**
 * Draw the article link
 *
 * @param array $article the article infos
 * @return string
 * @since Version 0.1
 */
function draw_link_article($article){
    global $rewrite;

    $date = strtotime($article['date']);
    $params = array(
        'article_id' => $article['ida'],
        'article_name' => $article['url'],
        'article_year' => date('Y', $date),
        'article_month' => date('m', $date),
        'article_day' => date('d', $date)
    );

    echo $rewrite->buildWith($params);
}

/**
 * Verify if there is only one
 *
 *
 * 
 * @return bool
 * @since Version 0.1
 */
function only_one(){
    global $articles;
    
    if(count($articles) == 1){
        return true;
    }else{
        return false;        
    }
}