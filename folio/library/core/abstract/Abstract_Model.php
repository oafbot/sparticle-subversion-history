<?php
/**
 * Abstract LAIKA_Abstract_Model class.
 * 
 * @abstract
 * @extends Laika
 */
abstract class LAIKA_Abstract_Model extends Laika implements LAIKA_Interface_Model{

    protected        $model;
    protected        $table;
    protected        $accessibles = array();
        
    protected        $id;

//-------------------------------------------------------------------
//	CONSTRUCTOR
//-------------------------------------------------------------------    
    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct(){
        $class = get_called_class();
        $this->model = str_replace(LAIKA_NS,"", $class,$count = 1);
        $this->table = strtolower($this->model)."s";        
    }

//-------------------------------------------------------------------
//	SETTER & GETTER METHODS
//-------------------------------------------------------------------    
    /**
     * dbset function.
     * 
     * @access public
     * @param  string $property
     * @param  mixed  $value
     * @return void
     */
    public function dset($property,$value){
        $this->$property = $value;
        $table = $this->table;
        $id    = $this->id;         
        LAIKA_Database::update($table, $property, $value, "id = $id");
    }
    
    /**
     * dbget function.
     * 
     * @access public
     * @param  string $property
     * @return mixed
     */
    public function dget($property){
        $table  = $this->table;
        $id     = $this->id;
        $result = LAIKA_Database::select_where($property, $table, "id = $id");
        $this->$property = $result[$property];
        return $result[$property];
    }
    
    
//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
    /**
     * load function.
     * 
     * @access public
     * @static
     * @param mixed $id
     * @return void
     */
    public static function load($id){
        $class = get_called_class();
        $m = new $class();
        $table = $m->table;

        $result = LAIKA_Database::select_by($id,$table);
        $model = get_class_vars(get_class($m));
        $count = count($model);
        
        foreach ($model as $property => $value)            
            if($property != 'instance' && $property != 'model' && $property != 'table' && $property != 'accessibles')
               $m->$property = $result[$property];
        return $m;
    }
    
    /**
     * find function.
     * 
     *
     * @access public
     * @static
     * @param mixed $param
     * @param mixed $value
     * @return void
     */
    public static function find($param,$value){
        $class = get_called_class();
        $m = new $class();
        $table = $m->table;
        $result = LAIKA_Database::select_where('id', $table, "$param = '$value'");
        return $m::load($result['id']);
    }
    
    /**
     * map_to_string function.
     * 
     * @access public
     * @static
     * @param mixed $ignore_id
     * @return void
     */
    public static function map_to_string($ignore_id){
        $columns = $this::get_map();
        if($ignore_id)
            foreach($columns as $key => $value)
                if($value != 'id')
                    $string[] = $value;  
        return implode(',',$string);
    }

    /**
     * get_map function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function get_map(){           
        $class = get_called_class();
        $m = new $class();
        $table = $m->table;

        $full_map = LAIKA_Database::show($table);
        foreach($full_map as $array => $column)
            foreach($column as $key => $value)
                if($key == 'Field')
                    $map[] = $value;
        return $map;
    }    
    
    /**
     * add function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function add(){
        $obj = func_get_arg(0);
        LAIKA_Database::add($obj);
    }
     
    /**
     * delete function.
     * 
     * @access public
     * @static
     * @param mixed $object
     * @return void
     */
    public static function delete($object){
        LAIKA_Database::delete($object->table,$object->id);
    }
        

    public static function create(){}
    public static function drop(){}
    public static function update(){}

    
    /**
     * count function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function count(){
        $class = get_called_class();
        $m = new $class();
        $table = $m->table;
        $result = LAIKA_Database::count($table);
        return (int)array_pop(array_pop($result));
    }    
    
    /**
     * last function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function last(){
        $class = get_called_class();
        $m = new $class();
        $args = func_get_args();
        $table = $m->table;
        if(isset($args[0]) && $args[0] > 1)       
            return LAIKA_Database::last($table,$args[0]);
        else
            return LAIKA_Database::last($table,1);
    }
    
    /**
     * first function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function first(){
        $args = func_get_args();
        $table = self::init()->table;
        if(isset($args[0]) && $args[0] > 1)       
            return LAIKA_Database::first($table,$args[0]);
        else
            return LAIKA_Database::first($table,1);
    }
    
    /**
     * offset function.
     * 
     * @access public
     * @static
     * @param mixed $offset
     * @param mixed $limit
     * @return void
     */
    public static function offset(){
        $num = func_num_args();
        $args = func_get_args();
        
        $class = get_called_class();
        $model = new $class();
        
        switch($num){
            case 0:
                $offset = 0;
                $limit  = 10;
                $column = '*';
                break;
            case 1:
                $offset = $args[0];
                $limit  = self::count();
                $column = '*';
                break;
            case 2:
                $offset = $args[0];
                $limit  = $args[1];
                $column = '*'; 
                break;
            case 3:
                $offset = $args[0];
                $limit  = $args[1];
                $column = $args[2];
                break;
        }
        $table = $model->table;
        return LAIKA_Database::offset($table,$column,$limit,$offset);
    }   
    
    public static function find_with_offset($param,$value,$offset,$limit){
        return LAIKA_Database::find_with_offset($param,$value,$offset,$limit);
    }    
    
    /**
     * paginate function.
     * 
     * @access public
     * @static
     * @param int $limit
     * @return void
     */
    public static function paginate(){
        $num = func_num_args();
        $class = get_called_class();
        $m = new $class();
        $model = $m->model;
        $offset = $model.'_offset';
        
        if( !isset($_SESSION[$offset]) )
            $_SESSION[$offset] = 0;
                
        if($num>0):
            $limit = func_get_arg(0);            
            $results = self::offset($_SESSION[$offset],$limit);
            $_SESSION[$offset] += $limit;
        else:
            $results = self::offset($_SESSION[$offset]);
        endif;
        
        return self::collection($results);
    }
        
    /**
     * collection function.
     * 
     * @access public
     * @static
     * @param mixed $array
     * @return void
     */
    public static function collection($array){
        $collection = new LAIKA_Collection();
        $class = get_called_class();
        $m = new $class();
        foreach($array as $key => $value)
            if(is_array($value))
                $collection[] = new LAIKA_Collectable($m::from_array($value));
        return $collection;    
    }
    
    /**
     * accessible function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function accessible(){
        $class = get_called_class();
        $object = new $class();
        $accessibles = $object->accessibles;
        foreach($accessibles as $key => $value)
            $response[$value] = $object->$value;
        return $response;
    }
        
    //public static function populate(){}
}