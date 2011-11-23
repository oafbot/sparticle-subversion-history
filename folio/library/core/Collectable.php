<?php
class LAIKA_Collectable extends Laika{

    /**
     * __construct function.
     * 
     * @access public
     * @param mixed $name
     * @param mixed $array
     * @return void
     */
    public function __construct($object){
        if(is_subclass_of($object,'LAIKA_Singleton')):
            $array = $object->to_array();
        elseif(is_subclass_of($object,'Laika')):
            //$array = $object::reflect()->getProperties();
            $array = $object->to_array();
        else:
            $ref = new ReflectionClass($object);
            $array = $ref->getProperties();
        endif;        
        $name = get_class($object);
        return $this->freeze($name,$array);
    }

    /**
     * get_var function.
     * 
     * @access public
     * @param mixed $key
     * @return void
     */
    public function get_property($key){
        $object = $this->revive();
        if(is_subclass_of($object,'Laika'))
            return $object->$key;
        else throw new LAIKA_Exception('INVALID_DATA_TYPE',800);
    }
    
    /**
     * freeze function.
     * 
     * @access public
     * @param mixed $name
     * @param mixed $array
     * @return void
     */
    public function freeze($name,$array){
        $this->object_type = $name;
        foreach($array as $k => $value){
            if(is_a($value,'ReflectionProperty')):
                $value->setAccessible(true);
                $key = $value->getName();
                $this->$key = $value->getValue($value);
            else:
                $this->$k = $value;
            endif;}
        return $this;    
    }
    
    /**
     * revive function.
     * 
     * @access public
     * @return void
     */
    public function revive(){
        $class = $this->object_type;

        is_subclass_of($class,'LAIKA_Singleton') ? $object = $class::init() : $object = new $class();
        $vars = get_object_vars($this);
        foreach($vars as $key => $value) 
            if($key!='object_type')
                $object->$key($value);
        return $object;
    }
}