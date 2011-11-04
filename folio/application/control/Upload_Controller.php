<?php
class FOLIO_Upload_Controller extends LAIKA_Abstract_Page_Controller {

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
    public    static $access_group = 'USER';

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
	
	public function default_action(){ $this->display(array("page"=>"upload")); }
	    
    public function complete(){
        $this->display(array(
        "page"=>"upload",
        "user"=>LAIKA_User::active()->id(),
        /*"alert"=>"Upload successful",
        "alert_type"=>"success",*/
        "upload"=>$this->parameters["upload"],
        "component"=>"complete" ));             
    }
    
    public function error(){
        $this->display(array(
        "page"=>"upload",
        "user"=>LAIKA_User::active()->id(),
        "alert"=>"Upload failed.",
        "alert_type"=>"warning" ));        
    }
    
    public function upload_handler(){
        
        $i = 0;
        $array = array();
        
        if(is_array(func_get_arg(1)))
            $array = func_get_arg(1);
        foreach($array as $key => $value):
            if($i > 0)
                $param['upload'] .= '+'.$value;
            else
                $param['upload'] = $value;
            $i++;
        endforeach;
        
        if(func_get_arg(0)=='UPLOAD_SUCCESS')
            self::redirect_to( '/upload/complete', $param );
        elseif(func_get_arg(0)=='UPLOAD_ERROR')
            self::redirect_to( '/upload/error');
    }
}