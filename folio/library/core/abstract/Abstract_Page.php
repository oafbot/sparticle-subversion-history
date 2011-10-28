<?php
 
/**
 * Abstract LAIKA_Abstract_Page class.
 * 
 * @abstract
 * @extends LAIKA_Singleton
 */
abstract class LAIKA_Abstract_Page extends LAIKA_Singleton{

    private static $instance;
    private        $template;
    private        $component;
    private        $page;
    
    public  static $access_level = 'PUBLIC';
    public  static $access_group = 'USER'; 
    

    /**
     * __callStatic function.
     * 
     * If method name includes 'render_' it will render q partial
     * Otherwise it will echo a proprerty.
     *
     * @access public
     * @static
     * @param string $name
     * @param mixed $arg
     * @return void
     */
    public static function __callStatic($name,$arg){
        $class = get_called_class();
        if(substr($name,0,7)=='render_'):
            $class::render(substr($name,7));
        elseif(empty($arg)):
            echo $class::init()->$name;
        elseif(is_array($class::init()->$name)):
            $array = $class::init()->$name;
            echo $array[$arg[0]];
        endif;
    }    
        
    /**
     * render_page function.
     * 
     * @access public
     * @return void
     */
    public function render_page(){
        
        $class = get_called_class();
        $arg   = func_get_arg(0);
               
        if( !empty($arg) )
            foreach($arg as $params)
                foreach( $params as $key => $value)
                    self::init()->$key = $value;
        if(!isset(self::init()->component))
            self::init()->component = "DEFAULT";
        if(!isset(self::init()->template))
            self::init()->template = "DEFAULT";
        if(!isset(self::init()->page))
            self::init()->page = strtolower(str_replace('_Page','',substr($class,6)));
        //include_once($class::add_component($component));
                
        include_once($class::add_template(self::init()->template));
    }
    
        
    /**
     * render_component function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function render_component(){
        $class = get_called_class();
        include_once($class::add_component(self::init()->component));    
    }    
    
    /**
     * render_alert function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function render_alert(){
        if(isset(self::init()->alert))
            echo '<div id="alert" class="'.self::init()->alert_type.'">'.self::init()->alert.'</div>';
    }
    
    /**
     * render function.
     * 
     * @access public
     * @static
     * @param mixed $partial
     * @return void
     */
    public static function render($partial){
        $class = get_called_class();
        include_once($class::add_partial($partial));
    }
    
    /**
     * add_partial function.
     * 
     * @access public
     * @static
     * @param string $partial
     * @return void
     */
    public static function add_partial($partial){
        if(file_exists(APP_VIEW_SHARED.'partials/'.$partial.'.php'))
            return APP_VIEW_SHARED.'partials/'.$partial.'.php';
        elseif(file_exists(APP_VIEW_COMPONENTS.'partials/'.$partial.'.php'))
            return APP_VIEW_COMPONENTS.'partials/'.$partial.'.php';
        elseif(file_exists($partial.'php'))
            return $partial.'php';
        throw new LAIKA_Exception('MISSING_PARTIAL',811);
    }
    
    /**
     * add_logic function.
     * 
     * @access public
     * @static
     * @param mixed $file
     * @return void
     */
    public static function add_logic($file){
        include_once(APP_VIEW_LOGIC.basename($file).'_logic.php');
    }
    
    /**
     * add_component function.
     * 
     * @access public
     * @param string $component
     * @return string
     */
    public function add_component($component){
        $class_name = get_called_class();
        $page_name  = str_replace(CODE_NAME.'_',"", $class_name,$count = 1); 
                
        if($component == "DEFAULT")
            $page_name  = str_replace('_Page',"_Component",$page_name,$count = 1);             
        else           
            $page_name  = str_replace('_Page','_'.ucfirst(strtolower($component)).'_Component',$page_name,$count = 1);
        return APP_VIEW_COMPONENTS.$page_name.'.php';        
    }
    
    /**
     * add_template function.
     * 
     * @access public
     * @param string $template
     * @return string
     */
    public function add_template($template){
        $class_name = get_called_class();
        $page_name  = str_replace(CODE_NAME.'_',"", $class_name,$count = 1);

        if($template == "DEFAULT"):
            return APP_VIEW_SHARED.'default_template.php';
        else:
            str_replace('_Page','_'.ucfirst(strtolower($template)).'_Template',$page_name,$count = 1);
            return APP_VIEW_SHARED.$page_name.'.php';
        endif;
    }

    
    /**
     * scripts function.
     *
     * Outputs javascript src includes constructed from parameters
     * 
     * @access public
     * @static
     * @return void
     */
    public static function scripts(){
        $args = func_get_args();
        foreach($args as $k => $v)
            echo '<script type="text/javascript" src="'.HTTP_ROOT.'/js/'.$v.'.js"></script>';
    }
    
    /**
     * styles function.
     *
     * Outputs stylesheet includes constructed from parameters
     * 
     * @access public
     * @static
     * @return void
     */
    public static function styles(){
        $args = func_get_args();
        $page = self::init()->page;
        foreach($args as $k => $v)
            echo '<link rel="stylesheet" href="'.HTTP_ROOT.'/stylesheets/'.$v.'.css" type="text/css">';
        echo '<link rel="stylesheet" href="'.HTTP_ROOT.'/stylesheets/'.$page.'.css" type="text/css">';        
    }
    
    /**
     * path function.
     *
     * Outputs url.
     * 
     * @access public
     * @static
     * @param string $path
     * @return void
     */
    public static function path_to($path){
        echo HTTP_ROOT.$path;
    }
    
    /**
     * link_to function.
     * 
     * Outputs a HTML link inside a anchor tag.
     * View Superclass Laika::link_to method for usage.
     *
     * @access public
     * @static
     * @return void
     */
    public static function link_to(){
        echo call_user_func_array('Laika::link_to', func_get_args() );
    }
}