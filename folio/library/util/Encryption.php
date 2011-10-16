<?php
class LAIKA_Encryption extends Laika{
    
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------    

    public static function encrypt($key,$string){
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
    }
    
    public static function decrypt($key,$encrpted){
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    }
    
}