<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Bootstrap.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     kernel
 *	@category       boot
 *	@date           2010-01-19 02:50:27 -0500 (Tue, 19 Jan 2010)
 *
 *	@author         Leonard M. Witzel <leonard_witzel@harvard.edu>
 *	@copyright      Copyright (c) 2010  Harvard University <{@link http://lab.dce.harvard.edu}>
 *
 */
 /**
 * LAIKA_Bootstrap class.
 * 
 * System Boot Loader
 *
 */
final class LAIKA_Bootstrap{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------    
    /**
     * BOOT_REGISTRY
     * 
     * The Framework Boot Registry
     *
     * All Essential Classes that are required for a successful system startup
     * and application execution are registered here. 
     * 
     * @var array    multidimensional array of registered filepaths
     * @access       public
     * @static
     *
     */
    public static $BOOT_REGISTRY = array();

	
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------    
    /**
     * set_paths function.
     * 
     * @access private
     * @static
     * @return void
     */
    private static function set_paths(){
    
        define( 'SYS_LIBRARY',   LAIKA_ROOT. '/library/core/');
        define( 'SYS_UTIL',      LAIKA_ROOT. '/library/util/');
        define( 'SYS_MODULE',    LAIKA_ROOT. '/library/module/');
        define( 'SYS_EXTENSION', LAIKA_ROOT. '/library/ext/' );
        define( 'SYS_CACHE',     LAIKA_ROOT. '/tmp/cache/');
    
        define( 'APP_CONTROL',         APPLICATION_ROOT. '/control/');
        define( 'APP_MODEL',           APPLICATION_ROOT. '/model/');
        define( 'APP_VIEW_LOGIC',      APPLICATION_ROOT. '/view/logic/');
        define( 'APP_VIEW_SHARED',     APPLICATION_ROOT. '/view/shared/');
        define( 'APP_VIEW_COMPONENTS', APPLICATION_ROOT. '/view/components/');
        define( 'APP_CONFIG',          APPLICATION_ROOT. '/library/config/');
        define( 'APP_PLUGIN',          APPLICATION_ROOT. '/library/plugin/');
        define( 'APP_UTIL',            APPLICATION_ROOT. '/library/util/');
    
    }



    /**
     * load_system_library function.
     * 
     * The autoloader for system files.
     *
     * @access private
     * @static 
     * @param  string $class_name
     * @return void
     */
    private static function load_system_library($class_name){    
      
        self::$BOOT_REGISTRY['LIB'] = array( SYS_LIBRARY, SYS_UTIL, SYS_MODULE );
      
        foreach( self::$BOOT_REGISTRY['LIB'] as $base_directory ){

            $class_name = str_replace(LAIKA_NS, "", $class_name);          
            $directory = new RecursiveIteratorIterator(new 
                                RecursiveDirectoryIterator($base_directory));

            foreach($directory as $file){
                if (file_exists(dirname($file) .'/'. $class_name . '.php')){
                    require_once (dirname($file) .'/'. $class_name . '.php');
                    return;
                }
            }
        }
        

        //throw new LAIKA_Exception('NO_CLASS', 900);
    }


    /**
     * load_application_library function.
     * 
     * The autoloader for application files.
     *
     * @access private
     * @static
     * @param mixed $class_name
     * @return void
     */
    private static function load_application_library($class_name){    

	   self::$BOOT_REGISTRY['APP'] = array( APP_CONTROL, APP_VIEW_LOGIC, APP_MODEL, APP_UTIL, APP_PLUGIN );
            
        foreach (self::$BOOT_REGISTRY['APP'] as $directory){          

            $class_name = str_replace( CODE_NAME.'_', "", $class_name);          

            if (file_exists($directory . $class_name . '.php')) {
                  require_once ($directory . $class_name . '.php');
                  return;
            }
        }
        //throw new LAIKA_Exception('NO_PAGE_CONTROLLER', 800);
        //echo $directory . $class_name . '.php';
        throw new LAIKA_Exception('NO_CLASS', 900);
    }   
    
    
    
    /**
     * set_reporting function.
     *
     * Sets Error Reporting to Development or Production Values 
     *
     * Sets the Error Reporting level of the runtime
     * environment according to the settings configured in
     * the end user (admin) config file.   
     *
     * @access private
     * @static
     * @return void
     */
    private static function set_reporting() {
        if (DEVELOPMENT_ENVIRONMENT == true) {
        	error_reporting(E_ALL ^ E_DEPRECATED);
        	ini_set('display_errors','On');
        	ini_set('error_log', LOG_DIRECTORY.'/error.log');
            require_once(LAIKA_ROOT.'/library/ext/FirePHPCore/FirePHP.class.php');
            ob_start();       	

        } 
        else {
        	error_reporting(E_ALL);
        	ini_set('display_errors','Off');
        	ini_set('log_errors',TRUE);
        	ini_set('error_log', LOG_DIRECTORY.'/error.log');
        }
    }
    
    
    
    /**
     * unregister_globals function.
     * 
     * Does what it says it does.
     *
     * @access private
     * @static
     * @return void
     */    
    private static function unregister_globals(){
        if(ini_get('register_globals')){
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $type)
                foreach ($GLOBALS[$type] as $key=>$var)
                    if($var === $GLOBALS[$key]) unset($GLOBALS[$key]);
        }
    }
      

    /**
     * execute function.
     *
     * Run the bootstrapping process:
     *
     * Sets the default timezone, unregisters global
     * Sets the error reporting level.
     * Initiates the autoloaders for the system and application
     * Sets bootup timestamp
     * 
     * @access public
     * @static
     * @return void
     */
    public static function execute(){
        
        /* Set Time Zone */
        date_default_timezone_set(TIME_ZONE);
        
        /* Clear Globals */
        self::unregister_globals();
        
        /* Set Error Reporting Level */
        self::set_reporting();
        
        self::set_paths();
        spl_autoload_register(array(__CLASS__,'load_system_library'),false,false);
        spl_autoload_register(array(__CLASS__,'load_application_library'),false,false);
        
        if(!isset($_SESSION['INIT_TIMESTAMP'])|empty($_SESSION['INIT_TIMESTAMP']))      
            $_SESSION['INIT_TIMESTAMP'] = microtime();
    
        define( 'INIT_TIMESTAMP', $_SESSION['INIT_TIMESTAMP'] );
        define( 'SESSION_TOKEN', md5(INIT_TIMESTAMP) );
        
        require_once(APP_CONFIG.'constants.conf.php');

     }
}