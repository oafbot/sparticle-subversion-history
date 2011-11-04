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

/*
    public function upload(){
        $this->display(array(
        "page"=>LAIKA_User::active()->firstname(),
        "user"=>LAIKA_User::active()->id(),
        "component"=>"upload" )); 
    }
*/

}