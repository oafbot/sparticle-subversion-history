<?php

/**
 * LAIKA_Login_Controller class.
 * 
 * Controller for the login module.
 *
 * @extends LAIKA_Abstract_Page_Controller
 */
class LAIKA_Login_Controller extends LAIKA_Abstract_Page_Controller{

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
    public    static $access_group = 'USER'; 


//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------

    /**
     * display function.
     *
     * Same as the display method defined in LAIKA_Abstract_Page_Controller
     * 
     * @access public
     * @return void
     */
    public function display(){
        $args = func_get_args();
        $view = str_replace('_Controller', '_Page', __CLASS__);
        ob_start('ob_gzhandler');
        $view::init()->render_page($args);
        ob_end_flush();
    }
    
    /**
     * default_action function.
     * 
     * Default action is to display the login page unless already logged in.
     *
     * @access public
     * @return void
     */
    public function default_action(){ 
        if($_SESSION['LOGIN_TOKEN']==SESSION_TOKEN)
            $this->redirect();
        else
            $this->display(array("page"=>"login"));
    }
    
    /**
     * authenticate function.
     *
     * Checks login status and prompts for login or reroutes to requested page
     * 
     * @access public
     * @param mixed $user
     * @param mixed $pass
     * @return void
     */
    public function authenticate($user, $pass){                
        if($_SESSION['LOGIN_TOKEN']==SESSION_TOKEN)
            $this->redirect();
        else
            $this->verify_credentials($user, $pass);
    }
    
    /**
     * redirect function.
     * 
     * Redirect to the requested page.
     *
     * @access public
     * @return void
     */
    public function redirect(){        
        if( isset($_SESSION['REDIRECT']) )
            header("Location: ".$_SESSION['REDIRECT']);
        else 
            self::redirect_to();        
        $_SESSION['REDIRECT']=NULL;
    }
    
    /**
     * denied function.
     * 
     * Displays the login denied page.
     * Terminates the session.
     *
     * @access public
     * @return void
     */
    public function denied(){
        LAIKA_Controller::process(new LAIKA_Command('ACCESS','DESTROY_SESSION', NULL));        
        $this->display(array(
            "alert"       => "Access denied: Invalid username or password.", 
            "alert_type"  => "warning", 
            "page"        => "login"));
            
        //LAIKA_Event::dispatch('ACCESS_DENIED');        
    }
    
    /**
     * terminate function.
     * 
     * Terminates the session.
     * Hibernates the user.
     * Sets the login status of the user to false.  
     * Destroys the session and unregisters the user from the Registry.  
     *  
     * @access public
     * @return void
     */
    public function terminate(){
        LAIKA_Active_User::sleep();
        LAIKA_Active_User::init()->logged_in(false);
        LAIKA_Controller::process(new LAIKA_Command('ACCESS','DESTROY_SESSION', NULL));        
        LAIKA_Registry::unregister("Active_User");        
        $this->display(array(
            "alert"       => "You logged out sucessfully.", 
            "alert_type"  => "success", 
            "page"        => "login"));
            
        //LAIKA_Event::dispatch('TERMINATE_SESSION');
    }
    
    /**
     * verify_credentials function.
     *
     * If submitted password and database records match
     * Change the state of the Access object,
     * Load and register user in the Registry,
     * Set login status of the user to true,
     * Check if the user account is confirmed and activated
     *
     * @access public
     * @param mixed $user
     * @param mixed $pass
     * @return void
     */
    public function verify_credentials($user, $pass){
        
        $result = LAIKA_Database::select_where('id,password,salt','users',"username = '{$user}'");
        
        if( $result['password'] == md5($pass.$result['salt']) ):
            
            /* Change Access state */
            LAIKA_Controller::process(new LAIKA_Command('ACCESS','GRANT_ACCESS', NULL));
            
            /* Load and register user in the Registry */
            LAIKA_User::bind($result['id']);
            
            /* Set user status to logged in */
            LAIKA_User::active()->logged_in(true);
            
            /* Check if the user account is confirmed and activated */
            if( LAIKA_User::active()->valid_account() )
                $this->redirect();
            else
                self::redirect_to('/login/activation');
        else:            
            self::redirect_to('/login/denied');
        endif;
        
    }
    
    /**
     * activation function.
     * 
     * Displays the activation page.
     * Terminates the session.
     *
     * @access public
     * @return void
     */
    public function activation(){
        LAIKA_Controller::process(new LAIKA_Command('ACCESS','DESTROY_SESSION', NULL));
        $this->display(array("component"=>"activation"));
    }
}