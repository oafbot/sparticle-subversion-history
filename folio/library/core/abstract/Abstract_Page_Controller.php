<?php
/**
 * Abstract LAIKA_Abstract_Page_Controller class.
 * 
 * @abstract
 * @extends LAIKA_Abstract_Controller
 */
abstract class LAIKA_Abstract_Page_Controller extends LAIKA_Abstract_Controller{
    
    const            CACHE_TIME    = 60;
    
    public    static $access_level = 'PUBLIC'; // PUBLIC, PRIVATE, PROTECTED
    public    static $access_group = 'USER';   // USER, ADMIN, WORLD
    public    static $caching      = TRUE;
    protected        $ignore       = array('action_handler');
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------    
    /**
     * display function.
     * 
     * @access public
     * @return void
     */
    public function display(){
        $args = func_get_args();
        $view = str_replace('_Controller', '_Page', get_called_class());        
        $this->set_pagination();

        if(CACHE_PAGES && $this::$caching):
            $this->caching($args);
        else:
            ob_start(OB_HANDLER);
            $view::init()->render_page($args);          
        endif;

        ob_end_flush();
        LAIKA_Event::dispatch('PAGE_RENDER_COMPLETE',__FILE__);

        /*$html = ob_get_contents();
        $html = ob_get_clean();
        $config = array(
           'indent'=> false,
           'hide-comments' => true,
           'output-xhtml' => false,
           'wrap' => false
        );        
        $tidy = new tidy;
        $tidy->parseString($html, $config, 'utf8');
        $tidy->cleanRepair();
        echo tidy_get_output($tidy);
        ob_end_flush();*/

    }

    /**
     * caching function.
     * 
     * @access public
     * @param mixed $args
     * @return void
     */
    public function caching($args){
        $zip = true;
        $view  = str_replace('_Controller', '_Page', get_called_class());
        $class = get_called_class();
        $url   = urlencode( str_replace(HTTP_ROOT, "File_".md5(LAIKA_User::active()->username), LAIKA_Router::init()->uri) );
        //$cachefile = SYS_CACHE.basename($class, '.php') . '.cache';
        $cachefile = SYS_CACHE.$url.'.cache';
        clearstatcache();
        
        if (file_exists($cachefile) && filemtime($cachefile) > time() - $this::CACHE_TIME) { // good to serve!
            if($zip)
                echo gzuncompress(file_get_contents($cachefile));
            else include($cachefile);
            LAIKA_Event::dispatch('PAGE_RENDER_COMPLETE',__FILE__);
            exit;
        }        

        ob_start();
        $view::init()->render_page($args);        

        $contents = ob_get_contents();
        ob_end_clean();
        $handle = fopen($cachefile, "w");
        fwrite($handle, gzcompress($contents));
        fclose($handle);
        
        if($zip) echo gzuncompress(file_get_contents($cachefile));
        else include($cachefile);
        LAIKA_Event::dispatch('PAGE_RENDER_COMPLETE',__FILE__);        
    }
       
    /**
     * action_handler function.
     * 
     * Check if method exists. If called method does not exist or action_handler 
     * is called recursively, direct flow of control to the default_action.
     * Otherwise perform requested action.
     *
     * @access public
     * @param mixed $action
     * @param mixed $parameters
     * @return void
     */
    public function action_handler($action,$parameters){
        $this->ignore = array_merge($this->ignore, get_class_methods(get_parent_class(get_parent_class($this))));
        
        !empty($parameters) ? $this->parameters = $parameters : $this->parameters = NULL;        
        if( $action == 'default' )
            $this->default_action();
        else if( !method_exists(get_called_class(), $action) | in_array($action,$this->ignore)) 
            $this->default_action();
        else $this->$action();    
    }
        
    /**
     * default_action function.
     * 
     * @access public
     * @return void
     */
    abstract protected function default_action();

    
    /**
     * set_pagination function.
     * 
     * @access public
     * @return void
     */
    public function set_pagination(){
        if(!isset($this->parameters['p']))
            $_SESSION['pagination'] = 1;
        else
            $_SESSION['pagination'] = $this->parameters['p'];
    }
    
    /**
     * alert function.
     * 
     * @access public
     * @return void
     */
    public function alert(){        
        $view = str_replace('_Controller', '_Page', get_called_class());
        $view::init()->alert_type = $this->parameters['type'];
        $view::init()->alert = $this->parameters['message'];
        $view::render_alert();    
    }
}