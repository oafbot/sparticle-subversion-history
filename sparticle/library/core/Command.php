<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource 	Command.php
 *
 *	@version 	    0.1.0b
 *	@package 	    laika
 *	@subpackage     core
 *	@category       control
 *	@date       	2010-01-18 22:21:21 -0500 (Mon, 18 Jan 2010)
 *
 *	@author     	Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright  	Copyright (c) 2010 Harvard University <{@link http://lab.dce.harvard.edu}>
 *
 */

 /**
 * LAIKA_Command class.
 * 
 */

class LAIKA_Command extends Laika{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------

    private $class_name  = NULL;
    private $method      = NULL;
    private $params      = NULL;
    

//-------------------------------------------------------------------
//	CONSTRUCTOR
//-------------------------------------------------------------------     
    /**
     * __construct function.
     * 
     * @access public
     * @return void
     *
     * @todo maybe this function could be made a lot stricter
     */
    public function __construct(){
        func_num_args() == 3 ? $args = func_get_args() : 
          $this->setError( 'Invalid parameter construct' );
        
        isset($args[0]) && !empty($args[0]) ? $this->class_name  = $args[0] : 
          $this->setError( 'Invalid argument at parameter[0]' );
        isset($args[1]) && !empty($args[1]) ? $this->method      = $args[1] : 
          $this->setError( 'Invalid argument at parameter[1]' );
        isset($args[2]) && !empty($args[2]) ? $this->params      = $args[2] : 
          //$this->setError( 'Invalid argument at parameter[2]' );
          $this->params = NULL;  
    }    

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------    
    /**
     * validate_command function.
     * 
     * @access public
     * @return void
     */
    public function validate_command(){    
      //$class = LAIKA_NS.ucfirst(strtolower(( $this->class_name )));
      $class = $this->get_class_name();
      method_exists($class, strtolower($this->method)) ? $exists = true : $exists = false;
      return $exists;
    }
    
    /**
     * get_class_name function.
     * 
     * @access public
     * @return void
     */
    public function get_class_name(){ 
        $class_name = LAIKA_Data::format_class_name($this->class_name);
        return LAIKA_NS.$class_name; 
    }
    
    /**
     * get_method_name function.
     * 
     * @access public
     * @return void
     */
    public function get_method_name(){ return strtolower($this->method); }
    /**
     * get_parameters function.
     * 
     * @access public
     * @return void
     */
    public function get_parameters(){ return $this->params; }      
    
    /**
     * setError function.
     * 
     * @access public
     * @param mixed $error
     * @return void
     */
    public function setError( $error ){
        throw new LAIKA_Exception('INVALID_COMMAND:['.$error.']',901);
                
        //Event::init()->reportError(new LAIKA_Error($error) );
        
        //Event::init()->type('ERROR')->level('FATAL',$error);        
        //throw new Exception('Command Fault');
    }
}