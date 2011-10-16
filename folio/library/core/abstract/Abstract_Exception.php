<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Abstract_Exception.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     abstract
 *	@category       
 *	@date           2011-05-22 08:50:52 -0400 (Sun, 22 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */ 
/**
 * Abstract LAIKA_Abstract_Exception class.
 * 
 * @abstract
 * @extends    Exception
 * @implements LAIKA_Interface_Exception
 */
abstract class LAIKA_Abstract_Exception extends Exception implements LAIKA_Interface_Exception{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------
    protected $message = 'Unknown exception';     // Exception message
    private   $string;                            // Unknown
    protected $code    = 0;                       // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private   $trace;                             // Unknown

//-------------------------------------------------------------------
//	CONSTRUCTOR
//-------------------------------------------------------------------

    /**
     * __construct function.
     * 
     * @access public
     * @param mixed $message (default: null)
     * @param int $code (default: 0)
     * @return void
     */
    public function __construct($message = null, $code = 0){
        if(!$message) throw new $this('Unknown '. get_class($this));
        parent::__construct($message, $code);
    }
   
    /**
     * __toString function.
     * 
     * @access public
     * @return void
     */
    public function __toString(){
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }

} 