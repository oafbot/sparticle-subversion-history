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
        $move .= '/'.$file['upload']['name'];
        return $this->move(LAIKA_Uploader::init()->upload($file),$move);
    }
    
    public function download(){}
}