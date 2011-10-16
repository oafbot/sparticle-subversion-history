<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource 	Controller.php
 *
 *	@version    	0.1.0b
 *	@package    	laika
 *	@subpackage 	core
 *	@category 	    control
 *	@date       	2010-01-18 03:02:34 -0500 (Mon, 18 Jan 2010)
 *
 *	@author     	Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright 	    Copyright (c) 2010 Harvard University <{@link http://lab.dce.harvard.edu}>
 *
 */
/**
 * LAIKA_Controller class.
 */
class LAIKA_Controller extends LAIKA_Abstract_Controller{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------
    /**
     * instance
     * 
     * @var    object
     * @access protected
     * @static
     */
    protected static $instance;
 
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------     
    /**
     * process function.
     * 
     * @access public
     * @param  LAIKA_Command $Cmd
     * @return void
     */
    public static function process( LAIKA_Command $Cmd ){
        
        self::init();                
        if( $Cmd->validate_command() ){
            
            $class  = $Cmd->get_class_name();
            $method = $Cmd->get_method_name();
            $params = $Cmd->get_parameters();        
          
            if( is_subclass_of($class,'LAIKA_Singleton') )
                $class::init()->$method($params);
            else{
                $object = new $class();
                $object->$method($params);
            }
        }
        else throw new LAIKA_Exception('INVALID_COMMAND', 901);        
    }  
}