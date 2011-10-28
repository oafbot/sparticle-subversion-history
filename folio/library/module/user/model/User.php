<?php
/**
 * LAIKA_User class.
 * 
 * @extends LAIKA_Abstract_Model
 */
class LAIKA_User extends LAIKA_Abstract_Model{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $model;
    protected        $table;
    protected        $accessibles = array('username','email','firstname','lastname','logged_in');
        
    protected        $id;
    protected        $username;
    protected        $password;
    protected        $salt;
    protected        $email;
    protected        $level;
    protected        $firstname;
    protected        $lastname;
    protected        $logged_in;
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------

    /**
     * bind function.
     * 
     * @access public
     * @static
     * @param int $id
     * @return void
     */
    public static function bind(){
        if(func_num_args()>0)
            LAIKA_Active_User::bind(func_get_arg(0));
        else
            LAIKA_Active_User::bind($this->id);
    }

    /**
     * active function.
     * 
     * @access public
     * @static
     * @return User Object
     */
    public static function active(){
        return LAIKA_Active_User::active();            
    }
    
    /**
     * wake_up function.
     * 
     * @access public
     * @static
     * @return User Object
     */
    public static function wake_up(){
        return LAIKA_Active_User::wake_up();
    }
    
    /**
     * sleep function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function sleep(){
        LAIKA_Active_User::sleep();   
    }
    
    public static function deactivate(){}
    
    /**
     * name function.
     * 
     * @access public
     * @return string
     */
    public function name(){
        if(func_num_args()==0)
            $user = $this;
        else
            $user = LAIKA_User::load(func_get_arg(0));
        return $user->firstname." ".$user->lastname;
    }
    
    /**
     * activated function.
     * 
     * @access public
     * @return void
     */
    public function valid_account(){
        $account = LAIKA_Account::find('user',$this->id);
        if(!$account->confirmed() || $account->deactivated())
            return false;
        return true;
    }
    
    /**
     * account function.
     * 
     * @access public
     * @return void
     */
    public function account(){
        return LAIKA_Account::find('user',$this->id);
    }
                            
}