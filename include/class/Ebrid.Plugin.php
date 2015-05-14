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
        'category' => null,
        'package' => null,
        'since' => '0.0',
        'version' => '0.0',
        'author' => null,
        'email' => null
    );

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
            $this->extractInfos( $filePath );
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
     * @return array
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