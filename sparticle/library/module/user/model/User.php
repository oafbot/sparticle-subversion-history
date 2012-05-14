<?php
/**
 * LAIKA_User class.
 *
 * User class with methods coupling it with the Active User class
 * 
 * @extends LAIKA_Abstract_Model
 */
class LAIKA_User extends LAIKA_Abstract_Model{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------
    const            LOGOUT_TIME = 300;  /* in seconds */

    protected static $instance;
    protected        $model;
    protected        $table;
    protected        $accessibles = array('id','username','email','firstname','lastname','logged_in','created','updated');
        
    protected        $id;
    protected        $username;
    protected        $password;
    protected        $salt;
    protected        $email;
    protected        $level;
    protected        $firstname;
    protected        $lastname;
    protected        $logged_in;

    protected        $created;
    protected        $updated;
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------

    /**
     * bind function.
     *
     * Registers a user as the active user in the Registry.
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
     * Retrieves the Active User object.
     * 
     * @access public
     * @static
     * @return object
     */
    public static function active(){
        return LAIKA_Active_User::active();            
    }
    
    /**
     * wake_up function.
     * 
     * Alias for the Active_User wake method
     * 
     * @access public
     * @static
     * @return object
     */
    public static function wake_up(){
        return LAIKA_Active_User::wake_up();
    }
    
    /**
     * sleep function.
     * 
     * Alias for the Active_User sleep method
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
     * Returns the full name of a user
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
     * valid_account function.
     *
     * Checks whether a user account is confirmed and not deactivated
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
     * Retrieves the account associated with a user
     * 
     * @access public
     * @return void
     */
    public function account(){
        return LAIKA_Account::find('user',$this->id);
    }
    
    /**
     * logged_in function.
     * 
     * @access public
     * @return void
     */
    public function logged_in(){
        
        if(func_num_args()>0)          
            $this->dset('logged_in', func_get_arg(0));
            
        elseif( LAIKA_Time::time_since($this->updated) > self::LOGOUT_TIME && $this->id != self::active()->id )
            $this->dset('logged_in', false);            
        
        elseif( $this->id == self::active()->id )
            $this->dset('logged_in', true);
        
        else $this->dget('logged_in');
        
        return $this->logged_in;      
    }
    
    public function avatar($size,$options=NULL){
        
        $attributes = "";        
        if($options) foreach($options as $key => $value)
                $attributes .= ' '.$key.'="'.$value.'"';
        
        $link = '<a href="'.HTTP_ROOT.'/user/'.$this->username.'"'.$attributes.' >';
        return $link.LAIKA_Avatar::img($this->email,$size).'</a>';
    }
    
    public function link_to_user(){
        if(func_num_args()==1):
            $text = $this->username;
            $attr = func_get_arg(0);
        elseif(func_num_args()>1):
            $text = func_get_arg(0);
            $attr = func_get_arg(1);
        else:
            $text = $this->username;
            $attr = "";
        endif;
        return self::link_to($text,'/user/'.$this->username,$attr);
    }                        
}