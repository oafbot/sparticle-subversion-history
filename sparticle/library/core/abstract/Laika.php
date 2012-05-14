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

    /**
     * __call function.
     * 
     * @access public
     * @param mixed $name
     * @param mixed $arg
     * @return mixed
     */
    public function __call($name,$arg){
        if(!empty($arg))
            $this->$name = $arg[0];
        else return $this->$name;
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
                $k = urlencode($key);
                $v = urlencode($value);
                ($x>0) ? $query .= "&$k=$v" : $query = "?$k=$v";
                $x++; }
            $snip .= $query; 
        endif;       
        header("Location: ".HTTP_ROOT.$snip);
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
        $path != "javascript" ? $tag .= 'href="'.HTTP_ROOT.$path.'" ' : $tag .= 'href="javascript:;" ';
        $tag .= $attribute_string;
        $tag .= '>';
        
        $link = $tag.$text.'</a>';
                    
        return $link;        
    }
    
    /**
     * img function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function img(){
        
        $src  = func_get_arg(0);
        
        if(func_num_args()>1)
            $args = func_get_arg(1);
        
        $attributes = "";
        
        if(isset($args))
            foreach($args as $key => $value)
                $attributes .= $key.'="'.$value.'" ';
                
        return '<img src='.$src.' '.$attributes.'/>';  
    }
    
    /**
     * from_array function.
     * 
     * Returns an instance of an object constructed from an array
     *
     * @access public
     * @static
     * @param  mixed  $array
     * @return object
     */
    public static function from_array($array){
        $class = get_called_class();
        $object = new $class();
        $properties = get_object_vars($object);
        foreach($array as $key => $value)
            if(array_key_exists($key,$properties))
                $object->$key = $value;
        return $object;
    }
    
    /**
     * to_array function.
     *
     * Returns an array from an object
     * 
     * @access public
     * @static
     * @return array
     */
    public function to_array(){
        $array = get_object_vars($this);
        return $array;
    }
    
    public static function pop_assoc($index,&$array){
        $value = &$array[$index];
        unset($array[$index]);
        return $value;
    }
    
    public static function pop_index($index,&$array){
        $value = &$array[$index];
        unset($array[$index]);
        array_values(&$array);
        return $value;        
    }
       
//-------------------------------------------------------------------
//	DESTRUCTOR
//-------------------------------------------------------------------     
    //private function __destruct(){}
    
        
}