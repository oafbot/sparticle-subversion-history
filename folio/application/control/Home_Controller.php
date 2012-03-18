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
        $result = LAIKA_Database::query("SELECT * FROM medias WHERE privacy = true ORDER BY RAND() LIMIT 1","SINGLE");
        $path   = $result['path'];
        $media  = FOLIO_Media::find('path',$path);
        $id     = $media->id;
                
        $name = $media->name;
        $user = LAIKA_User::find('id',$media->user)->username;

        $image  = LAIKA_Image::api_path( $path , 'auto', 500 );
        $reflection = LAIKA_Image::api_path( $path, 'reflection', 500 );
        
        $permalink = implode( "/", array_slice(explode("/",$path), 0, 4) )
                        ."/content/".$user."?media=".array_pop(explode("/",$path));
        
        if(LAIKA_Access::is_logged_in())
            $check = FOLIO_Favorite::is_favorite( LAIKA_User::active()->id, $media->id);
        else 
            $check = false;
        ( $check )? $fav = "N" : $fav = "O";
        
        if(empty($name))
            $name = "Untitled";
        
        $json = array("title"=>$name, 
                      "user"=>$user, 
                      "image"=>$image, 
                      "reflection"=>$reflection, 
                      "favorite"=>$fav, 
                      "id"=>$id,
                      "path"=>LAIKA_Image::api_path( $path, 'constrain', '800x600' ),
                      "permalink"=>$permalink
                      ); 
        
        echo json_encode($json);
    }
    
    /**
     * favorite function.
     * 
     * @access public
     * @return void
     */
    public function favorite(){
        $id = $this->parameters['id'];
        FOLIO_Favorite::mark($id);
    }
    
    /**
     * unfavorite function.
     * 
     * @access public
     * @return void
     */
    public function unfavorite(){        
        $id = $this->parameters['id'];        
        FOLIO_Favorite::undo(FOLIO_Favorite::find('item',$id));
    }    
}