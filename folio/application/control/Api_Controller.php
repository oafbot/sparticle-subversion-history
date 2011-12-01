<?php
class FOLIO_Api_Controller extends LAIKA_Abstract_Page_Controller {

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
    public    static $access_group = 'USER';

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
	
	public function default_action(){echo 'HelloWorld';}

    
    public function image(){        
        $path =  HTTP_ROOT.urldecode($this->parameters['src']);

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
        endif;
        
        $image->output();
    }
    
}