<?php
 
/**
 * Abstract LAIKA_Abstract_Page class.
 * 
 * @abstract
 * @extends LAIKA_Singleton
 */
abstract class LAIKA_Abstract_Page extends LAIKA_Singleton{

    private static $instance;
    public  static $access_level = 'PUBLIC';
    public  static $access_group = 'USER'; 

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
                    ${$key} = $value;
        if(!isset($component))
            $component = "DEFAULT";
        if(!isset($template))
            $template = "DEFAULT";

        include_once($class::add_component($component));
        include_once($class::add_template($template));
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
}