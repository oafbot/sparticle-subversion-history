<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Singleton.php
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
  * Abstract LAIKA_Singleton class.
  * 
  * Base class for all objects employing the Singleton patterm.
  *
  * @abstract
  * @extends Laika
  */
 abstract class LAIKA_Singleton extends Laika{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------    
    /**
     * instance
     * 
     * @var    object
     * @access private
     * @static
     */
    private static $instance;
    
//-------------------------------------------------------------------
//	CONSTRUCTOR
//------------------------------------------------------------------- 
    /**
     * __construct function.
     * 
     * @access private
     * @final
     * @return void
     */
    private final function __construct(){}

    /**
     * init function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function init(){
        $called_class = get_called_class();
        if( !($called_class::$instance instanceof $called_class) ) 
            $called_class::$instance = new $called_class();        
        return $called_class::$instance;
    }
    
    /**
     * __clone function.
     * 
     * @access private
     * @final
     * @return void
     */
    //private final function __clone(){}


//-------------------------------------------------------------------
//	SETTER & GETTER METHODS
//-------------------------------------------------------------------

    /**
     * get function.
     * 
     * @access public
     * @static
     * @param mixed $member
     * @return void
     */
    public static function get($member){        
        $class = get_called_class();
        return $class::init()->$member;    
    }

    /**
     * set function.
     * 
     * @access public
     * @static
     * @param mixed $member
     * @param mixed $value
     * @return void
     */
    public static function set($member,$value){
        $class = get_called_class();
        $class::init()->$member = $value;    
    }

    /**
     * from_array function.
     * 
     * Returns an instance of an object constructed from an array
     *
     * @access public
     * @static
     * @param mixed $array
     * @return void
     */
    public static function from_array($array){
        $class = get_called_class();
        $object = $class::init();
        $properties = get_object_vars($object);
        foreach($array as $key => $value)
            if(array_key_exists($key,$properties))
                $object->$key = $value;
        return $object;
    }
    
    /**
     * to_array function.
     *
     * Returns an array from an object
     * 
     * @access public
     * @static
     * @return void
     */
    public static function to_array(){
        $class = get_called_class();
        $object = $class::init();
        $array = get_object_vars($object);
        unset($array['instance']);
        return $array;
    }
    
    public function switch_instance($object){
        $called_class = get_called_class();
        $called_class::$instance = $object::$instance;
    }
    
    
//-------------------------------------------------------------------
//	SERIALIZE & UNSERIALIZE METHODS
//-------------------------------------------------------------------
    /**
     * serialize_me function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function serialize_me(){
        $called_class = get_called_class();
        $_SESSION[$called_class] = urlencode(serialize($called_class::$instance));
    }
    
    /**
     * unserialize_me function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function unserialize_me(){
        $called_class = get_called_class();
        $called_class::$instance = new $called_class();
        $called_class::$instance = unserialize(urldecode($_SESSION[$called_class]));
        return $called_class::$instance;
    }
    
    public function __destruct(){
        $called_class = get_called_class();
        $called_class::$instance = NULL;
    }
    
    public function destroy(){
        $called_class = get_called_class();
        $called_class::$instance = NULL;            
    }
              
 }