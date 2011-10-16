<?php
/**
 * Abstract LAIKA_Abstract_Model class.
 * 
 * @abstract
 * @extends LAIKA_Singleton
 */
abstract class LAIKA_Abstract_Model extends LAIKA_Singleton{

    protected static $instance;
    protected        $model;
    protected        $table;
    protected        $accessibles = array();
        
    protected        $id;

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------

    /**
     * init function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function init(){        
        $m = parent::init();
        $class_name = get_class($m);
        $m->model = str_replace(LAIKA_NS,"", $class_name,$count = 1);
        $m->table = strtolower($m->model)."s";
        return $m;    
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
        parent::set($member,$value);
        $table = parent::init()->table;
        $id    = parent::init()->id;         
        LAIKA_Database::update($table, $member, $value, "id = '$id'");      
    }
    
    /**
     * get function.
     * 
     * @access public
     * @static
     * @param mixed $member
     * @return void
     */
    public static function get($member){        
        return parent::get($member);
    }

    /**
     * __call function.
     * 
     * @access public
     * @param mixed $name
     * @param mixed $arg
     * @return void
     */
    public function __call($name,$arg){
        if(!empty($arg))
            self::set($name,$arg[0]);
        else
            self::get($name);
        return self::get($name);
    }    
    

    /**
     * load function.
     * 
     * @access public
     * @static
     * @param mixed $id
     * @return void
     */
    public static function load($id){
        $m =  self::init();
        $table = $m->table;
        
        $result = LAIKA_Database::select_by($id,$table);

        $model = get_class_vars(get_class($m));
        $count = count($model);
        
        foreach ($model as $member => $value)            
            if($member != 'instance' && $member != 'model' && $member != 'table' && $member != 'accessibles')
               $m->$member = $result[$member];
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
        $table = self::init()->table;
        $result = LAIKA_Database::select_where('id', $table, "$param = '$value'");
        return self::load($result['id']);
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
        $columns = self::get_map();
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
        $full_map = LAIKA_Database::show(self::init()->table);
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
        LAIKA_Database::add(self::init());
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
        
/*
    public static function create(){
        LAIKA_Database::create(self::init()->table);
    }
    public static function drop(){}
    public static function update(){}
*/
    
    /**
     * count function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function count(){
        $table = self::init()->table;
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
        $args = func_get_args();
        $table = self::init()->table;
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
        switch($num){
            case 0:
                $offset = 0;
                $limit  = 10;
                $column = '*';
                break;
            case 1:
                $offset = $args[0];
                //$limit  = 'ALL';
                $limit = self::count();
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
        $table = self::init()->table;
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
        $model = self::init()->model;
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
        foreach($array as $key => $value)
            if(is_array($value))
                $collection[] = new LAIKA_Collectable(self::from_array($value));
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
        $accessibles = self::init()->accessibles;
        foreach($accessibles as $key => $value)
            $response[$value] = self::init()->$value;
        return $response;
    }
        
    //public static function populate(){}
}