<?php
class LAIKA_Uploader extends LAIKA_Singleton {

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    //const UPLOAD_PATH   = LAIKA_ROOT.'/tmp/uploads';
    //const MAX_FILE_SIZE = 1073741824; // 1048576KB, 1024M, 1G
    
    protected static $instance;
    
        
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------

    /**
     * upload function.
     * 
     * @access public
     * @param mixed $F
     * @return string
     */
    public function upload($F){
        
        $target = LAIKA_ROOT.'/tmp/uploads/'.basename($F['name']); 
        $error  = 0; 
     
        if($F['size'] > MAX_FILE_SIZE) 
            $error = 720; 
      
        if($F['type'] == "text/php") 
            $error = 750; 
    
        if($error!=0)
            self::upload_error($error);
            //throw new LAIKA_Exception('UPLOAD_USER_ERROR',$error);
        
        elseif(move_uploaded_file($F['tmp_name'], $target))    
            return $target; 
        else self::upload_error($error);    
        //throw new LAIKA_Exception('UPLOAD_MOVE_ERROR',$error);
    }
    
    public static function upload_error($error){
        LAIKA_Event::dispatch('UPLOAD_ERROR',$error);
    }
       
}