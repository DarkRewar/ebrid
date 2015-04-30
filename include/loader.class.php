<?php

/**
 * Load all classes you need
 *
 * @package Ebrid
 */
require( dirname(__FILE__) . '/lib/Database.class.php');

require( dirname(__FILE__) . '/class/Blog.Article.php');
require( dirname(__FILE__) . '/class/Blog.Category.php');
require( dirname(__FILE__) . '/class/Blog.Comment.php');
require( dirname(__FILE__) . '/class/Blog.Revision.php');

require( dirname(__FILE__) . '/class/Forum.Category.php');
require( dirname(__FILE__) . '/class/Forum.Forum.php');
require( dirname(__FILE__) . '/class/Forum.Topic.php');
require( dirname(__FILE__) . '/class/Forum.Message.php');
require( dirname(__FILE__) . '/class/Forum.Revision.php');

require( dirname(__FILE__) . '/class/User.php');

require( dirname(__FILE__) . '/class/Ebrid.Settings.php');
require( dirname(__FILE__) . '/class/Ebrid.Theme.php');
require( dirname(__FILE__) . '/class/Ebrid.RewriteRule.php');