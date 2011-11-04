<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource 	Router.php
 *
 *	@version    	0.1.0b
 *	@package    	laika
 *	@subpackage 	core
 *	@category   	
 *	@date       	2010-01-19 01:27:51 -0500 (Tue, 19 Jan 2010)
 *
 *	@author     	Leonard M. Witzel <witzel@post.harvard.edu> 
 *	@copyright  	Copyright (c) 2010  Harvard University <{@link http://lab.dce.harvard.edu}>
 *
 */
/**
 * LAIKA_Router class.
 * 
 * @extends LAIKA_Singleton
 */
class LAIKA_Router extends LAIKA_Singleton{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------
    protected static $instance;
    private          $commands;
    private          $parameters;
    private          $uri;
    //protected        $redirect;

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
    /**
     * configure function.
     * 
     * @access private
     * @param mixed $request
     * @return void
     * @todo The parse_url() function may simplify code (10-31-2011).
     */
    private function configure($request){

        /* Strip the base directory if found in the URI */
        if( strpos( $request, BASE_DIRECTORY ) == 0 )
        $request = str_replace(BASE_DIRECTORY.'/',"", $request,$count = 1); 
        /*
        * Separate URI into filepath and query string
        * individuate command components found in filepath 
        */           
        $uri_component =  strpos($request, '?' ) ? explode('?', $request) : array( $request, NULL);      
        $this->commands = array_filter(explode('/',$uri_component[0]), 'strlen');
        /*
        * Remove reference to main application directory 
        * Cut off malformed commands.
        * Default routing added to missing commands
        */      
        if( count( $this->commands ) >= 3 )  $this->commands = array_slice($this->commands, 0, 2);      
        if( count( $this->commands ) == 0 ){ $this->commands[0] = DEFAULT_ROUTE; $this->commands[1] = 'default';}
        if( count( $this->commands ) == 1 ){ $this->commands[] = 'default';}        
    
        /* Reconstruct URL */ 
        $this->uri = HTTP_ROOT.'/'.implode('/',$this->commands)."?".$uri_component[1]; 
        
        /* individuate query string parameters */           
        if( !empty($uri_component[1]) ){                
            $parts = explode( '&', urldecode($uri_component[1]) );
            foreach($parts as $k => $v ){
                $key = explode('=',$v);
                $this->parameters[$key[0]] = $key[1];         
            }
        }
    } 
    
    public function set_redirect($array){
        if(!isset($_SESSION['REDIRECT']) && !LAIKA_Access::is_logged_in()) 
            $_SESSION['REDIRECT'] = HTTP_ROOT."/".$array[0]."/".$array[1]."/".$array[2];
    }


    /**
     * redirect function.
     * 
     * @access public
     * @param mixed $request
     * @return void
     */
    public function redirect($request){
        
        self::$instance->configure($request);
        $command_set['COMMANDS']   = self::$instance->commands;
        $command_set['PARAMETERS'] = self::$instance->parameters; 
        /* Hand off the command set to the Application Controller */
        LAIKA_Controller::process(new LAIKA_Command('APPLICATION_CONTROLLER', 'CALL_TARGET', $command_set));
        //LAIKA_Registry::register(__CLASS__,self::$instance);        
        //LAIKA_Event::init()->register('ROUTING', );
    }      
}