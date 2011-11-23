<?php
class FOLIO_Assets_Controller extends LAIKA_Abstract_Page_Controller {

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
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
        
        $collection = FOLIO_Media::paginate(9,'id',LAIKA_User::active()->id());
        
        foreach($collection as $key => $value)
            $objects[] = $value::revive();
        return $objects; 
        //var_dump($collection);
        //var_dump($objects);
        die();        
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
        foreach($_POST as $key => $id){
            $media = FOLIO_Media::load($id);
            $path  = str_replace(HTTP_ROOT, PUBLIC_DIRECTORY, $media::find('id',$id)->path);
            if(unlink($path))   
                FOLIO_Media::delete($media);
        }
        self::redirect_to('/assets');    
    }
}