<?php
class FOLIO_Content_Controller extends LAIKA_Abstract_Page_Controller {

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
	
	public function default_action(){ $this->display(array("page"=>"")); }
	
    public function __call($name,$arg){
        $user = LAIKA_User::find('username',$name);
        $id = $user->id();
        
        $media = "/media/".$name."/".$this->parameters['media'];
        
        if(isset( $id ))
            $this->display(array("user"=>$id,"media"=>$media));
        else
            $this->display(array("alert"=>"User not found","alert_type"=>"warning"));
            
        
    }
    
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