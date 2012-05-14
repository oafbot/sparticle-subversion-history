<?php
class FOLIO_Content_Page extends LAIKA_Abstract_Page{

	protected static $instance;


    public function fullscreen(){
        $media = self::init()->media;        
        echo LAIKA_Image::api_path( $media->path, 'constrain', '800x600' ); 
    }

}