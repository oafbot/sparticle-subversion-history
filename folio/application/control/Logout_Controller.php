<?php
/**
 * FOLIO_Login_Controller class.
 * 
 * @extends LAIKA_Login_Controller
 */
class FOLIO_Logout_Controller extends LAIKA_Login_Controller{

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
    public    static $access_group = 'USER'; 

    public function default_action(){ parent::terminate(); }
}