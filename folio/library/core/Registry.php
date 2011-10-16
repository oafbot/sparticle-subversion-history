<?php

/**
 * LAIKA_Registry class.
 * 
 * @extends LAIKA_Abstract_Registry
 */
class LAIKA_Registry extends LAIKA_Abstract_Registry{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------
    protected static $instance;
    private          $registry;

    /**
     * init function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function init(){ 
        if( empty(self::$instance) )       
            if( isset($_SESSION[__CLASS__]) && !empty($_SESSION[__CLASS__]) )                   
                self::$instance = self::unserialize_me();
            else
                parent::init(); 
        $_SESSION[__CLASS__] = self::$instance;       
        return self::$instance;
    }

    /**
     * register function.
     * 
     * @access public
     * @param mixed $index
     * @param mixed $reference
     * @return void
     */
    public static function register($index,$reference){
        self::init()->registry[$index] = $reference;
        $db = self::init()->registry[$index];
        $_SESSION[__CLASS__] = self::$instance;
    }
    
    /**
     * unregister function.
     * 
     * @access public
     * @param mixed $index
     * @return void
     */
    public static function unregister($index){
        self::init()->registry[$index] = NULL;
        $_SESSION[__CLASS__] = self::$instance;
        return NULL;    
    }
    
    /**
     * get_record function.
     * 
     * @access public
     * @param mixed $index
     * @return void
     */
    public static function get_record($index){
        return self::init()->registry[$index];   
    }
    
    /**
     * set_record function.
     * 
     * @access public
     * @param mixed $index
     * @param mixed $reference
     * @return void
     */
    public static function set_record($index,$reference){
        self::init()->registry[$index] = $reference;
        $_SESSION[__CLASS__] = self::$instance;    
    }
    
    /**
     * peek function.
     * 
     * @access public
     * @static
     * @param mixed $index
     * @return void
     */
    public static function peek($index){
        if( isset(self::init()->registry[$index]) && !empty(self::init()->registry[$index]) )
            return true;
        else
            return false;
    }
        
    /**
     * __destruct function.
     * 
     * @access public
     * @return void
     */
    public function __destruct(){
        self::serialize_me();
    }
}