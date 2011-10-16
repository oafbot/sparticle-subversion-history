<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource 	Application_Controller.php
 *
 *	@version    	0.1.0b
 *	@package    	laika
 *	@subpackage 	core
 *	@category   	control
 *	@date       	2010-01-18 02:29:45 -0500 (Mon, 18 Jan 2010)
 * 
 *	@author     	Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright  	Copyright (c) 2010 Harvard University <{@link http://lab.dce.harvard.edu}>
 *
 */
/**
 * LAIKA_Application_Controller class.
 */
class LAIKA_Application_Controller extends LAIKA_Abstract_Controller{

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
     * call_target function.
     * 
     * @access public
     * @param  mixed  $command_set
     * @return void
     */
    public function call_target($command_set){

        $method     = array_pop($command_set['COMMANDS']);
        $controller = array_pop($command_set['COMMANDS']);
        $parameters = $command_set['PARAMETERS'];
        $this->invoke_target($controller,$method,$parameters);
    }

    /**
     * invoke_target function.
     * 
     * @access private
     * @param  string  $controller
     * @param  string  $method
     * @param  array   $parameters
     * @return void
     */
    private function invoke_target($controller,$method, $parameters){
        
        $class_name = LAIKA_Data::format_class_name($controller);        
        $page = CODE_NAME.'_'.$class_name.'_Controller';        
        $action = strtolower($method);

        try{
            if($page::$access_level == 'PUBLIC' && !REQUIRE_LOGIN)
                $page::init()->action_handler($action,$parameters);
            
            elseif($controller != 'login' && !LAIKA_Access::is_logged_in()) 
                $this->login_interrupt($controller,$method, $parameters);                
            
            else $page::init()->action_handler($action,$parameters); 
        }
        catch(LAIKA_Exception $e){
            if($e->getCode() == 900)
                self::redirect_to('/error/missing');
        }
    }
    
    /**
     * login_interrupt function.
     * 
     * @access private
     * @return void
     */
    private function login_interrupt($controller,$method, $parameters){
        LAIKA_Controller::process(new LAIKA_Command('ROUTER','SET_REDIRECT',array($controller, $method, $parameters)));
        $this->invoke_target('login','default', NULL);
    }
    
}