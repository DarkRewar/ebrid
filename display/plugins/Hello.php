<?php

/**
 * File Hello.php
 *
 * PHP version 5
 *
 * @category Plugin
 * @package Ebrid
 * @license http://opensource.org/licenses/MIT
 * @link http://ebrid.lignusdev.com/
 * @since Version 0.2
 * @version 0.2
 */

/**
 * Hello Plugin Class
 * A simple plugin which says "Hello"
 *
 * @category Plugin
 * @package Ebrid
 * @since Version 0.2
 * @version 0.2
 * @author Curtis Pelissier <curtis.pelissier@lignusdev.com>
 */
class Hello implements EbridPlugin
{

    /**
     * This function must draw/display the
     * plugin in front end.
     *
     * @since Version 0.2
     * @version 0.2
     */
    public function draw(){
        $sentences = array(
            'Lili, take another walk out of your fake world',
            'Please put all the drugs out of your hand',
            'You\'ll see that you can breath without no back up',
            'So much stuff you got to understand',

            'For every step in any walk',
            'Any town of any thought',
            'I\'ll be your guide',

            'For every street of any scene',
            'Any place you\'ve never been',
            'I\'ll be your guide'
        );
        __( $this->randomSentence($sentences) );
    }

    /**
     * Get the environment of the plugin,
     * where do the plugin must be drawn.
     * It'll be used for the intent drawer.
     *
     * @return string
     * @since Version 0.2
     * @version 0.2
     */
    public function getEnvironment(){
        return 'admin-head-up';
    }

    /**
     * Get a random sentence
     *
     * @param array $sentences sentences to display
     * @return string
     * @since Version 0.2
     * @version 0.2
     */
    private function randomSentence($sentences){
        $nb = count( $sentences ) - 1;
        return $sentences[rand(0, $nb)];
    }
}