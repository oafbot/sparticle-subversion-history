<?php
/**
 * FOLIO_User_Controller class.
 * 
 * @extends LAIKA_User_Controller
 */
class FOLIO_User_Controller extends LAIKA_User_Controller{

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PRIVATE';
    public    static $access_group = 'USER';
    protected        $submenu      = USER_MENU;
    


    public function default_action(){
        $this->display(array(
        "page"=>LAIKA_User::active()->username(),
        "user"=>LAIKA_User::active()->id(),
        "submenu"=>unserialize($this->submenu)
        ));                 
    }    
    
    public function gallery(){}
    
    public function content(){
        $this->display(array(
        "page"=>LAIKA_User::active()->username(),
        "user"=>LAIKA_User::active()->id,
        "submenu"=>unserialize($this->submenu),
        "component"=>"content",
        "media"=>$this->parameters['src']
        ));
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
        
        switch($this->parameters['show']):
            case 'all':
                $users = LAIKA_User::paginate();
                break;
            default:
                $users = LAIKA_User::paginate($this->parameters['show']);
                break;
        endswitch;        
         
        foreach($users as $k => $user)                            
            foreach( LAIKA_User::accessible() as $k2 => $v ) 
                $response[$k][$k2] = $user->get_property($k2);
        
        $this->display(array(
            "component"=>"directory",
            "users"=>$response,
            "submenu"=>unserialize($this->submenu)));
    }    
}