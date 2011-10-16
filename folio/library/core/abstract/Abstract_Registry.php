<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Abstract_Registry.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     abstract
 *	@category       
 *	@date           2011-05-21 18:28:12 -0400 (Sat, 21 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
/**
 * Abstract LAIKA_Abstract_Registry class.
 * 
 * @abstract
 * @extends Laika_Singleton
 */
abstract class LAIKA_Abstract_Registry extends LAIKA_Singleton{

    /*
    static function add(){}
    static function pop(){}
    static function seek(){}*/
    static function peek(){}
    static function register(){}
    static function unregister(){}    
}