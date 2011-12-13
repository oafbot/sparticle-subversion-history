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
        if(is_int(strpos($class,CODE_NAME)))
            $this->model = str_replace(CODE_NAME.'_', "", $class, $count = 1);
        else
            $this->model = str_replace(LAIKA_NS, "", $class, $count = 1);
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
    
    /**
     * update function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function update(){
        $object = func_get_arg(0);
        $map = self::get_map();
        foreach($map as $key => $value)
            if(isset($object->$value))
                $properties[$value] = $object->$value;
        LAIKA_Database::batch_update($object->table,$properties,"id={$object->id}");
    }

    
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
        
        if(func_num_args()>0):
            $args = func_get_args();
            $result = LAIKA_Database::count($table,$args[0],$args[1]);
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
        $class = get_called_class();
        $m = new $class();
        $args = func_get_args();
        $table = $m->table;
        if(isset($args[0]) && $args[0] > 1):       
            $result = LAIKA_Database::last($table,$args[0]);
            foreach($result as $key => $value)
                $array[] = self::from_array($value);
            return $array;
        else:
            $result = LAIKA_Database::last($table,1);
            return self::from_array($result);
        endif;
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
            $result = LAIKA_Database::first($table,$args[0]);
        else
            $result = LAIKA_Database::first($table,1);
        return self::from_array($result);
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
    
    /**
     * find_with_offset function.
     * 
     * @access public
     * @static
     * @param mixed $param
     * @param mixed $value
     * @param mixed $offset
     * @param mixed $limit
     * @return void
     */
    public static function find_with_offset($param,$value,$offset,$limit){
        $class = get_called_class();
        $model = new $class();
        $table = $model->table;                
        return LAIKA_Database::find_with_offset($param,$value,$table,$limit,$offset);
    }    
    
            
    /**
     * paginate function.
     * 
     * @access public
     * @static
     * @return object
     */
    public static function paginate(){

        $num = func_num_args();
                
        ($num > 0) ? $limit = func_get_arg(0) : $limit = 10; 
        ($num > 1) ? $count = self::count(func_get_arg(1),func_get_arg(2)) : $count = self::count(); 

        $total  = ceil($count/$limit);
        
        if( !isset($_SESSION['pagination']) )
            $_SESSION['pagination'] = 1;
        elseif( $_SESSION['pagination'] > $total )
            $_SESSION['pagination'] = $total;
        
        if($_SESSION['pagination']>1)
            $offset = ($_SESSION['pagination']-1) * $limit;
        else
            $offset = 0;
        
        if($num==1):            
            $results = self::offset($offset,$limit);
        elseif($num>1):
            $param = func_get_arg(1);
            $value = func_get_arg(2); 
            $results = self::find_with_offset($param,$value,$offset,$limit);
        else:
            $results = self::offset($offset);
        endif;

        return self::collection($results);
    }    
    
    
    /**
     * render_pagination function.
     * 
     * @access public
     * @static
     * @param mixed $limit
     * @param mixed $param
     * @param mixed $value
     * @return void
     */
    public static function render_pagination($limit,$param,$value){

        $current = $_SESSION['pagination'];
        $style = "pagination_ellipsis";
                
        $count = self::count($param,$value);        
        $total = ceil($count/$limit);
        
        ($current+1 <= $total) ? ($inc = $current+1) : ( $inc = $current);
        ($current-1 < 1) ? ($dec = $current) : ( $dec = $current-1);
        
        self::link_to('&#60', '/assets', 
            array("class"=>"pagination nav", "style"=>"font-family:'WebFont'"), array('p'=>$dec));

        if($total<10):
            for($i=0;$i<$total;++$i){
                ($i+1 == $current) ? $css = 'pagination selected' : $css = 'pagination';
                self::link_to($i+1, '/assets', array('class'=>$css), array('p'=>$i+1));
            }
        else:
            if($current < 6):
                for($i=0;$i<5;++$i){
                    ($i+1 == $current) ? $css = 'pagination selected' : $css = 'pagination';
                    self::link_to($i+1, '/assets', array('class'=>$css), array('p'=>$i+1));
                }
                self::link_to('&#8230;', '/assets', array('class'=>$style), array('p'=>$current+2));
                for($i=$total-2;$i<$total;++$i){
                    ($i+1 == $current) ? $css = 'pagination selected' : $css = 'pagination';
                    self::link_to($i+1, '/assets', array('class'=>$css), array('p'=>$i+1));
                }
            elseif($current > $total-5):
                for($i=0;$i<2;++$i){
                    ($i+1 == $current) ? $css = 'pagination selected' : $css = 'pagination';
                    self::link_to($i+1, '/assets', array('class'=>$css), array('p'=>$i+1));
                }
                self::link_to('&#8230;', '/assets', array('class'=>$style), array('p'=>$current-2));
                for($i=$total-5;$i<$total;++$i){
                    ($i+1 == $current) ? $css = 'pagination selected' : $css = 'pagination';
                    self::link_to($i+1, '/assets', array('class'=>$css), array('p'=>$i+1));
                }
            else:
                for($i=0;$i<2;++$i){
                    ($i+1 == $current) ? $css = 'pagination selected' : $css = 'pagination';
                    self::link_to($i+1, '/assets', array('class'=>$css), array('p'=>$i+1));
                }
                if($current > 3 && $current+1 < $total-1){
                    self::link_to('&#8230;', '/assets', array('class'=>$style), array('p'=>$current-2));
                    for($i=$current-2;$i<$current+1;++$i){
                        ($i+1 == $current) ? $css = 'pagination selected' : $css = 'pagination';
                        self::link_to($i+1, '/assets', array('class'=>$css), array('p'=>$i+1));
                    }
                   self::link_to('&#8230;', '/assets', array('class'=>$style), array('p'=>$current+2));               
                }            
                for($i=$total-2;$i<$total;++$i){
                    ($i+1 == $current) ? $css = 'pagination selected' : $css = 'pagination';
                    self::link_to($i+1, '/assets', array('class'=>$css), array('p'=>$i+1));
            }
            endif;
        endif;    
        self::link_to('&#62','/assets', 
            array("class"=>"pagination nav", "style"=>"font-family:'WebFont'"), array('p'=>$inc));        
    }

    /**
     * link_to function.
     * 
     * Outputs a HTML link inside a anchor tag.
     * View Superclass Laika::link_to method for usage.
     *
     * @access public
     * @static
     * @return void
     */
    public static function link_to(){
        echo call_user_func_array('Laika::link_to', func_get_args() );
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