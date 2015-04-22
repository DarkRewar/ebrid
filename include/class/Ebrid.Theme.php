<?php
/**
 * Fichier Ebrid.Theme.php
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
 * Class Theme
 *
 * @category Ebrid
 * @package Ebrid
 * @since Version 0.1
 */
class EbridTheme
{
    private $name;
    private $preview;
    private $path;
    private $pathRaw = '/display/themes/';
    private $info;

    public function __construct($name, $path = null)
    {
        if(is_null($path)) $path = EBRIDDISPLAY . '/themes/';

        if(self::_exist($name, $path)){
            $this->name = $name;
            $this->path = $path;
            $this->buildInfo();
        }else{
            $this->name = 'default';
            $this->path = EBRIDDISPLAY . '/themes/';
            $this->info = array();
        }
    }

    /**
     * Get the name of the theme
     *
     * @return string
     * @since Version 0.1
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Get the screenshot of the theme
     *
     * @return mixed
     * @since Version 0.1
     */
    public function getScreenshot(){
        $fileRaw = $this->pathRaw . $this->name . '/screenshot.png';
        $file = $this->path . $this->name . '/screenshot.png';
        
        if(file_exists($file)){
            return $fileRaw;
        }
        return null;
    }

    /**
     *  Get the real path of the theme
     **
     *  @param bool $raw get the raw path or not
     *  @return string
     *  @since 0.1
     */
    public function getPath($raw = false){
        if($raw)
            return $this->pathRaw . $this->name;
        else
            return $this->path . $this->name;
    }

    /**
     * Get a or all infos
     *
     * @param string $key key of the info
     * @return mixed
     * @since Version 0.1
     */
    public function getInfos($key = null){
        if($key === null){
            return $this->info;
        }else if(isset($this->info[$key])){
            return $this->info[$key];
        }
        return null;
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
     * Check if a theme has the specified page
     *
     * @param string $name the file name
     * @return bool
     * @since Version 0.2
     */
    public function hasPage($name){
        $file = $this->getPath() . '/' . $name . '.php';
        return file_exists($file);
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
    static public function _exist($name, $path = null){
        if($path === null){
            $path = EBRIDDISPLAY . '/themes/';
        }

        $theme = $path . $name;
        $filesToNeed = array('.info', 'index.php', 'style.css');

        if(
            !file_exists($theme) 
            || !is_dir($theme)
        ){
            return false;
        }else{
            foreach ($filesToNeed as $file) {                
                if(!file_exists($theme . '/' . $file) OR !is_file($theme . '/'. $file)){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get all theme available in the
     * theme repository
     *
     * @param int $page
     * @return array
     * @since Version 0.1
     */
    static public function _getAll($page = 0){
        $themesArray = array();

        $themePath = EBRIDDISPLAY . '/themes/';
        $dir = opendir($themePath);

        $readThemes = 0;
        while( false !== ( $theme = readdir($dir) ) ){
            if($theme === '.' || $theme === '..'){
                continue;
            }

            $themesArray[$theme] = new EbridTheme($theme);

            ++$readThemes;
        }

        return $themesArray;
    }
}