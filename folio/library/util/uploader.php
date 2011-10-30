<?php
class LAIKA_Uploader extends LAIKA_Singleton {

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    //const UPLOAD_PATH   = LAIKA_ROOT.'/tmp/uploads';
    const MAX_FILE_SIZE = 1073741824; // 1048576KB, 1024M, 1G
    
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

        $target = LAIKA_ROOT.'/tmp/uploads/'.basename($F['upload']['name']); 
        $error  = false; 
     
        if($F['upload']['size'] > self::MAX_FILE_SIZE) 
            $error = 720; 
      
        if($F['upload']['type'] == "text/php") 
            $error = 750; 
    
        if($error)
            throw new LAIKA_Exception('UPLOAD_USER_ERROR',$error);
        
        if(move_uploaded_file($F['upload']['tmp_name'], $target)) 
            //LAIKA_Event::dispatch('FILE_UPLOADED');    
            return $target;
        else throw new LAIKA_Exception('UPLOAD_MOVE_ERROR',$error);
    }   
}