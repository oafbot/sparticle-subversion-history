<?php
class LAIKA_Account extends LAIKA_Abstract_Model{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $model;
    protected        $table;

    protected        $id;
    protected        $user;
    protected        $token;
    protected        $confirmed;
    protected        $deactivated;
    protected        $created;
    protected        $updated;
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------

    public static function create($username){
        
        $account = self::init();        
        $user = LAIKA_User::find('username',$username);              
        
        $account->user($user::get('id'));
        $account->token(md5($user->salt().SESSION_TOKEN));
        $account->confirmed(false);
        $account->deactivated(false);
        $account->created(date("Y-m-d")); /**@todo Create database date wrapper in the Time class*/

        return $account;
    }    
}