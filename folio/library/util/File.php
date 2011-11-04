<?php
class LAIKA_File extends Laika{
    
   // private static $path;
    //private static $file;
    
    public function __construct(){}
    //self::$file = new SplFileObject(self::$path);

    
    public function open(){
        //copy($old, $new) or throw new LAIKA_Exception('FILE_OPEN_ERROR',850);
    }
    
    public function close(){
        //copy($old, $new) or throw new LAIKA_Exception('FILE_CLOSE_ERROR',859);
    }
    
    public function read(){
/*         copy($old, $new) or throw new LAIKA_Exception('FILE_READ_ERROR',854); */
    }
    
    public function write(){
/*         copy($old, $new) or throw new LAIKA_Exception('FILE_WRITE_ERROR',855); */
    }
    
    public function move($old,$new){
        if(copy($old, $new))
            unlink($old);
        else throw new LAIKA_Exception('FILE_MOVE_ERROR',853);
        return true;
    }
    
    public function delete(){
/*         unlink($this->) */
    }
    
    public function rename(){
/*         rename($old, $new) or throw new LAIKA_Exception('FILE_RENAME_ERROR',852); */
    }
    
    public function copy(){
/*         copy($old, $new) or throw new LAIKA_Exception('FILE_COPY_ERROR',851); */
    }
    
    public function upload($file,$move){
        
        if(!isset($file)||empty($file))
            LAIKA_Event::dispatch('UPLOAD_ERROR',0);    
        
        $f = array();
        $post = $file['upload'];
        $count = count($post['name']);

        for($i=0;$i<$count;$i++){
            foreach($post as $key => $array)
                $f[$i][$key] = $array[$i];
        }

        foreach($f as $index => $upload){
        
            $ext   = pathinfo($upload['name'],PATHINFO_EXTENSION);
            $user  = str_replace(MEDIA_DIRECTORY.'/',"",$move);
            $uuid  = uniqid(hash('crc32',$user).'_').".$ext";
            $path  = $move.'/'.$uuid;         
        
            if($this->move(LAIKA_Uploader::init()->upload($upload),$path))
                $success = true;
            else
                $success = false;           

            $ids[] = $uuid;             
        }
        
        if($success)
            LAIKA_Event::dispatch('UPLOAD_SUCCESS',$ids);
        else
            LAIKA_Event::dispatch('UPLOAD_ERROR',0);  
    }
    
    public function download(){}
}