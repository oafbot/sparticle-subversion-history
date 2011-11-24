<?php
class FOLIO_Assets_Controller extends LAIKA_Abstract_Page_Controller {

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PRIVATE';
    public    static $access_group = 'USER';

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
	
	public function default_action(){ $this->assets(); }
	
	public function assets(){
        $this->display(array(
        "page"=>"assets",
        "user"=>LAIKA_User::active()->id(),
        "gallery"=>$this->list_assets()
        ));             
    }
    
    public function list_assets(){
        
        if(!isset($this->parameters['p']))
            $_SESSION['pagination'] = 1;
        else
            $_SESSION['pagination'] = $this->parameters['p'];
        
        $collection = FOLIO_Media::paginate(8,'user',LAIKA_User::active()->id());
        $paths = array();

        foreach($collection as $key => $value)
            $paths[] = $value->revive()->path();
        return $paths;
    }
    
    public function list_directory(){

        $directory = MEDIA_DIRECTORY.'/'.LAIKA_User::active()->username();
        $iterator = new DirectoryIterator($directory);
        
        foreach($iterator as $file)
            if($file->isFile())
                $images[] = HTTP_ROOT.'/media/'.LAIKA_User::active()->username().'/'.$file->getFilename();        
        return $images;
    }
    
    public function delete(){
        if(empty($_POST)||!isset($_POST)){
            $this->message('warning','Please select files to be deleted.');return;
        }
        foreach($_POST as $key => $id){
            $media = FOLIO_Media::load($id);
            $path  = str_replace(HTTP_ROOT, PUBLIC_DIRECTORY, $media::find('id',$id)->path);
            if(unlink($path))   
                FOLIO_Media::delete($media);
        }
        self::redirect_to('/assets');    
    }
    
    public function message($type,$message){
        $this->display(array(
        "page"=>"assets",
        "user"=>LAIKA_User::active()->id(),
        "alert"=>$message,
        "alert_type"=>$type,
        "gallery"=>$this->list_assets()
        ));        
    }
}