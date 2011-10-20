<?php
class FOLIO_About_Controller extends LAIKA_Abstract_Page_Controller{

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
    
    public function default_action(){ $this->display(array("page"=>"about")); }    
}