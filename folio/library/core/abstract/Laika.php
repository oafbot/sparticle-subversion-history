<?php
/**
 *	LEXICAL ACCESSOR IMPLEMENTATION for KERNEL APPLICATION
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
	
	const LAIKA_VERSION = 0.10;
	const LAIKA_RELEASE = 'beta'; // alpha, beta or gamma
	
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

    
    public static function version(){return LAIKA_VERSION;}
    
    public static function release(){return LAIKA_RELEASE;}
    
    /**
     * get function.
     * 
     * @access public
     * @static
     * @param mixed $member
     * @return void
     */
    public static function get($member){
        $class = get_called_class();
        return $class->$member;    
    }

    /**
     * set function.
     * 
     * @access public
     * @static
     * @param mixed $member
     * @param mixed $value
     * @return void
     */
    public static function set($member,$value){
        $class = get_called_class();
        $class->$member = $value;    
    }
    
    /**
     * reflect function.
     * 
     * @access public
     * @static
     * @return void
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
     * @access public
     * @static
     * @param string $text
     * @param string $path
     * @param array  $query
     * @param array  $attributes
     * @return void
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