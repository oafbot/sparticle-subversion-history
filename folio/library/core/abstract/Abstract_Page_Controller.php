<?php
/**
 * Abstract LAIKA_Abstract_Page_Controller class.
 * 
 * @abstract
 * @extends LAIKA_Abstract_Controller
 */
abstract class LAIKA_Abstract_Page_Controller extends LAIKA_Abstract_Controller{

    public    static $access_level = 'PUBLIC'; // PUBLIC, PRIVATE, PROTECTED
    public    static $access_group = 'USER';   // USER, ADMIN, WORLD
    protected        $ignore       = array('action_handler');
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------    
    /**
     * display function.
     * 
     * @access public
     * @return void
     */
    public function display(){
        $args = func_get_args();
        $view = str_replace('_Controller', '_Page', get_called_class());
        ob_start('ob_gzhandler');
        $view::init()->render_page($args);
        ob_end_flush();
    }
       
    /**
     * action_handler function.
     * 
     * Check if method exists. If called method does not exist or action_handler 
     * is called recursively, direct flow of control to the default_action.
     * Otherwise perform requested action.
     *
     * @access public
     * @param mixed $action
     * @param mixed $parameters
     * @return void
     */
    public function action_handler($action,$parameters){
        $this->ignore = array_merge($this->ignore, get_class_methods(get_parent_class(get_parent_class($this))));
        
        !empty($parameters) ? $this->parameters = $parameters : $this->parameters = NULL;        
        if( $action == 'default' )
            $this->default_action();
        else if( !method_exists(get_called_class(), $action) | in_array($action,$this->ignore)) 
            $this->default_action();
        else $this->$action();    
    }
        
    /**
     * default_action function.
     * 
     * @access public
     * @return void
     */
    abstract protected function default_action();
}