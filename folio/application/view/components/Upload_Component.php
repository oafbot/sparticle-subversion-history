<?php 
if(!empty($_FILES) && isset($_FILES)):
        
    LAIKA_Event_Handler::init()->attach(
        LAIKA_Event_Listener::init("UPLOAD_SUCCESS","FOLIO_Upload_Controller","upload_handler") );
    
    LAIKA_Event_Handler::init()->attach(
        LAIKA_Event_Listener::init("UPLOAD_ERROR","FOLIO_Upload_Controller","upload_handler") );
    
    $file = new LAIKA_File();
    $file->upload($_FILES,MEDIA_DIRECTORY.'/'.LAIKA_User::active()->username);

endif;

self::render('upload');