<?php
/**
 * FOLIO_Login_Controller class.
 * 
 * @extends LAIKA_Login_Controller
 */
class FOLIO_Login_Controller extends LAIKA_Login_Controller{

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
    public    static $access_group = 'USER'; 
    
    public function authenticate(){
        isset($_POST['user']) ? $user = $_POST['user'] : $user = NULL;
        isset($_POST['password']) ? $pass = $_POST['password'] : $pass = NULL;
        parent::authenticate($user,$pass);
    }
}