<?php
class LAIKA_Image extends Laika{

    private $image;
    private $type;
    
    /**
     * __construct function.
     * 
     * @access public
     * @param mixed $src (default: NULL)
     * @param mixed $action (default: NULL)
     * @param mixed $dimension (default: NULL)
     * @param mixed $save (default: NULL)
     * @return void
     */
    public function __construct($src=NULL,$action=NULL,$dimension=NULL,$save=NULL){

        if(func_num_args()>1):
            
            $d = explode('x',$dimension);
            $this->open($src);
            
            switch($action){
                case 'landscape':
                    $this->fixed_width($d[0]);
                    break;
                case 'portrait':
                    $this->fixed_height($d[0]);
                    break;
                case 'square':
                    $this->square($d[0]);
                    break;
                case 'constrain':
                    count($d)==1 ? $this->constrain($d[0]) : $this->constrain($d[0],$d[1]);
                    break;
                case 'resize':
                    $this->resize($d[0],$d[1]);
                    break;
                case 'crop':
                    $this->crop($d[0],$d[1]);
                    break;
                case 'auto':
                    $this->auto_resize($d[0]);
                    break;              
            }
            !$save ? $this->output() : $this->save($save);
        elseif(func_num_args()>0):
            $this->open($src);
        endif;
    }
            
    /**
     * open function.
     * 
     * @access public
     * @param mixed $file
     * @return void
     */
    public function open( $file ){
    
        $info = getimagesize( $file );
        $this->type = $info[2];
                
        if( $this->type == IMAGETYPE_JPEG ):
            $this->image = imagecreatefromjpeg($file);
      
        elseif( $this->type == IMAGETYPE_GIF ):
            $this->image = imagecreatefromgif($file);
      
        elseif( $this->type == IMAGETYPE_PNG ): 
            $this->image = imagecreatefrompng($file);
            imagesavealpha($this->image, true);
            //imagealphablending($this->image, false);
            //$this->preserve_transparency();
        endif;
    }
    
    public function preserve_transparency(){
        $trans = imagecolorallocate($this->image, 255, 255, 255);
        imagecolortransparent($this->image, $trans);    
    }       
           
    /**
     * save function.
     * 
     * @access public
     * @param mixed $name
     * @param mixed $type (default: IMAGETYPE_PNG)
     * @param int $compression (default: 75)
     * @param mixed $permissions (default: NULL)
     * @return void
     */
    public function save( $name, $type=IMAGETYPE_PNG, $compression=75, $permissions=NULL ){
    
        if( $type == IMAGETYPE_JPEG )
            imagejpeg($this->image,$name,$compression);
      
        elseif( $type == IMAGETYPE_GIF )
            imagegif($this->image,$name);
        
        elseif( $type == IMAGETYPE_PNG )
            imagepng($this->image,$name);
        
        if( $permissions != NULL)
            chmod($name,$permissions);
        
        imagedestroy($this->image);
    }
    
    
    /**
     * output function.
     * 
     * @access public
     * @param mixed $type (default: IMAGETYPE_PNG)
     * @return void
     */
    public function output( $type=IMAGETYPE_PNG ){
                    
        header("Cache-Control: private, max-age=10800, pre-check=10800");
        header("Pragma: private");
        header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));

        if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
            // if the browser has a cached version of this image, send 304
            header('Last-Modified: '.$_SERVER['HTTP_IF_MODIFIED_SINCE'],true,304);
            exit;
        }       
        
        if( $type == IMAGETYPE_JPEG ):
            header('Content-Type: image/jpeg');
            imagejpeg($this->image);
            
        elseif( $type == IMAGETYPE_GIF ):
            header('Content-Type: image/gif');
            imagegif($this->image);
                        
        elseif( $type == IMAGETYPE_PNG ):
            header('Content-Type: image/png');
            imagepng($this->image);
                        
        endif;        
        imagedestroy($this->image);
    }
      
    /**
     * width function.
     * 
     * @access public
     * @return void
     */
    public function width(){    
      return imagesx($this->image);
    }
    
    /**
     * height function.
     * 
     * @access public
     * @return void
     */
    public function height(){    
      return imagesy($this->image);
    }
    
    /**
     * fixed_height function.
     * 
     * @access public
     * @param mixed $height
     * @return void
     */
    public function fixed_height( $length ){    
      $ratio = $length / $this->height();
      $width = $this->width() * $ratio;
      $this->resize($width,$length);
    }

    /**
     * fixed_width function.
     * 
     * @access public
     * @param mixed $width
     * @return void
     */
    public function fixed_width( $length ){
      $ratio  = $length / $this->width();
      $height = $this->height() * $ratio;
      $this->resize($length,$height);
    }
    
    /**
     * scale function.
     * 
     * @access public
     * @param mixed $scale
     * @return void
     */
    public function scale( $scale ){
      $width  = $this->width()  * $scale/100;
      $height = $this->height() * $scale/100;
      $this->resize($width,$height);
    }
        
    /**
     * resize function.
     * 
     * @access public
     * @param mixed $width
     * @param mixed $height
     * @return void
     */
    public function resize( $width, $height ){
      $new = imagecreatetruecolor($width, $height);
      imagecopyresampled($new, $this->image, 0, 0, 0, 0, $width, $height, $this->width(), $this->height());
      $this->image = $new;
    }
    
    /**
     * auto_resize function.
     * 
     * @access public
     * @param mixed $constraint
     * @return void
     */
    public function auto_resize($constraint){
        if($this->orientation()=='L')
            $this->fixed_width($constraint);
        else
            $this->fixed_height($constraint);
    }
        
    /**
     * square function.
     * 
     * @access public
     * @param mixed $length
     * @return void
     */
    public function square($length){

        $this->orientation()=='L'   ? 
        $this->fixed_height($length): 
        $this->fixed_width($length);
        
        $this->crop($length,$length);
    }
        
    /**
     * constrain function.
     * 
     * @access public
     * @param mixed $x
     * @param mixed $y (default: NULL)
     * @return void
     */
    public function constrain( $x, $y=NULL ){
        if(!$y)
            $this->orientation()=='L' ? $this->fixed_width($x) : $this->fixed_height($x);
        else
            $this->orientation()=='L' ? $this->fixed_width($x) : $this->fixed_height($y);                
    }      
    
    /**
     * orientation function.
     * 
     * @access public
     * @return void
     */
    public function orientation(){
        
        if($this->width() > $this->height())
            $orientation = 'L';        
        elseif($this->height() > $this->width())
            $orientation = 'P';        
        else 
            $orientation = 'S';
        return $orientation;        
    }

	/**
	 * crop function.
	 * 
	 * @access private
	 * @param mixed $width
	 * @param mixed $height
	 * @param mixed $new_width
	 * @param mixed $new_height
	 * @return void
	 */
	private function crop($width, $height){

		$x = ( $this->width()  / 2 ) - ( $width  / 2 );
		$y = ( $this->height() / 2 ) - ( $height / 2 );
		
		$crop = $this->image;
		$this->image = imagecreatetruecolor($width, $height);
		imagecopyresampled($this->image, $crop , 0, 0, $x, $y, $width, $height, $width, $height);
	}

	
	public static function api_path($path,$function,$param){
        switch(strtolower($function)){
            case 'landscape':
                $f = 'w';
                break;
            case 'portrait':
                $f = 'h';
                break;
            case 'square':
                $f = 'sq';
                break;
            case 'constrain':
                $f = 'c';
                break;
            case 'resize':
                $f = 'r';
                break;
            case 'crop':
                $f = 'k';
                break;
            case 'auto':
                $f = 'a';
                break;              
        }

        $filepath = str_replace(HTTP_ROOT,'',$path);
/*        $name = str_replace('/','-',$filepath);
        $array = explode('.',$name);
        $name = $array[0]."-$f-$param".$array[1];
                
        if(file_exists(IMG_DIRECTORY."/cache/$name"))
            return IMG_DIRECTORY."/cache/$name";
*/
        return HTTP_ROOT.'/api/image?src='.urlencode($filepath)."&$f=$param";
	}   
}