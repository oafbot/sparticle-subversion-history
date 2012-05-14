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
        $result = LAIKA_Database::query("SELECT path FROM medias WHERE privacy = true ORDER BY RAND() LIMIT 1","SINGLE");
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
    
    public function get_latest($object,$size,$percent){
        //echo '<img src="'.LAIKA_Image::api_path( $path, 'reflection+', $size.'x'.$percent ).'" />';
        self::img( LAIKA_Image::api_path($object->path,'reflection+','150x25x50'),
            array('class'=>'reflection', 'title'=>$object->name) );         
    }
    
    public function get_permalink($path){
/*
        $path = explode("/",$path);
        $media = array_pop($path);
        $user = array_pop($path);
        array_pop($path);
        echo implode("/",$path)."/content/".$user."?media=".$media;
*/      
        $media = FOLIO_Media::find('path',$path);
        echo self::init()->path_to('/content?id='.$media->id);
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
        $path  = self::init()->path;
        $media = FOLIO_Media::find('path',$path);
        if(LAIKA_Access::is_logged_in())
            $fav = FOLIO_Favorite::is_favorite( LAIKA_User::active()->id, $media->id, $media->type );
        else $fav = false;
        if($fav)
            return "&#78;";
        return "&#79;";        
    }
    
    public function fullscreen(){
        $path = self::init()->path;
        echo LAIKA_Image::api_path( $path, 'constrain', '800x600' ); 
    }
    
    public function next_set($limit){
        $_SESSION['pagination'] = $_SESSION['pagination']+1;
        self::paginate('FOLIO_Media',$limit,array(0),'latest',array('DESC'=>'created'));
    }
}