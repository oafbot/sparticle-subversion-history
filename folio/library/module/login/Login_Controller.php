<?php

/**
 * LAIKA_Login_Controller class.
 * 
 * @extends LAIKA_Abstract_Page_Controller
 */
class LAIKA_Login_Controller extends LAIKA_Abstract_Page_Controller{

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
    public    static $access_group = 'USER'; 
    //protected        $ignore = array('action_handler','get_salt');

    /**
     * display function.
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
     * @access public
     * @return void
     */
    public function denied(){
        LAIKA_Controller::process(new LAIKA_Command('ACCESS','DESTROY_SESSION', NULL));        
        $this->display(array(
            "alert"       => "Access denied: Invalid username or password.", 
            "alert_type"  => "warning", 
            "page"        => "login"));        
    }
    
    /**
     * terminate function.
     * 
     * @access public
     * @return void
     */
    public function terminate(){
        LAIKA_User::sleep();
        LAIKA_User::active()->logged_in(false);
        LAIKA_Controller::process(new LAIKA_Command('ACCESS','DESTROY_SESSION', NULL));        
        LAIKA_Registry::unregister("Active_User");        
        $this->display(array(
            "alert"       => "You logged out sucessfully.", 
            "alert_type"  => "success", 
            "page"        => "login"));
    }
    
    /**
     * verify_credentials function.
     * 
     * @access public
     * @param mixed $user
     * @param mixed $pass
     * @return void
     */
    public function verify_credentials($user, $pass){

        $params = array('users',"username = '{$user}'");
        $result = LAIKA_Database::select_where('id,password,salt','users',"username = '{$user}'");

        if( $result['password'] == md5($pass.$result['salt']) ):
            LAIKA_Controller::process(new LAIKA_Command('ACCESS','GRANT_ACCESS', NULL));
            LAIKA_User::bind($result['id']);
            LAIKA_User::active()->logged_in(true);
            if( LAIKA_User::active()->activated() )
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
     * @access public
     * @return void
     */
    public function activation(){
        LAIKA_Controller::process(new LAIKA_Command('ACCESS','DESTROY_SESSION', NULL));
        $this->display(array("component"=>"activation"));
    }
}