<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Data.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     util
 *	@category       
 *	@date           2011-05-21 03:54:15 -0400 (Sat, 21 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
/**
 * LAIKA_Data class.
 */
class LAIKA_Data extends Laika{

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
    /**
     * format_class_name function.
     * 
     * @access public
     * @static
     * @param  mixed $name
     * @return string
     */
    public static function format_class_name($name){
        $parts = explode('_', strtolower($name));
        foreach( $parts as $key => $value ){
            $name_array[] = ucfirst($value);
        }
        return implode('_',$name_array);
    }
        
    /**
     * traverse function.
     * 
     * @access public
     * @static
     * @param object $iterator
     * @param array $callback
     * @return void
     */
    public static function traverse($iterator,$callback){   
        $class  = $callback[0];
        $method = $callback[1];
        while($iterator->valid()):    
            if($iterator->hasChildren()):          
                self::traverse($iterator->getChildren(),$callback);
            else:
                $class::$method($iterator->key(),$iterator->current());
            endif;
            $iterator -> next();
        endwhile;
    }
    
    /**
     * recursive_array_filter function.
     * 
     * @access public
     * @static
     * @param array $input
     * @return array
     */
    public static function recursive_array_filter($input){
        foreach ($input as &$value)
            if(is_array($value))
                $value = self::recursive_array_filter($value);   
        return array_filter($input);
    }
}