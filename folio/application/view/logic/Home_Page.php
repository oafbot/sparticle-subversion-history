<?php
/**
 * FOLIO_Home_Page class.
 */
class FOLIO_Home_Page extends LAIKA_Abstract_Page{

	protected static $instance;
    protected $user;
    protected $title;
    protected $path;

    
    
    public function content(){
        if(LAIKA_Access::is_logged_in())
            self::render('home_hidden');
    }

    public function config(){        
        $result = LAIKA_Database::query("SELECT path FROM medias ORDER BY RAND() LIMIT 1","SINGLE");
        self::init()->path = $result['path'];
    }

    public function get_feature(){
        $path = self::init()->path;
        echo LAIKA_Image::api_path( $path, 'auto', 500 );   
    }
    
    public function get_reflection(){
        $path = self::init()->path;
        echo LAIKA_Image::api_path( $path, 'reflection', 500 );
    }
    
    public function get_title(){
        $path = self::init()->path;
        self::init()->title = FOLIO_Media::find('path',$path)->name;
        return self::init()->title;
    }
    
    public function get_user(){
        $path = self::init()->path;
        self::init()->user = LAIKA_User::find('id',FOLIO_Media::find('path',$path)->user);
        return self::init()->user;
    }
    
    public function get_id(){
        $path = self::init()->path;
        return FOLIO_Media::find('path',$path)->id;
    }
    
    public function get_fav(){
        $path = self::init()->path;
        $fav = FOLIO_Favorite::is_favorite( LAIKA_User::active()->id, FOLIO_Media::find('path',$path)->id);
        
        if($fav)
            return "&#78;";
        return "&#79;";        
    }
}