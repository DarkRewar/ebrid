<?php

/**
 * Fichier Ebrid.RewriteRule.php
 *
 * PHP version 5
 *
 * @category Ebrid
 * @package Ebrid
 * @license http://opensource.org/licenses/MIT
 * @link http://ebrid.lignusdev.com
 * @since Version 0.1
 */

/**
 * Class RewriteRule
 *
 * @category Ebrid
 * @package Ebrid
 * @since Version 0.1
 */
class EbridRewriteRule
{
    private $rawUrl;
    private $parsedUrl;
    
    private $itemsAvailable = array(
        'article_id' => '[\d]+',
        'article_name' => '[\w\-]+',
        'article_year' => '[\d]{4}',
        'article_month' => '[\d]{2}',
        'article_day' => '[\d]{2}',
        'category_id' => '[\d]+',
        'category_name' => '[\w]+'
    );
    
    public function __construct($url) {
        $this->rawUrl = $url;
        $this->parseUrl();
    }
    
    /**
     * Parse all informations in an array
     *
     * @return self
     * @since Version 0.1
     */
    public function parseUrl() {
        $url = $this->rawUrl;
        
        $parseArray = array();
        
        while (preg_match('#\{.*\}#Usi', $url)) {
            $regex = "#^(.*)\{(.*)\}(.*)$#Usi";
            $parseArray[] = preg_replace($regex, '$2', $url);
            $url = preg_replace($regex, '$1$3', $url);
        }
        
        $this->parsedUrl = $parseArray;
        return $this;
    }

    /**
     * Build an URL from the informations
     *
     * @param array $params the informations array
     * @return string
     * @since Version 0.1
     */
    public function buildWith($params){
        $url = addslashes($this->rawUrl);

        foreach ($this->parsedUrl as $v) {
            if(isset($params[$v]) ){
                while (preg_match('#\{'.$v.'\}#Usi', $url)) {
                    $regex = "#^(.*)\{$v\}(.*)$#Usi";
                    $url = preg_replace($regex, '${1}'.$params[$v].'${2}', $url);
                }
            }
        }

        if($url == $this->rawUrl) return '/'; 
        return $url;
    }

    /**
     * Check if a keyword is available
     * and it's correct from the regex
     *
     * @param mixed $keyword The keyword in parse
     * @return bool
     * @since Version 0.1
     */
    public function checkKeyword($keyword){
        if(
            isset($this->itemsAvailable[$keyword]) && 
            preg_match('#^'.$this->itemsAvailable[$keyword].'$#', $keyword)
        ){
            return true;
        }
        return false;
    }

    /**
     * Build the regex url
     * 
     * @return string
     * @since Version 0.1
     */
    public function buildRegex(){
        $regex = $this->rawUrl;

        foreach ($this->itemsAvailable as $k => $v) {
            $localRegex = "#^(.*)\{($k)\}(.*)$#Usi";
            while(preg_match($localRegex, $regex)){
                $regex = preg_replace($localRegex, '($1)('.$v.')($3)', $regex);
            }
        }

        $regex = "#$regex#";
        return $regex;
    }

    /**
     * Get arguments from the current uri
     *
     * @param string $currentUrl the current request_uri
     * @return array the params array for the query
     * @since Version 0.1
     */
    public function getArguments($currentUrl){
        $regex = $this->buildRegex();
        $res = array();

        if(!preg_match($regex, $currentUrl)){
            return $res;
        }

        $strokeUrl = array();
        $raw = $this->rawUrl;
        while(preg_match("#\{.*\}#Usi", $raw)){
            $localRegex = "#^(.*)(\{.*\})(.*)$#Usi";
            $strokeUrl[] = preg_replace($localRegex, '$1$2', $raw);
            $raw = preg_replace($localRegex, '$3', $raw);
        }

        foreach ($strokeUrl as $k => $v) {
            $key = preg_replace("#^(.*)\{(.*)\}$#", "$2", $v);
            $localRegex = "#^(.*)(\{.*\})$#";
            $needRegex = $this->itemsAvailable[$key];

            $newRegex = preg_replace($localRegex, '${1}('.$needRegex.')(.*)', $v);

            if(preg_match("#$newRegex#", $currentUrl)){
                $res[$key] = preg_replace("#$newRegex#", '$1', $currentUrl); 
                $currentUrl = preg_replace("#$newRegex#", '$2', $currentUrl);             
            }
        }

        return $res;
    }
}
