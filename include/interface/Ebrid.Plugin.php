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
 * Interface object of a plugin.
 * This interface must be implemented
 * in a plugin class to be operational.
 *
 * @category Plugin
 * @package Ebrid
 * @since Version 0.2
 * @version 0.2
 */
interface EbridPlugin
{
    /**
     * This function must draw/display the
     * plugin in front end.
     *
     * @since Version 0.2
     * @version 0.2
     */
    public function draw();

    /**
     * Get the environment of the plugin,
     * where do the plugin must be drawn.
     * It'll be used for the intent drawer.
     *
     * @return string
     * @since Version 0.2
     * @version 0.2
     */
    public function getEnvironment();
}