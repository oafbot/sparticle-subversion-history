<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Home_Controller.php
 *
 *	@version        0.1.0b
 *	@package        FOLIO
 *	@subpackage     control
 *	@category       control
 *	@date           2011-05-21 03:37:00 -0400 (Sat, 21 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
/**
 * FOLIO_Home_Controller class.
 * 
 * @extends LAIKA_Abstract_Page_Controller
 */
class FOLIO_Home_Controller extends LAIKA_Abstract_Page_Controller{

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';

    
    /**
     * default_action function.
     * 
     * @access public
     * @return void
     */
    public function default_action(){ $this->display(array("page"=>"home")); }


    /**
     * reload_image function.
     * 
     * @access public
     * @return void
     */
    public function reload_image(){
        $result = LAIKA_Database::query("SELECT * FROM medias ORDER BY RAND() LIMIT 1","SINGLE");
        $path   = $result['path'];
        $media  = FOLIO_Media::find('path',$path);
                
        $name = $media->name;
        $user = LAIKA_User::find('id',$media->user)->username;

        $image  = LAIKA_Image::api_path( $path , 'auto', 500 );
        $reflection = LAIKA_Image::api_path( $path, 'reflection', 500 );        
        
        $check = FOLIO_Favorite::is_favorite( LAIKA_User::active()->id, $media->id);
        ( $check )? $fav = "N" : $fav = "O";
        
        if(empty($name))
            $name = "Untitled";
        
        $json = array("title"=>$name, "user"=>$user, "image"=>$image, "reflection"=>$reflection, "favorite"=>$fav ); 
        echo json_encode($json);
    }
    
    public function favorite(){
        $id = $this->parameters['id'];
        FOLIO_Favorite::mark($id);
    }
    
    public function unfavorite(){        
        $id = $this->parameters['id'];        
        FOLIO_Favorite::undo(FOLIO_Favorite::find('item',$id));
    }    
}