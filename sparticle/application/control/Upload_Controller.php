<?php
class FOLIO_Upload_Controller extends LAIKA_Abstract_Page_Controller {

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $parameters;

    public    static $access_level = 'PRIVATE';
    public    static $access_group = 'USER';
    public    static $caching      = FALSE;

    protected        $submenu      = USER_MENU;


//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
	
	/**
	 * default_action function.
	 * 
	 * @access public
	 * @return void
	 */
	public function default_action(){ 
	   $this->display(array(
	       "page"=>"upload",
	       "submenu"=>unserialize($this->submenu)
	       )); 
    }
	    
    /**
     * complete function.
     * 
     * @access public
     * @return void
     */
    public function complete(){
        $this->display(array(
        "page"=>"upload",
        "user"=>LAIKA_User::active()->id(),
        /*"alert"=>"Upload successful",
        "alert_type"=>"success",*/
        "upload"=>$this->parameters["upload"],
        "component"=>"complete",
        "submenu"=>unserialize($this->submenu) ));             
    }
    
    /**
     * progress function.
     * 
     * @access public
     * @return void
     */
    public function progress(){
       if(extension_loaded('uploadprogress'))
            echo $this->get_progress($this->parameters['uid']);                
    }
    
    /**
     * get_progress function.
     * 
     * @access public
     * @param mixed $id
     * @return void
     */
    public function get_progress($id){
        $status = uploadprogress_get_info($id);
        if($status)
            return round($status['bytes_uploaded']/$status['bytes_total']*100);
        return 100; 
    }
    
    /**
     * error function.
     * 
     * @access public
     * @return void
     */
    public function error(){
        $this->display(array(
        "page"=>"upload",
        "user"=>LAIKA_User::active()->id(),
        "submenu"=>unserialize($this->submenu),
        "alert"=>"Upload failed.",
        "alert_type"=>"warning" ));        
    }
    
    /**
     * upload_handler function.
     * 
     * @access public
     * @return void
     */
    public function upload_handler(){        
        $i = 0;
        $array = array();
        
        if(is_array(func_get_arg(1)))
            $array = func_get_arg(1);
            
        foreach($array as $key => $value):
            $media = new FOLIO_Media();
            $media->user         =  LAIKA_User::active()->id();
            $media->path         =  HTTP_ROOT.'/media/'.LAIKA_User::active()->username.'/'.$value;
            $media->type         =  "image";
            $media->privacy      =  1;
            $media->access_group =  'everyone';
            $media->created      =  date("Y-m-d");
            FOLIO_Media::add($media);
            
            ($i > 0) ? ($param['upload'] .= '+'.$value) : ($param['upload'] = $value);
            $i++;        
        endforeach;
        
        if(func_get_arg(0)=='UPLOAD_SUCCESS')
            self::redirect_to( '/upload/complete', $param );
        
        elseif(func_get_arg(0)=='UPLOAD_ERROR')
            self::redirect_to( '/upload/error');
    }
}