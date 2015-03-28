<?php

/**
 * Fichier Ebrid.Setting.php
 *
 * PHP version 5
 *
 * @category Ebrid
 * @package Ebrid
 * @license http://opensource.org/licenses/MIT
 * @link http://ebrid.lignusdev.com/
 * @since Version 0.1
 */

/**
 * Class Description
 *
 * @category Ebrid
 * @package Ebrid
 * @since Version 0.1
 */
class EbridSettings
{
    
    /**
     * The file path of settings
     *
     * @var {2:type}
     */
    private $file;
    
    /**
     * All the settings of Ebrid
     *
     * @var array
     */
    private $settings = array(
        'DBHOST' => 'localhost',
        'DBNAME' => 'ebrid',
        'DBUSER' => 'root',
        'DBPASSWORD' => '',
        'SITENAME' => '',
        'THEME' => 'default',
        'REWRITE_RULE' => '/{article_year}/article/{article_name}'
    );
    
    public function __construct($filename) {
        if (defined("EBRIDPATH")) {
            $path = EBRIDPATH;
        } 
        else {
            $path = dirname(dirname(dirname(__FILE__)));
        }
        
        $filename = preg_replace("#^/#", "", $filename);
        $this->setFile($path . '/' . $filename);
        
        if (!file_exists($this->getFile())) {
            throw new Exception("Le fichier: " . $this->getFile() . " n'existe pas.");
        }
        
        $settings = $this->readSettings();
        $this->fillSettings($settings);
        unset($settings);
    }
    
    /**
     * Set the file settings
     *
     * @param string $pathfile the path of the file
     * @return self
     * @since Version 0.1
     */
    protected function setFile($pathfile) {
        if (!preg_match("#^[\w\\\/\-\. à]*\/setting\.php$#", $pathfile)) {
            $this->file = $pathfile;
        }
        return $this;
    }
    
    /**
     * Get the file path setting
     *
     * @return string
     * @since Version 0.1
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Set a setting in the settings array.
     * If the key doesn't exist in the array,
     * it will automatically return self
     * without done anything.
     *
     * @param mixed $key the key in the array
     * @param mixed $val the value to set
     * @return self
     * @since Version 0.1
     */
    public function setSettings($key, $val){
        if(isset($this->settings[$key])){
            $this->settings[$key] = $val;
        }
        return $this;
    }

    /**
     * Get a or all settings
     *
     * @param string $key key of the setting
     * @return mixed
     * @since Version 0.1
     */
    public function getSettings($key = null){
        if($key === null){
            return $this->settings;
        }else if(isset($this->settings[$key])){
            return $this->settings[$key];
        }
        return null;
    }
    
    /**
     * Read each lines of the settings
     *
     * @return array
     * @since Version 0.1
     */
    protected function readSettings() {
        $returnSettings = array();
        
        $file = fopen($this->getFile() , 'r');
        while (($line = fgets($file)) !== false) {
            if (!preg_match('#^define\(.*\)#', $line)) {
                continue;
            }
            
            $regex = '#^define\(\'(.*)\',[\s]?[\'|"](.*)[\'|"]\);.*$#';
            if(preg_match($regex, $line)){
                $key = rtrim(preg_replace($regex, '$1', $line));
                $val = rtrim(preg_replace($regex, '$2', $line));
                
                $returnSettings[$key] = $val;
            }
        }
        fclose($file);
        return $returnSettings;
    }

    /**
     * Write in the instance variable
     * all the settings we need
     *
     * @param array $settings the array of settings
     * @return self
     * @since Version 0.1
     */
    protected function fillSettings($settings){
        foreach ($settings as $k => $v) {
            $this->setSettings($k, $v);
        }
        return $this;
    }

    /**
     * Write in the settings file all
     * settings that there are in the
     * instance variable.
     *
     * @return self
     * @since Version 0.1
     */
    public function writeSettings(){
        $content = file_get_contents($this->file);

        foreach ($this->getSettings() as $k => $v) {
            $regex = '#define\((\''.$k.'\'),[\s]?[\'|"](.*)[\'|"]\);#Usi';
            $replace = 'define($1, \''.$v.'\');';
            $content = preg_replace($regex, $replace, $content);
        }

        /**
         * Put an @ to prevent error
         * But it still here just for a while
         * We will remove it later
         */
        @file_put_contents($this->file, $content, LOCK_EX);

        return $this;
    }
}
