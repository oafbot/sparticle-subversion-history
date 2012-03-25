<?php
/**
 * Abstract LAIKA_Abstract_Model class.
 * 
 * @abstract
 * @extends Laika
 */
abstract class LAIKA_Abstract_Model extends Laika implements LAIKA_Interface_Model{

/**
* @todo May be a good idea to make $table and $model static or class constants
* to avoid excessive object construction in static funcions... 
*
*/
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
    public static function find_with_offset($params,$offset,$limit){
        $class = get_called_class();
        $model = new $class();
        $table = $model->table; 
        $conditions = $model::prep_conditions($params);
                       
        return LAIKA_Database::find_with_offset($conditions,$table,$limit,$offset);
    }    
    
    /**
     * find_with_offset_order_by function.
     * 
     * @access public
     * @static
     * @param mixed $params
     * @param mixed $offset
     * @param mixed $limit
     * @param mixed $ord
     * @return void
     */
    public static function find_with_offset_order_by($params,$offset,$limit,$ord){
        $class = get_called_class();
        $model = new $class();
        $table = $model->table; 
        $conditions = $model::prep_conditions($params);
        
        $order = key($ord);
        $by = $ord[$order];
                       
        return LAIKA_Database::find_with_offset_order_by($conditions,$table,$limit,$offset,$by,$order);    
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
     * @return object
     */
    public static function paginate(){
        $class = get_called_class();
        $m = new $class();
        $table = $m->table;
        
        $num = func_num_args();
                
        ($num > 0) ? $limit = func_get_arg(0) : $limit = PAGINATION_LIMIT;        
        ($num > 1) ? $count = self::count(func_get_arg(1)) : $count = self::count(); 

        $total = ceil($count/$limit);
        
        if( !isset($_SESSION['pagination']) )
            $_SESSION['pagination'] = 1;
        elseif( $_SESSION['pagination'] > $total )
            $_SESSION['pagination'] = $total;
        
        if($_SESSION['pagination']>1)
            $offset = ($_SESSION['pagination']-1) * $limit;
        else
            $offset = 0;
        
        /* If only the LIMIT is specified */
        if($num==1):            
            $results = self::offset($offset,$limit);
        
        /* If the LIMIT and conditions are specified */
        elseif($num==2):
            $results = self::find_with_offset(func_get_arg(1),$offset,$limit);
        
        /* If the LIMIT, conditions and ORDER BY are specified */
        elseif($num>2):
            $results = self::find_with_offset_order_by(func_get_arg(1),$offset,$limit,func_get_arg(2));
        
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
    public static function render_pagination($limit,$params,$controller){

        $current = $_SESSION['pagination'];
        $style = "pagination_ellipsis";
                
        $count = self::count($params);                
        $total = ceil($count/$limit);
        
        ($current+1 <= $total) ? ($inc = $current+1) : ( $inc = $current);
        ($current-1 < 1) ? ($dec = $current) : ( $dec = $current-1);
                
        self::link_to('&#60', "/$controller", 
            array("class"=>"pagination nav", "style"=>"font-family:'WebFont'"), array('p'=>$dec));
        
        if($total<10):
            for($i=0;$i<$total;++$i)
                self::pagination_link_helper($page=$i+1,$current,$controller);
        else:
            if($current < 6):                
                for($i=0;$i<5;++$i)
                    self::pagination_link_helper($page=$i+1,$current,$controller);
                
                self::link_to('&#8230;', "/$controller", array('class'=>$style), array('p'=>$current+2));
                
                for($i=$total-2;$i<$total;++$i)
                    self::pagination_link_helper($page=$i+1,$current,$controller);
            
            elseif($current > $total-5):
                for($i=0;$i<2;++$i)
                    self::pagination_link_helper($page=$i+1,$current,$controller);
                    
                self::link_to('&#8230;', "/$controller", array('class'=>$style), array('p'=>$current-2));
                
                for($i=$total-5;$i<$total;++$i)
                    self::pagination_link_helper($page=$i+1,$current,$controller);
            
            else:
                for($i=0;$i<2;++$i)
                    self::pagination_link_helper($page=$i+1,$current,$controller);
                
                if($current > 3 && $current+1 < $total-1){
                    self::link_to('&#8230;', "/$controller", array('class'=>$style), array('p'=>$current-2));
                    
                    for($i=$current-2;$i<$current+1;++$i)
                        self::pagination_link_helper($page=$i+1,$current,$controller);
                        
                   self::link_to('&#8230;', "/$controller", array('class'=>$style), array('p'=>$current+2));               
                }            
                
                for($i=$total-2;$i<$total;++$i)
                    self::pagination_link_helper($page=$i+1,$current,$controller);
            endif;        
        endif;    
        
        self::link_to('&#62',"/$controller", 
            array("class"=>"pagination nav", "style"=>"font-family:'WebFont'"), array('p'=>$inc));        
    }

    
    /**
     * render_ajax_pagination function.
     * 
     * @access public
     * @static
     * @param mixed $limit
     * @param mixed $params
     * @param mixed $controller
     * @return void
     */
    public static function render_ajax_pagination($limit,$params,$controller){

        $current = $_SESSION['pagination'];
        $style = "pagination_ellipsis";
                
        $count = self::count($params);        
        $total = ceil($count/$limit);
        
        ($current+1 <= $total) ? ($inc = $current+1) : ( $inc = $current);
        ($current-1 < 1) ? ($dec = $current) : ( $dec = $current-1);
                
        self::link_to('&#60', "javascript", 
            array('class'=>'pagination nav', 
                  'style'=>"font-family:'WebFont'", 
                  'onclick'=>"ajax_pagination($dec,'$controller');"));
        
        if($total<10):
            for($i=0;$i<$total;++$i)
                self::ajax_pagination_link_helper($text=$i+1, $current, $page=$i+1, $controller);
        
        else:            
            if($current < 6):
                for($i=0;$i<5;++$i)
                    self::ajax_pagination_link_helper($text=$i+1, $current, $page=$i+1, $controller);
                
                self::ajax_pagination_link_helper('&#8230;', $current, $page=$current+2, $controller);
                
                for($i=$total-2;$i<$total;++$i)
                    self::ajax_pagination_link_helper($text=$i+1, $current, $page=$i+1, $controller);
            
            elseif($current > $total-5):
                for($i=0;$i<2;++$i)
                    self::ajax_pagination_link_helper($text=$i+1, $current, $page=$i+1, $controller);                
                
                self::ajax_pagination_link_helper('&#8230;', $current, $page=$current-2, $controller);

                for($i=$total-5;$i<$total;++$i)
                    self::ajax_pagination_link_helper($text=$i+1, $current, $page=$i+1, $controller);

            else:
                for($i=0;$i<2;++$i)
                    self::ajax_pagination_link_helper($text=$i+1, $current, $page=$i+1, $controller);
                    
                if($current > 3 && $current+1 < $total-1){
                    self::ajax_pagination_link_helper('&#8230;', $current, $page=$current-2, $controller);
                    
                    for($i=$current-2;$i<$current+1;++$i)
                        self::ajax_pagination_link_helper($text=$i+1, $current, $page=$i+1, $controller);
                    
                    self::ajax_pagination_link_helper('&#8230;', $current, $page=$current+2, $controller);
                }            
                for($i=$total-2;$i<$total;++$i)
                    self::ajax_pagination_link_helper($text=$i+1, $current, $page=$i+1, $controller);
            endif;
            
        endif;    
        
        self::link_to('&#62',"javascript", 
            array("class"=>"pagination nav", "style"=>"font-family:'WebFont'", 'onclick'=>"ajax_pagination($inc,'$controller');"));        
    }
    
/*     Should this be in a helper utility class? */
    public static function ajax_pagination_link_helper($text,$current,$page,$controller){
        ($text != $page) ? $css = 'pagination_ellipsis' : $css = 'pagination';
        ($page == $current) ? $css = 'pagination selected' : $css = 'pagination';
        $attributes = array('class'=>$css, 'onclick'=>"ajax_pagination($page,'$controller');");
        self::link_to($text, "javascript", $attributes);    
    }

    public static function pagination_link_helper($page,$current,$controller){
        ($page == $current) ? $css = 'pagination selected' : $css = 'pagination';
        self::link_to($page, "/$controller", array('class'=>$css), array('p'=>$page));        
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
    
    
    public function created_to_date(){
       return LAIKA_Time::database_to_date($this->created);
    }
    public function created_to_shortdate(){
       return LAIKA_Time::database_to_shortdate($this->created);
    }
    public function created_to_datetime(){
        return LAIKA_Time::database_to_datetime($this->created);
    }
    public function created_to_time(){
        return LAIKA_Time::database_to_time($this->created);
    }
    
    public function updated_to_date(){
        return LAIKA_Time::database_to_date($this->updated);
    }
    public function updated_to_shortdate(){
        return LAIKA_Time::database_to_shortdate($this->updated);    
    }
    public function updated_to_datetime(){
        return LAIKA_Time::database_to_datetime($this->updated);
    }
    public function updated_to_time(){
        return LAIKA_Time::database_to_time($this->updated);
    }
    
}