<?php  
if(!empty($_FILES) && isset($_FILES)):
    $file = new LAIKA_File();
    $upload = $file->upload($_FILES,MEDIA_DIRECTORY);
endif;   

self::render('upload');