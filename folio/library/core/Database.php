<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Database.php
 *
 *	@version        0.1.0b
 *	@package        laika
 *	@subpackage     core
 *	@category       database
 *	@date           2010-01-20 17:06:20 -0500 (Wed, 20 Jan 2010)
 *
 *	@author         Leonard M. Witzel <leonard_witzel@harvard.edu>
 *	@copyright      Copyright (c) 2010  Harvard University <{@link http://lab.dce.harvard.edu}>
 *
 */
/**
 * LAIKA_Database class.
 *
 * Main wrapper class to abstract database transactions.
 * 
 */
class LAIKA_Database extends LAIKA_Abstract_Socket_Service{

//-------------------------------------------------------------------
//	VARIABLES
//-------------------------------------------------------------------
    protected static $instance;
    private   static $database;
    private   static $driver;
    
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

        if( empty(self::$instance) )      
            $index = LAIKA_Registry::get_record(__CLASS__);
            if( isset($index) )                   
                self::$instance = LAIKA_Registry::get_record(__CLASS__);
            else
                parent::init(); 
        return self::$instance;    
    }
    
    /**
     * load_database_driver function.
     * 
     * @access public
     * @param  string $driver
     * @return void
     */
    public function load_database_driver($driver){
        $this::$database = $driver::connect();
    }
    
    /**
     * connect function.
     * 
     * @access public
     * @param  string $driver
     * @return void
     */
    public function connect($driver){

        USE_PDO && extension_loaded('pdo') ? 
            $this::$driver = LAIKA_NS.'Pdo_Driver' :
            $this::$driver = LAIKA_NS.ucfirst($driver).'_Driver';
        try{ 
            $this->load_database_driver($this::$driver);
            LAIKA_Registry::register(__CLASS__,$this);
        }
        catch(LAIKA_Exception $e){ 
            throw new LAIKA_Exception('DATABASE_NO_CONNECT', 830); 
        }
    }
    
    /**
     * disconnect function.
     * 
     * @access public
     * @return void
     */
    public function disconnect(){
        $db = $this::$driver;
        $this::$database = $db::disconnect();   
    }

    /**
     * select function.
     * 
     * @access public
     * @static
     * @param mixed $subject
     * @param mixed $table
     * @return void
     */
    public static function select($subject,$table,$condition){
        $db = self::init();
        $driver = $db::$database;
        return $driver->select($subject,$table,$condition);
    }       
    
    /**
     * select_column function.
     * 
     * @access public
     * @static
     * @param mixed $subject
     * @param mixed $table
     * @return void
     */
    public static function select_column($subject,$table){
        $db = self::init();
        $driver = $db::$database;
        return $driver->select_column($subject,$table);
    }
      
    /**
     * select_by function.
     * 
     * @access public
     * @static
     * @param mixed $id
     * @param mixed $table
     * @return void
     */
    public static function select_by($id,$table){
        $db = self::init();
        $driver = $db::$database;
        return $driver->select_by($id,$table);
    }
    /**
     * select_all function.
     * 
     * @access public
     * @static
     * @param mixed $table
     * @return void
     */
    public static function select_all($table){
        $db = self::init();
        $driver = $db::$database;
        return $driver->select_all($table);
    }       

    /**
     * select_all_where function.
     * 
     * @access public
     * @static
     * @param mixed $subject
     * @param mixed $table
     * @param mixed $condition
     * @return void
     */
    public static function select_all_where($table, $condition){
        $db = self::init();
        $driver = $db::$database;
        return $driver->select_all_where($table, $condition);
    }

    /**
     * select_where function.
     * 
     * @access public
     * @static
     * @param mixed $column
     * @param mixed $table
     * @param mixed $condition
     * @return void
     */
    public static function select_where($subject, $table, $condition){
        $db = self::init();
        $driver = $db::$database;
        return $driver->select_where($subject, $table, $condition);
    }
    
    /**
     * query function.
     * 
     * @access public
     * @static
     * @param mixed $statement
     * @param mixed $return
     * @return void
     */
    public static function query($statement,$return){
        $db = self::init();
        $driver = $db::$database;
        return $driver->query($statement,$return);    
    }
    
    /**
     * insert function.
     * 
     * @access public
     * @static
     * @param mixed $table
     * @param array $columns
     * @param array $values
     * @return void
     */
    public static function insert($table,$columns,$values){
        $db = self::init();
        $driver = $db::$database;
        return $driver->insert($table,$columns,$values); 
    }
    
    /**
     * update function.
     * 
     * @access public
     * @static
     * @param mixed $table
     * @param mixed $record
     * @param mixed $data
     * @param mixed $condition
     * @return void
     */
    public static function update($table, $record, $data, $condition){
        $db = self::init();
        $driver = $db::$database;
        return $driver->update($table, $record, $data, $condition);     
    }
    
    /**
     * add function.
     * 
     * @access public
     * @static
     * @param mixed $object
     * @return void
     */
    public static function add($object){
        $db = self::init();
        $driver = $db::$database;        
        return $driver->add($object);    
    }
    
    /**
     * delete function.
     * 
     * @access public
     * @param mixed $table
     * @param mixed $id
     * @return void
     */
    public static function delete($table,$id){
        $db = self::init();
        $driver = $db::$database;
        $driver->delete($table,$id);  
    }

    /**
     * show function.
     * 
     * @access public
     * @static
     * @param mixed $table
     * @return void
     */
    public static function show($table){
        $db = self::init();
        $driver = $db::$database;        
        return $driver->show($table);        
    }    
    
    /**
     * reset_auto_increment function.
     * 
     * @access public
     * @param mixed $table
     * @param mixed $id
     * @return void
     */
    public static function reset_auto_increment($table,$id){
        $db = self::init();
        $driver = $db::$database;
        $driver->reset_auto_increment($table,$id);
    }
    
    /**
     * alter function.
     * 
     * @access public
     * @param mixed $table
     * @param mixed $condition
     * @return void
     */
    public static function alter($table,$condition){
        $db = self::init();
        $driver = $db::$database;
        $driver->alter($table,$condition);
    }
    
    /**
     * last function.
     * 
     * @access public
     * @param mixed $table
     * @param mixed $limit
     * @return void
     */
    public static function last($table,$limit){
        $db = self::init();
        $driver = $db::$database;
        return $driver->last($table,$limit); 
    }
    
    /**
     * first function.
     * 
     * @access public
     * @param mixed $table
     * @param mixed $limit
     * @return void
     */
    public static function first($table,$limit){
        $db = self::init();
        $driver = $db::$database;
        return $driver->first($table,$limit);     
    }
     
    public static function count($table){
        $db = self::init();
        $driver = $db::$database;
        return $driver->count($table);         
    }
    /**
     * offset function.
     * 
     * @access public
     * @static
     * @param mixed $table
     * @param mixed $column
     * @param mixed $offset
     * @param mixed $limit
     * @return void
     */
    public static function offset($table,$column,$limit,$offset){
        $db = self::init();
        $driver = $db::$database;
        return $driver->offset($table,$column,$limit,$offset);    
    }
    public static function find_with_offset(){}

    public static function create($table,$fields){}
    public static function drop(){}   
}