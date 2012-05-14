<?php
class FOLIO_Content_Controller extends LAIKA_Abstract_Page_Controller {

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $parameters;
    
    public    static $access_level = 'PUBLIC';
    public    static $access_group = 'USER';
    public    static $caching      = TRUE;
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
	
	public function default_action(){ $this->show(); }
	
    public function __call($name,$arg){
        $user = LAIKA_User::find('username',$name);
        $id = $user->id();
        
        //$media = HTTP_ROOT."/media/".$name."/".$this->parameters['media'];        
        //$media = FOLIO_Media::find('path',$media);
        
        if(isset( $id ))
            $this->display(array("user"=>$id,"media"=>$media));
        else
            $this->display(array("alert"=>"User not found","alert_type"=>"warning"));        
    }

    public function show(){
        
        $media = FOLIO_Media::find('id',$this->parameters['id']);
        $user  = LAIKA_User::find('id',$media->user);
        
        if(isset($this->parameters['id']) && !empty($this->parameters['id'])):
            $this->display(array("page"=>"content","media"=>$media,"user"=>$user));
        else:
            $media->path = IMG_DIRECTORY."/error.png";
            $media->name = "Missing Content";
            $user->username = "nobody";
            $this->display(array("alert"=>"Content not found.","alert_type"=>"warning","media"=>$media,"user"=>$user));
        endif;
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