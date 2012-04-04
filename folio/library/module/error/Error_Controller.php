<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Home_Controller.php
 *
 *	@version        0.1.0b
 *	@package        FOLIO
 *	@subpackage     control
 *	@category       control
 *	@date           2011-05-21 03:37:00 -0400 (Sat, 21 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
class LAIKA_Error_Controller extends LAIKA_Abstract_Page_Controller{

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
    
    
    /**
     * display function.
     * 
     * @access public
     * @return void
     */
    public function display(){
        $args = func_get_args();
        $view = str_replace('_Controller', '_Page', __CLASS__);
        ob_start(OB_HANDLER);
        $view::init()->render_page($args);
        ob_end_flush();
    }
    
    public function default_action(){ $this->missing(); }
    
    public function missing(){
        $this->display(array("component"=>"missing"));
    }
    
    public function exceptions(){
        
        echo $_SESSION['ERROR_MSG'];
        
    }  
}