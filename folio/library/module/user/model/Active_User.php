<?php
/**
 * LAIKA_Active_User class.
 *
 * Class representing the user currently logged in.
 * A Singleton representation of the User Model Class.
 * 
 * @extends LAIKA_Abstract_Singleton_Model
 */
class LAIKA_Active_User extends LAIKA_Abstract_Singleton_Model{

//-------------------------------------------------------------------
//	PROPERTIES
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
     * init function.
     * 
     * @access public
     * @static
     * @return object
     */
    public static function init(){       
        parent::init();
        self::$instance->model = 'Active_User';
        self::$instance->table = 'users';
        return self::$instance;    
    }

    /**
     * bind function.
     * 
     * @access public
     * @static
     * @param int $id
     * @return void
     */
    public static function bind($id){
        LAIKA_Active_Session::unregister($id,false);
        $user = self::load($id);
        LAIKA_Registry::register('Active_User',$user);
        LAIKA_Active_Session::register($id);
    }

    /**
     * active function.
     * 
     * @access public
     * @static
     * @return Active_User Object
     */
    public static function active(){
        if(LAIKA_Registry::peek('Active_User'))
            self::$instance = LAIKA_Registry::get_record('Active_User');            
        else self::$instance = self::wake_up();
        return self::$instance;            
    }
    
    /**
     * wake_up function.
     * 
     * @access public
     * @static
     * @return Active_User Object
     */
    public static function wake_up(){
        $id = LAIKA_Active_Session::find_user($_SESSION['PREVIOUS_TOKEN']);
        self::bind($id);
        return LAIKA_Registry::get_record('Active_User');
    }
    
    /**
     * sleep function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function sleep(){
        $user = self::active();
        $id = $user::get('id');
        LAIKA_Active_Session::unregister($id,true);    
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
            $user = self::init();
        else
            $user = self::load(func_get_arg(0));
        return $user->firstname." ".$user->lastname;
    }
    
    /**
     * activated function.
     * 
     * @access public
     * @return void
     */
    public static function valid_account(){
        $account = LAIKA_Account::find('user',self::init()->id);
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
        return LAIKA_Account::find('user',self::init()->id);
    }
                            
}