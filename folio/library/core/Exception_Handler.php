<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Exception_Handler.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     core
 *	@category       
 *	@date           2011-05-22 08:49:46 -0400 (Sun, 22 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
/**
 * LAIKA_Exception_Handler class.
 * 
 * Intercepts uncaught exceptions.
 * Notifies Observers of intercepted exceptions.
 *
 * @extends LAIKA_Singleton
 * @implements SplSubject
 */
class LAIKA_Exception_Handler extends LAIKA_Singleton implements SplSubject{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------
    /**
    * instance of LAIKA_Exception_Handler
    * 
    * @var    object
    * @access protected
    * @static
    */
    protected static $instance;
    /**
    * Array of SplObserver objects
    *
    * @var array
    */
    private $observers = array();

    /**
    * Uncaught exception
    *
    * @var Exception
    */
    public $exception;


//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
    /**
    * Attaches an SplObserver object to the handler
    *
    * @param SplObserver
    * @return void
    */
    public function attach(SplObserver $observer){
        $id = spl_object_hash($observer);
        $this->observers[$id] = $observer;
    }

    /**
    * Detaches the SplObserver object from the handler
    *
    * @param SplObserver
    * @return void
    */
    public function detach(SplObserver $observer){
        $id = spl_object_hash($observer);
        unset($this->observers[$id]);
    }

    /**
    * Notify all observers
    *
    * @return void
    */
    public function notify(){
        foreach($this->observers as $observer){
            $observer->update($this);
        }
    }

    /**
    * The Exception Handler calls notify() and outputs
    * a notice onscreen if DEVELOPMENT_ENVIRONMENT is set
    *
    * @return void
    */
    public function handle(Exception $e){
        $this->exception = $e;
        $this->notify();
        if(DEVELOPMENT_ENVIRONMENT == true):
            if(is_a($e,'ErrorException'))
                $trace = 
                    '<div id="php_error"><strong><span style="color:#faa51a;">PHP Interpreter ERROR ['.
                    $e->getCode().']:</span>  '.
                    $e->getMessage().' at Line( '.
                    $e->getLine().' )in File: '.
                    $e->getFile().'</strong><br /><br /><p><pre>'.
                    $e->getTraceAsString().'</pre></p></div>';
            else
                $trace =
                    '<div id="php_error"><strong><span style="color:#faa51a;">LAIKA ERROR ['.
                    $e->getCode().']:</span> '.
                    $e->getMessage().' at Line( '.
                    $e->getLine().' ) in File: '.
                    $e->getFile().'</strong><br /><br /><p><pre>'.
                    $e->getTraceAsString().'</pre></p></div>';
            $this->display($trace,$e->getFile(),$e->getLine());
        else:
            $message = '<div id="php_error">
                        <strong><span style="color:#faa51a;">APPLICATION ERROR</span></strong>
                        </div>';
            $this->display($message,NULL,NULL); 
        endif;        
    }
    
    /**
     * display function.
     * 
     * @access public
     * @param mixed $trace
     * @param mixed $file
     * @param mixed $line
     * @return void
     */
    public function display($trace,$file,$line){
        $exception_css = HTTP_ROOT.'/stylesheets/exception.css';
        $reset_css     = HTTP_ROOT.'/stylesheets/reset.css';
        isset($file) ? $source = highlight_file($file, true) : $source = "";
        $page = "<!DOCTYPE html>
                <html lang=en>
                <head>
                <meta charset=utf-8>
                <title>FRAMEWORK EXCEPTION</title>
                <link rel=\"shortcut icon\" href=/favicon.ico type=image/x-icon />
                <link rel=stylesheet href=$reset_css type=text/css>
                <link rel=stylesheet href=$exception_css type=text/css>
                </head>
                <body>
                <div id=main>
                $trace
                <div id=source>
                <h2>Source Code:</h2>
                $source
                </div>
                </div>
                </body>
                </html>"; 
        echo $page;
    }
}
