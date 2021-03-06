<?php
/**
 * Abstract LAIKA_Abstract_Singleton_Model class.
 * 
 * @abstract
 * @extends LAIKA_Singleton
 */
abstract class LAIKA_Abstract_Singleton_Model extends LAIKA_Singleton implements LAIKA_Interface_Model{

    protected static $instance;
    protected        $model;
    protected        $table;
    protected        $accessibles = array();
        
    protected        $id;
    protected        $created;
    protected        $updated;

//-------------------------------------------------------------------
//	CONSTRUCTOR
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
        $class = get_class($m);
        
        if(is_int(strpos($class,CODE_NAME)))
            $m->model = str_replace(CODE_NAME.'_', "", $class, $count = 1);
        else
            $m->model = str_replace(LAIKA_NS, "", $class, $count = 1);        
        $m->table = strtolower($m->model)."s";
        
        return $m;    
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

        static::init()->$property = $value;

        $table = static::init()->table;
        $id    = static::init()->id; 
        
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
        
        $table  = static::init()->table;
        $id     = static::init()->id;
        $result = LAIKA_Database::select_where($property, $table, "id = $id");
        
        static::init()->$property = $result[$property];
        
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
        $m =  $class::init();
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
        $class = get_called_class();
        LAIKA_Database::add($class::init());
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

        if(func_num_args()>0):
            $conditions =  self::prep_conditions(func_get_arg(0));
            $result = LAIKA_Database::count($table,$conditions);
        else:
            $result = LAIKA_Database::count($table);
        endif;
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

    
    /**
     * find_with_offset function.
     * 
     * @access public
     * @static
     * @param mixed $params
     * @param mixed $offset
     * @param mixed $limit
     * @return void
     */
    public static function find_with_offset($params,$offset,$limit){
        $table = self::init()->table;
        $conditions = $model::prep_conditions($params);
                        
        return LAIKA_Database::find_with_offset($conditions,$table,$limit,$offset);
    }    


    /**
     * prep_conditions function.
     * 
     * @access public
     * @static
     * @param mixed $params
     * @return void
     */
    public static function prep_conditions($params){
        $c = 0;
        foreach($params as $k => $v):
            ($c>0) ? $cond .= " AND $k = '$v'" : $cond = "$k = '$v'";
            $c++;
        endforeach;
                
        return $cond;    
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
                
        if($num==1):
            $limit = func_get_arg(0);            
            $results = self::offset($_SESSION[$offset],$limit);
            $_SESSION[$offset] += $limit;
        elseif($num>1):
            $limit = func_get_arg(0);
            $param = func_get_arg(1);
            $value = func_get_arg(2);
            $results = self::find_with_offset($where,$_SESSION[$offset],$limit);
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
    
    
    public function created_to_date(){
       return LAIKA_Time::database_to_date(self::init()->created);
    }
    public function created_to_shortdate(){
       return LAIKA_Time::database_to_shortdate(self::init()->created);
    }
    public function created_to_datetime(){
        return LAIKA_Time::database_to_datetime(self::init()->created);
    }
    public function created_to_time(){
        return LAIKA_Time::database_to_time(self::init()->created);
    }
    
    public function updated_to_date(){
        return LAIKA_Time::database_to_date(self::init()->updated);
    }
    public function updated_to_shortdate(){
        return LAIKA_Time::database_to_shortdate(self::init()->updated);    
    }
    public function updated_to_datetime(){
        return LAIKA_Time::database_to_datetime(self::init()->updated);
    }
    public function updated_to_time(){
        return LAIKA_Time::database_to_time(self::init()->updated);
    }

    /**
     * exists function.
     * 
     * @access public
     * @param mixed $conditions
     * @return void
     */
    public function exists($conditions){
        if(self::count($conditions))
            return true;
        return false;
    }    
}