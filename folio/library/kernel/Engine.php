<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource 	Engine.php
 *
 *	@version    	0.1.0b
 *	@package    	laika
 *	@subpackage 	kernel
 *	@category   	engine
 *	@date       	2010-01-18 02:29:45 -0500 (Mon, 18 Jan 2010)
 * 
 *	@author     	Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright  	Copyright (c) 2010 Harvard University <{@link http://lab.dce.harvard.edu}>
 *
 */
/**
 * LaikaEngine class.
 * 
 * Framework Engine
 * 
 * @extends Laika
 * @final 
 */
 
final class LAIKA_Engine{

//-------------------------------------------------------------------
//	CONSTANTS & VARIABLES
//-------------------------------------------------------------------

	private static $instance;
	//const BOOT_FLAG;
	
//-------------------------------------------------------------------
//	CONSTRUCTOR
//-------------------------------------------------------------------    
    /**
    * __construct function.
    * 
    * @access public
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
    
      	session_start();
    	require_once('../config/user.conf.php');
    	require_once('../config/system.conf.php');    	
    	
    	if( empty( self::$instance ) ){			
            
            self::$instance = new self();
    		self::$instance-> boot();
    		self::$instance-> configure();
    	}	
        return self::$instance;
    }

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------   
    /**
    * boot function.
    * 
    * @access private
    * @return void
    */
    private function boot(){
    	
        require_once('../library/kernel/Bootstrap.php');      
        LAIKA_Bootstrap::execute();                    
    }
        
    /**
    * configure function.
    * 
    * @access public
    * @return void
    */
    private function configure(){
    	
    	// Set exception handler:
        set_exception_handler(array(LAIKA_Exception_Handler::init(),'handle'));
    	// Attach a new observer:
    	LAIKA_Exception_Handler::init()->attach(new LAIKA_Exception_Logger());
    	
    	// Set error handler:
    	set_error_handler(array(LAIKA_Error::init(),'error_handler'),E_ALL);
    	    	
        // Establish Database Connection:
    	LAIKA_Controller::process(new LAIKA_Command('DATABASE','CONNECT',DB_TYPE));
        
        // CHECK ACCESS PRIVILEGES:		    	
    	LAIKA_Controller::process(new LAIKA_Command('ACCESS','CONFIGURE', NULL));
    	 				
    	// Initiate hooks, activate plugins:
    	//LAIKA_Controller::process(new LAIKA_Command('PLUGINS','HOOK', NULL));
    					
    }
         
    /**
    * execute function.
    * 
    * The guts of the 
    *
    * @access public
    * @return void
    */
    public function execute($uri){
    		     	 
        // INSTANTIATE EVENT LISTENER:		    	
        //LAIKA_Event::dispatch('URL_REQUEST', );
        //LAIKA_Controller::process(new LAIKA_Command('ACCESS','CHECK_ACCESS',$_SERVER['REMOTE_ADDR']));
        LAIKA_Controller::process(new LAIKA_Command('ROUTER','REDIRECT',$uri));  
    }
            
}