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
     * If method name includes 'render_' it will render a partial
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
                    $class::init()->$key = $value;
        if(!isset($class::init()->component))
            $class::init()->component = "DEFAULT";
        if(!isset($class::init()->template))
            $class::init()->template = "DEFAULT";
        if(!isset($class::init()->page))
            $class::init()->page = strtolower(str_replace('_Page','',substr($class,6)));
        //include_once($class::add_component($component));
        include_once($class::add_template($class::init()->template));
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
        include_once($class::add_component($class::init()->component));    
    }    
    
    /**
     * render_alert function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function render_alert(){
        if(self::init()->alert_type == 'warning')
            $icon = '<span class=alert_icon >W</span>';
        elseif(self::init()->alert_type == 'success')
            $icon = '<span class=alert_icon >&#47;</span>';
        if(isset(self::init()->alert))
            echo '<div id="alert" class="'.self::init()->alert_type.'">'.$icon.self::init()->alert.'
            <a href="javascript:;" onclick="close_alert();" class="webfont close" title="close">&#215;</a>
            </div>';
    }
        
    /**
     * render function.
     *
     * renders a view partial
     * parameters passed into the method can be accessed from the called partial by 
     * the "$parameter" variable.
     * 
     * @access public
     * @static
     * @param mixed $partial
     * @return void
     */
    public static function render(){
        func_num_args()>1 ? $parameters = func_get_arg(1) : $parameters = NULL;
        $partial = func_get_arg(0);
        $class = get_called_class();
        
        if(file_exists(PUBLIC_DIRECTORY."/js/$partial.js"))
            echo '<script type="text/javascript" src="'.HTTP_ROOT.'/js/'.$partial.'.js"></script>';

        if(file_exists(PUBLIC_DIRECTORY."/stylesheets/$partial.css"))
            echo '<link rel="stylesheet" href="'.HTTP_ROOT.'/stylesheets/'.$partial.'.css" type="text/css">';

        include_once($class::add_partial($partial));
    }
    
    /**
     * render_foreach function.
     *
     * renders a view partial for each object in a collection
     * 
     * @access public
     * @static
     * @param mixed $partial
     * @return void
     */
    public static function render_foreach($partial,$collection){
        $class = get_called_class();
        $count = 0;
        foreach($collection as $label => $object)
            include($class::add_partial($partial));   
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
        $page = self::init()->page;
        $component = self::init()->component;
        
        foreach($args as $k => $v)
            if(file_exists(PUBLIC_DIRECTORY."/js/$v.js"))
                echo '<script type="text/javascript" src="'.HTTP_ROOT.'/js/'.$v.'.js"></script>';
        
        if(isset($page))
            if(file_exists(PUBLIC_DIRECTORY."/js/$page.js"))
                echo '<script type="text/javascript" src="'.HTTP_ROOT.'/js/'.$page.'.js"></script>';
                
        if(isset($component) && $component!="DEFAULT")
            if(file_exists(PUBLIC_DIRECTORY."/js/$component.js"))
                echo '<script type="text/javascript" src="'.HTTP_ROOT."/js/$component.js".'"></script>'; 
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
        $component = self::init()->component;
        foreach($args as $k => $v)
            if(file_exists(PUBLIC_DIRECTORY."/stylesheets/$v.css"))
                echo '<link rel="stylesheet" href="'.HTTP_ROOT.'/stylesheets/'.$v.'.css" type="text/css">';
            elseif(file_exists(PUBLIC_DIRECTORY."/$v.css"))
                echo '<link rel="stylesheet" href="'.HTTP_ROOT."/$v.css".'" type="text/css">';
        if(isset($page))
            echo '<link rel="stylesheet" href="'.HTTP_ROOT.'/stylesheets/'.$page.'.css" type="text/css">';
        if(isset($component) && $component!="DEFAULT")
            echo '<link rel="stylesheet" href="'.HTTP_ROOT.'/stylesheets/'.$component.'.css" type="text/css">';        
    }
    
    /**
     * add_style function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function add_style(){
        $args = func_get_args();
        foreach($args as $k => $v)
            if(file_exists(PUBLIC_DIRECTORY."/stylesheets/$v.css"))
                echo '<link rel="stylesheet" href="'.HTTP_ROOT.'/stylesheets/'.$v.'.css" type="text/css">';
            elseif(file_exists(PUBLIC_DIRECTORY."/$v.css"))
                echo '<link rel="stylesheet" href="'.HTTP_ROOT."/$v.css".'" type="text/css">';
             
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
    
    /**
     * img function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function img(){
        echo call_user_func_array('Laika::img', func_get_args());
    }    
    
    /**
     * paginate function.
     * 
     * @access public
     * @static
     * @param mixed $class
     * @param mixed $limit
     * @param mixed $k
     * @param mixed $v
     * @return void
     */
    public static function paginate($class,$limit,$params,$partial,$order=NULL){
        
        if($order)
           $c = $class::paginate($limit,$params,$order); 
        else        
            $c = $class::paginate($limit,$params);
        
        $collection = array();

        foreach($c as $key => $value)
            $collection[] = $value->revive();
        self::render_foreach($partial,$collection);    
    }
    
    public static function render_pagination(){
        
    }
    
    public static function set_login_redirect(){
        (func_num_args()>0) ? $url = HTTP_ROOT.func_get_arg(0) : $url = LAIKA_Router::init()->uri;
        $_SESSION['REDIRECT'] = $url;        
    }
        
}