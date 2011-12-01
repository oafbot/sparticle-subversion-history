<?php
class FOLIO_Assets_Controller extends LAIKA_Abstract_Page_Controller {

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PRIVATE';
    public    static $access_group = 'USER';
    protected        $ignore       = array('action_handler','edit','delete');
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
	
	public function default_action(){ $this->assets(); }
	
	/**
	 * assets function.
	 * 
	 * @access public
	 * @return void
	 */
	public function assets(){	        
        if(isset($this->parameters['alert']) && $this->parameters['alert']=='delete')
                $this->message('success','Selected files were successfully deleted.');
        else
            $this->display(array("page"=>"assets","user"=>LAIKA_User::active()->id()));             
    }
        
    /**
     * action function.
     * 
     * @access public
     * @return void
     */
    public function action(){
        
        $action = self::pop_assoc('action',$_POST);

        if(empty($_POST)||!isset($_POST)):
            $this->message('warning','Please select files for the specified action.');
        else:
            switch($action):
                case 'Delete':
                    $this->delete($_POST,$_SESSION['pagination']);
                    break;
                case 'Edit':
                    $this->edit($_POST,$_SESSION['pagination']);
                    break;
            endswitch;
        endif;
    }
    
    /**
     * save function.
     * 
     * @access public
     * @return void
     */
    public function save(){
        /* Determine id of object from post data */
        foreach($_POST as $key => $value):
            $array = explode('-',$key);
            $data[$array[1]][$array[0]] = $value;
        endforeach;

        foreach($data as $id => $array){
            /* @todo: sanitize input 
            $array = LAIKA_Validation::sanitize_form($array) */
            $media = FOLIO_Media::load($id);
            foreach($array as $key => $value)
                $media->$key($value);
            FOLIO_Media::update($media);
        }
        $this->message('success','Selected files were successfully edited.');
    }
    
    /**
     * edit function.
     * 
     * @access public
     * @param mixed $data
     * @return void
     */
    public function edit($data,$pagination){
        $this->display(array(
        "page"=>"assets",
        "user"=>LAIKA_User::active()->id(),
        "component"=>'edit',
        "editables"=>$_POST,
        "pagination"=>$pagination
        ));        
    }
    
    /**
     * delete function.
     * 
     * @access public
     * @return void
     */
    public function delete($data,$pagination){

        foreach($data as $key => $id){
            $media = FOLIO_Media::load($id);
            $path  = str_replace(HTTP_ROOT, PUBLIC_DIRECTORY, $media::find('id',$id)->path);
            if(unlink($path))   
                FOLIO_Media::delete($media);
        }
        //$this->message('success','Selected files were successfully deleted.');
        self::redirect_to('/assets', array('p'=>$pagination,'alert'=>'delete') );    
    }
    
    /**
     * message function.
     * 
     * @access public
     * @param mixed $type
     * @param mixed $message
     * @return void
     */
    public function message($type,$message){
        $this->display(array(
        "page"=>"assets",
        "user"=>LAIKA_User::active()->id(),
        "alert"=>$message,
        "alert_type"=>$type
        ));        
    }
    
    
    public function organize(){
    
    }
    
    
    
    
    public function list_directory(){

        $directory = MEDIA_DIRECTORY.'/'.LAIKA_User::active()->username();
        $iterator = new DirectoryIterator($directory);
        
        foreach($iterator as $file)
            if($file->isFile())
                $images[] = HTTP_ROOT.'/media/'.LAIKA_User::active()->username().'/'.$file->getFilename();        
        return $images;
    }
}