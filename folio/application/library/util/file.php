<?php
class FOLIO_File extends LAIKA_File{

    public function upload($file,$move){
        LAIKA_Event_Handler::init()->attach(
            LAIKA_Event_Listener::init("UPLOAD_SUCCESS","FOLIO_File","upload_handler") );
        parent::upload($file,$move);
    }
    
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
        endforeach;
    }
}