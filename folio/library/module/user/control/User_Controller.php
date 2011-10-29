<?php
/**
 * LAIKA_User_Controller class.
 * 
 * @extends LAIKA_Abstract_Page_Controller
 */
class LAIKA_User_Controller extends LAIKA_Abstract_Page_Controller{

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PRIVATE';
    public    static $access_group = 'USER';

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
        $this->me();
    }
    
    /**
     * __call function.
     * 
     * @access public
     * @param mixed $name
     * @param mixed $arg
     * @return void
     */
    public function __call($name,$arg){
        $user = LAIKA_User::find('username',$name);
        $id = $user->id();
        if(isset( $id ))
            $this->display(array("user"=>$id));
        else
            $this->display(array("alert"=>"User not found","alert_type"=>"warning"));
    }
    
    /**
     * me function.
     * 
     * @access public
     * @return void
     */
    public function me(){
        $this->display(array(
            "page"=>LAIKA_User::active()->firstname(),
            "user"=>LAIKA_User::active()->id() ));        
    }
    
    /**
     * directory function.
     * 
     * @access public
     * @return void
     */
    public function directory(){
        $this->itemize();
    }
    
    /**
     * itemize function.
     * 
     * @access public
     * @return void
     */
    public function itemize(){
        
        $_SESSION['User_offset']=NULL;
        
        if(!isset($this->parameters['show']))
            $this->parameters['show'] = 20;
        
        switch($this->parameters['show']){
            case 'all':
                $users = LAIKA_User::paginate();
                break;
            default:
                $users = LAIKA_User::paginate($this->parameters['show']);
                break;
        }        
         
        foreach($users as $k => $user)                            
            foreach( LAIKA_User::accessible() as $k2 => $v ) 
                $response[$k][$k2] = $user->get_property($k2);
        $this->display(array("component"=>"directory","users"=>$response));
    }
            
    /**
     * action_handler function.
     * 
     * @access public
     * @param mixed $action
     * @param mixed $parameters
     * @return void
     */
    public function action_handler($action,$parameters){    
        $ignore = get_class_methods(get_parent_class(get_parent_class($this)));
        $ignore[] = 'action_handler';        
        !empty($parameters) ? $this->parameters = $parameters : $this->parameters = NULL;
        if($action == 'default')
            $this->default_action();
        else if($action == 'action_handler' | in_array($action,$ignore))
            $this->default_action();
        else
            $this->$action();    
    }
}