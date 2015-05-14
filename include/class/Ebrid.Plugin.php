<?php

/**
 * File Ebrid.Plugin.php
 *
 * PHP version 5
 *
 * @category Plugin
 * @package Ebrid
 * @license http://opensource.org/licenses/MIT
 * @link http://ebrid.lignusdev.com
 * @since Version 0.2
 * @version 0.2
 */

/**
 * Class EbridPlugin
 * This class manage all plugins.
 * It enable, disable, remove, add a plugins.
 *
 * @category Plugin
 * @package Ebrid
 * @since Version 0.2
 * @version 0.2
 */
class EbridPlugin
{
    /**
     * Name of the plugin
     *
     * @var string
     */
    private $name = null;

    /**
     * Informations there are in the file
     *
     * @var array
     */
    private $infos = array(
        'description' => null,
        'category' => null,
        'package' => null,
        'since' => '0.0',
        'version' => '0.0',
        'author' => null,
        'email' => null
    );

    /**
     * The real path of the plugin
     *
     * @var string
     */
    private $path = null;

    /**
     * The raw path is the path which accessible in
     * the web navigator.
     *
     * @var string
     */
    private $raw = '/display/plugins/';

    /**
     * If the plugin is a directory
     *
     * @var bool
     */
    private $isDir = false;

    /**
     * Constructor of the class
     *
     * @param string $name the name of the plugin.
     *                     If it's null, create un empty plugin.
     * @since Version 0.2
     * @version 0.2
     */
    public function __construct($name = null)
    {
        $filePath = EBRIDDISPLAY . '/plugins/' . $name;

        if( file_exists($filePath) ){
            if( is_dir($filePath)){
                $this->setIsDir(true);
            }
            
            $this
                ->setPath( $filePath )
                ->extractInfos();
        }
    }

    /**
     * Gets the Name of the plugin.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the Name of the plugin.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the Informations there are in the file.
     *
     * @param string $index the information that you want to get
     * @return mixed
     */
    public function getInfos($index = null)
    {
        if( is_null($index) || !isset($this->infos[$index]) ){
            return $this->infos;
        } else {
            return $this->infos[$index];
        }
    }

    /**
     * Sets the Informations there are in the file.
     *
     * @param array $infos the infos
     *
     * @return self
     */
    public function setInfos(array $infos)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Gets the Path of the plugin.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the Path of the plugin.
     *
     * @param string $path the path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Gets the The raw path is the path which accessible in
     * the web navigator.
     *
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * Sets the The raw path is the path which accessible in
     * the web navigator.
     *
     * @param string $raw the raw
     *
     * @return self
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;

        return $this;
    }

    /**
     * Gets the If the plugin is a directory.
     *
     * @return bool
     */
    public function getIsDir()
    {
        return $this->isDir;
    }

    /**
     * Sets the If the plugin is a directory.
     *
     * @param bool $isDir the is dir
     *
     * @return self
     */
    public function setIsDir($isDir)
    {
        $this->isDir = $isDir;

        return $this;
    }

    /**
     * Extract informations about the plugin
     *
     * @return self
     * @since Version 0.2
     * @version 0.2
     */
    public function extractInfos(){
        $infos = $this->getInfos();

        $file = fopen( $this->getPath(), 'r' );
        while ( ($line = fgets($file)) !== false ){
            if( preg_match("#<\?php#", $line) ){
                continue;
            } else if( preg_match("#^class [\w]+ implements Plugin$#", $line) ){
                $name = preg_replace("#^class ([\w]+) implements Plugin$#", '$1', $line);
                break;
            }

            $regexInfo = "#^.*@([\w]+) (.*)$#";
            if( preg_match($regexInfo, $line) ){
                $index = rtrim(preg_replace($regexInfo, '$1', $line));
                $value = rtrim(preg_replace($regexInfo, '$2', $line));
                $infos[$index] = $value;
            } else {
                $infos['description'] .= $line . '\n';
            }
        }
        fclose( $file );

        return $this
            ->setName( $name )
            ->setInfos( $infos )
            ->treatInfos();
    }

    /**
     * Treat informations (rtrim, make link...)
     *
     * 
     * @return self
     * @since Version 0.2
     * @version 0.2
     */
    public function treatInfos(){
        $infos = $this->getInfos();

        $infos['author'] = preg_replace(
            "#(.*)[\s]*<(.*)>#", 
            '<a href="mailto:$2">$1</a>', 
            $infos['author']
        );

        $description = null;
        $infos['description'] = explode('\n', $infos['description']);
        $regexDesc = "#^ \* ([\w\"\.\-\' -à]+).*#";
        foreach ($infos['description'] as $line) {
            if( preg_match($regexDesc, $line) ){
                $description .= preg_replace($regexDesc, '$1', $line);
            }
        }
        $infos['description'] = $description;

        return $this->setInfos( $infos );
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

        $themePath = EBRIDDISPLAY . '/plugins/';
        $dir = opendir($themePath);

        $readThemes = 0;
        while( false !== ( $theme = readdir($dir) ) ){
            if($theme === '.' || $theme === '..'){
                continue;
            }

            $themesArray[$theme] = new EbridPlugin($theme);

            ++$readThemes;
        }

        return $themesArray;
    }
}