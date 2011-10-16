<?php

/**
 * LAIKA_Access class.
 * 
 * Basic layer access class.
 * This class should be agnostic of User and Login classes and modules.
 *
 * @extends LAIKA_Singleton
 */
class LAIKA_Access extends LAIKA_Singleton{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------

    protected static $instance;
    private          $token;
    private          $logged_in;        
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
    /**
     * init function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function init(){    
        if( empty(self::$instance) )      
            if( LAIKA_Registry::peek(__CLASS__) )                 
                self::$instance = LAIKA_Registry::get_record(__CLASS__);
            else
                parent::init();
        LAIKA_Registry::register(__CLASS__,self::$instance); 
        return self::$instance;    
    }

    /**
     * configure function.
     * 
     * @access public
     * @return void
     */
    public function configure(){
        if( isset($_COOKIE['LAIKA_SESSION']) ){            
            $this->logged_in = true;
            $this->token = SESSION_TOKEN;

            if(!isset($_SESSION['PREVIOUS_TOKEN']))
                $_SESSION['PREVIOUS_TOKEN'] = $_COOKIE['LAIKA_SESSION'];                       
            
            if($_COOKIE['LAIKA_SESSION'] != $this->token)
                setcookie('LAIKA_SESSION', $this->token, time() + 31536000, '/');

            LAIKA_Registry::set_record(__CLASS__,self::$instance);
        }
        if( isset($this->token) )
            $_SESSION['LOGIN_TOKEN']= $this->token;
        else $_SESSION['LOGIN_TOKEN']= NULL;
    }
    
    /**
     * grant_access function.
     * 
     * @access public
     * @return void
     */
    public function grant_access(){
        $this->token = SESSION_TOKEN;
        $this->logged_in = true;
        LAIKA_Registry::set_record(__CLASS__,self::$instance);
        $_SESSION['LOGIN_TOKEN']=$this->token;
        if (!isset($_COOKIE['LAIKA_SESSION']))
            setcookie('LAIKA_SESSION', $this->token, time() + 31536000, '/');
    }
    
    /**
     * destroy_session function.
     * 
     * @access public
     * @return void
     */
    public function destroy_session(){
        unset($_SESSION['LOGIN_TOKEN']);
        self::$instance = LAIKA_Registry::unregister(__CLASS__);
        setcookie('LAIKA_SESSION', " ", time()-3600, '/');
        $_SESSION['REDIRECT']=NULL;
        LAIKA_Controller::process(new LAIKA_Command('DATABASE','DISCONNECT',NULL));        
        //session_destroy();        
    }
    
    /**
     * is_logged_in function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function is_logged_in(){
        return self::init()->logged_in;
    }
}