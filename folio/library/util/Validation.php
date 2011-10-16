<?php
/**
 * LAIKA_Validation class.
 * 
 * @extends Laika
 */
class LAIKA_Validation extends Laika{

    /**
     * validate_form function.
     * 
     * @access public
     * @param array $data
     * @param array $check
     * @param array $required
     * @return object
     */
    public function validate_form($data,$check,$required,$custom){
        if(isset($required))
            $result['required'] = self::check_required_fields($data,$required);
        if(isset($check)):
            if(filter_has_var(INPUT_POST,'email') && in_array('email',$check))
                $result['email'] = self::check_email($data['email']);
            if(in_array('password',$check))
                $result['password'] = self::check_password($data['password'],$data['verify']);
            if(in_array('password_strength',$check))
                $result['password_strength'] = self::check_password_strength($data['password']);
        endif;
        if(isset($custom))
            $result['custom'] = call_user_func($custom[0],$custom[1]);        
        $errors = LAIKA_Data::recursive_array_filter($result);      
        $v = new LAIKA_Validation_Responder($errors);
        return $v;   
    }

    
    /**
     * sanitize_form function.
     * 
     * @access public
     * @param array $data
     * @return array
     */
    public function sanitize_form($data){
        return $data;
    }
    
    /**
     * check_required_fields function.
     * 
     * @access public
     * @static
     * @param array $data
     * @param array $required
     * @return string
     */
    public static function check_required_fields($data,$required){
        $failed = array();
        if(in_array('ALL',$required))
            foreach($data as $key => $value){
                if(!isset($value) | empty($value))
                    $failed[$key] = 'Required information missing.<br />';}
        else
            foreach($required as $key => $value){
                if(!isset($data[$value]) | empty($data[$value]))
                    $failed[$key] = 'Required information missing.<br />';}
        return $failed;    
    }
    
    /**
     * check_email function.
     * 
     * @access public
     * @static
     * @param string $email
     * @return string
     */
    public static function check_email($email){
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
            return 'Email failed validation.<br />';
    }
    
    /**
     * check_password function.
     * 
     * @access public
     * @static
     * @param string $password
     * @param string $verify
     * @return string
     */
    public static function check_password($password,$verify){
        if($password != $verify)
            return 'Passwords did not match.<br />';
    }
    
    public static function check_password_strength($password){
/*
        if( strlen($pwd) < 8 )
        	$error .= "Password too short! <br />";
        if( strlen($pwd) > 20 )
        	$error .= "Password too long! <br />";
        if( strlen($pwd) < 8 )
        	$error .= "Password too short! <br />";
        if( !preg_match("#[0-9]+#", $pwd) )
        	$error .= "Password must include at least one number! <br />";
        if( !preg_match("#[a-z]+#", $pwd) )
        	$error .= "Password must include at least one letter! <br />";
        if( !preg_match("#[A-Z]+#", $pwd) )
        	$error .= "Password must include at least one CAPS! <br />";
        if( !preg_match("#\W+#", $pwd) )
        	$error .= "Password must include at least one symbol! <br />";
*/
        if(!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password))            
            return 'Password is weak.<br />';
    }
    
}





/**
 * LAIKA_Validation_Responder class.
 * 
 * @extends Laika
 */
class LAIKA_Validation_Responder extends Laika{

    private $passed;
    private $failed;
    
    /**
     * __construct function.
     * 
     * @access public
     * @param array $errors
     * @return void
     */
    public function __construct($errors){
        if(empty($errors))
            $this->passed = true;
        else
            $this->failed = $errors;
    }
    
    /**
     * passed function.
     * 
     * @access public
     * @return bool
     */
    public function passed(){
        return $this->passed;
    }
    
    /**
     * failed function.
     * 
     * @access public
     * @return array
     */
    public function failed(){
        return $this->failed;
    }
}