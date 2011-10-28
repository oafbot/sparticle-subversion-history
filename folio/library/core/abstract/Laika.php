<?php
/**
 *	LIGHTWEIGHT AUTOLOAD IMPLEMENTATION for KERNEL and APPLICATION
 *
 *	@filesource 	Laika.php
 *
 *	@version    	0.1.0b
 *	@package    	laika
 *	@subpackage 	abstract
 *	@category   	root
 *	@date       	2010-01-18 02:29:45 -0500 (Mon, 18 Jan 2010)
 * 
 *	@author 	    Leonard M. Witzel <leonard_witzel@harvard.edu> 
 *	@copyright  	Copyright (c) 2010 Harvard University <{@link http://lab.dce.harvard.edu}>
 *
 */
 /**
 * Laika class.
 * 
 * Framework Superclass
 * 
 */
abstract class Laika{

//-------------------------------------------------------------------
//	CONSTANTS & VARIABLES
//-------------------------------------------------------------------
	
	const LAIKA_VERSION = 0.20;
	const LAIKA_RELEASE = 'alpha'; // alpha, beta, rc, production
	
//-------------------------------------------------------------------
//	CONSTRUCTOR
//-------------------------------------------------------------------
    
    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    private function __construct(){}

   
//-------------------------------------------------------------------
//	SETTER & GETTER METHODS
//-------------------------------------------------------------------

    /**
     * version function.
     *
     * Returns Version number 
     * 
     * @access public
     * @static
     * @return constant VERSION
     */
    public static function version(){return LAIKA_VERSION;}
    
    /**
     * release function.
     *
     * Returns Release type 
     *  
     * @access public
     * @static
     * @return constant RELEASE
     */
    public static function release(){return LAIKA_RELEASE;}
    
    /**
     * get function.
     * 
     * Base getter method
     *
     * @access public
     * @static
     * @param  mixed $property
     * @return mixed
     */
    public static function get($property){
        $class = get_called_class();
        return $class->$property;    
    }
    
    /**
     * __get function.
     * 
     * @access public
     * @param  mixed $property
     * @return mixed
     */

    public function __get($property){
        if (property_exists($this, $property))
            return $this->$property;
    } 
   
    /**
     * set function.
     * 
     * Base setter method
     * 
     * @access public
     * @static
     * @param mixed $property
     * @param mixed $value
     * @return void
     */

    public static function set($property,$value){
        $class = get_called_class();
        $class->$property = $value;    
    }

    
    /**
     * __set function.
     * 
     * @access public
     * @param  mixed $property
     * @param  mixed $value
     * @return void
     */
    public function __set($property, $value){
        $this->$property = $value;
    }


//-------------------------------------------------------------------
//	METHODS
//------------------------------------------------------------------- 
    
    /**
     * reflect function.
     * 
     * Returns a reflection class object of the current object.
     *
     * @access public
     * @static
     * @return Object ReflectionClass
     */
    public static function reflect(){
        $num = func_num_args();
        if($num>0)
            return new ReflectionClass(func_get_arg(0));
        else
            return new ReflectionClass(get_called_class());
    }
    
    /**
     * redirect_to function.
     *
     * Redirects to specified route.
     * If not specified, will reroute to default route.
     *
     * @access public
     * @static
     * @return void
     */
    public static function redirect_to(){
        $args = func_get_args();
        !isset($args[0]) ? $snip = '/'.DEFAULT_ROUTE : $snip = $args[0];
        if( isset($args[1]) ):
            $x = 0;
            foreach($args[1] as $key => $value){
                ($x>0) ? $query .= "&$key=$value" : $query = "?$key=$value";
                $x++; }    
        else:
            header("Location: ".HTTP_ROOT.$snip);
        endif;
    }
    
    /**
     * link_to function.
     * 
     * Constructs an anchor tag taking in the following parameters:
     *
     * link_to(String $text, String $url, Array $attributes, Array $query)
     *
     * 1 parameters: returns link with address as the text.
     * 2 paremeters: returns link with specified text.
     * 3 parameters: returns link with specified text and attributes.
     * 4 parameters: returns link with specified text, attributes, and query string. 
     *
     * @access public
     * @static
     * @param  string $text
     * @param  string $path
     * @param  array  $query
     * @param  array  $attributes
     * @return String
     */
    public static function link_to(){
        $attribute_string = '';
        $query_string = '';
        
        $args = func_get_args();
        $num  = func_num_args();
        
        switch( $num ){
            case 1:
                $text = $args[0];
                $path = $args[0];
                break;
            case 2:
                $text = $args[0];
                $path = $args[1];
                break;
            case 3:
                $text = $args[0];
                $path = $args[1];
                $attributes = $args[2];
                break;
            case 4:
                $text = $args[0];
                $path = $args[1];
                $attributes = $args[2];
                $query = $args[3];
                break;
        }
        
        
        if(isset($query)&&!empty($query)):
            $i = 0;
            foreach($query as $key => $value):
                if($i>0) $query_string .= "&$key=$value";
                else $query_string = "?$key=$value";
                $i++;
            endforeach;
            $path .= $query_string;
        endif;
        
        if(isset($attributes)&&!empty($attributes))
            foreach($attributes as $key => $value)
                $attribute_string .= "$key=\"$value\" ";
                    
        $tag  = '<a ';
        $tag .= 'href="'.HTTP_ROOT.$path.'" ';
        $tag .= $attribute_string;
        $tag .= '>';
        
        $link = $tag.$text.'</a>';
                    
        return $link;        
    }
    
       
//-------------------------------------------------------------------
//	DESTRUCTOR
//-------------------------------------------------------------------     
    //private function __destruct(){}
    
        
}