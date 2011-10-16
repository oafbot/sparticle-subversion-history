<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Exception_Logger.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     util
 *	@category       
 *	@date           2011-05-22 08:51:14 -0400 (Sun, 22 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
class LAIKA_Exception_Logger extends Laika implements SPLObserver{

//-------------------------------------------------------------------
//	CONSTRUCTOR
//-------------------------------------------------------------------

    public function __construct(){}

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------    

    public function update(SplSubject $subject){ 
        return error_log($subject->exception);
    }
}