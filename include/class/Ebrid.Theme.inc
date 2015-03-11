<?php

/**
 *  Theme Builder for Ebrid
 */
class EbridTheme
{
    private $name;
    private $path;
    private $info;

    public function __construct($name, $path = null)
    {
        if(is_null($path)) $path = EBRIDDISPLAY . '/themes/';

        if(self::_exist($name, $path)){
            $this->name = $name;
            $this->path = $path;
            $this->buildInfo();
            // var_dump("Theme built");
        }else{
            $this->name = 'default';
            $this->path = EBRIDDISPLAY . '/themes/';
            $this->info = array();
            // var_dump("Theme not built");
        }
    }

    /**
     *  Get the real path of the theme
     *
     *  
     *  @return string
     *  @since 0.1
     */
    public function getPath(){
        return $this->path . $this->name;
    }

    /**
     *  Info Theme Builder
     *  Fill the array info
     *
     *  @return self
     *  @since 0.1
     */
    public function buildInfo(){
        $this->info = array();
        $themeDir = $this->path . $this->name;
        $finfo = fopen($themeDir . '/.info', 'r');
        if($finfo){
            while(($line = fgets($finfo)) !== false){
                $regex = '#^(.*)[\s]*:[\s]*(.*)$#';
                if(!preg_match($regex, $line)) continue;
                $key = trim(preg_replace($regex, '$1', $line));
                $val = trim(preg_replace($regex, '$2', $line));
                if(is_null($key) || $key === '') continue;
                $this->info[$key] = $val;
            }
        }
        fclose($finfo);
        return $this;
    }

    /**
     *  Static functions
     */

    /**
     *  Verify if a theme exist
     *
     *  @param string $name The name of theme dir
     *  @param string $path The path of theme dir
     *  @return bool
     *  @since 0.1
     */
    static public function _exist($name, $path){
        $theme = $path . $name;
        $filesToNeed = array('.info', 'index.php', 'style.css');

        if(
            !file_exists($theme) 
            || !is_dir($theme)
        ){
            return false;
        }else{
            foreach ($filesToNeed as $file) {                
                if(!file_exists($theme . '/' . $file) OR !is_file($theme . '/'. $file))
                    return false;
            }
        }
        return true;
    }
}