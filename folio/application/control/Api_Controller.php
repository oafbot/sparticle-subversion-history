<?php
class FOLIO_Api_Controller extends LAIKA_Abstract_Page_Controller {

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
    public    static $access_group = 'USER';
    public    static $caching      = FALSE;
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
	
	public function default_action(){echo 'HelloWorld';}

    
    public function image(){        
        
        $pair="";        
        foreach($this->parameters as $k => $v)
            $pair .= "-$k=$v";
        $cache = SYS_CACHE.'img'.urlencode($pair).'.cache';

        if(file_exists($cache)):
            $cached_image = new LAIKA_Image($cache);
            $cached_image->output();    
            
        else:
            $path = HTTP_ROOT.urldecode($this->parameters['src']);
            $image = new LAIKA_Image($path);
            
            /* WIDTH: */
            if(isset($this->parameters['w'])):
                $image->fixed_width($this->parameters['w']);
            /* HEIGHT */
            elseif(isset($this->parameters['h'])):
                $image->fixed_height($this->parameters['h']);
            /* SQUARE */
            elseif(isset($this->parameters['sq'])):
                $image->square($this->parameters['sq']);
            /* CONSTRAIN */
            elseif(isset($this->parameters['c'])):
                $p = explode('x',$this->parameters['c']);
                count($p)==1 ? $image->constrain($p[0]) : $image->constrain($p[0],$p[1]);
            /* RESIZE */
            elseif(isset($this->parameters['r'])):
                $p = explode('x',$this->parameters['r']);
                $image->resize($p[0],$p[1]);
            elseif(isset($this->parameters['k'])):
                $p = explode('x',$this->parameters['k']);
                $image->crop($p[0],$p[1]);
            elseif(isset($this->parameters['a'])):
                $image->auto_resize($this->parameters['a']);
            elseif(isset($this->parameters['rf'])):
                $image->reflection($path,$this->parameters['rf']);
            elseif(isset($this->parameters['op'])):
                $p = explode('x',$this->parameters['op']);
                $image->optimal($p[0],$p[1]);
            elseif(isset($this->parameters['rp'])):
                $rp = explode('x',$this->parameters['rp']);
                !isset($rp[1]) ? $percent      = 30 : $percent      = $rp[1];
                !isset($rp[2]) ? $transparency = 30 : $transparency = $rp[2];
                $image->reflection_plus($path,$rp[0],$percent,$transparency);
            endif;
            //$clone = clone $image;
            if(!isset($this->parameters['nocache']))            
                $image->save($cache);
            $image->output();
        endif;
    }
    
    public function avatar(){
        $user = LAIKA_User::find('id',$this->parameters['user']);
        if(isset($this->parameters['size']))
            $size = $this->parameters['size'];
        else
            $size = 120;
        echo $user->avatar($size);
    }
}